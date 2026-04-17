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



1. Остановить всё
docker stop $(docker ps -aq)
2. Удалить все контейнеры
docker rm $(docker ps -aq)
3. Удалить все образы
docker rmi $(docker images -aq)
4. Удалить все volume (ОСТОРОЖНО — БД)
docker volume rm $(docker volume ls -q)
5. Очистить build cache
docker builder prune -a




    Если хочешь просто пересобрать проект:
docker compose down -v
docker compose build --no-cache
docker compose up -d

    Пересборка кода (БЕЗ скачивания всего заново)
docker compose down
docker compose up -d --build

Проверить сколько мусора:
docker system df