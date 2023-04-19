import Query from './query';

(function () {
    'use strict';

    const accordions = document.querySelectorAll('.body-trip-search [data-accordion]');

    if (!accordions.length) {
        return;
    }

    if (Query.fence === '1') {
        return;
    }

    const map = window.map;

    if (!map) {
        return;
    }

    let fit = false;

    accordions.forEach(element => {
        const mapFence = element.querySelector('input[name="fence"]');

        element.querySelector('.accordion-button').addEventListener('click', (e) => {
            mapFence.value = (mapFence.value === '1') ? '0' : '1';

            if (fit) {
                return;
            }

            setTimeout(() => {
                map.fitBounds(map.getBounds(), { animate: false, padding: [30, 30] });
                map.invalidateSize();
                map.setZoom(12);
            }, 100);

            fit = true;
        }, false);
    });
})();
