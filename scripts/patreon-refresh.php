<?php
// Lightweight Patreon token refresher
// Usage:
//   php scripts/patreon-refresh.php [--dry-run]

$dryRun = in_array('--dry-run', $argv, true);

$base = realpath(__DIR__ . '\..');
$secretsFile = $base . '/storage/secrets/patreon.json';
$patreonStorage = $base . '/storage/patreon';
$tokensFile = $patreonStorage . '/tokens.json';

if (!file_exists($secretsFile)) {
    fwrite(STDERR, "ERROR: secrets file not found: $secretsFile\n");
    exit(2);
}

$secrets = json_decode(file_get_contents($secretsFile), true);
if (empty($secrets['client_id']) || empty($secrets['client_secret'])) {
    fwrite(STDERR, "ERROR: client_id or client_secret missing from secrets file\n");
    exit(2);
}

if (!is_dir($patreonStorage)) {
    if ($dryRun) {
        echo "Would create directory: $patreonStorage\n";
    } else {
        mkdir($patreonStorage, 0700, true);
    }
}

if (!file_exists($tokensFile)) {
    fwrite(STDOUT, "No existing tokens file found at $tokensFile. Nothing to refresh.\n");
    exit(0);
}

$tokens = json_decode(file_get_contents($tokensFile), true);
if (empty($tokens['refresh_token'])) {
    fwrite(STDOUT, "No refresh_token found in tokens.json — manual re-auth may be required.\n");
    exit(0);
}

$endpoint = 'https://www.patreon.com/api/oauth2/token';
$post = [
    'grant_type' => 'refresh_token',
    'refresh_token' => $tokens['refresh_token'],
    'client_id' => $secrets['client_id'],
    'client_secret' => $secrets['client_secret'],
];

echo "Refreshing Patreon token...\n";
if ($dryRun) {
    echo "DRY RUN: would POST to $endpoint with refresh_token and client credentials\n";
    exit(0);
}

$ch = curl_init($endpoint);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);

$resp = curl_exec($ch);
if ($resp === false) {
    fwrite(STDERR, "cURL error: " . curl_error($ch) . "\n");
    curl_close($ch);
    exit(2);
}

$httpCode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
curl_close($ch);

if ($httpCode < 200 || $httpCode >= 300) {
    fwrite(STDERR, "Token refresh failed (HTTP $httpCode): $resp\n");
    exit(2);
}

$new = json_decode($resp, true);
if (!is_array($new)) {
    fwrite(STDERR, "Failed to parse token response as JSON\n");
    exit(2);
}

// Merge fields and add timestamp
$new['fetched_at'] = time();
// Preserve refresh_token if not returned
if (empty($new['refresh_token']) && !empty($tokens['refresh_token'])) {
    $new['refresh_token'] = $tokens['refresh_token'];
}

$saved = file_put_contents($tokensFile, json_encode($new, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES));
if ($saved === false) {
    fwrite(STDERR, "Failed to write tokens file to $tokensFile\n");
    exit(2);
}

@chmod($tokensFile, 0600);

echo "Token refresh successful — tokens written to $tokensFile\n";
exit(0);
