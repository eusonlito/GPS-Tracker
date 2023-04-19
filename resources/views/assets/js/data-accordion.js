(function () {
    'use strict';

    document.querySelectorAll('[data-accordion]').forEach(element => {
        const button = element.querySelector('.accordion-button');

        if (!button) {
            return;
        }

        const item = button.closest('.accordion-item');

        if (!item) {
            return;
        }

        const collapse = item.querySelector('.accordion-collapse');

        if (!collapse) {
            return;
        }

        button.addEventListener('click', (e) => {
            collapse.classList.toggle('show');
        }, false);
    });
})();
