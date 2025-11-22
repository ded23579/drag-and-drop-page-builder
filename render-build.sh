#!/bin/sh
# Render build script for Laravel application

set -e # exit on error

echo "Starting build on "$(date)

# Install dependencies
composer install --no-dev --optimize-autoloader

# Generate application key
php artisan key:generate --force

# Clear config cache
php artisan config:clear

# Run migrations
php artisan migrate --force

# Build frontend assets
npm install --production=false
npm run build

echo "Build completed on "$(date)