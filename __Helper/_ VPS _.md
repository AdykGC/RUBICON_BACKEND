<h3 align="center"> КОРОТКО | VPS → чистый сервер → установка Docker </h3>

ОБНОВЛЕНИЕ СИСТЕМЫ

    sudo apt update && sudo apt upgrade -y

УСТАНОВКА DOCKER (ТВОЯ ОСНОВА)

    sudo apt update
    sudo apt install -y ca-certificates curl gnupg
    sudo install -m 0755 -d /etc/apt/keyrings
    curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /etc/apt/keyrings/docker.gpg
    echo \
      "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.gpg] https://download.docker.com/linux/ubuntu \
      $(. /etc/os-release && echo "$VERSION_CODENAME") stable" | \
      sudo tee /etc/apt/sources.list.d/docker.list > /dev/null

    sudo apt update
    sudo apt install -y docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin

ДАЙ ДОСТУП UBUNTU К DOCKER

    sudo usermod -aG docker ubuntu
    newgrp docker

Включаем автозапуск Docker:

    sudo systemctl enable docker
    sudo systemctl start docker

Проверка:
    
    docker --version
    docker-compose version

<h3 align="center"> КОРОТКО | VPS → чистый сервер → AUTODEPLOY </h3>

Создаём папку сами:

    sudo mkdir -p /var/www

Даём себе доступ:

    sudo chown -R $USER:$USER /var/www

ЗАЛИВАЕМ ПРОЕКТ НА VPS

    cd /var/www

GitHub Actions | сам подключается к VPS и делает deploy
ШАГ 1 — СОЗДАЙ SSH КЛЮЧ НА VPS

ssh-keygen -t rsa -b 4096 -C "deploy"
    получишь:
~/.ssh/id_rsa       (приватный)
~/.ssh/id_rsa.pub   (публичный)


ШАГ 2 — ДОБАВЬ КЛЮЧ В VPS
cat ~/.ssh/id_rsa.pub

👉 скопируй

открой:

nano ~/.ssh/authorized_keys

👉 вставь ключ

ШАГ 3 — ДОБАВЬ В GITHUB

В репозитории:

👉 Settings → Secrets → Actions

добавь:

VPS_HOST=YOUR_IP
VPS_USER=ubuntu
SSH_KEY= (вставь приватный id_rsa)

ШАГ 4 — СОЗДАЙ GITHUB ACTION

Создай файл:

.github/workflows/deploy.yml




[][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][]
1 | СОЗДАТЬ SSH КЛЮЧ
ssh-keygen -t rsa -b 4096 -C "deploy"

→ Enter везде (без пароля) -> получишь:
    ~/.ssh/id_rsa       (приватный)
    ~/.ssh/id_rsa.pub   (публичный)


[][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][]
2 | GitHub Actions → VPS (AUTODEPLOY / CI-CD)

cat ~/.ssh/id_rsa    (ПРИВАТНЫЙ)
    → вставить в:
        GitHub → Repo → Settings → Secrets → Actions → SSH_KEY
    → результат:
        GitHub может зайти на VPS и выполнить deploy


[][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][]
3 | VPS → GitHub (Deploy access)

cat ~/.ssh/id_rsa.pub   (ПУБЛИЧНЫЙ)
    → вставить в:
        GitHub → Repo → Settings → Deploy keys
    → результат:
        VPS может делать git clone / git pull

✔ ПРОВЕРКА
ssh -T git@github.com
→ результат:
    Hi username! You've successfully authenticated



    Midnight Commander
sudo apt install mc -y
mc


<h3 align="center"> ------------------------------------ </h3>
<h3 align="center"> HTTPS </h3>
<h3 align="center"> ------------------------------------ </h3>

Обновляем систему:

    sudo apt update
    sudo apt upgrade -y

Установка Nginx на хосте

    sudo apt install nginx certbot python3-certbot-nginx -y

Настройка reverse proxy

    sudo nano /etc/nginx/sites-available/rub1c0n.tech

/etc/nginx/sites-available/rub1c0n.tech(Version1)

    server {
        server_name rub1c0n.tech www.rub1c0n.tech;
    
        location / {
            proxy_pass http://127.0.0.1:8080;
            proxy_set_header Host $host;
            proxy_set_header X-Real-IP $remote_addr;
        }
    
        listen 443 ssl; # managed by Certbot
        ssl_certificate /etc/letsencrypt/live/rub1c0n.tech/fullchain.pem; # managed by Certbot
        ssl_certificate_key /etc/letsencrypt/live/rub1c0n.tech/privkey.pem; # managed by Certbot
        include /etc/letsencrypt/options-ssl-nginx.conf; # managed by Certbot
        ssl_dhparam /etc/letsencrypt/ssl-dhparams.pem; # managed by Certbot
    }
    
    server {
        if ($host = www.rub1c0n.tech) {
            return 301 https://$host$request_uri;
        } # managed by Certbot
    
    
        if ($host = rub1c0n.tech) {
            return 301 https://$host$request_uri;
        } # managed by Certbot
    
    
        listen 80;
        server_name rub1c0n.tech www.rub1c0n.tech;
        return 404; # managed by Certbot
    
    }

/etc/nginx/sites-available/rub1c0n.tech(Version2)

    server {
        listen 80;
        server_name rub1c0n.tech www.rub1c0n.tech;
    
        return 301 https://$host$request_uri;
    }
    
    server {
        listen 443 ssl;
        server_name rub1c0n.tech www.rub1c0n.tech;
    
        ssl_certificate /etc/letsencrypt/live/rub1c0n.tech/fullchain.pem;
        ssl_certificate_key /etc/letsencrypt/live/rub1c0n.tech/privkey.pem;
        include /etc/letsencrypt/options-ssl-nginx.conf;
        ssl_dhparam /etc/letsencrypt/ssl-dhparams.pem;
    
        location / {
            proxy_pass http://127.0.0.1:8080;
    
            proxy_set_header Host $host;
            proxy_set_header X-Real-IP $remote_addr;
            proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
            proxy_set_header X-Forwarded-Proto $scheme;
        }
    }

Активация:

    sudo ln -s /etc/nginx/sites-available/rub1c0n.tech /etc/nginx/sites-enabled/
    sudo nginx -t
    sudo systemctl restart nginx

Получение HTTPS (Let's Encrypt)

    sudo certbot --nginx -d rub1c0n.tech -d www.rub1c0n.tech

Результат:

└──  SSL установлен

└──  HTTP → HTTPS редирект включен

└──  Сертификат автообновляется

Проверка

    curl -I http://127.0.0.1:8080
    curl -I https://rub1c0n.tech

Ожидаем:

└──  HTTP/1.1 200 OK

Итоговая архитектура

    Internet
       ↓ ↑
    VPS Nginx (host, HTTPS)
       ↓ ↑
    127.0.0.1:8080
       ↓ ↑
    Docker Nginx
       ↓ ↑
    Laravel (PHP-FPM)
       ↓ ↑
    MariaDB / Redis / Mosquitto