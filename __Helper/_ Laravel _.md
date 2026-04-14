## Версия Composer
composer --version
## Создать Laravel проект
composer create-project laravel/laravel Backend "12.*"

## Sanctum
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"

## Spatie
composer require spatie/laravel-permission:6.22.0
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan migrate

# Backpack
composer require backpack/crud

# Larastan:
composer require --dev larastan/larastan:^3.0

## Инструмент для Laravel, который помогает находить ошибки в коде до запуска проекта.
    находит баги до запуска сайта
    добавляет “строгую типизацию” в Laravel
    ловит ошибки в Eloquent, запросах, фасадах
    понимает “магический” Laravel код (что PHPStan сам не понимает)

# ЗАПУСК
docker exec -it container-laravel bash
./vendor/bin/phpstan analyse
