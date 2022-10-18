(function () {
    'use strict';

    document.querySelectorAll('[data-click-one]').forEach(element => {
        element.addEventListener('click', (e) => {
            const form = element.closest('form');

            if (!form) {
                return;
            }

            if (!form.checkValidity()) {
                return form.reportValidity();
            }

            e.preventDefault();

            element.disabled = true;

            const input = document.createElement('input');

            input.type = 'hidden';
            input.name = element.name;
            input.value = element.value;

            form.appendChild(input);
            form.dispatchEvent(new Event('submit'));
            form.submit();
        }, false);
    });
})();
