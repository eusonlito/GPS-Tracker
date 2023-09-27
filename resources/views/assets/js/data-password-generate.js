(function () {
    'use strict';

    document.querySelectorAll('[data-password-generate]').forEach(element => {
        element.addEventListener('click', (e) => {
            e.preventDefault();

            const field = document.querySelector(element.dataset.passwordGenerate);

            if (!field) {
                return;
            }

            function password() {
                return Array(Math.floor(Math.random() * (16 - 12 + 1) + 12))
                    .fill('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz!$%&/()=?[]{}+-_:;')
                    .map((x) => x[Math.floor(Math.random() * x.length)])
                    .join('');
            }

            function uuid() {
                return ([1e7] + -1e3 + -4e3 + -8e3 + -1e11).replace(/[018]/g, c =>
                    (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16)
                );
            }

            function value() {
                if (element.dataset.passwordGenerateFormat === 'uuid') {
                    return uuid();
                }

                return password();
            }

            field.value = value();
        }, false);
    });
})();
