#!/bin/bash

echo "[---] Waiting for DB..."
sleep 10

# Установка COMPOSER
if [ ! -d "vendor" ]; then
  echo "[---] Installing dependencies..."
  composer install
fi

# Применение МИГРАЦИЙ
echo "[---] Running migrations..."
until php artisan migrate --force; do
  echo "DB not ready, retrying..."
  sleep 5
done

echo "[---] Cache clear..."
php artisan config:clear

echo "[---] Starting PHP-FPM..."
exec php-fpm