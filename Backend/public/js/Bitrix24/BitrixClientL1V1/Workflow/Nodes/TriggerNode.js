import { BaseNode } from "./BaseNode.js";

export class TriggerNode extends BaseNode {
    async execute({ node }) {
        console.log("TRIGGER:", node.data.name);

        return {
            context: {
                triggered: true
            }
        };
    }
}