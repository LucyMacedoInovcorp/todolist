# Use PHP 8.2 com FrankenPHP
FROM dunglas/frankenphp:php8.2-bookworm

# Install system dependencies
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

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy composer files
COPY composer.json composer.json

# Remove problematic lock file and install dependencies for production
RUN rm -f composer.lock && \
    composer install --optimize-autoloader --no-dev --no-interaction --no-scripts --ignore-platform-reqs

# Copy package files and install Node dependencies
COPY package*.json ./
RUN npm ci --production

# Copy application code
COPY . .

# Remove test files and development artifacts
RUN rm -rf tests/ phpunit.xml .env.testing Pest.php .phpunit.result.cache docs/ README.md .editorconfig .vscode/

# Build assets
RUN npm run build

# Create Laravel directories and set permissions
RUN mkdir -p storage/framework/{sessions,views,cache,testing} \
    storage/logs \
    bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache

# Optimize Laravel
RUN php artisan optimize && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# Expose port
EXPOSE 8000

# Start command
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]