import { TriggerNode } from "../Nodes/TriggerNode.js";
import { ActionNode } from "../Nodes/ActionNode.js";
import { NodeDefinitions } from "./NodeDefinitions.js";

export class NodeFactory {
    static map = {
        trigger: TriggerNode,
        action: ActionNode
    };

    static create(templateKey) {
        const def = NodeDefinitions[templateKey];
        const Class = this.map[def.type];

        return new Class(def);
    }
}