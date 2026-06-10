<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/drawflow/dist/drawflow.min.css">
    <script src="https://cdn.jsdelivr.net/npm/drawflow/dist/drawflow.min.js"></script>

    <title>Workflow Builder</title>

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
            overflow: hidden;
        }

        .workflow-layout {
            display: flex;
            height: 100%;
        }

        .workflow-sidebar {
            width: 260px;
            background: white;
            border-right: 1px solid #e5e7eb;
            padding: 20px;
        }

        .workflow-canvas {
            flex: 1;
            position: relative;
            overflow: auto;
            background: #f8fafc;
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
            box-shadow: 0 2px 8px rgba(0,0,0,.08);
            cursor: pointer;
            user-select: none;
        }

        /* Событие */

        .trigger,
        .start {
            border-left: 5px solid #2563eb;
        }

        /* Действие */

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

    @stack('styles')
</head>

<body>

<div class="app-layout">

    @include('Bitrix24.BitrixClientL1V1.partials.sidebar')

    <main class="app-content">
        @yield('content')
    </main>

</div>

<script>
    window.workflow = @json($workflow ?? []);

    console.log('Workflow:', window.workflow);

    document.addEventListener('DOMContentLoaded', () => {

        document.querySelectorAll('.node').forEach(node => {

            node.addEventListener('click', () => {

                console.log(
                    'Node selected:',
                    node.dataset.id
                );

            });

        });

    });
</script>

@stack('scripts')

</body>
</html>