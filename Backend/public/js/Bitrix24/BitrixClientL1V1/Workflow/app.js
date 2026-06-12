// resources/js/Bitrix24/BitrixClientL1V1/Workflow/app.js

import { WorkflowEditor } from "./Core/WorkflowEditor.js";
// import { EventBus } from "./Core/EventBus.js"; // если понадобится
// import { TokenEngine } from "./Core/TokenEngine.js"; // он внутри WorkflowEditor

const editor = new WorkflowEditor("drawflow");
window.workflowEditor = editor;