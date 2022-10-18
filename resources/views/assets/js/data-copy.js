(function () {
    'use strict';

     function clipboard (text) {
        const element = document.createElement('textarea');

        element.style = 'position: absolute; width: 1px; height: 1px; left: -10000px; top: -10000px';
        element.value = text;

        document.body.appendChild(element);

        element.select();
        element.setSelectionRange(0, 99999);

        document.execCommand('copy');

        document.body.removeChild(element);
    }

    document.querySelectorAll('[data-copy]').forEach(element => {
        element.addEventListener('click', (e) => {
            e.preventDefault();

            const field = document.querySelector(element.dataset.copy);

            if (!field) {
                return;
            }

            clipboard(field.value);

            const color = element.style.color;

            element.style.color = 'green';

            setTimeout(() => element.style.color = color, 1000);
        }, false);
    });
})();
