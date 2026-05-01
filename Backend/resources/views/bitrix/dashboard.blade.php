<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rub1c0n Dashboard</title>

    <!-- Bitrix JS API -->
    <script src="https://api.bitrix24.com/api/v1/"></script>

    <style>
        body {
            font-family: system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
            padding: 20px;
            background: #f5f7fa;
            margin: 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        h1 {
            margin-top: 0;
            color: #2c3e50;
        }

        .info {
            background: #eef2f7;
            padding: 16px;
            border-radius: 8px;
            margin-top: 20px;
        }

        .btn {
            margin-top: 20px;
            padding: 10px 15px;
            background: #2fc6f6;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .btn:hover {
            background: #1aa7d8;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Добро пожаловать в приложение</h1>

    @php
        $user = $userInfo['result'] ?? [];
    @endphp

    <div class="info">
        <p><strong>Имя:</strong> {{ $user['NAME'] ?? 'Не определено' }}</p>
        <p><strong>Email:</strong> {{ $user['EMAIL'] ?? 'Не указан' }}</p>
    </div>

    <button class="btn" onclick="location.reload()">
        Обновить данные
    </button>
</div>

<script>
BX24.init(function () {
    console.log('BX24 ready');

    // ✅ Авто-адаптация iframe
    BX24.fitWindow();

    // ✅ Завершение установки (ВАЖНО для Маркета)
    const params = new URLSearchParams(window.location.search);
    if (params.get('install') === 'Y') {
        BX24.installFinish();
    }
});
</script>

</body>
</html>