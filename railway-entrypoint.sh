#!/bin/bash
set -e

echo "==> Preparing storage & cache directories"
mkdir -p storage/framework/{cache,sessions,views} storage/logs bootstrap/cache database
chmod -R 775 storage bootstrap/cache database || true

echo "==> Generating APP_KEY if missing"
if [ -z "$APP_KEY" ]; then
  php artisan key:generate --force
fi

echo "==> Linking storage"
php artisan storage:link || true

echo "==> Caching config/routes/views"
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> Running database migrations"
php artisan migrate --force

echo "==> Starting server on port ${PORT:-8080}"
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
