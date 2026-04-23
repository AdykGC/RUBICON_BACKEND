# _Docker/Laravel/entrypoint.sh

#!/bin/bash

set -e
echo "[---] Waiting for DB..."
until php -r "
try {
    new PDO('mysql:host=laravel_db;port=3306;dbname=laravel', 'root', 'root');
    exit(0);
} catch (Exception \$e) {
    exit(1);
}
"; do
  sleep 2
done

# composer install УДАЛЁН — зависимости уже в образе
# composer install --no-interaction --prefer-dist --optimize-autoloader

if [ ! -f .env ]; then
  cp .env.example .env
fi
if ! grep -q "APP_KEY=base64" .env; then
  php artisan key:generate --force
fi

# Миграции и кеш
echo "[---] Running migrations..."
php artisan migrate --force

echo "[---] Clearing cache..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear

echo "[---] Starting PHP-FPM..."
exec php-fpm