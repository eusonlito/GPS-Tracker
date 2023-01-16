'use strict';

export default class {
    constructor(name) {
        this.name = name;
    }

    set(name, value) {
        if (!this.available() || !name) {
            return;
        }

        let storage = localStorage.getItem(this.name);

        if (storage) {
            try {
                storage = JSON.parse(storage);
            } catch (e) {
                storage = {};
            }
        } else {
            storage = {};
        }

        if (typeof name === 'object') {
            storage = {...storage, ...name };
        } else {
            storage[name] = value;
        }

        localStorage.setItem(this.name, JSON.stringify(storage));
    }

    get(name) {
        if (!this.available() || !name) {
            return;
        }

        const storage = localStorage.getItem(this.name);

        if (!storage) {
            return;
        }

        try {
            return JSON.parse(storage)[name] || null;
        } catch (e) {
            return null;
        }
    }

    del(name) {
        if (!this.available() || !name) {
            return;
        }

        const storage = localStorage.getItem(this.name);

        if (!storage || !storage[name]) {
            return;
        }

        delete storage[name];

        localStorage.setItem(this.name, JSON.stringify(storage));
    }

    available() {
        if (this._available) {
            return this._available;
        }

        if (!this.name) {
            return this._available = false;
        }

        const test = 'test';

        try {
            localStorage.setItem(test, test);
            localStorage.removeItem(test);

            return this._available = true;
        } catch (e) {
            return this._available = false;
        }
    }
}
