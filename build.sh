#!/bin/bash

# Build script for Laravel app on Vercel

echo "Starting build process on Vercel..."

# Install PHP dependencies
echo "Installing PHP dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction --ignore-platform-reqs

# Generate application key if not present
if [ -z "$VERCEL" ] || [ -z "$APP_KEY" ]; then
    echo "Setting application key..."
    # Generate key if not set in environment
    if [ -z "$APP_KEY" ]; then
        php artisan key:generate --force
    fi
fi

# Clear and cache configuration
echo "Caching configuration..."
php artisan config:clear

# Only cache config in production
if [ "$VERCEL_ENV" = "production" ]; then
    php artisan config:cache
fi

# Create necessary directories if they don't exist
mkdir -p storage/logs
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views

# Set permissions for storage
chmod -R 777 storage

# Ensure public directory has proper permissions
chmod -R 755 public

# Install and build frontend assets if they exist
if [ -f "package.json" ]; then
    echo "Installing node dependencies..."
    npm ci --only=production

    if [ "$VERCEL_ENV" = "production" ]; then
        echo "Building frontend assets..."
        npm run build
    else
        echo "Skipping frontend build in non-production environment"
    fi
fi

echo "Build process completed."