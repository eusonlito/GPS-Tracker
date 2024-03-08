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
            if (collapse.classList.contains('collapse')) {
                collapse.classList.replace('collapse', 'show');
            } else {
                collapse.classList.replace('show', 'collapse');
            }
        }, false);

        new ResizeObserver(entries => {
            if (!window.map) {
                return;
            }

            window.map.fitBounds(window.map.getBounds(), { animate: false, padding: [30, 30] });
            window.map.invalidateSize(true);
            window.map.setZoom(12);
        }).observe(collapse);
    });
})();
