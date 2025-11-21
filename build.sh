#!/bin/bash

# Build script for Laravel app on Railway

echo "Starting build process..."

# Install PHP dependencies
echo "Installing PHP dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

# Clear and cache configuration
echo "Caching configuration..."
php artisan config:clear
php artisan config:cache

# Cache routes and views
php artisan route:cache
php artisan view:cache

# Install and build frontend assets if they exist
if [ -f "package.json" ]; then
    echo "Installing node dependencies..."
    npm ci --only=production
fi

echo "Build process completed."