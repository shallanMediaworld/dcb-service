# Use the official PHP image with version 8.1
FROM php:8.1-fpm

# Set working directory inside the container
WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libxml2-dev \
    zip \
    unzip \
    build-essential \
    libonig-dev  # This is necessary for mbstring extension

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy existing application directory contents
COPY . .

# Ensure proper permissions
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 775 /var/www/html

# Install PHP dependencies using Composer
# Adding composer update to ensure compatibility with the PHP version
RUN composer install --no-interaction || composer update --no-interaction

# Copy .env file if it exists (Laravel uses .env for environment variables)
COPY .env .env

# Generate Laravel application key
RUN php artisan key:generate

# Expose port 9000
EXPOSE 9000

# Run PHP-FPM server
CMD ["php-fpm"]
