<?php
/**
 * Whoops Error Handler for JenniNexus
 * 
 * Enables beautiful error pages in development with copy-paste support
 * Falls back to production error handling when not in dev mode
 */

// Check if we're in development mode
$isDevelopment = (
    $_SERVER['SERVER_NAME'] === 'localhost' || 
    $_SERVER['SERVER_NAME'] === '127.0.0.1' ||
    strpos($_SERVER['SERVER_NAME'], '.local') !== false ||
    strpos($_SERVER['HTTP_HOST'], ':8002') !== false  // Dev server port
);

if ($isDevelopment) {
    // Try to load Whoops if available
    $whoopsPath = __DIR__ . '/../../vendor/autoload.php';
    
    if (file_exists($whoopsPath)) {
        require $whoopsPath;
        
        $whoops = new \Whoops\Run;
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
        $whoops->register();
        
        // Log that Whoops is active
        error_log('[JenniNexus] Whoops error handler activated for development');
    } else {
        // Whoops not installed, use enhanced PHP error display
        ini_set('display_errors', '1');
        ini_set('display_startup_errors', '1');
        error_reporting(E_ALL);
        
        // Log that we're using fallback
        error_log('[JenniNexus] Whoops not installed, using PHP error display');
    }
} else {
    // Production mode - hide errors, log to file
    ini_set('display_errors', '0');
    ini_set('display_startup_errors', '0');
    error_reporting(E_ALL);
    
    // Ensure error logging is enabled
    ini_set('log_errors', '1');
    $logPath = __DIR__ . '/../../storage/logs/php_errors.log';
    if (!file_exists(dirname($logPath))) {
        mkdir(dirname($logPath), 0755, true);
    }
    ini_set('error_log', $logPath);
}
