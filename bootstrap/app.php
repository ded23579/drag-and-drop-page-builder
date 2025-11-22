<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// Set Vercel-specific configurations if in Vercel environment
if (isset($_ENV['VERCEL']) || getenv('VERCEL')) {
    // Use sync queue driver in Vercel environment
    $queueConnection = $_ENV['QUEUE_CONNECTION'] ?? $_SERVER['QUEUE_CONNECTION'] ?? 'sync';
    if (!isset($_ENV['QUEUE_CONNECTION'])) {
        $_ENV['QUEUE_CONNECTION'] = $queueConnection;
        $_SERVER['QUEUE_CONNECTION'] = $queueConnection;
    }

    // Use array cache driver in Vercel environment (if not using Redis/other)
    $cacheDriver = $_ENV['CACHE_DRIVER'] ?? $_SERVER['CACHE_DRIVER'] ?? 'array';
    if (!isset($_ENV['CACHE_DRIVER'])) {
        $_ENV['CACHE_DRIVER'] = $cacheDriver;
        $_SERVER['CACHE_DRIVER'] = $cacheDriver;
    }
}

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->validateCsrfTokens(except: [
            'tailwind/compile', // API endpoint for Tailwind CSS compilation
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
