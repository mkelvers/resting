FROM php:8.2-cli-alpine

WORKDIR /app

# Install PHP extensions and composer
RUN docker-php-ext-install pdo pdo_mysql pcntl
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy composer files first for better caching
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader

# Copy application files
COPY . .

# Expose the port Comet will run on
EXPOSE 8080

# Run the application
CMD ["php", "index.php", "start"]
