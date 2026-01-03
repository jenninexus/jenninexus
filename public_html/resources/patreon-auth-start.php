<?php
// Proxy redirect for legacy/resource paths: forward to site root OAuth starter
// This file allows links under /resources to continue working even if the
// canonical OAuth start file lives at /patreon-auth-start.php
$target = '/patreon-auth-start.php';
// If invoked directly from CLI or by accident, show target
if (php_sapi_name() === 'cli') {
    echo "Would redirect to: $target\n";
    exit;
}

// Preferred: send a 302 to the canonical location
header('Location: ' . $target, true, 302);
exit;

?>
