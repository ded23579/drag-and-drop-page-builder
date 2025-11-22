#!/bin/bash

# Build script for Laravel app on Railway

echo "Starting build process on Railway..."

# Update composer.lock file first
echo "Updating composer.lock to match composer.json..."
composer update --no-dev --optimize-autoloader --no-interaction --ignore-platform-reqs || composer install --no-dev --optimize-autoloader --no-interaction --ignore-platform-reqs

# Install PHP dependencies
echo "Installing PHP dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction --ignore-platform-reqs

# Generate application key if not present in environment
if [ -z "$APP_KEY" ]; then
    echo "Application key not set in environment, you'll need to set it in Railway dashboard"
fi

# Clear and cache configuration
echo "Caching configuration..."
php artisan config:clear

# For production, cache config
php artisan config:cache

# Create necessary storage directories
mkdir -p storage/logs
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
chmod -R 777 storage

# Build frontend assets
echo "Building frontend assets..."
npm run build

# Run database migrations
echo "Running database migrations..."
php artisan migrate --force

echo "Build process completed."