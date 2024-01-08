(function () {
    'use strict';

    document.querySelectorAll('[data-scroll-bottom]').forEach(element => {
        element.addEventListener('click', (e) => {
            e.preventDefault();

            const target = document.querySelector(element.dataset.scrollBottom);

            if (!target) {
                return;
            }

            target.scrollTop = target.scrollHeight;

            target.scrollIntoView({
                behavior: 'smooth',
                block: 'end'
            });
        }, false);
    });
})();
