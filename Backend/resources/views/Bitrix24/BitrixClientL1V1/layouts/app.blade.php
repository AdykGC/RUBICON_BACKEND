<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Inter, Arial, sans-serif;
            background: #f5f7fb;
        }

        .app-layout {
            display: flex;
            height: 100vh;
        }

        .app-sidebar {
            width: 240px;
            background: #111827;
            color: white;
            padding: 20px;
        }

        .logo {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .app-sidebar nav {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .app-sidebar a {
            color: white;
            text-decoration: none;
        }

        .app-content {
            flex: 1;
        }

        .workflow-layout {
            display: flex;
            height: 100vh;
        }

        .workflow-sidebar {
            width: 260px;
            background: white;
            border-right: 1px solid #e5e7eb;
            padding: 20px;
        }

        .workflow-canvas {
            flex: 1;
            background: #f8fafc;
            padding: 30px;
        }

        .workflow-properties {
            width: 300px;
            background: white;
            border-left: 1px solid #e5e7eb;
            padding: 20px;
        }

        .node-item {
            padding: 12px;
            margin-bottom: 10px;
            background: #eef2ff;
            border-radius: 8px;
            cursor: pointer;
        }

        .node {
            width: 220px;
            padding: 16px;
            background: white;
            border-radius: 12px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .08);
        }

        .start {
            border-left: 5px solid #2563eb;
        }

        .action {
            border-left: 5px solid #16a34a;
        }

        input,
        select {
            width: 100%;
            margin-top: 6px;
            margin-bottom: 16px;
            padding: 10px;
        }
    </style>
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