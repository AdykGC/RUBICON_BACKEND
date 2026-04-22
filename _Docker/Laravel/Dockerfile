FROM php:8.4-fpm

# Системные пакеты и PHP-расширения (этот слой кешируется)
RUN apt-get update && apt-get install -y \
    git zip unzip curl \
    libpng-dev libzip-dev libicu-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring bcmath gd zip intl opcache pcntl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Временная директория
RUN mkdir -p /tmp && chmod 777 /tmp

# Composer (из официального образа)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html/backend

# Копируем ТОЛЬКО файлы зависимостей (кешируемый слой)
COPY Backend/composer.json Backend/composer.lock ./

# Устанавливаем зависимости, но не выполняем скрипты (artisan пока нет)
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev --no-scripts

# Копируем остальной код (меняется часто, пересборка этого слоя быстрая)
COPY Backend/ .

# Теперь artisan на месте – выполняем скрипты (package:discover и т.д.)
RUN composer run-script post-autoload-dump

# Копируем конфиги PHP и entrypoint
COPY ./_Docker/Laravel/php.ini /usr/local/etc/php/conf.d/php.ini
COPY ./_Docker/Laravel/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

CMD ["/entrypoint.sh"]