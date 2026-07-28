FROM php:8.4-apache

# Install dependencies for PHP extensions and Node.js
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libpng-dev \
    libpq-dev \
    zip \
    unzip \
    nodejs \
    npm

# Install necessary PHP extensions for Laravel
RUN docker-php-ext-install pdo pdo_mysql pdo_pgsql gd zip

# Enable Apache mod_rewrite for Laravel routing
RUN a2enmod rewrite

# Change Apache document root to Laravel's public directory
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf || true
# We need to make sure Apache can read the storage directory outside the document root
RUN echo "<Directory /var/www/html/storage/app/public>\n    Require all granted\n</Directory>" >> /etc/apache2/apache2.conf

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
