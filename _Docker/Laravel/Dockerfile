# _Docker/Laravel/Dockerfile

FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    git zip unzip curl \
    libpng-dev libzip-dev libicu-dev libonig-dev libxml2-dev \
    nodejs npm && \
    docker-php-ext-install pdo_mysql mbstring bcmath gd zip intl opcache pcntl

# ✅ FIX TEMP
RUN mkdir -p /tmp && chmod 777 /tmp

COPY ./_Docker/Laravel/php.ini /usr/local/etc/php/conf.d/php.ini

RUN curl -sS https://getcomposer.org/installer | php -- \
    --filename=composer --install-dir=/usr/local/bin

WORKDIR /var/www/html/backend

COPY ./_Docker/Laravel/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

CMD ["/entrypoint.sh"]