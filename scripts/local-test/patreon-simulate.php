<?php
// Simulate Patreon OAuth token exchange locally using dev secrets and fake token data.
// This script writes a tokens.json file under storage/patreon and then performs a local request
// to the membership-check endpoint to demonstrate the flow.

$base = dirname(__DIR__, 2); // project root (scripts/local-test -> scripts -> project root)
$public = $base . DIRECTORY_SEPARATOR . 'public_html';
$storage = $base . DIRECTORY_SEPARATOR . 'storage';

// Load dev secrets (storage/secrets/secrets.json)
$secretsPath = $storage . DIRECTORY_SEPARATOR . 'secrets' . DIRECTORY_SEPARATOR . 'secrets.json';
if (!file_exists($secretsPath)) {
    echo "Dev secrets not found at $secretsPath\n";
    exit(1);
}
$secrets = json_decode(file_get_contents($secretsPath), true);

if (empty($secrets['PATREON_CLIENT_ID'])) {
    echo "PATREON_CLIENT_ID missing in dev secrets; aborting simulation.\n";
    exit(1);
}

// Create fake token payload similar to Patreon token response
$tokenData = [
    'access_token' => 'dev_fake_access_token_12345',
    'refresh_token' => 'dev_fake_refresh_token_12345',
    'expires_in' => 3600,
    'scope' => 'identity identity.memberships',
    'token_type' => 'Bearer',
    'created_at' => time()
];

$patreonDir = $storage . DIRECTORY_SEPARATOR . 'patreon';
if (!is_dir($patreonDir)) mkdir($patreonDir, 0750, true);
$tokenFile = $patreonDir . DIRECTORY_SEPARATOR . 'tokens.json';
file_put_contents($tokenFile, json_encode($tokenData, JSON_PRETTY_PRINT));
@chmod($tokenFile, 0600);

echo "Wrote fake tokens to $tokenFile\n";

// Also create a fake user identity file that AuthManager will read (if applicable)
// We'll write a simple file used by our simulated AuthManager: storage/patreon/user.json
$userData = [
    'data' => ['id' => 'user_dev_1', 'type' => 'user'],
    'included' => [
        [
            'type' => 'member',
            'attributes' => [ 'patron_status' => 'active_patron' ]
        ]
    ]
];
file_put_contents($patreonDir . DIRECTORY_SEPARATOR . 'user.json', json_encode($userData, JSON_PRETTY_PRINT));
@chmod($patreonDir . DIRECTORY_SEPARATOR . 'user.json', 0600);

// Now call the membership-check endpoint via HTTP
$endpoint = 'http://localhost:8000/resources/api/check-patreon-membership.php';
$ch = curl_init($endpoint);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$resp = curl_exec($ch);
$http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$err = curl_error($ch);
curl_close($ch);

if ($resp === false) {
    echo "HTTP request failed: $err\n";
    exit(1);
}

echo "Membership endpoint HTTP $http response:\n";
echo $resp . "\n";

// Clean up: leave tokens in place for manual testing

exit(0);
