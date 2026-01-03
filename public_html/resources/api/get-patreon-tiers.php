<?php
// Patreon tiers proxy - fetch campaign tiers and return simple normalized list
header('Content-Type: application/json; charset=utf-8');

@include_once __DIR__ . '/../includes/app_core.php';

$secretsPathPrimary = function_exists('jn_patreon_secrets_path') ? jn_patreon_secrets_path() : dirname(__DIR__, 3) . '/storage/secrets/patreon.json';
$secrets = [];
if (file_exists($secretsPathPrimary)) {
    $secrets = json_decode(file_get_contents($secretsPathPrimary), true) ?: [];
}

$creatorToken = $secrets['PATREON_CREATOR_ACCESS_TOKEN'] ?? '';
$campaignId = $secrets['PATREON_CAMPAIGN_ID'] ?? '';

if (empty($creatorToken) || empty($campaignId)) {
    echo json_encode(['status' => 'no_token', 'tiers' => []]);
    exit;
}

$url = 'https://www.patreon.com/api/oauth2/v2/campaigns/' . urlencode($campaignId) . '/tiers';
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $creatorToken,
    'Accept: application/json',
    'User-Agent: JenniNexus/1.0 (+https://jenninexus.com)'
]);

$resp = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlErr = curl_error($ch);
curl_close($ch);

$cacheDir = dirname(__DIR__, 3) . '/storage/patreon';
if (!is_dir($cacheDir)) { @mkdir($cacheDir, 0750, true); }
$cachePath = $cacheDir . '/tiers_cache.json';

if ($resp === false || $httpCode !== 200) {
    if (file_exists($cachePath)) {
        $cached = json_decode(file_get_contents($cachePath), true);
        if (json_last_error() === JSON_ERROR_NONE && !empty($cached['tiers'])) {
            echo json_encode(['status' => 'cached', 'tiers' => $cached['tiers']]);
            exit;
        }
    }
    echo json_encode(['status' => 'error', 'message' => 'failed to fetch tiers', 'http' => $httpCode, 'curl' => $curlErr, 'tiers' => []]);
    exit;
}

$data = json_decode($resp, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['status' => 'error', 'message' => 'invalid json', 'raw' => $resp, 'tiers' => []]);
    exit;
}

$tiers = [];
if (!empty($data['data']) && is_array($data['data'])) {
    foreach ($data['data'] as $t) {
        $attrs = $t['attributes'] ?? [];
        $tiers[] = [
            'id' => $t['id'] ?? null,
            'title' => $attrs['title'] ?? 'Tier',
            'amount_cents' => $attrs['amount_cents'] ?? null,
            'description' => $attrs['description'] ?? ''
        ];
    }
}

// Cache tiers for 30 minutes
@file_put_contents($cachePath, json_encode(['fetched_at' => time(), 'tiers' => $tiers]));

echo json_encode(['status' => 'ok', 'tiers' => $tiers]);
exit;

?>
