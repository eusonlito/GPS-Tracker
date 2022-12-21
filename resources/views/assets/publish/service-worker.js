importScripts('./build/js/ajax.js');
importScripts('./build/js/router.js');

self.addEventListener('install', (event) => {
    self.skipWaiting();
});

self.addEventListener('message', (event) => {
    switch (event.data.action) {
        case 'alarmNotification': return alarmNotification(event.data);
    };
});

let alarmNotificationInterval;

const clientsPostMessage = function (message, isEvent) {
    const url = self.registration.scope;

    return clients.matchAll({ type: 'window', includeUncontrolled: true }).then(clients => {
        for (const i = 0; i < clients.length; i++) {
            const client = clients[i];

            if (!client.url.startsWith(url) || !('focus' in client)) {
                continue;
            }

            if (isEvent) {
                client.focus();
            }

            client.postMessage({ message });

            return client;
        }

        if (isEvent && clients.openWindow) {
            return clients.openWindow(url);
        }
    });
};

const alarmNotification = function (data) {
    if (alarmNotificationInterval) {
        clearInterval(alarmNotificationInterval);
    }

    alarmNotificationInterval = setInterval(() => {
        new Ajax(Router.get('alarm-notification.index'), 'GET')
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

        clientsPostMessage('dashboard');
    };

    const notify = function (notification) {
        if (Notification.permission === 'granted') {
            self.registration.showNotification(notifyMessage(notification));
        }
    };

    const notifyMessage = function (notification) {
        return `${notification.vehicle.name} - ${notification.name} - ${notification.title} - ${notification.message}`;
    };

    const updateSentAt = function (notification) {
        new Ajax(updateSentAtUrl(notification), 'GET')
            .setAjax(true)
            .setJson(true)
            .send();
    };

    const updateSentAtUrl = function (notification) {
        return Router.get('alarm-notification.update.sent-at', notification.id);
    };
};

self.addEventListener('notificationclick', (event) => {
    event.notification.close();

    return event.waitUntil(() => clientsPostMessage('dashboard', true));
});
