<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Rub1c0n Install</title>
    <script src="https://api.bitrix24.com/api/v1/"></script>

    <style>
        body { font-family: Arial; padding: 20px; }
        .ok { color: green; }
        .err { color: red; }
        .log { background: #111; color: #0f0; padding: 10px; height: 200px; overflow: auto; }
    </style>
</head>
<body>

<h2>Rub1c0n Installation</h2>

<div id="log" class="log"></div>

<div id="s1">1. Check portal</div>
<div id="s2">2. Install status</div>
<div id="s3">3. Finish</div>

<script>
function log(msg) {
    document.getElementById('log').innerHTML += msg + "<br>";
}

function ok(id, text) {
    const el = document.getElementById(id);
    el.innerHTML = "✔ " + text;
    el.className = "ok";
}

function err(id, text) {
    const el = document.getElementById(id);
    el.innerHTML = "✖ " + text;
    el.className = "err";
}

BX24.init(function () {

    BX24.fitWindow();

    try {
        // 1. Только читаем контекст Bitrix (для логов/отладки)
        const auth = BX24.getAuth();
        log("Portal: " + auth.domain);
        ok("s1", "Portal OK");

        // 2. ВАЖНО:
        // Install УЖЕ произошёл на backend (/api/bitrix/install)
        // здесь мы НЕ сохраняем ничего

        ok("s2", "Already installed on server");
        log("Backend already processed install event");

        // 3. Финализация UI
        BX24.installFinish();
        ok("s3", "Finished");

        log("INSTALL COMPLETE");

        setTimeout(() => {
            try { BX24.closeApplication(); } catch(e) {}
        }, 1200);

    } catch (e) {
        console.error(e);
        err("s2", "Error");
        log("ERROR: " + e);
    }
});
</script>

</body>
</html>