<!-- rubicon.blade -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- убирает мигание до загрузки Vue -->
    <style>
        [v-cloak] { display: none; }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-black">

    <div id="app" v-cloak></div>

</body>
</html>

<!--
🔥 Почему это важно
1. @vite(['css', 'js'])
    👉 У тебя сейчас не подключается Tailwind / стили (если они в app.css)
2. viewport
    👉 Без этого на мобилке всё поедет
3. v-cloak
    👉 Без него будет:
        сначала “сырой HTML”
        потом Vue перерисует
        (выглядит как мигание)
4. body class="bg-black"
    👉 Чтобы не было белого фона до загрузки
-->