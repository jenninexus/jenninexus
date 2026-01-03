<?php
// Patreon OAuth callback: exchanges OAuth code for tokens and sets session.
// Requires storage/secrets/patreon.json with PATREON_CLIENT_ID and PATREON_CLIENT_SECRET

// Use the shared small core (session + minimal AuthManager fallback)
require_once __DIR__ . '/resources/includes/app_core.php';
use JenniNexus\Auth\AuthManager;

$secretsPathFallback = __DIR__ . '/resources/playlists/secrets.json';
// Prefer secrets resolved by app_core helper (canonical production path)
$secretsPathPrimary = function_exists('jn_patreon_secrets_path') ? jn_patreon_secrets_path() : __DIR__ . '/../storage/secrets/patreon.json';
$secrets = [];
if (file_exists($secretsPathPrimary)) {
    $secrets = json_decode(file_get_contents($secretsPathPrimary), true);
} elseif (file_exists($secretsPathFallback)) {
    $secrets = json_decode(file_get_contents($secretsPathFallback), true);
}

if (empty($secrets['PATREON_CLIENT_ID']) || empty($secrets['PATREON_CLIENT_SECRET']) || empty($secrets['PATREON_REDIRECT_URI'])) {
    header('Content-Type: text/plain; charset=utf-8');
    echo "Patreon OAuth not configured. Add PATREON_CLIENT_ID, PATREON_CLIENT_SECRET and PATREON_REDIRECT_URI to storage/secrets/patreon.json\n";
    exit;
}

// Validate state if present
if (isset($_GET['state']) && isset($_SESSION['patreon_oauth_state'])) {
    if (!hash_equals($_SESSION['patreon_oauth_state'], $_GET['state'])) {
        http_response_code(400);
        echo "Invalid OAuth state\n";
        exit;
    }
}

if (!isset($_GET['code'])) {
    http_response_code(400);
    echo "Missing OAuth code\n";
    exit;
}

$code = $_GET['code'];

// Exchange code for tokens
$tokenUrl = 'https://www.patreon.com/api/oauth2/token';
$postFields = http_build_query([
    'code' => $code,
    'grant_type' => 'authorization_code',
    'client_id' => $secrets['PATREON_CLIENT_ID'],
    'client_secret' => $secrets['PATREON_CLIENT_SECRET'],
    'redirect_uri' => $secrets['PATREON_REDIRECT_URI']
]);

$ch = curl_init($tokenUrl);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Accept: application/json'
]);
$resp = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlErr = curl_error($ch);
curl_close($ch);

if ($resp === false || $httpCode !== 200) {
    error_log("Patreon token exchange failed: HTTP $httpCode curlErr=$curlErr resp=" . substr($resp ?? '',0,500));
    http_response_code(502);
    echo "Token exchange failed\n";
    exit;
}

$tokenData = json_decode($resp, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(502);
    echo "Invalid token response\n";
    exit;
}

// Persist tokens to storage/patreon/tokens.json (server-only)
$patreonStorageDir = jn_patreon_storage_dir();
if (!is_dir($patreonStorageDir)) {
    @mkdir($patreonStorageDir, 0750, true);
}
$tokenFile = $patreonStorageDir . '/tokens.json';
file_put_contents($tokenFile, json_encode($tokenData, JSON_PRETTY_PRINT));
@chmod($tokenFile, 0600);

// Fetch basic user identity using the access token
$accessToken = $tokenData['access_token'] ?? null;
$userData = null;
if ($accessToken) {
    $ch = curl_init('https://www.patreon.com/api/oauth2/v2/identity?include=memberships');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $accessToken,
        'Accept: application/json'
    ]);
    $uResp = curl_exec($ch);
    $uCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $uErr = curl_error($ch);
    curl_close($ch);
    if ($uResp !== false && $uCode === 200) {
        $uJson = json_decode($uResp, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            $userData = $uJson;
        }
    } else {
        error_log("Patreon user fetch failed: HTTP $uCode err=$uErr");
    }
}

// Create session and mark user as patron if memberships indicate so
$auth = new AuthManager();
$isPatron = false;
// Simple heuristic: if memberships included, treat as patron
if (is_array($userData) && !empty($userData['included'])) {
    $isPatron = true;
}
$auth->setPatreonSession($userData ?? ['id' => 'unknown'], $isPatron);

// Persist user identity to disk so the membership API can read it later
// (storage/patreon/user.json) — owner-locked to prevent accidental exposure.
if (is_array($userData) && !empty($userData)) {
    $userFile = $patreonStorageDir . '/user.json';
    // Attempt to write as the running user (PHP-FPM usually runs as www-data)
    @file_put_contents($userFile, json_encode($userData, JSON_PRETTY_PRINT));
    @chmod($userFile, 0600);
}

// Redirect user to Patreon page
header('Location: /patreon');
exit;
