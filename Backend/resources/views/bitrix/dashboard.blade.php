<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мое приложение</title>

    <script src="https://api.bitrix24.com/api/v1/"></script>

    <style>
        body {
            font-family: system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
            padding: 20px;
            background: #f5f7fa;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        h1 { margin-top: 0; color: #2c3e50; }
        .info { background: #eef2f7; padding: 16px; border-radius: 8px; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Добро пожаловать в приложение!</h1>
        <div class="info">
            <p><strong>Пользователь:</strong> {{ $userInfo['result']['NAME'] ?? 'Не определен' }}</p>
            <p><strong>Email:</strong> {{ $userInfo['result']['EMAIL'] ?? 'Не указан' }}</p>
        </div>
    </div>

    <script>
BX24.init(function () {
    console.log('BX24 ready');

    const params = new URLSearchParams(window.location.search);

    if (params.get('install') === 'Y') {
        BX24.installFinish();
    }
});
</script>
</body>
</html>