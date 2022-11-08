(function () {
    'use strict';

    const modal = document.getElementById('delete-modal');

    if (!modal) {
        return;
    }

    const form = modal.querySelector('form');

    document.querySelectorAll('[data-delete-modal-one]').forEach(element => {
        element.addEventListener('click', (e) => {
            const name = element.dataset.deleteModalOneName;
            const value = element.dataset.deleteModalOneValue;

            if (!name || !value) {
                return;
            }

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
        }, false);
    });
})();
