'use strict';

export default class {
    static get(name, ...parameters) {
        return this.replace(this.list()[name] || '', parameters || []);
    }

    static list() {
        return {
            'dashboard.index': '/',
            'device-alarm.index': '/device-alarm',
            'device-alarm-notification.index': '/device-alarm-notification',
            'device-alarm-notification.update.sent-at': '/device-alarm-notification/0/sent-at',
        };
    }

    static replace(route, parameters) {
        parameters.forEach((value, key) => {
            route = route.replace('/' + key + '/', '/' + value + '/');
        });

        return route;
    }
};
