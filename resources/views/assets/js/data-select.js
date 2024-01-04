(function () {
    'use strict';

    document.querySelectorAll('[data-select]').forEach(element => {
        element.addEventListener('click', (e) => {
            e.preventDefault();

            const target = document.querySelector(element.dataset.select);

            if (!target) {
                return;
            }

            target.ownerDocument?.getSelection()?.selectAllChildren(target);

            const color = element.style.color;

            element.style.color = 'green';

            setTimeout(() => element.style.color = color, 1000);
        }, false);
    });
})();
