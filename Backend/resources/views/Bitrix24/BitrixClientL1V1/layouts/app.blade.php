<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/Bitrix24/BitrixClientL1V1/app.css" >
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