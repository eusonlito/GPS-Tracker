(function () {
    'use strict';

    document.querySelectorAll('[data-checkall]').forEach(element => {
        const checkboxes = document.querySelectorAll(element.dataset.checkall + ' input[type="checkbox"]');

        if (checkboxes.length) {
            element.indeterminate = true;
        }

        checkboxes.forEach(checkbox => checkbox.dataset.checkallPrevious = checkbox.checked);

        let checkallClicks = 0;

        element.addEventListener('click', (e) => {
            e.stopPropagation();

            if (checkallClicks === 0) {
                element.checked = true;
                element.indeterminate = false;

                checkboxes.forEach(checkbox => {
                    if (checkbox.offsetParent) {
                        checkbox.checked = true;
                    }
                });
            } else if (checkallClicks === 1) {
                element.checked = false;
                element.indeterminate = false;

                checkboxes.forEach(checkbox => {
                    if (checkbox.offsetParent) {
                        checkbox.checked = false;
                    }
                });
            } else {
                element.checked = true;
                element.indeterminate = true;

                checkboxes.forEach(checkbox => {
                    if (checkbox.offsetParent) {
                        checkbox.checked = checkbox.dataset.checkallPrevious === 'true';
                    }
                });
            }

            checkallClicks++;

            if (checkallClicks > 2) {
                checkallClicks = 0;
            }
        });
    });
})();
