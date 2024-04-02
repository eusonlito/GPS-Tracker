(function () {
    'use strict';

    document.querySelectorAll('[data-input-default]').forEach(element => {
        element.addEventListener('click', (e) => {
            e.preventDefault();

            const field = document.querySelector(element.dataset.inputDefault);

            if (!field) {
                return;
            }

            field.value = field.defaultValue;
        }, false);
    });
})();
