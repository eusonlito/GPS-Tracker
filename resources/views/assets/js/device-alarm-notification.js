import Ajax from './ajax';
import Router from './router';

(function () {
    'use strict';

    const deviceAlarmRequest = function () {
        new Ajax(Router.get('device-alarm.index'), 'GET')
            .setAjax(true)
            .setJsonResponse(true)
            .setCallback(deviceAlarmCheck)
            .send();
    };

    const deviceAlarmCheck = function (alarms) {
        if (alarms.length) {
            deviceAlarmNotificationServiceWoker();
        }
    };

    const deviceAlarmNotificationServiceWoker = function () {
        navigator.serviceWorker.ready.then((worker) => worker.active.postMessage({ action: 'deviceAlarmNotification' }));
        navigator.serviceWorker.addEventListener('message', event => navigatorServiceWorkerMessage(event.data));
    };

    const navigatorServiceWorkerMessage = function (data) {
        switch (data.action) {
            case 'reload': return navigatorServiceWorkerMessageReload();
        };
    };

    const navigatorServiceWorkerMessageReload = function (data) {
        return window.location.reload();
    };

    const notificationPermission = function () {
        Notification.requestPermission().then(result => {
            if (result === 'granted') {
                deviceAlarmRequest();
            };
        });
    };

    notificationPermission();
})();
