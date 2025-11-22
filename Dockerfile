FROM php:8.3-cli

# Install system dependencies including Node.js
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm

# Clear package cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install additional PHP extensions that Laravel might need
RUN docker-php-ext-install opcache

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy the entire application first
COPY . .

# Remove the existing composer.lock to force regeneration
RUN rm -f composer.lock

# Install dependencies fresh to generate proper lock file
RUN composer install --no-dev --optimize-autoloader --no-interaction --ignore-platform-reqs

# Install all frontend dependencies (including devDependencies) and build
RUN npm install
RUN npm run build

# Setup storage and bootstrap/cache directory permissions
RUN mkdir -p storage/logs
RUN mkdir -p storage/framework/cache
RUN mkdir -p storage/framework/sessions
RUN mkdir -p storage/framework/views
RUN mkdir -p bootstrap/cache
RUN chmod -R 777 storage
RUN chmod -R 777 bootstrap/cache

# Create SQLite directory if needed
RUN mkdir -p /tmp

# Expose port
EXPOSE 8000

# Create startup script
RUN echo '#!/bin/bash\n\
echo "Starting Laravel application..."\n\
echo "Environment: ${APP_ENV:-local}"\n\
echo "Database: ${DB_CONNECTION:-sqlite}"\n\
echo "APP_URL: ${APP_URL:-not set}"\n\
echo "Port: $PORT"\n\
\n\
# Create .env file from environment variables if it does not exist\n\
if [ ! -f .env ]; then\n\
  echo "APP_NAME=Laravel" > .env\n\
  echo "APP_ENV=${APP_ENV:-production}" >> .env\n\
  echo "APP_KEY=${APP_KEY:-base64:your-key-here}" >> .env\n\
  echo "APP_DEBUG=${APP_DEBUG:-false}" >> .env\n\
  echo "APP_URL=${APP_URL:-http://localhost}" >> .env\n\
  echo "DB_CONNECTION=${DB_CONNECTION:-sqlite}" >> .env\n\
  echo "DB_DATABASE=/tmp/database.sqlite" >> .env\n\
  echo "LOG_CHANNEL=${LOG_CHANNEL:-stack}" >> .env\n\
  echo "LOG_LEVEL=${LOG_LEVEL:-debug}" >> .env\n\
  echo "SESSION_DRIVER=${SESSION_DRIVER:-file}" >> .env\n\
  echo "QUEUE_CONNECTION=${QUEUE_CONNECTION:-sync}" >> .env\n\
  echo "CACHE_STORE=${CACHE_STORE:-array}" >> .env\n\
fi\n\
\n\
# Display .env contents for debugging (remove this in production after debugging)\n\
echo "Current .env file:"\n\
cat .env\n\
\n\
# Make sure storage is linked\n\
php artisan storage:link 2>/dev/null || echo "Storage link not needed"\n\
\n\
# Clear config and cache\n\
php artisan config:clear\n\
php artisan cache:clear\n\
php artisan view:clear\n\
php artisan route:clear\n\
php artisan config:cache\n\
\n\
# Run migrations\n\
php artisan migrate --force\n\
\n\
# Start the PHP development server\n\
echo "Starting server on 0.0.0.0:$PORT"\n\
exec php artisan serve --host=0.0.0.0 --port=$PORT 2>&1\n\
' > start.sh && chmod +x start.sh

# Start the application
CMD ["sh", "-c", "./start.sh"]