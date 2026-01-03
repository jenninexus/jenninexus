<?php
// Read persisted tokens and user info and report membership state (CLI-friendly)
$base = dirname(__DIR__, 2);
$patreonDir = $base . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'patreon';
$tokenFile = $patreonDir . DIRECTORY_SEPARATOR . 'tokens.json';
$userFile = $patreonDir . DIRECTORY_SEPARATOR . 'user.json';

$result = [
    'token_present' => false,
    'user_present' => false,
    'is_patron' => false,
    'reason' => ''
];

if (file_exists($tokenFile)) {
    $result['token_present'] = true;
    $tokenData = json_decode(file_get_contents($tokenFile), true);
    $result['token'] = array_intersect_key($tokenData, array_flip(['access_token','refresh_token','expires_in','created_at']));
} else {
    $result['reason'] = 'tokens.json missing';
}

if (file_exists($userFile)) {
    $result['user_present'] = true;
    $user = json_decode(file_get_contents($userFile), true);
    $result['user'] = $user;
    if (!empty($user['included'])) {
        // simple heuristic
        $result['is_patron'] = true;
    }
} else {
    if (empty($result['reason'])) $result['reason'] = 'user.json missing';
}

echo json_encode($result, JSON_PRETTY_PRINT) . "\n";
