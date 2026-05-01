{{-- resources/views/bitrix/install.blade.php --}}

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Установка приложения Rub1c0n</title>
    <script src="https://api.bitrix24.com/api/v1/"></script>
    <style>
        body { font-family: system-ui, sans-serif; background: #f5f7fa; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 40px auto; background: #fff; border-radius: 12px; padding: 24px;
                     box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        h1 { margin-top: 0; }
        .log { font-size: 13px; color: #555; margin-top: 16px; white-space: pre-wrap; }
    </style>
</head>
<body>
<div class="container">
    <h1>Установка приложения Rub1c0n</h1>
    <p>Пожалуйста, подождите, идёт регистрация виджетов и событий…</p>
    <div class="log" id="log"></div>
</div>

<script>
function log(msg) {
    const el = document.getElementById('log');
    el.textContent += msg + "\n";
}

BX24.init(async function () {
    try {
        BX24.fitWindow();

        const auth = BX24.getAuth(); // даёт member_id, DOMAIN, auth_id и т.д.[web:38]
        log('Auth: ' + JSON.stringify(auth));

        // 1. Регистрируем placement
        await new Promise((resolve, reject) => {
            BX24.callMethod('placement.bind', {
                PLACEMENT: 'CRM_DEAL_DETAIL_TAB',
                HANDLER: '{{ config('app.url') }}/bitrix/placement/deal-tab'
                    + '?member_id=' + encodeURIComponent(auth.member_id)
                    + '&application_token={{ $applicationTokenFromServer }}',
                TITLE: 'Rub1c0n',
                DESCRIPTION: 'Виджет сделки'
            }, function (result) {
                if (result.error()) {
                    log('placement.bind error: ' + result.error());
                    return reject(result.error());
                }
                log('placement.bind OK: ' + JSON.stringify(result.data()));
                resolve();
            });
        });

        // 2. Подписываемся на события
        await new Promise((resolve, reject) => {
            BX24.callMethod('event.bind', {
                event: 'ONCRMDEALADD',
                handler: '{{ config('app.url') }}/bitrix/events/crm-deal-add'
                    + '?member_id=' + encodeURIComponent(auth.member_id)
                    + '&application_token={{ $applicationTokenFromServer }}'
            }, function (result) {
                if (result.error()) {
                    log('event.bind error: ' + result.error());
                    return reject(result.error());
                }
                log('event.bind OK: ' + JSON.stringify(result.data()));
                resolve();
            });
        });

        // 3. Завершаем установку
        BX24.installFinish(); // обязательный шаг для мастера установки[web:10][web:36][web:39]
        log('installFinish called');
    } catch (e) {
        console.error(e);
        log('Install error: ' + e);
        alert('Ошибка при установке приложения. Подробности в логах браузера.');
    }
});
</script>
</body>
</html>