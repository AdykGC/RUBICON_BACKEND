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

# Проверяем через переменную окружения (безопаснее)
if [ "$RUN_SEED" = "true" ]; then
    echo "[---] Seeding database (RUN_SEED=true)..."
    php artisan db:seed --force
else
    echo "[---] Skipping seeders (set RUN_SEED=true to enable)."
fi

echo "[---] Clearing cache..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear

echo "[---] Starting PHP-FPM..."
exec php-fpm