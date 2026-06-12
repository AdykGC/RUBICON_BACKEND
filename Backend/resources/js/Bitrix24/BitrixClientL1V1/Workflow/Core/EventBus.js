export class EventBus {
    constructor() {
        this.events = {};
    }

    on(event, fn) {
        if (!this.events[event]) this.events[event] = [];
        this.events[event].push(fn);
    }

    emit(event, data) {
        (this.events[event] || []).forEach(fn => fn(data));
    }
}