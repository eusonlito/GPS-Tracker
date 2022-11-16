import Ajax from './ajax';

(function () {
    'use strict';

    const deviceAlarmRequest = function () {
        new Ajax(ROUTER['device-alarm.index'], 'GET')
            .setAjax(true)
            .setJsonResponse(true)
            .setCallback(deviceAlarmCheck)
            .send();
    };

    const deviceAlarmCheck = function (alarms) {
        if (alarms.length) {
            deviceAlarmNotificationRequest();
        }
    };

    const deviceAlarmNotificationRequest = function () {
        new Ajax(ROUTER['device-alarm-notification.index'], 'GET')
            .setAjax(true)
            .setJsonResponse(true)
            .setCallback(deviceAlarmNotificationCheck)
            .send();
    };

    const deviceAlarmNotificationCheck = function (notifications) {
        if (!notifications.length) {
            return;
        }

        notifications.forEach(notification => {
            deviceAlarmNotificationNotify(notification);
            deviceAlarmNotificationSentAt(notification);
        })
    };

    const deviceAlarmNotificationNotify = function (notification) {
        new Notification(deviceAlarmNotificationNotifyMessage(notification)).onclick = function(e) {
            window.location.reload();
        };
    };

    const deviceAlarmNotificationNotifyMessage = function (notification) {
        return `${notification.device.name} - ${notification.name} - ${notification.title} - ${notification.message}`;
    };

    const deviceAlarmNotificationSentAt = function (notification) {
        new Ajax(deviceAlarmNotificationSentAtUrl(notification), 'GET')
            .setAjax(true)
            .setJson(true)
            .send();
    };

    const deviceAlarmNotificationSentAtUrl = function (notification) {
        return ROUTER['device-alarm-notification.update.sent-at'].replace('/0/', '/' + notification.id + '/');
    };

    const notificationPermission = function () {
        Notification.requestPermission().then(result => {
            if (result === 'granted') {
                deviceAlarmRequest();
            };
        });
    }

    notificationPermission();
})();
