{{-- resources/views/bitrix/install.blade.php --}}

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Установка приложения Rub1c0n</title>
    <script src="https://api.bitrix24.com/api/v1/"></script>
    <style>
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: #f5f7fa;
            margin: 0;
            padding: 24px;
        }

        .container {
            max-width: 520px;
            margin: 40px auto;
            background: #fff;
            border-radius: 16px;
            padding: 24px 24px 18px;
            box-shadow: 0 4px 16px rgba(15, 23, 42, 0.12);
        }

        h1 {
            margin: 0 0 8px;
            font-size: 20px;
            color: #111827;
        }

        .subtitle {
            margin: 0 0 16px;
            font-size: 14px;
            color: #6b7280;
        }

        .steps {
            margin: 16px 0 12px;
            padding: 0;
            list-style: none;
            font-size: 14px;
        }

        .step {
            display: flex;
            align-items: center;
            margin-bottom: 6px;
            color: #4b5563;
        }

        .step-status {
            width: 18px;
            height: 18px;
            border-radius: 999px;
            margin-right: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
        }

        .step-status.pending {
            border: 2px solid #9ca3af;
        }

        .step-status.active {
            border: 2px solid #3b82f6;
            border-top-color: transparent;
            border-right-color: transparent;
            animation: spin 0.75s linear infinite;
        }

        .step-status.done {
            background: #22c55e;
            color: #fff;
        }

        .step-status.error {
            background: #ef4444;
            color: #fff;
        }

        .log {
            margin-top: 10px;
            padding: 8px 10px;
            font-size: 12px;
            color: #6b7280;
            background: #f9fafb;
            border-radius: 8px;
            max-height: 140px;
            overflow: auto;
            white-space: pre-wrap;
        }

        .hint {
            margin-top: 8px;
            font-size: 11px;
            color: #9ca3af;
        }

        .success {
            margin-top: 10px;
            font-size: 13px;
            color: #16a34a;
            display: none;
        }

        .error-text {
            margin-top: 10px;
            font-size: 13px;
            color: #ef4444;
            display: none;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>



<body>
<div class="container">
    <h1>Установка приложения Rub1c0n</h1>
    <p class="subtitle">Регистрируем виджеты и события в Bitrix24. Это займёт несколько секунд.</p>
    <ul class="steps">
        <li class="step" id="step-auth">
            <span class="step-status pending" id="step-auth-status"></span>
            Получение параметров портала
        </li>
        <li class="step" id="step-placement">
            <span class="step-status pending" id="step-placement-status"></span>
            Регистрация вкладки сделки
        </li>
        <li class="step" id="step-events">
            <span class="step-status pending" id="step-events-status"></span>
            Подписка на события CRM
        </li>
        <li class="step" id="step-finish">
            <span class="step-status pending" id="step-finish-status"></span>
            Завершение установки
        </li>
    </ul>
    <div class="log" id="log"></div>
    <div class="success" id="success">
        ✔ Установка завершена. Окно закроется автоматически.
    </div>
    <div class="error-text" id="error">
        Произошла ошибка во время установки. Подробнее см. в логах браузера (F12 → Console).
    </div>
    <div class="hint">
        Если окно не закроется, просто обновите страницу или откройте приложение из списка установленных.
    </div>
</div>



<script>
    function log(msg) {
        const el = document.getElementById('log');
        el.textContent += msg + "\n";
        el.scrollTop = el.scrollHeight;
    }

    function setStep(id, state) {
        const el = document.getElementById(id + '-status');
        el.classList.remove('pending', 'active', 'done', 'error');
        el.textContent = '';
        if (state === 'pending') {
            el.classList.add('pending');
        } else if (state === 'active') {
            el.classList.add('active');
        } else if (state === 'done') {
            el.classList.add('done');
            el.textContent = '✔';
        } else if (state === 'error') {
            el.classList.add('error');
            el.textContent = '!';
        }
    }

    BX24.init(async function () {
        try {
            BX24.fitWindow();

            // 1. Auth
            setStep('step-auth', 'active');
            const auth = BX24.getAuth();
            log('Auth: ' + JSON.stringify(auth));
            setStep('step-auth', 'done');

            // 2. placement.bind
            setStep('step-placement', 'active');
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
                        const err = result.error();
                        log('placement.bind error: ' + err);

                        // Если обработчик уже привязан — считаем шаг успешным
                        if (err.indexOf('Handler already binded') !== -1) {
                            log('placement.bind: handler уже привязан, шаг считаем OK');
                            setStep('step-placement', 'done');
                            return resolve();
                        }

                        setStep('step-placement', 'error');
                        return reject(err);
                    }

                    log('placement.bind OK: ' + JSON.stringify(result.data()));
                    setStep('step-placement', 'done');
                    resolve();
                });
            });

            // 3. event.bind
            setStep('step-events', 'active');
            await new Promise((resolve, reject) => {
                BX24.callMethod('event.bind', {
                    event: 'ONCRMDEALADD',
                    handler: '{{ config('app.url') }}/bitrix/events/crm-deal-add'
                        + '?member_id=' + encodeURIComponent(auth.member_id)
                        + '&application_token={{ $applicationTokenFromServer }}'
                }, function (result) {
                    if (result.error()) {
                        const err = result.error();
                        log('event.bind error: ' + err);

                        // Если обработчик события уже зарегистрирован — тоже считаем ОК
                        if (err.indexOf('Handler already binded') !== -1 ||
                            err.indexOf('event handler already registered') !== -1) {
                            log('event.bind: handler уже привязан, шаг считаем OK');
                            setStep('step-events', 'done');
                            return resolve();
                        }

                        setStep('step-events', 'error');
                        return reject(err);
                    }

                    log('event.bind OK: ' + JSON.stringify(result.data()));
                    setStep('step-events', 'done');
                    resolve();
                });
            });

            // 4. installFinish
            setStep('step-finish', 'active');
            setTimeout(function () {
                BX24.installFinish();
                setStep('step-finish', 'done');
                log('installFinish called');
            }, 500);

            document.getElementById('success').style.display = 'block';

            // На всякий случай: если Bitrix не закрыл окно сам — пробуем
            setTimeout(function () {
                try { BX24.closeApplication(); } catch (e) {}
            }, 2000);

        } catch (e) {
            console.error(e);
            log('Install error: ' + e);
            document.getElementById('error').style.display = 'block';
            setStep('step-finish', 'error');
            alert('Ошибка при установке приложения. Подробности в логах браузера.');
        }
    });
