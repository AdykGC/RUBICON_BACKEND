services:
  nginx:          # reverse proxy
  laravel_php:    # php-fpm для Laravel
  laravel_db:     # mariadb для Laravel
  redis:          # общий Redis для обоих проектов (опционально)


sudo nano /etc/hosts
127.0.0.1 api.local

ping api.local

docker compose build
docker compose down
docker compose up -d
docker compose restart nginx
docker compose logs -f nginx

http://bitrix.local
http://api.local