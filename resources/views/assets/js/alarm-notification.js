import Ajax from './ajax';
import Router from './router';

(function () {
    'use strict';

    const alarmRequest = function () {
        if (!document.body.classList.contains('authenticated')) {
            return;
        }

        new Ajax(Router.get('alarm.index'), 'GET')
            .setAjax(true)
            .setJsonResponse(true)
            .setCallback(alarmCheck)
            .send();
    };

    const alarmCheck = function (alarms) {
        if (alarms.length) {
            alarmNotificationServiceWoker();
        }
    };

    const alarmNotificationServiceWoker = function () {
        navigator.serviceWorker.ready.then((worker) => worker.active.postMessage({ action: 'alarmNotification' }));
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

    alarmRequest();
})();
