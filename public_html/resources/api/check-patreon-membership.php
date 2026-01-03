<?php
// Self-contained Patreon membership check endpoint.
// Preferred source: storage/patreon/user.json and storage/patreon/tokens.json
header('Content-Type: application/json; charset=utf-8');

// Include small shared core for session/Auth fallback and helpers
require_once __DIR__ . '/../includes/app_core.php';

// Look for on-disk token/user files created by OAuth flow or the local simulation
// Use helper from app_core.php to compute the correct storage path (project root/storage/patreon)
$patreonDir = function_exists('jn_patreon_storage_dir') ? jn_patreon_storage_dir() : __DIR__ . '/../../storage/patreon';
$tokenFile = $patreonDir . '/tokens.json';
$userFile = $patreonDir . '/user.json';

$response = [
    'authenticated' => false,
    'is_patron' => false,
    'user' => null,
    'source' => null
];

// If user.json exists and contains 'included' memberships, treat as patron
if (file_exists($userFile)) {
    $response['source'] = 'storage';
    $u = json_decode(file_get_contents($userFile), true);
    if (json_last_error() === JSON_ERROR_NONE) {
        $response['user'] = $u;
        if (!empty($u['included'])) {
            $response['authenticated'] = true;
            $response['is_patron'] = true;
        } else {
            // user present but no memberships
            $response['authenticated'] = true;
            $response['is_patron'] = false;
        }
    }
    echo json_encode($response);
    exit;
}

// If tokens exist but no user info, report authenticated=true (tokens present) but not necessarily patron
if (file_exists($tokenFile)) {
    $response['source'] = 'tokens';
    $t = json_decode(file_get_contents($tokenFile), true);
    if (json_last_error() === JSON_ERROR_NONE) {
        $response['authenticated'] = true;
        $response['token'] = array_intersect_key($t, array_flip(['access_token','refresh_token','expires_in','created_at']));
    }
    echo json_encode($response);
    exit;
}

// Session fallback: if the runtime OAuth flow set session values, return them.
// This avoids requiring any legacy app bootstrap or framework.
// session already started by app_core.php
if (!empty($_SESSION['patreon_user']) || !empty($_SESSION['is_patron'])) {
    $response['source'] = 'session';
    $response['authenticated'] = !empty($_SESSION['patreon_user']) || !empty($_SESSION['is_patron']);
    $response['is_patron'] = !empty($_SESSION['is_patron']);
    $response['user'] = $_SESSION['patreon_user'] ?? null;
    echo json_encode($response);
    exit;
}

// Nothing found — return empty non-auth response
echo json_encode($response);
exit;
