<?php
// Lightweight index shim so requests to /blog/ serve the main blog.php
// Keeps URLs clean and avoids directory index 403 errors.
$parent = dirname(__DIR__);
$target = $parent . '/blog.php';
if (file_exists($target)) {
    include $target;
    exit;
}
// Fallback: redirect to site root if blog.php missing
header('Location: /', true, 302);
exit;
