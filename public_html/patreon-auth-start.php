<?php
// Simple Patreon OAuth start redirect
// Prefer secrets stored in storage/secrets/patreon.json (server-only), fallback to resources/playlists/secrets.json for dev
$secretsFallback = __DIR__ . '/resources/playlists/secrets.json';
require_once __DIR__ . '/resources/includes/app_core.php';
$secretsPrimary = jn_patreon_secrets_path();
$clientId = '';
$redirect = '';
$s = [];
if (file_exists($secretsPrimary)) {
    $s = json_decode(file_get_contents($secretsPrimary), true);
} elseif (file_exists($secretsFallback)) {
    $s = json_decode(file_get_contents($secretsFallback), true);
}

$clientId = $s['PATREON_CLIENT_ID'] ?? '';
$redirect = $s['PATREON_REDIRECT_URI'] ?? '';

if (empty($clientId) || empty($redirect)) {
    http_response_code(500);
    echo 'Patreon OAuth not configured on server.';
    exit;
}

session_start();
// CSRF state for OAuth
$state = bin2hex(random_bytes(16));
$_SESSION['patreon_oauth_state'] = $state;

$authUrl = 'https://www.patreon.com/oauth2/authorize?response_type=code&client_id=' . urlencode($clientId) . '&redirect_uri=' . urlencode($redirect) . '&state=' . urlencode($state) . '&scope=identity%20campaigns.members%20campaigns.posts';
header('Location: ' . $authUrl);
exit;

?>
