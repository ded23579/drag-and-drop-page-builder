<?php
// bootstrap/debug.php - Debug configuration

// Register error handler to log errors to stderr which will appear in railway logs
set_error_handler(function ($severity, $message, $file, $line) {
    if (!(error_reporting() & $severity)) {
        return;
    }
    error_log("PHP Error: $message in $file on line $line");
    throw new ErrorException($message, 0, $severity, $file, $line);
});

// Register exception handler to log to stderr
set_exception_handler(function ($exception) {
    error_log("Uncaught Exception: " . $exception->getMessage() . 
              " in " . $exception->getFile() . 
              " on line " . $exception->getLine());
    error_log("Stack trace: " . $exception->getTraceAsString());
    
    // In debug mode, show the exception
    if (env('APP_DEBUG', false)) {
        echo "Exception: " . $exception->getMessage() . "\n";
        echo "File: " . $exception->getFile() . "\n";
        echo "Line: " . $exception->getLine() . "\n";
        echo "Trace:\n" . $exception->getTraceAsString() . "\n";
    }
    
    http_response_code(500);
    exit(1);
});