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
    ca-certificates \
    gnupg

# Install Node.js 20.x
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

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

# Copy package files and install Node dependencies (including dev for building)
COPY package*.json ./
RUN npm ci

# Copy application code
COPY . .

# Copy Caddyfile
COPY Caddyfile /etc/caddy/Caddyfile

# Remove test files and development artifacts
RUN rm -rf tests/ phpunit.xml .env.testing Pest.php .phpunit.result.cache docs/ README.md .editorconfig .vscode/

# Build assets
RUN npm run build

# Remove node_modules to save space (keeping only built assets)
RUN rm -rf node_modules

# Create .env for production
RUN cp .env.production .env && \
    php artisan key:generate && \
    touch database/database.sqlite && \
    php artisan migrate --force

# Create Laravel directories and set permissions
RUN mkdir -p storage/framework/{sessions,views,cache,testing} \
    storage/logs \
    bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache && \
    chown -R www-data:www-data /app/storage /app/bootstrap/cache

# Optimize Laravel (skip caching as we don't have DB connection yet)
RUN php artisan optimize

# Expose port 80 (FrankenPHP default)
EXPOSE 80

# Start FrankenPHP
CMD ["frankenphp", "run", "--config", "/etc/caddy/Caddyfile"]