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

# Setup storage directory permissions
RUN mkdir -p storage/logs
RUN mkdir -p storage/framework/cache
RUN mkdir -p storage/framework/sessions
RUN mkdir -p storage/framework/views
RUN chmod -R 777 storage

# Generate application key if not set (this may fail if .env is incomplete)
RUN php artisan key:generate --force || echo "Key generation skipped - set APP_KEY in environment variables"

# Expose port
EXPOSE 8000

# Create startup script
RUN echo '#!/bin/bash\n\
echo "Starting Laravel application..."\n\
echo "Environment: ${APP_ENV:-local}"\n\
echo "Database: ${DB_CONNECTION:-sqlite}"\n\
echo "Port: $PORT"\n\
\n\
# Run any pending migrations\n\
php artisan migrate --force || echo "Migrations failed - check database configuration"\n\
\n\
# Start the PHP development server\n\
exec php artisan serve --host=0.0.0.0 --port=$PORT\n\
' > start.sh && chmod +x start.sh

# Start the application
CMD ["sh", "-c", "./start.sh"]