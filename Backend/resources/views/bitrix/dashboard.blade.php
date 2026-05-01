{{-- resources/views/bitrix/dashboard.blade.php --}}

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Rub1c0n Dashboard</title>
    <script src="https://api.bitrix24.com/api/v1/"></script>
    <style>/* твой CSS */</style>
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

    <button class="btn" onclick="location.reload()">Обновить данные</button>
</div>

<script>
BX24.init(function () {
    BX24.fitWindow();
});
</script>
</body>
</html>