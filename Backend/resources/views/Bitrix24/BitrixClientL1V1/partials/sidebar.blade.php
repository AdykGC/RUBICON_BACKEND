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
    
    <button class="btn btn-trigger" onclick="window.workflowEditor && workflowEditor.addNodeFromTemplate('trigger_lead')">
        <span>🔔</span> Триггер (Лид создан)
    </button>
    <button class="btn btn-action" onclick="window.workflowEditor && workflowEditor.addNodeFromTemplate('action_task')">
        <span>⚙️</span> Действие (Создать задачу)
    </button>
    <button class="btn btn-export" onclick="window.workflowEditor && workflowEditor.exportWorkflow()">
        <span>📦</span> Экспорт JSON
    </button>
    <button class="btn btn-run" id="runButton" onclick="window.workflowEditor && workflowEditor.runWorkflow()">
        ▶ Выполнить workflow
    </button>
    <div class="log-panel" id="logPanel">
        <div class="log-entry">Готов к работе...</div>
    </div>
</aside>