<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Rub1c0n install wizard</title>
    <script src="https://api.bitrix24.com/api/v1/"></script>
</head>
<body>
<script>
    BX24.init(function () {
        BX24.fitWindow();

        BX24.callMethod('placement.bind', {
            PLACEMENT: 'CRM_DEAL_DETAIL_TAB',
            HANDLER: 'https://rub1c0n.tech/bitrix/placement/deal-tab',
            TITLE: 'Rub1c0n',
            DESCRIPTION: 'Виджет сделки'
        });

        BX24.callMethod('event.bind', {
            event: 'ONCRMDEALADD',
            handler: 'https://rub1c0n.tech/bitrix/events/crm-deal-add'
        });

        BX24.installFinish();
    });
</script>
</body>
</html>