(function () {
    'use strict';

    document.querySelectorAll('[data-input-insert]').forEach(element => {
        const selector = element.dataset.inputInsertSelector;
        const value = element.dataset.inputInsertValue;

        if (!selector || !value) {
            return;
        }

        const target = document.querySelector(selector);

        if (!target) {
            return;
        }

        element.addEventListener('click', (e) => {
            e.preventDefault();

            target.value += value;
        }, false);
    });
})();
