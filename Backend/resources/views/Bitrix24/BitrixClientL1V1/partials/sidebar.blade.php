<aside class="sidebar">
    <h3>⚡ RUB1C0N</h3>
<!--
    <nav>
        <a href="#"> Dashboard </a>
        <a href="#"> Workflows </a>
        <a href="#"> Logs </a>
        <a href="#"> Settings </a>
    </nav>
-->
    
    <button class="btn btn-trigger" onclick="window.app && app.addNodeFromTemplate('trigger_lead')">
        <span>🔔</span> Триггер (Лид создан)
    </button>
    <button class="btn btn-trigger" onclick="window.app && app.addNodeFromTemplate('trigger_lead')">
        <span>⚙️</span> Действие (Создать задачу)
    </button>
    <button class="btn btn-export" onclick="app.exportWorkflow()">
        <span>📦</span> Экспорт JSON
    </button>
    <button class="btn btn-run" id="runButton" onclick="app.runWorkflow()">
        ▶ Выполнить workflow
    </button>
    <div class="log-panel" id="logPanel">
        <div class="log-entry">Готов к работе...</div>
    </div>
</aside>
