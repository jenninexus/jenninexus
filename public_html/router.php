<?php
/**
 * PHP Built-in Server Router
 * Handles routing for PHP built-in development server
 * Serves clean URLs for /game/* and /blog/* subdirectories
 * 
 * Debug Mode: Set ROUTER_DEBUG=1 environment variable to enable Whoops error handler
 */

// Initialize Whoops error handler if debug mode enabled
$debugMode = getenv('ROUTER_DEBUG') === '1' || (isset($_GET['debug']) && $_GET['debug'] === '1');

if ($debugMode && file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require __DIR__ . '/../vendor/autoload.php';
    
    $whoops = new \Whoops\Run;
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    $whoops->register();
}

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = urldecode($uri);

// Handle legacy /imgs/jenai.png requests by mapping to resources/profilepix
if ($uri === '/imgs/jenai.png' || $uri === '/imgs/jenai.JPG' || $uri === '/imgs/jenai.jpg') {
    $legacy = __DIR__ . '/resources/images/profilepix/jenni-pfp-ai.png';
    if (file_exists($legacy)) {
        header('Content-Type: image/png');
        readfile($legacy);
        return true;
    }
}

// Serve static files directly (CSS, JS, images, fonts, etc.)
// Only return false (let the built-in server serve) when the request maps to a regular file.
if ($uri !== '/' && is_file(__DIR__ . $uri)) {
    return false;
}

// Root - serve index.php
if ($uri === '/') {
    require __DIR__ . '/index.php';
    return true;
}

// Map common top-level pages to their PHP files (handle requests like /blog, /gamedev, /sitemap, /links)
// Also handles .php extensions: /live.php, /blog.php, etc.
$topLevelPages = [
    'blog' => 'blog.php',
    'gamedev' => 'gamedev.php',
    'sitemap' => 'sitemap.php',
    'links' => 'links.php',
    'gaming' => 'gaming.php',
    'music' => 'music.php',
    'diy' => 'diy.php',
    'live' => 'live.php',
    'patreon' => 'patreon.php',
    'resume' => 'resume.php',
    'services' => 'services.php',
    'media' => 'media.php',
    'ai' => 'ai.php',
    'vip' => 'vip.php',
    'youtube' => 'youtube.php',
    'index' => 'index.php'
];

foreach ($topLevelPages as $route => $file) {
    // Match /route, /route/, /route.php
    if ($uri === '/' . $route || $uri === '/' . $route . '/' || $uri === '/' . $file) {
        $phpFile = __DIR__ . '/' . $file;
        if (file_exists($phpFile)) {
            require $phpFile;
            return true;
        }
    }
}

// Serve /game or /game/ - prefer a dedicated index in /game/index.php, otherwise fall back to gamedev.php
if ($uri === '/game' || $uri === '/game/') {
    $gameIndex = __DIR__ . '/game/index.php';
    if (file_exists($gameIndex)) {
        require $gameIndex;
        return true;
    }
    // fallback to gamedev overview
    require __DIR__ . '/gamedev.php';
    return true;
}

// Handle /game/* routes (with or without .php)
// Examples: /game/catgame, /game/catgame/, /game/catgame.php → /game/catgame.php
if (preg_match('#^/game/([^/]+?)(?:\.php)?/?$#', $uri, $matches)) {
    $gamePage = __DIR__ . '/game/' . $matches[1] . '.php';
    if (file_exists($gamePage)) {
        require $gamePage;
        return true;
    }
}

// Handle /blog/* routes (with or without .php)
// Examples: /blog/voice-acting-in-games, /blog/voice-acting-in-games.php → /blog/voice-acting-in-games.php
if (preg_match('#^/blog/([^/]+?)(?:\.php)?/?$#', $uri, $matches)) {
    $blogPost = __DIR__ . '/blog/' . $matches[1] . '.php';
    if (file_exists($blogPost)) {
        require $blogPost;
        return true;
    }
}

// Support top-level game slugs: /catgame, /purgatoryfell, /jennistyles, /gamejams -> /game/catgame.php, etc.
// This allows accessing game pages without /game/ prefix
if (preg_match('#^/([a-z0-9\-]+)(?:\.php)?/?$#i', $uri, $m)) {
    $slug = $m[1];
    
    // First check if it's a game page
    $gamePath = __DIR__ . '/game/' . $slug . '.php';
    if (file_exists($gamePath)) {
        require $gamePath;
        return true;
    }

    // Check if it's a blog post (to match Nginx behavior)
    $blogPath = __DIR__ . '/blog/' . $slug . '.php';
    if (file_exists($blogPath)) {
        require $blogPath;
        return true;
    }
    
    // Then check if it's a top-level page (but not in $topLevelPages - those are already handled)
    $topLevelPath = __DIR__ . '/' . $slug . '.php';
    if (file_exists($topLevelPath)) {
        require $topLevelPath;
        return true;
    }
}

// 404 for everything else
http_response_code(404);

if ($debugMode) {
    // Pretty 404 page in debug mode
    echo '<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Not Found - Router Debug</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white">
    <div class="container mt-5">
        <div class="alert alert-danger">
            <h1 class="display-4"><i class="bi bi-exclamation-triangle"></i> 404 Not Found</h1>
            <hr>
            <p class="lead">URI: <code>' . htmlspecialchars($uri) . '</code></p>
            <h5>Router Debug Info:</h5>
            <ul>
                <li><strong>Request Method:</strong> ' . htmlspecialchars($_SERVER['REQUEST_METHOD']) . '</li>
                <li><strong>Request URI:</strong> ' . htmlspecialchars($_SERVER['REQUEST_URI']) . '</li>
                <li><strong>Script Name:</strong> ' . htmlspecialchars($_SERVER['SCRIPT_NAME']) . '</li>
                <li><strong>Document Root:</strong> ' . htmlspecialchars(__DIR__) . '</li>
            </ul>
            <h5>Available Routes:</h5>
            <ul>
                <li><code>/game/[slug]</code> - Game pages (e.g., /game/martiangames)</li>
                <li><code>/blog/[slug]</code> - Blog posts (e.g., /blog/voice-acting)</li>
                <li><code>/[page]</code> - Top-level pages (gamedev, gaming, diy, music, etc.)</li>
            </ul>
            <p class="mb-0"><small>Debug mode enabled. Disable by removing ROUTER_DEBUG=1 or ?debug=1</small></p>
        </div>
    </div>
</body>
</html>';
} else {
    echo "404 Not Found - " . htmlspecialchars($uri);
}
return true;
