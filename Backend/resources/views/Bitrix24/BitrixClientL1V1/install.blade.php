<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Rub1c0n Install Wizard</title>
    <script src="https://api.bitrix24.com/api/v1/"></script>
    <style>
        body { font-family: Arial; padding: 20px; }
        .step { margin: 10px 0; }
        .ok { color: green; }
        .err { color: red; }
        .log { background: #111; color: #0f0; padding: 10px; height: 200px; overflow: auto; }
    </style>
</head>
<body>

<h2>Install Rub1c0n</h2>

<div id="log" class="log"></div>

<div id="steps">
    <div id="s1">1. Auth</div>
    <div id="s2">2. Placement bind</div>
    <div id="s3">3. Event bind</div>
    <div id="s4">4. Test event</div>
    <div id="s5">5. Finish</div>
</div>

<script>
function log(msg) {
    const el = document.getElementById('log');
    el.innerHTML += msg + "<br>";
    el.scrollTop = el.scrollHeight;
}

function ok(id, text) {
    document.getElementById(id).innerHTML = "✔ " + text;
    document.getElementById(id).className = "ok";
}

function err(id, text) {
    document.getElementById(id).innerHTML = "✖ " + text;
    document.getElementById(id).className = "err";
}

BX24.init(async function () {

    try {

        BX24.fitWindow();

        // =========================
        // 1. AUTH
        // =========================
        const auth = BX24.getAuth();
        log("AUTH: " + JSON.stringify(auth));
        ok("s1", "Auth OK");

        const memberId = auth.member_id;

        // =========================
        // 2. PLACEMENT
        // =========================
        await new Promise((resolve, reject) => {

            BX24.callMethod("placement.bind", {
                PLACEMENT: "CRM_DEAL_DETAIL_TAB",
                TITLE: "Rub1c0n",
                HANDLER: "{{ config('app.url') }}/api/bitrix/placement/deal-tab?member_id=" + memberId,
            }, function(res) {

                if (res.error()) {
                    log("placement error: " + res.error());
                    err("s2", "Placement failed");
                    return reject(res.error());
                }

                log("placement OK");
                ok("s2", "Placement OK");
                resolve();
            });
        });

        // =========================
        // 3. EVENT BIND
        // =========================
        await new Promise((resolve, reject) => {

            BX24.callMethod("event.bind", {
                event: "ONCRMDEALADD",
                handler: "{{ config('app.url') }}/api/bitrix/events/ONCRMDEALADD?member_id=" + memberId,
            }, function(res) {

                if (res.error()) {
                    log("event error: " + res.error());
                    err("s3", "Event bind failed");
                    return reject(res.error());
                }

                log("event OK");
                ok("s3", "Event OK");
                resolve();
            });
        });

        // =========================
        // 4. TEST EVENT (ВАЖНО)
        // =========================
        log("Trigger test event...");

        // создаём тестовую сделку чтобы проверить pipeline
        BX24.callMethod("crm.deal.add", {
            fields: {
                TITLE: "TEST INSTALL DEAL",
                OPPORTUNITY: 1000
            }
        }, function(res) {

            if (res.error()) {
                log("test deal error: " + res.error());
                err("s4", "Test event failed");
                return;
            }

            log("Test deal created: " + JSON.stringify(res.data()));
            ok("s4", "Event pipeline triggered");

            setTimeout(() => {
                log("Check Laravel logs + queue worker");
            }, 2000);
        });

        // =========================
        // 5. FINISH
        // =========================
        setTimeout(() => {

            BX24.installFinish();
            ok("s5", "Installed");

            log("INSTALL COMPLETE");

            setTimeout(() => {
                try { BX24.closeApplication(); } catch(e) {}
            }, 1500);

        }, 3000);

    } catch (e) {
        log("ERROR: " + e);
        console.error(e);
    }
});
</script>

</body>
</html>