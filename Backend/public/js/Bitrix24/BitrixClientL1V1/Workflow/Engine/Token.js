export class Token {
    constructor({ id, nodeId, context = {} }) {
        this.id = id;
        this.nodeId = nodeId;
        this.context = context;
    }
}