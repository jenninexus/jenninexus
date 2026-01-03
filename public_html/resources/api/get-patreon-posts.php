<?php
// Patreon posts proxy - basic implementation
// Reads server-only secrets and uses the creator access token to fetch campaign posts.

header('Content-Type: application/json; charset=utf-8');

// Include shared core so we can resolve canonical server paths and sessions
@include_once __DIR__ . '/../includes/app_core.php';

// Prefer canonical server secret path, fall back to local dev secrets
$secretsPathPrimary = function_exists('jn_patreon_secrets_path') ? jn_patreon_secrets_path() : __DIR__ . '/../../storage/secrets/patreon.json';
$secretsPathFallback = __DIR__ . '/playlists/secrets.json';
$secrets = [];
if (file_exists($secretsPathPrimary)) {
    $secrets = json_decode(file_get_contents($secretsPathPrimary), true) ?: [];
} elseif (file_exists($secretsPathFallback)) {
    $secrets = json_decode(file_get_contents($secretsPathFallback), true) ?: [];
}

$creatorToken = $secrets['PATREON_CREATOR_ACCESS_TOKEN'] ?? '';
$campaignId = $secrets['PATREON_CAMPAIGN_ID'] ?? '';

if (empty($creatorToken) || empty($campaignId)) {
    echo json_encode(['status' => 'no_token', 'posts' => []]);
    exit;
}

// Build the Patreon API v2 endpoint for campaign posts
// Use a minimal, supported query: remove invalid include/fields parameters that cause 400 errors.
// Request a small page of recent posts sorted by published date.
$url = 'https://www.patreon.com/api/oauth2/v2/campaigns/' . urlencode($campaignId) . '/posts?sort=-published_at&page[size]=6';

// Prepare cURL with sensible timeouts and headers
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5); // seconds to connect
curl_setopt($ch, CURLOPT_TIMEOUT, 10); // total seconds for the request
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $creatorToken,
    'Accept: application/json',
    'User-Agent: JenniNexus/1.0 (+https://jenninexus.com)'
]);

$resp = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlErr = curl_error($ch);
curl_close($ch);

// Basic error/caching strategy:
// - On success (200 + valid JSON) parse and return normalized posts
// - On error, try to return a cached copy from storage/patreon/posts_cache.json if available

if ($resp === false) {
    $errMsg = 'cURL error: ' . $curlErr;
    // Try cache
    $cachePath = __DIR__ . '/../../storage/patreon/posts_cache.json';
    if (file_exists($cachePath)) {
        $cached = json_decode(file_get_contents($cachePath), true);
        if (json_last_error() === JSON_ERROR_NONE && !empty($cached['posts'])) {
            echo json_encode(['status' => 'cached', 'message' => $errMsg, 'posts' => $cached['posts']]);
            exit;
        }
    }
    echo json_encode(['status' => 'error', 'message' => $errMsg, 'posts' => []]);
    exit;
}

$data = json_decode($resp, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    $errMsg = 'Invalid JSON from Patreon API';
    $cachePath = __DIR__ . '/../../storage/patreon/posts_cache.json';
    if (file_exists($cachePath)) {
        $cached = json_decode(file_get_contents($cachePath), true);
        if (json_last_error() === JSON_ERROR_NONE && !empty($cached['posts'])) {
            echo json_encode(['status' => 'cached', 'message' => $errMsg, 'raw' => $resp, 'posts' => $cached['posts']]);
            exit;
        }
    }
    echo json_encode(['status' => 'error', 'message' => $errMsg, 'raw' => $resp, 'posts' => []]);
    exit;
}

// Normalize included resources for quick lookup (images/attachments)
$includedMap = [];
if (!empty($data['included']) && is_array($data['included'])) {
    foreach ($data['included'] as $inc) {
        if (!empty($inc['id']) && !empty($inc['type'])) {
            $includedMap[$inc['type'] . ":" . $inc['id']] = $inc;
        }
    }
}

