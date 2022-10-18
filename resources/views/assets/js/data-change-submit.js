(function () {
    'use strict';

    document.querySelectorAll('[data-change-submit]').forEach(element => {
        element.addEventListener('change', (e) => {
            const form = element.closest('form');

            if (!form) {
                return;
            }

            e.preventDefault();

            form.submit();
        }, false);
    });
})();
