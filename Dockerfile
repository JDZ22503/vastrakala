FROM php:8.4-apache

# Install dependencies for PHP extensions and Node.js
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libpng-dev \
    libpq-dev \
    libjpeg-dev \
    libwebp-dev \
    zip \
    unzip \
    nodejs \
    npm

# Install necessary PHP extensions for Laravel (GD with JPEG + WebP support)
RUN docker-php-ext-configure gd --with-jpeg --with-webp
RUN docker-php-ext-install pdo pdo_mysql pdo_pgsql gd zip

# Enable Apache mod_rewrite for Laravel routing
RUN a2enmod rewrite

# Write a clean Apache VirtualHost that:
# 1. Sets DocumentRoot to Laravel's /public folder
# 2. Grants access to /var/www/html entirely (covers storage symlinks)
# 3. Follows symlinks so storage:link works
RUN { \
    echo '<VirtualHost *:80>'; \
    echo '    DocumentRoot /var/www/html/public'; \
    echo '    <Directory /var/www/html>'; \
    echo '        AllowOverride All'; \
    echo '        Require all granted'; \
    echo '        Options FollowSymLinks'; \
    echo '    </Directory>'; \
    echo '    <Directory /var/www/html/public>'; \
    echo '        AllowOverride All'; \
    echo '        Require all granted'; \
    echo '        Options FollowSymLinks'; \
    echo '    </Directory>'; \
    echo '</VirtualHost>'; \
} > /etc/apache2/sites-available/000-default.conf

# Set working directory
WORKDIR /var/www/html

# Copy the rest of the application
COPY . .

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Build Frontend assets
RUN npm install && npm run build

# Fix permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Use our start script
COPY scripts/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

# Run the start script when the container boots
CMD ["/usr/local/bin/start.sh"]
