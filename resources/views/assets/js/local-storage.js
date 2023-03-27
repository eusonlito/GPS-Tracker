'use strict';

export default class {
    constructor(name) {
        this.name = name;
        this.available = this.isAvailable();
    }

    isAvailable() {
        return this.name
            && this.name.length
            && this.storage() !== false;
    }

    set(name, value) {
        if (!this.available) {
            return;
        }

        let storage = this.storage();

        if (!name || !name.length) {
            storage = value;
        } else if (typeof name === 'object') {
            storage = {...storage, ...name };
        } else {
            storage[name] = value;
        }

        localStorage.setItem(this.name, JSON.stringify(storage));
    }

    get(name) {
        if (!this.available) {
            return;
        }

        const storage = this.storage();

        if (!name || !name.length) {
            return storage;
        }

        return storage[name] || null;
    }

    del(name) {
        if (!this.available) {
            return;
        }

        let storage = this.storage();

        if (!name || !name.length) {
            storage = {};
        } else {
            delete storage[name];
        }

        localStorage.setItem(this.name, JSON.stringify(storage));
    }

    storage() {
        const storage = localStorage.getItem(this.name);

        if (!storage) {
            return {};
        }

        try {
            return JSON.parse(storage) || {};
        } catch (e) {
            return false;
        }
    }
}
