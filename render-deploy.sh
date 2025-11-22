#!/bin/bash
# Deployment script for Render

# Exit immediately if a command exits with a non-zero status
set -e

echo "Starting deployment to Render..."

# Set environment variables for production
export APP_ENV=production
export APP_DEBUG=false

# Install PHP dependencies
echo "Installing PHP dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

# Install and build frontend assets
if [ -f "package.json" ]; then
    echo "Installing Node.js dependencies..."
    npm install --production=false --ignore-scripts
    
    echo "Building frontend assets..."
    npm run build
fi

# Generate application key if it doesn't exist
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "" ]; then
    echo "Generating application key..."
    php artisan key:generate --force
fi

# Clear and cache configuration
echo "Caching configuration..."
php artisan config:clear
php artisan config:cache

# Clear and cache routes
echo "Caching routes..."
php artisan route:clear
php artisan route:cache

# Clear and cache views
echo "Caching views..."
php artisan view:clear
php artisan view:cache

# Run database migrations
echo "Running database migrations..."
php artisan migrate --force

# Link storage directory (if needed)
php artisan storage:link || true

echo "Deployment script completed successfully!"