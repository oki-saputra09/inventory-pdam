#!/bin/bash
set -e

echo "==> Preparing storage & cache directories"
mkdir -p storage/framework/{cache,sessions,views} storage/logs bootstrap/cache database
chmod -R 775 storage bootstrap/cache database || true

echo "==> Checking APP_KEY"
if [ -z "$APP_KEY" ]; then
  echo "ERROR: APP_KEY is not set. Please set it in Railway Variables."
  echo "Generate one locally with: openssl rand -base64 32"
  exit 1
fi

echo "==> Linking storage"
if [ ! -L public/storage ]; then
  php artisan storage:link
else
  echo "Storage link already exists, skipping."
fi

echo "==> Caching config/routes/views"
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> Running database migrations"
php artisan migrate --force

echo "==> Seeding default roles & admin user (safe to skip if exists)"
php artisan db:seed --force || echo "Seeding skipped or already done."

echo "==> Starting server on port ${PORT:-8080}"
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8080}