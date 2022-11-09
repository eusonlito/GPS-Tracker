(function () {
    'use strict';

    document.querySelectorAll('.nav-tabs').forEach(element => {
        const selected = element.querySelector(':scope > .active');

        if (!selected || ((selected.offsetWidth + selected.offsetLeft) < element.offsetWidth)) {
            return;
        }

        element.scrollTo({
            left: selected.offsetLeft - parseFloat(window.getComputedStyle(selected, null).paddingLeft),
            behavior: 'smooth'
        });
    });
})();
