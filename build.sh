#!/bin/bash

# Simple build script for Laravel app on Vercel

echo "Starting build process on Vercel..."

# Install PHP dependencies
echo "Installing PHP dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction --ignore-platform-reqs

# Generate application key if not present in environment
if [ -z "$APP_KEY" ]; then
    echo "Generating application key..."
    php artisan key:generate --force
fi

# Clear and cache configuration
echo "Caching configuration..."
php artisan config:clear
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

echo "Build process completed."