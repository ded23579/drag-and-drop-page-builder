#!/bin/sh
# Render start script for Laravel application

set -e # exit on error

echo "Starting application on "$(date)

# Run the PHP built-in server
exec php -S 0.0.0.0:$PORT -t public/