#!/usr/bin/env bash
set -e

# ── Force PostgreSQL (Supabase) — never fall back to MySQL ──────────────────
export DB_CONNECTION="${DB_CONNECTION:-pgsql}"
export DB_HOST="${DB_HOST:-aws-1-ap-south-1.pooler.supabase.com}"
export DB_PORT="${DB_PORT:-5432}"
export DB_DATABASE="${DB_DATABASE:-postgres}"

echo "===> DB env vars in use:"
echo "     DB_CONNECTION = $DB_CONNECTION"
echo "     DB_HOST       = $DB_HOST"
echo "     DB_PORT       = $DB_PORT"
echo "     DB_DATABASE   = $DB_DATABASE"
echo "     DB_USERNAME   = $DB_USERNAME"

echo "===> Ensuring storage & framework cache directories exist..."
mkdir -p /var/www/html/storage/framework/views
mkdir -p /var/www/html/storage/framework/cache/data
mkdir -p /var/www/html/storage/framework/sessions
mkdir -p /var/www/html/storage/logs
mkdir -p /var/www/html/bootstrap/cache
mkdir -p /var/www/html/public/storage

chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public/storage
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public/storage

# Run artisan commands as www-data passing current env vars explicitly
ARTISAN_ENV="DB_CONNECTION=$DB_CONNECTION DB_HOST=$DB_HOST DB_PORT=$DB_PORT DB_DATABASE=$DB_DATABASE DB_USERNAME=$DB_USERNAME DB_PASSWORD=$DB_PASSWORD APP_KEY=$APP_KEY APP_ENV=$APP_ENV"

echo "===> Clearing config cache..."
su www-data -s /bin/bash -c "env $ARTISAN_ENV php /var/www/html/artisan config:clear"

echo "===> Caching config..."
su www-data -s /bin/bash -c "env $ARTISAN_ENV php /var/www/html/artisan config:cache"

echo "===> Caching routes..."
su www-data -s /bin/bash -c "env $ARTISAN_ENV php /var/www/html/artisan route:cache"

echo "===> Caching views..."
su www-data -s /bin/bash -c "env $ARTISAN_ENV php /var/www/html/artisan view:cache"

echo "===> Starting Apache..."
exec apache2-foreground
