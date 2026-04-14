#!/bin/bash

echo "[---] Waiting for DB..."
sleep 10

# Установка зависимостей COMPOSER
if [ ! -d "vendor" ]; then
  echo "[---] Installing dependencies..."
  composer install
fi

# Генерация ключа (если отсутствует)
if [ -z "$APP_KEY" ]; then
  php artisan key:generate
fi

# Публикация пакетов (важно!)
# php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --force
# php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider" --force


# Применение МИГРАЦИЙ (с ожиданием БД)
echo "[---] Running migrations..."
until php artisan migrate --force; do
  echo "DB not ready, retrying..."
  sleep 5
done

# Кэш
echo "[---] Cache clear..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear

echo "[---] Starting PHP-FPM..."
exec php-fpm