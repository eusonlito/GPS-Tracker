(function () {
    'use strict';

    if ((Notification.permission === 'granted') || (Notification.permission === 'denied')) {
        return;
    }

    document.querySelectorAll('[data-notification-request]').forEach(element => {
        element.classList.remove('hidden');

        element.addEventListener('click', (e) => {
            e.preventDefault();
            Notification.requestPermission();
        });
    });
})();
