import Ajax from './ajax';
import Router from './router';

(function () {
    'use strict';

    const deviceAlarmRequest = function () {
        new Ajax(Router.get('alarm.index'), 'GET')
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
            case 'dashboard': return navigatorServiceWorkerMessageDashboard();
            case 'reload': return navigatorServiceWorkerMessageReload();
        };
    };

    const navigatorServiceWorkerMessageDashboard = function () {
        return window.location.href = Router.get('dashboard.index');
    };

    const navigatorServiceWorkerMessageReload = function () {
        return window.location.reload();
    };

    deviceAlarmRequest();
})();
