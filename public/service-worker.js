importScripts('./build/js/ajax.js');
importScripts('./build/js/router.js');

self.addEventListener('install', (event) => {
    self.skipWaiting();
});

self.addEventListener('message', (event) => {
    switch (event.data.action) {
        case 'deviceAlarmNotification': return deviceAlarmNotification(event.data);
    };
});

let deviceAlarmNotificationInterval;

const deviceAlarmNotification = function (data) {
    if (deviceAlarmNotification) {
        clearInterval(deviceAlarmNotificationInterval);
    }

    deviceAlarmNotificationInterval = setInterval(() => {
        new Ajax(Router.get('device-alarm-notification.index'), 'GET')
            .setAjax(true)
            .setJsonResponse(true)
            .setCallback(check)
            .send();
    }, 10000);

    const check = function (notifications) {
        if (!notifications.length) {
            return;
        }

        notifications.forEach(notification => {
            notify(notification);
            updateSentAt(notification);
        });

        self.dispatchEvent(new Event('notificationclick'));
    };

    const notify = function (notification) {
        if (Notification.permission === 'granted') {
            self.registration.showNotification(notifyMessage(notification));
        }
    };

    const notifyMessage = function (notification) {
        return `${notification.device.name} - ${notification.name} - ${notification.title} - ${notification.message}`;
    };

    const updateSentAt = function (notification) {
        new Ajax(updateSentAtUrl(notification), 'GET')
            .setAjax(true)
            .setJson(true)
            .send();
    };

    const updateSentAtUrl = function (notification) {
        return Router.get('device-alarm-notification.update.sent-at', notification.id);
    };
};

self.addEventListener('notificationclick', (event) => {
    const url = self.registration.scope;

    const taskWait = (resolve) => setTimeout(resolve, 1000);

    const taskClients = () => {
        return clients.matchAll({ type: 'window', includeUncontrolled: true }).then(clients => {
            for (const i = 0; i < clients.length; i++) {
                const client = clients[i];

                if (!client.url.startsWith(url) || !('focus' in client)) {
                    continue;
                }

                client.focus();
                client.postMessage({ action: 'dashboard' });

                return client;
            }

            if (clients.openWindow) {
                return clients.openWindow(url);
            }
        });
    };

    const task = () => new Promise(taskWait).then(taskClients);

    if (event.notification) {
        event.notification.close();
    }

    if (typeof event.waitUntil === 'function') {
        return event.waitUntil(task);
    }

    return task();
});
