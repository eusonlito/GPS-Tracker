(function () {
    'use strict';

    const available = ('Notification' in window) && ('serviceWorker' in navigator) && ('PushManager' in window);

    if (!available) {
        return;
    }

    const permission = Notification.permission;

    document.querySelectorAll('[data-notification-request]').forEach(element => {
        if (permission === 'granted') {
            element.textContent = element.dataset.notificationRequestGranted;
            element.classList.add('btn-outline-success');
        }

        if (permission === 'denied') {
            element.textContent = element.dataset.notificationRequestDenied;
            element.classList.add('btn-outline-danger');
        }

        element.addEventListener('click', (e) => {
            e.preventDefault();

            if ((permission !== 'granted') && (permission !== 'denied')) {
                Notification.requestPermission();
            }
        });
    });
})();
