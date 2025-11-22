<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Load Vercel-specific runtime configuration if in Vercel environment
if (isset($_ENV['VERCEL']) || getenv('VERCEL')) {
    require_once __DIR__.'/../vercel-runtime.php';
}

// Load Vercel-specific configuration if in Vercel environment
if (isset($_ENV['VERCEL']) || getenv('VERCEL')) {
    require_once __DIR__.'/../vercel.php';
}

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
