<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rubicon | Smart Vending Payments</title>

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        html { scroll-behavior: smooth; }
        body { background-color: black; }

        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #000; }
        ::-webkit-scrollbar-thumb { background: #333; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #444; }
    </style>
</head>

<body class="bg-black text-white font-sans relative overflow-y-auto">

<!-- ВСЁ остальное можно оставить БЕЗ изменений -->

<script>
    function goToPayment() {
        window.location.href = "{{ url('/pay?id=RUB-001') }}";
    }

    function downloadAPK() {
        const link = document.createElement('a');
        link.href = "{{ asset('app-rubicon-release.apk') }}";
        link.download = 'Rubicon_Vending.apk';
        link.click();
    }
</script>

</body>
</html>