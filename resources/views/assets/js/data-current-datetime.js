(function () {
    'use strict';

    const dateCurrent = function () {
        return new Date(new Date().getTime() - new Date().getTimezoneOffset() * 60 * 1000)
            .toISOString()
            .slice(0, 19)
            .replace('T', ' ');
    };

    document.querySelectorAll('[data-current-datetime]').forEach(element => {
        element.value = element.value || dateCurrent();
    });
})();