</script>

</body>
</html>





{{--
    Этот экран установки делает одну конкретную вещь: подключает твоё приложение к Bitrix24 и «встраивает» его в CRM, чтобы потом оно работало прямо в карточке сделки.

    По шагам, человеческим языком
    Когда пользователь в Bitrix24 жмёт «Установить приложение Rub1c0n», Bitrix открывает вот этот экран в боковом окне.

    Дальше внутри него происходит:

    Получение данных портала.
    Скрипт спрашивает у Bitrix: «Кто меня установил? Какой это портал? Какой у него идентификатор?» — это member_id, домен и т.п.

    Регистрация вкладки в сделке.
    Приложение говорит Битриксу:
    Добавь, пожалуйста, во вкладки карточки сделки новую вкладку “Rub1c0n”, и когда её откроют — загружай мой URL https://rub1c0n.tech/bitrix/placement/deal-tab.

    Подписка на события.
    Приложение просит:
    Сообщай мне каждый раз, когда создаётся новая сделка (событие ONCRMDEALADD), по вот этому адресу https://rub1c0n.tech/bitrix/events/crm-deal-add.

    Сообщение Битриксу “я установился”.
    В конце вызывается BX24.installFinish(), это сигнал Bitrix24:
    «Все мои шаги установки выполнены, можно считать приложение установленным и закрывать это окно.»

    На экране ты просто видишь текст «Установка приложения Rub1c0n» и прогресс, а настоящая работа идёт «за кадром» — приложение регистрируется внутри Bitrix24, чтобы потом:

    у сделок появилась вкладка Rub1c0n;

    твой сервер мог реагировать на события CRM;

    и в дальнейшем ты уже реализовывал свою бизнес‑логику (подсчёт маржи, проверки, виджеты и т.д.) поверх этого подключения.
--}}