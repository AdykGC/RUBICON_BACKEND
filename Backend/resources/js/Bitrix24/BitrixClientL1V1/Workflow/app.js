import { WorkflowEditor } from "./Core/WorkflowEditor.js";
// import { EventBus } from "./Core/EventBus.js"; // если понадобится
// import { TokenEngine } from "./Core/TokenEngine.js"; // он внутри WorkflowEditor

const app = new WorkflowEditor("drawflow");
window.app = app;