export class BaseNode {
    constructor(def) {
        this.def = def;
    }

    async execute({ node, context }) {
        return {};
    }

    render() {
        return `<div class="node-box">
            <b>${this.def.name}</b>
        </div>`;
    }
}