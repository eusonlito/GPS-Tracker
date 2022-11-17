if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker
            .register(WWW + '/service-worker.js')
            .then((registration) => registration.update())
            .catch((error) => console.error('ServiceWorker registration failed: ', error));
    });
}
