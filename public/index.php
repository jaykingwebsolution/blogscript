<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Check if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
try {
    require __DIR__.'/../vendor/autoload.php';
} catch (Error $e) {
    // Laravel Framework dependencies not installed - show diagnostic page
    if (file_exists(__DIR__.'/../resources/views/diagnostic-status.blade.php')) {
        readfile(__DIR__.'/../resources/views/diagnostic-status.blade.php');
        exit;
    }
    
    // Fallback error message
    die("Laravel Framework dependencies not installed. Run: composer install --no-dev --optimize-autoloader");
}

// Bootstrap Laravel and handle the request...
try {
    (require_once __DIR__.'/../bootstrap/app.php')
        ->make(Kernel::class)
        ->handle($request = Request::capture())
        ->send();
} catch (Error $e) {
    // Show diagnostic page if Laravel bootstrap fails
    if (file_exists(__DIR__.'/../resources/views/diagnostic-status.blade.php')) {
        readfile(__DIR__.'/../resources/views/diagnostic-status.blade.php');
        exit;
    }
    
    // Fallback error message
    die("Laravel Framework not properly installed. Run: composer install --no-dev --optimize-autoloader");
}