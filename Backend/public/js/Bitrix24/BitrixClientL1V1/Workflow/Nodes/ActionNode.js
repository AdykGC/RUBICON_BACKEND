import { BaseNode } from "./BaseNode.js";

export class ActionNode extends BaseNode {
    async execute({ node }) {
        console.log("ACTION:", node.data.name);

        await new Promise(r => setTimeout(r, 500));

        return {
            context: {
                lastAction: node.data.name
            }
        };
    }
}