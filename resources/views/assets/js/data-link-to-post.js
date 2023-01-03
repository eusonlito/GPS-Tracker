(function () {
    'use strict';

    const input = function (key, value) {
        const element = document.createElement('input');

        element.setAttribute('type', 'hidden');
        element.setAttribute('name', key);
        element.setAttribute('value', (value && (typeof value === 'object')) ? JSON.stringify(value) : value);

        return element;
    }

    document.querySelectorAll('[data-link-to-post]').forEach(element => {
        element.addEventListener('click', (e) => {
            e.preventDefault();

            const form = document.createElement('form');

            form.setAttribute('action', element.href);
            form.setAttribute('method', 'POST');

            let data = {};

            try {
                data = JSON.parse(element.dataset.linkToPost || '{}');
            } catch (e) {}

            Object.keys(data).forEach(key => {
                form.appendChild(input(key, data[key]));
            });

            document.body.appendChild(form);

            form.submit();
        }, false);
    });
})();
