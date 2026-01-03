<?php
// Lightweight server-side proxy for fetching YouTube RSS and playlist feeds.
// Caches responses to storage/cache/youtube/ to avoid CORS issues and rate limits.
//
// ARCHITECTURE NOTE: JenniNexus does NOT use the YouTube Data API.
// All video data is fetched via RSS feeds and cached on the remote server.
// This proxy expects actual YouTube playlist IDs (e.g., PL9QBjNDhgNwRsznW8e3-KVmwfEuwvr7Yi).
// If passing slug names (e.g., "devlogs"), ensure your frontend resolves them to IDs first.
//
// SECURITY: Cache directory is OUTSIDE public_html to prevent direct web access
// Path: /var/www/jenninexus/storage/cache/youtube/ (production)
//       C:\Users\Owner\Projects\www\jenninexus\storage\cache\youtube\ (local dev)

$cacheDir = dirname(__DIR__, 3) . '/storage/cache/youtube';
if (!is_dir($cacheDir)) {
  @mkdir($cacheDir, 0755, true);
}

// Accept either rss (RSS URL), playlist_id, or channel_id as query params
$rss = isset($_GET['rss']) ? $_GET['rss'] : null;
$playlistId = isset($_GET['playlist_id']) ? $_GET['playlist_id'] : null;
$channelId = isset($_GET['channel_id']) ? $_GET['channel_id'] : null;

if ($playlistId && !$rss) {
  $rss = 'https://www.youtube.com/feeds/videos.xml?playlist_id=' . urlencode($playlistId);
} elseif ($channelId && !$rss) {
  $rss = 'https://www.youtube.com/feeds/videos.xml?channel_id=' . urlencode($channelId);
}

if (!$rss) {
  http_response_code(400);
  header('Content-Type: application/json');
  echo json_encode(['error' => 'missing rss, playlist_id, or channel_id']);
  exit;
}

// Simple filename-safe hash
$hash = substr(md5($rss), 0, 12);
$cacheFile = $cacheDir . '/' . $hash . '.json';
$cacheTTL = 60 * 10; // 10 minutes

// Serve cached copy when fresh
if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < $cacheTTL)) {
  header('Content-Type: application/json');
  header('X-Cache: HIT');
  readfile($cacheFile);
  exit;
}

// If cache is stale but exists, serve it if fresh fetch fails (graceful degradation)
$staleCache = file_exists($cacheFile);

// Fetch the RSS feed server-side using cURL for better reliability
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $rss);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'JenniNexus-fetch/1.0');
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Avoid SSL issues on some hosts
$raw = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);
curl_close($ch);

// If fetch failed or returned non-200, try serving stale cache as fallback
if ($raw === false || $httpCode !== 200) {
  if ($staleCache) {
    header('Content-Type: application/json');
    header('X-Cache: STALE');
    header('X-Cache-Warning: Fresh fetch failed (HTTP ' . $httpCode . '), serving stale cache');
    readfile($cacheFile);
    exit;
  }
  
  http_response_code(502);
  header('Content-Type: application/json');
  echo json_encode([
    'error' => 'failed to fetch feed',
    'http_code' => $httpCode,
    'curl_error' => $curlError,
    'playlist_id' => $playlistId,
    'channel_id' => $channelId,
    'rss_url' => $rss
  ]);
  exit;
}

// Convert RSS XML to simple JSON structure
libxml_use_internal_errors(true);
$xml = simplexml_load_string($raw, 'SimpleXMLElement', LIBXML_NOCDATA);

// If XML parsing failed, try serving stale cache
if ($xml === false) {
  if ($staleCache) {
    header('Content-Type: application/json');
    header('X-Cache: STALE');
    header('X-Cache-Warning: XML parsing failed, serving stale cache');
    readfile($cacheFile);
    exit;
  }
  
  http_response_code(502);
  header('Content-Type: application/json');
  $errors = libxml_get_errors();
  echo json_encode([
    'error' => 'invalid xml',
    'details' => $errors ? array_map(fn($e) => $e->message, $errors) : []
  ]);
  exit;
}

// Register XML namespaces for media:thumbnail extraction
$xml->registerXPathNamespace('media', 'http://search.yahoo.com/mrss/');
$xml->registerXPathNamespace('yt', 'http://www.youtube.com/xml/schemas/2015');

// Extract thumbnail URLs from media:group and add to each entry
if (isset($xml->entry)) {
  foreach ($xml->entry as $entry) {
    // Extract video ID from yt:videoId or id field
    $videoId = '';
    $ytVideoId = $entry->children('yt', true)->videoId;
    if ($ytVideoId) {
      $videoId = (string)$ytVideoId;
    } elseif (isset($entry->id)) {
      // Parse from yt:video:VIDEO_ID format
      $idParts = explode(':', (string)$entry->id);
      if (count($idParts) >= 3) {
        $videoId = $idParts[2];
      }
    }
    
    // Try to extract thumbnail from media:group/media:thumbnail
    $thumbnailUrl = '';
    $mediaGroup = $entry->children('media', true)->group;
    if ($mediaGroup) {
      $mediaThumbnail = $mediaGroup->children('media', true)->thumbnail;
      if ($mediaThumbnail && isset($mediaThumbnail['url'])) {
        $thumbnailUrl = (string)$mediaThumbnail['url'];
      }
    }
    
    // Fallback to standard YouTube thumbnail URL if media:thumbnail not found
    if (empty($thumbnailUrl) && !empty($videoId)) {
      $thumbnailUrl = "https://img.youtube.com/vi/{$videoId}/mqdefault.jpg";
    }
    
    // Add thumbnail as a new element in the entry
    if (!empty($thumbnailUrl)) {
      $entry->addChild('thumbnail', htmlspecialchars($thumbnailUrl));
    }
    
    // Also add videoId for easier access
    if (!empty($videoId)) {
      $entry->addChild('videoId', $videoId);
    }
  }
}

$json = json_encode($xml);
// Cache the JSON for future requests
@file_put_contents($cacheFile, $json);

header('Content-Type: application/json');
header('X-Cache: MISS');
header('X-Cache-Expires: ' . date('Y-m-d H:i:s', time() + $cacheTTL));
echo $json;