$posts = [];
if (!empty($data['data']) && is_array($data['data'])) {
    foreach ($data['data'] as $p) {
        $attrs = $p['attributes'] ?? [];
        $preview = null;
        $attachments = [];

        // If relationships.attachments present, try to resolve included attachments/images
        if (!empty($p['relationships']['attachments']['data']) && is_array($p['relationships']['attachments']['data'])) {
            foreach ($p['relationships']['attachments']['data'] as $aRef) {
                $key = ($aRef['type'] ?? '') . ':' . ($aRef['id'] ?? '');
                if (!empty($includedMap[$key])) {
                    $att = $includedMap[$key];
                    $attachments[] = $att;
                    // common pattern: images have attributes->url or meta->thumbnail
                    if (empty($preview)) {
                        if (!empty($att['attributes']['url'])) {
                            $preview = $att['attributes']['url'];
                        } elseif (!empty($att['attributes']['image_urls']['thumb'])) {
                            $preview = $att['attributes']['image_urls']['thumb'];
                        }
                    }
                }
            }
        }

        // If no preview found and top-level included images exist, try to find an image linked by relationships
        if (empty($preview) && !empty($p['relationships']['images']['data']) && is_array($p['relationships']['images']['data'])) {
            foreach ($p['relationships']['images']['data'] as $iRef) {
                $key = ($iRef['type'] ?? '') . ':' . ($iRef['id'] ?? '');
                if (!empty($includedMap[$key])) {
                    $img = $includedMap[$key];
                    if (!empty($img['attributes']['url'])) {
                        $preview = $img['attributes']['url'];
                        break;
                    }
                }
            }
        }

        // Fallback: try to extract first image src from content HTML
        if (empty($preview) && !empty($attrs['content'])) {
            if (preg_match('/<img[^>]+src=["\']([^"\']+)["\']/i', $attrs['content'], $m)) {
                $preview = $m[1];
            }
        }

        $posts[] = [
            'id' => $p['id'] ?? null,
            'title' => $attrs['title'] ?? '',
            'excerpt' => $attrs['excerpt'] ?? '',
            'url' => $attrs['url'] ?? '',
            'published_at' => $attrs['published_at'] ?? null,
            'preview_image' => $preview,
            'attachments' => $attachments,
        ];
    }
}

// Write a cache copy (best-effort). This helps when Patreon is temporarily failing.
$cacheDir = __DIR__ . '/../../storage/patreon';
$cachePath = $cacheDir . '/posts_cache.json';
if (!is_dir($cacheDir)) {
    @mkdir($cacheDir, 0750, true);
}

// Cache TTL (seconds) - prefer fresh data but allow cache if within TTL
$cacheTTL = 60 * 15; // 15 minutes

// Normalize posts: ensure minimal title/excerpt so UI shows something for placeholders
foreach ($posts as &$pp) {
    if (empty($pp['title'])) $pp['title'] = 'Patreon post';
    if (empty($pp['excerpt'])) $pp['excerpt'] = '';
}
unset($pp);

// Trim to 3 recent posts to keep the VIP area compact
if (count($posts) > 3) {
    $posts = array_slice($posts, 0, 3);
}

// Write cache (best-effort)
@file_put_contents($cachePath, json_encode(['fetched_at' => time(), 'posts' => $posts]));

// Log non-200 Patreon responses for diagnosis
$logsDir = $cacheDir . '/logs';
if (!is_dir($logsDir)) { @mkdir($logsDir, 0750, true); }
if (!empty($httpCode) && $httpCode !== 200) {
    $logEntry = [
        'time' => time(),
        'http_code' => $httpCode,
        'curl_error' => $curlErr,
        'url' => $url,
        'response_snippet' => substr($resp ?? '', 0, 2000)
    ];
    @file_put_contents($logsDir . '/patreon_posts.log', json_encode($logEntry) . PHP_EOL, FILE_APPEND | LOCK_EX);
}

// If debug flag provided, include the raw API response for diagnosis
if (!empty($_GET['debug']) && $_GET['debug'] === '1') {
    echo json_encode(['status' => 'ok', 'posts' => $posts, 'raw' => $data]);
} else {
    echo json_encode(['status' => 'ok', 'posts' => $posts]);
}
exit;

?>
