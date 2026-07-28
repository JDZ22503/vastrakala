#!/usr/bin/env bash

echo "Caching config..."
su www-data -s /bin/bash -c "php artisan config:cache"

echo "Caching routes..."
su www-data -s /bin/bash -c "php artisan route:cache"

echo "Running migrations..."
su www-data -s /bin/bash -c "php artisan migrate --force"

echo "Fixing permissions..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public/storage

echo "Starting Apache..."
exec apache2-foreground
