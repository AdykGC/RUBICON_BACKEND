<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        @vite('resources/js/Bitrix24/BitrixClientL1V1/app.js')
    </head>
    <body>
        <div class="app-layout">
            @include('Bitrix24.BitrixClientL1V1.partials.sidebar')
            <main class="app-content">
                @yield('content')
            </main>
        </div>
    </body>
</html>