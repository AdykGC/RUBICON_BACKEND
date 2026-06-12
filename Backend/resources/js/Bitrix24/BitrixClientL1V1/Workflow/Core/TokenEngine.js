import { Token } from "../Engine/Token.js";

export class TokenEngine {
    constructor({ editor, factory, logger }) {
        this.editor = editor;
        this.factory = factory;
        this.log = logger;
        this.queue = [];
        this.running = false;
    }

    start() {
        const startNodes = this.getStartNodes();

        this.queue = startNodes.map(id =>
            new Token({
                id: crypto.randomUUID(),
                nodeId: id,
                context: {}
            })
        );

        return this.run();
    }

    getStartNodes() {
        const data = this.editor.export().drawflow.Home.data;
        const result = [];

        for (const id in data) {
            const node = data[id];
            const hasInputs = Object.keys(node.inputs || {}).some(
                k => node.inputs[k].connections.length > 0
            );

            if (!hasInputs) {
                result.push(parseInt(id));
            }
        }

        return result;
    }

    async run() {
        if (this.running) return;
        this.running = true;

        this.log("🚀 Token engine started", "success");

        while (this.queue.length) {
            const token = this.queue.shift();
            await this.process(token);
        }

        this.running = false;
        this.log("✅ Workflow finished", "success");
    }

    async process(token) {
        const node = this.editor.getNodeFromId(token.nodeId);
        const template = node.data.template;

        const instance = this.factory.create(template);

        this.highlight(token.nodeId);

        const result = await instance.execute({
            node,
            context: token.context
        });

        this.unhighlight(token.nodeId);

        const nextNodes = this.getNextNodes(node, result);

        for (const nextId of nextNodes) {
            this.queue.push(
                new Token({
                    id: crypto.randomUUID(),
                    nodeId: nextId,
                    context: {
                        ...token.context,
                        ...(result?.context || {})
                    }
                })
            );
        }
    }

    getNextNodes(node, result) {
        const outputs = node.outputs || {};
        const next = [];

        for (const outKey in outputs) {
            const conns = outputs[outKey].connections || [];

            for (const c of conns) {
                next.push(parseInt(c.node));
            }
        }

        return next;
    }

    highlight(id) {
        const el = document.querySelector(`[data-node-id="${id}"]`);
        el?.classList.add("executing");
    }

    unhighlight(id) {
        const el = document.querySelector(`[data-node-id="${id}"]`);
        el?.classList.remove("executing");
    }
}