<?php

// config/vercel.php - Vercel-specific configuration

return [
    // Vercel environment detection
    'is_vercel' => isset($_ENV['VERCEL']) || getenv('VERCEL'),
    
    // File storage settings for Vercel's serverless environment
    'storage_path' => isset($_ENV['VERCEL']) || getenv('VERCEL') ? '/tmp' : storage_path(),
    
    // Queue settings for Vercel
    'queue_connection' => isset($_ENV['VERCEL']) || getenv('VERCEL') ? 'sync' : env('QUEUE_CONNECTION', 'sync'),
    
    // Cache settings for Vercel
    'cache_driver' => isset($_ENV['VERCEL']) || getenv('VERCEL') ? 'array' : env('CACHE_DRIVER', 'array'),
];