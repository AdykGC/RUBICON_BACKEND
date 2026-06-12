import { TokenEngine } from "./TokenEngine.js";
import { NodeFactory } from "../Factory/NodeFactory.js";

export class WorkflowEditor {
    constructor(containerId) {
        this.editor = new Drawflow(document.getElementById(containerId));
        this.editor.start();

        this.factory = NodeFactory;

        this.engine = new TokenEngine({
            editor: this.editor,
            factory: this.factory,
            logger: this.log.bind(this)
        });

        this.init();
    }

    init() {
        this.renderInitial();
        this.bindUI();
        this.log("Editor ready", "success");
    }

    renderInitial() {
        const nodes = [
            { id: 1, template: "trigger_lead", x: 100, y: 100 },
            { id: 2, template: "action_task", x: 400, y: 200 }
        ];

        nodes.forEach(n => this.addNode(n));
    }

    addNode(node) {
        const def = this.factory.create(node.template).def;

        this.editor.addNode(
            def.type,
            def.inputs,
            def.outputs,
            node.x,
            node.y,
            def.class,
            { id: node.id, template: node.template, name: def.name },
            `<div class="node-box"><b>${def.name}</b></div>`
        );
    }

    runWorkflow() {
        this.engine.start();
    }

    bindUI() {}

    log(msg) {
        console.log(msg);
    }
}