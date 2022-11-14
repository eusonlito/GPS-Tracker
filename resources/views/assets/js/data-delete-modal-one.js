(function () {
    'use strict';

    const modal = document.getElementById('delete-modal');

    if (!modal) {
        return;
    }

    const form = modal.querySelector('form');

    const formHidden = function (name, value) {
        form.action = '';

        let input = form.querySelector('[data-delete-modal-one-element]');

        if (input) {
            input.remove();
        }

        input = document.createElement('input');

        input.type = 'hidden';
        input.name = name;
        input.value = value;

        input.dataset.deleteModalOneElement = 'true';

        form.appendChild(input);
    };

    const formAction = function (href) {
        form.action = href;
    };

    document.querySelectorAll('[data-delete-modal-one]').forEach(element => {
        element.addEventListener('click', (e) => {
            e.preventDefault();

            const name = element.dataset.deleteModalOneName;
            const value = element.dataset.deleteModalOneValue;

            if (name && value) {
                formHidden(name, value);
            } else if (element.href) {
                formAction(element.href);
            }
        }, false);
    });
})();
