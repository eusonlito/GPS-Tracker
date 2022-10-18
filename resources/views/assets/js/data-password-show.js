(function () {
    'use strict';

    document.querySelectorAll('[data-password-show]').forEach(element => {
        element.addEventListener('click', (e) => {
            e.preventDefault();

            const field = document.querySelector(element.dataset.passwordShow);

            if (!field) {
                return;
            }

            const isHidden = field.type === 'password';

            field.type = isHidden ? 'text' : 'password';

            element.querySelector('svg:first-child').innerHTML = '<use xlink:href="' + WWW + '/build/images/feather-sprite.svg#' + (hidden ? 'eye-off' : 'eye') + '" />';
        }, false);
    });
})();
