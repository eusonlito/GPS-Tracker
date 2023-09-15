(function () {
    'use strict';

    const dateISO = function () {
        return new Date(new Date().getTime() - new Date().getTimezoneOffset() * 60 * 1000).toISOString();
    };

    const dateCurrent = function () {
        return dateISO().slice(0, 10);
    };

    const dateTimeCurrent = function () {
        return dateISO().slice(0, 19).replace('T', ' ');
    };

    document.querySelectorAll('[data-current-date]').forEach(element => {
        element.value = element.value || dateCurrent();
    });

    document.querySelectorAll('[data-current-datetime]').forEach(element => {
        element.value = element.value || dateTimeCurrent();
    });
})();
