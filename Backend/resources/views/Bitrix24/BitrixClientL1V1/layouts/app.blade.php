<!DOCTYPE html>
<html lang="ru">


    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Workflow Constructor — Minimal</title>
        <!-- Google Fonts (Inter) -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        <!-- Drawflow CDN -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/drawflow/dist/drawflow.min.css">
        <script src="https://cdn.jsdelivr.net/npm/drawflow/dist/drawflow.min.js"></script>
        <!-- Vite -->
        @vite(['resources/css/Bitrix24/BitrixClientL1V1/app.css', 'resources/js/Bitrix24/BitrixClientL1V1/Workflow/app.js'])
    </head>


    <body>
        <div class="app-layout">
            @include('Bitrix24.BitrixClientL1V1.partials.sidebar')
            <main class="app-content"> @yield('content') </main>
        </div>
        @stack('scripts')
    </body>


</html>