    ОБНОВЛЕНИЕ СИСТЕМЫ
sudo apt update && sudo apt upgrade -y
    УСТАНОВКА DOCKER (ТВОЯ ОСНОВА)
sudo apt install docker.io docker-compose -y
    Включаем автозапуск Docker:
sudo systemctl enable docker
sudo systemctl start docker
    Проверка:
docker --version
docker-compose version


    КОРОТКО
Ты сейчас на этапе:
VPS → чистый сервер → установка Docker


    Создаём папку сами:
sudo mkdir -p /var/www
    Даём себе доступ:
sudo chown -R $USER:$USER /var/www
    ЗАЛИВАЕМ ПРОЕКТ НА VPS
cd /var/www



GitHub Actions (ЛУЧШИЙ вариант)
    сам подключается к VPS и делает deploy

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