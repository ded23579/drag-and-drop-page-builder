<?php

// Handle Vercel environment specific configurations
if (isset($_ENV['VERCEL']) || getenv('VERCEL')) {
    // In Vercel, use environment variables from the platform
    $envFile = __DIR__ . '/.env.vercel';
    if (file_exists($envFile)) {
        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            // Skip comments
            if (strpos($line, '#') === 0) {
                continue;
            }
            
            // Parse key=value lines
            if (strpos($line, '=') !== false) {
                list($key, $value) = explode('=', $line, 2);
                $key = trim($key);
                $value = trim($value);
                
                // Remove quotes from value
                if ((startsWith($value, '"') && endsWith($value, '"')) ||
                    (startsWith($value, "'") && endsWith($value, "'"))) {
                    $value = substr($value, 1, -1);
                }
                
                // Set the environment variable
                if (!isset($_ENV[$key])) {
                    $_ENV[$key] = $value;
                    $_SERVER[$key] = $value;
                    putenv("$key=$value");
                }
            }
        }
    }
}

// Helper functions for the above
if (!function_exists('startsWith')) {
    function startsWith($haystack, $needle) {
        return substr($haystack, 0, strlen($needle)) === $needle;
    }
}

if (!function_exists('endsWith')) {
    function endsWith($haystack, $needle) {
        return substr($haystack, -strlen($needle)) === $needle;
    }
}