{{-- resources/views/bitrix/dashboard.blade.php --}}

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Rub1c0n · Панель в Bitrix24</title>
    <script src="https://api.bitrix24.com/api/v1/"></script>
    <style>
        :root {
            --bg: #0f172a;
            --card-bg: #020617;
            --accent: #22c55e;
            --accent-soft: rgba(34,197,94,0.12);
            --accent-border: rgba(34,197,94,0.35);
            --text-main: #e5e7eb;
            --text-muted: #94a3b8;
            --border-subtle: rgba(148,163,184,0.28);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 24px;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: radial-gradient(circle at top, #1e293b 0, #020617 60%);
            color: var(--text-main);
        }

        .shell {
            max-width: 880px;
            margin: 0 auto;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 18px;
        }

        .title-block {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .app-title {
            font-size: 20px;
            font-weight: 600;
            letter-spacing: 0.02em;
        }

        .app-subtitle {
            font-size: 13px;
            color: var(--text-muted);
        }

        .pill {
            padding: 6px 10px;
            border-radius: 999px;
            border: 1px solid var(--accent-border);
            background: radial-gradient(circle at top left, var(--accent-soft), rgba(15,23,42,0.9));
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.09em;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .pill-dot {
            width: 6px;
            height: 6px;
            border-radius: 999px;
            background: var(--accent);
            box-shadow: 0 0 0 4px rgba(34,197,94,0.25);
        }

        .grid {
            display: grid;
            grid-template-columns: minmax(0, 1.4fr) minmax(0, 1fr);
            gap: 16px;
        }

        .card {
            border-radius: 16px;
            padding: 16px 16px 14px;
            background: linear-gradient(135deg, rgba(15,23,42,0.96), var(--card-bg));
            border: 1px solid var(--border-subtle);
            box-shadow:
                0 18px 45px rgba(15,23,42,0.65),
                0 0 0 1px rgba(15,23,42,0.9);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .card-title {
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: var(--text-muted);
        }

        .badge {
            font-size: 11px;
            padding: 4px 8px;
            border-radius: 999px;
            border: 1px solid rgba(148,163,184,0.5);
            color: var(--text-muted);
        }

        .metric-row {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin: 6px 0 10px;
        }

        .metric {
            flex: 1 1 120px;
            padding: 8px 10px;
            border-radius: 10px;
            background: radial-gradient(circle at top left, rgba(15,23,42,0.3), rgba(15,23,42,1));
            border: 1px solid rgba(51,65,85,0.7);
        }

        .metric-label {
            font-size: 11px;
            color: var(--text-muted);
            margin-bottom: 4px;
        }

        .metric-value {
            font-size: 15px;
            font-weight: 600;
        }

        .metric-hint {
            margin-top: 2px;
            font-size: 11px;
            color: var(--text-muted);
        }

        .list {
            margin: 4px 0 0;
            padding-left: 16px;
            font-size: 13px;
            color: var(--text-muted);
        }

        .divider {
            margin: 10px 0;
            border: none;
            border-top: 1px dashed rgba(51,65,85,0.9);
        }

        .btn-row {
            margin-top: 6px;
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .btn {
            border: none;
            border-radius: 999px;
            padding: 7px 14px;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: radial-gradient(circle at top left, var(--accent-soft), rgba(22,163,74,0.12));
            color: var(--accent);
            border: 1px solid var(--accent-border);
        }

        .btn-secondary {
            background: rgba(15,23,42,0.9);
            border-color: rgba(148,163,184,0.45);
            color: var(--text-main);
        }

        .btn:active {
            transform: translateY(1px);
        }

        .hint {
            margin-top: 6px;
            font-size: 11px;
            color: var(--text-muted);
        }

        @media (max-width: 768px) {
            body {
                padding: 16px;
            }
            .grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
<div class="shell">
    <div class="header">
        <div class="title-block">
            <div class="app-title">Rub1c0n · Панель в Bitrix24</div>
            <div class="app-subtitle">
                Помогает работать со сделками прямо внутри Bitrix24, без переключения между системами.
            </div>
        </div>
        <div class="pill">
            <span class="pill-dot"></span>
            <span>Подключено к порталу</span>
        </div>
    </div>

    <div class="grid">
        {{-- Левая колонка: кто сейчас в портале и что уже настроено --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title">Текущий пользователь</div>
                <div class="badge" id="portal-domain-badge">Портал: —</div>
            </div>

            @php
                $u = $userInfo ?? [];
            @endphp

            <div class="metric-row">
                <div class="metric">
                    <div class="metric-label">Имя в Bitrix24</div>
                    <div class="metric-value" id="user-name">
                        {{ $u['NAME'] ?? 'Определяем через API…' }}
                    </div>
                    <div class="metric-hint" id="user-email">
                        {{ $u['EMAIL'] ?? 'Email уточним после запроса к порталу.' }}
                    </div>
                </div>

                <div class="metric">
                    <div class="metric-label">Режим работы</div>
                    <div class="metric-value">LITE</div>
                    <div class="metric-hint">
                        Данные берутся из Bitrix24 по токену установки.
                    </div>
                </div>
            </div>

            <hr class="divider">

            <ul class="list">
                <li>Мы работаем внутри вашего портала — домен Bitrix24 подтягивается автоматически.</li>
                <li>Все операции выполняются от имени установленного приложения, не от имени пользователя.</li>
            </ul>

            <div class="btn-row">
                <button class="btn" id="btn-refresh">Обновить данные из Bitrix24</button>
                <button class="btn btn-secondary" id="btn-open-deal">
                    Открыть текущую сделку
                </button>
            </div>

            <div class="hint">
                Если что‑то не обновляется, попробуйте перезапустить приложение из раздела «Приложения».
            </div>
        </div>

        {{-- Правая колонка: что делает Rub1c0n в CRM --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title">Что делает это приложение</div>
                <div class="badge">CRM Deal Tab + Events</div>
            </div>

            <ul class="list">
                <li><strong>Добавляет вкладку в сделку.</strong> В карточке сделки появляется вкладка Rub1c0n с вашим интерфейсом.</li>
                <li><strong>Подписывается на события CRM.</strong> Приложение реагирует на создание/обновление сделок.</li>
                <li><strong>Работает через REST.</strong> Взаимодействие с Bitrix24 идёт по официальному API.</li>
            </ul>

            <hr class="divider">

            <ul class="list">
                <li>Когда вы открываете сделку, Bitrix24 грузит наш виджет в отдельный iframe.</li>
                <li>Мы используем токены, полученные на этапе установки, чтобы читать и записывать данные по сделке.</li>
            </ul>

            <div class="hint">
                Эти настройки не меняют ваш портал, а только управляют тем, как Rub1c0n встраивается в интерфейс Bitrix24.
            </div>
        </div>
    </div>
</div>

<script>
    BX24.init(function () {
        BX24.fitWindow();

        // Подставляем домен портала в бейдж
        try {
            const auth = BX24.getAuth();
            if (auth && auth.domain) {
                const badge = document.getElementById('portal-domain-badge');
                badge.textContent = 'Портал: ' + auth.domain;
            }
        } catch (e) {
            console.warn('BX24.getAuth error', e);
        }

        // Кнопка "Обновить данные из Bitrix24"
        document.getElementById('btn-refresh').addEventListener('click', function () {
            try {
                BX24.callMethod('profile', {}, function (res) {
                    if (res.error()) {
                        console.error('profile error', res.error());
                        return;
                    }
                    const data = res.data();
                    if (!data) return;

                    document.getElementById('user-name').textContent =
                        (data.NAME || '') + ' ' + (data.LAST_NAME || '');
                    document.getElementById('user-email').textContent =
                        data.EMAIL || 'Email не указан в профиле';
                });
            } catch (e) {
                console.error('refresh click error', e);
            }
        });

        // Кнопка "Открыть текущую сделку" (если вызвано из карточки сделки)
        document.getElementById('btn-open-deal').addEventListener('click', function () {
            try {
                // Если приложение открыто как вкладка сделки, Bitrix передаёт параметры в PLACEMENT_OPTIONS.
                BX24.placement.info(function(info){
                    console.log('placement.info', info);

                    const options = info && info.options
                        ? info.options
                        : {};

                    const dealId = options.ID || options.DEAL_ID;

                    if (dealId) {
                        BX24.openLink('/crm/deal/details/' + dealId + '/');
                    } else {
                        alert('Не удалось определить текущую сделку. Откройте приложение из карточки сделки.');
                    }
                });
            } catch (e) {
                console.error('open deal error', e);
            }
        });
    });
</script>
</body>
</html>