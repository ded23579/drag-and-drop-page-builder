<?php

// vercel.php - Additional configuration for Vercel deployment

if (str_contains($_SERVER['REQUEST_URI'] ?? '', '/storage/') && !str_contains($_SERVER['REQUEST_URI'], '/storage/app/public/')) {
    // For Vercel, we need to properly handle storage links
    $path = $_SERVER['DOCUMENT_ROOT'] . $_SERVER['REQUEST_URI'];
    
    if (file_exists($path)) {
        return false; // Let Vercel serve the static file directly
    }
}

// Set appropriate temp directory for Vercel environment
if (isset($_ENV['VERCEL'])) {
    // Set temporary directory for Vercel environment
    ini_set('upload_tmp_dir', '/tmp');
    
    // In Vercel's serverless environment, file system is mostly read-only
    // except for /tmp directory
    if (!defined('STORAGE_PATH')) {
        define('STORAGE_PATH', '/tmp');
    }
}