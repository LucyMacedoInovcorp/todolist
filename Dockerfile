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
RUN echo 'APP_NAME="ToDo List"' > .env && \
    echo 'APP_ENV=production' >> .env && \
    echo 'APP_KEY=' >> .env && \
    echo 'APP_DEBUG=false' >> .env && \
    echo 'APP_URL=https://todolist-production.up.railway.app' >> .env && \
    echo 'APP_LOCALE=pt-BR' >> .env && \
    echo 'APP_FALLBACK_LOCALE=pt-BR' >> .env && \
    echo 'APP_FAKER_LOCALE=pt_BR' >> .env && \
    echo 'APP_MAINTENANCE_DRIVER=file' >> .env && \
    echo 'BCRYPT_ROUNDS=12' >> .env && \
    echo 'LOG_CHANNEL=stack' >> .env && \
    echo 'LOG_STACK=single' >> .env && \
    echo 'LOG_LEVEL=error' >> .env && \
    echo 'BROADCAST_CONNECTION=log' >> .env && \
    echo 'CACHE_STORE=file' >> .env && \
    echo 'FILESYSTEM_DISK=local' >> .env && \
    echo 'QUEUE_CONNECTION=database' >> .env && \
    echo 'SESSION_DRIVER=file' >> .env && \
    echo 'SESSION_LIFETIME=120' >> .env && \
    echo 'DB_CONNECTION=sqlite' >> .env && \
    echo 'DB_DATABASE=/app/database/database.sqlite' >> .env && \
    echo 'MAIL_MAILER=log' >> .env && \
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