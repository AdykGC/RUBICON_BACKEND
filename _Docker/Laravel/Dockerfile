# _Docker/Laravel/Dockerfile

FROM php:8.4-fpm

# Системные пакеты и PHP-расширения (этот слой кешируется)
RUN apt-get update && apt-get install -y \
    git zip unzip curl \
    libpng-dev libzip-dev libicu-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring bcmath gd zip intl opcache pcntl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*
# && apt-get clean && rm -rf /var/lib/apt/lists/*    |    Очистка кэша apt и списков пакетов для уменьшения размера Docker-образа

# Временная директория
RUN mkdir -p /tmp && chmod 777 /tmp
# Composer
# COPY ./_Docker/Laravel/php.ini /usr/local/etc/php/conf.d/php.ini | первый COPY — из твоей файловой системы | второй COPY --from — из другого Docker-образа (multi-stage build)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

#RUN curl -sS https://getcomposer.org/installer | php -- \
#    --filename=composer --install-dir=/usr/local/bin

# Рабочая директория
WORKDIR /var/www/html/backend
# Копируем ТОЛЬКО файлы зависимостей (кешируемый слой)
COPY Backend/composer.json Backend/composer.lock ./
# Устанавливаем зависимости (только если изменился composer.json/lock)
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev
# Копируем остальной код (меняется часто, но пересборка этого слоя быстрая)
COPY Backend/ .
# Копируем конфиги PHP и entrypoint
COPY ./_Docker/Laravel/php.ini /usr/local/etc/php/conf.d/php.ini
COPY ./_Docker/Laravel/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

CMD ["/entrypoint.sh"]