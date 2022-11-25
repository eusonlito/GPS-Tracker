'use strict';

export default class {
    static get(name, ...parameters) {
        return this.replace(this.list()[name] || '', parameters || []);
    }

    static list() {
        return {
            'dashboard.index': '/',
            'alarm.index': '/alarm',
            'alarm-notification.index': '/alarm-notification',
            'alarm-notification.update.sent-at': '/alarm-notification/0/sent-at',
        };
    }

    static replace(route, parameters) {
        parameters.forEach((value, key) => {
            route = route.replace('/' + key + '/', '/' + value + '/');
        });

        return route;
    }
};
