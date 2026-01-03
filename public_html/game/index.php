<?php
// Lightweight index shim so requests to /game/ serve the main gamedev.php
// Keeps URLs clean and avoids directory index 403 errors.
$parent = dirname(__DIR__);
$target = $parent . '/gamedev.php';
if (file_exists($target)) {
    include $target;
    exit;
}
// Fallback: redirect to site root if gamedev.php missing
header('Location: /', true, 302);
exit;
