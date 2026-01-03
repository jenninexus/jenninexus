<?php
// Simple processor for archived Patreon webhook payloads
// Usage:
//   php scripts/patreon-webhook-processor.php [--dir=/path/to/storage/patreon/webhooks] [--dry-run]

$opts = [];
foreach ($argv as $arg) {
    if (strpos($arg, '--dir=') === 0) $opts['dir'] = substr($arg, 6);
    if ($arg === '--dry-run') $opts['dry-run'] = true;
}

$base = realpath(__DIR__ . '\..');
$webhooksDir = $opts['dir'] ?? $base . '/storage/patreon/webhooks';
$patreonStorage = $base . '/storage/patreon';
$userFile = $patreonStorage . '/user.json';

if (!is_dir($webhooksDir)) {
    fwrite(STDOUT, "No webhook directory found at $webhooksDir — nothing to process.\n");
    exit(0);
}

$files = array_values(array_filter(scandir($webhooksDir), function($f){return is_file($GLOBALS['webhooksDir'].'/'. $f); }));
if (empty($files)) {
    fwrite(STDOUT, "No webhook files to process in $webhooksDir\n");
    exit(0);
}

echo "Processing " . count($files) . " webhook files from $webhooksDir\n";

$currentUser = [];
if (file_exists($userFile)) {
    $currentUser = json_decode(file_get_contents($userFile), true) ?? [];
}

foreach ($files as $file) {
    $path = $webhooksDir . '/' . $file;
    $raw = file_get_contents($path);
    $data = json_decode($raw, true);
    if (!is_array($data)) {
        echo "Skipping non-JSON webhook file: $file\n";
        continue;
    }

    // Basic handling: if event contains user/membership update, update user.json
    // Patreon webhook payloads vary; this is intentionally conservative.
    if (!empty($data['data']) && is_array($data['data'])) {
        // merge included -> find Patreon user or membership
        foreach (($data['included'] ?? []) as $included) {
            if (!empty($included['type']) && $included['type'] === 'user') {
                // store user attributes
                $currentUser['data'] = $included;
                $currentUser['last_processed'] = time();
            }
            if (!empty($included['type']) && $included['type'] === 'member') {
                // map membership attributes
                $currentUser['membership'] = $included;
                $currentUser['last_processed'] = time();
            }
        }
    }

    // After processing, archive or delete. We'll move to processed/ to be safe.
    $processedDir = $webhooksDir . '/processed';
    if (!is_dir($processedDir) && empty($opts['dry-run'])) mkdir($processedDir, 0700, true);
    if (empty($opts['dry-run'])) {
        rename($path, $processedDir . '/' . $file);
    } else {
        echo "DRY RUN: would move $path to $processedDir/\n";
    }
}

if (!empty($currentUser)) {
    if (empty($opts['dry-run'])) {
        if (!is_dir($patreonStorage)) mkdir($patreonStorage, 0700, true);
        file_put_contents($userFile, json_encode($currentUser, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES));
        @chmod($userFile, 0640);
        echo "Updated user file: $userFile\n";
    } else {
        echo "DRY RUN: would update user file at $userFile with data from webhooks\n";
    }
}

echo "Webhook processing complete.\n";
exit(0);
