<?php

/**
 * MS HORIZON GROUP - Front Controller (Application Entry Point)
 * All HTTP requests are routed through this file.
 */

// Define the root path
define('ROOT_PATH', dirname(__DIR__));

// Load configuration
require_once ROOT_PATH . '/config.php';

// Composer PSR-4 Autoloader
if (file_exists(ROOT_PATH . '/vendor/autoload.php')) {
    require_once ROOT_PATH . '/vendor/autoload.php';
} else {
    // Manual fallback PSR-4 autoloader (for shared hosting without composer install)
    spl_autoload_register(function (string $class) {
        $prefix = 'App\\';
        $baseDir = ROOT_PATH . '/app/';
        $len = strlen($prefix);
        if (strncmp($prefix, $class, $len) !== 0) return;
        $relativeClass = substr($class, $len);
        $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
        if (file_exists($file)) require $file;
    });
}

// Boot core classes
use App\Core\Session;
use App\Core\Router;

// Initialize secure session
Session::start();

// Load and dispatch routes
require_once ROOT_PATH . '/routes/web.php';
Router::resolve();
