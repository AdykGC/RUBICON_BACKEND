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



HTTPS

sudo apt update
sudo apt install certbot python3-certbot-nginx -y

⚠️ Важное условие (часто ломается тут)

Перед запуском certbot должно быть:

✅ Домен rub1c0n.tech указывает на твой VPS
✅ Nginx уже настроен с:

server_name rub1c0n.tech www.rub1c0n.tech;

✅ Сайт открывается хотя бы по HTTP:

http://rub1c0n.tech
🚀 После этого запускаешь:
sudo certbot --nginx -d rub1c0n.tech -d www.rub1c0n.tech

Он:

проверит домен
выпустит бесплатный SSL (Let's Encrypt)
сам изменит конфиг nginx
включит редирект на HTTPS