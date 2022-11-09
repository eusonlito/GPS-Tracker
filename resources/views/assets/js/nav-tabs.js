(function () {
    'use strict';

    document.querySelectorAll('.nav-tabs').forEach(element => {
        const selected = element.querySelector(':scope > .active');

        if (!selected || ((selected.offsetWidth + selected.offsetLeft) < element.offsetWidth)) {
            return;
        }

        element.scrollTo({
            left: selected.offsetLeft,
            behavior: 'smooth'
        });
    });
})();
