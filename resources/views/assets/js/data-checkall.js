(function () {
    'use strict';

    document.querySelectorAll('[data-checkall]').forEach(element => {
        const checked = (checkbox, status) => {
            if (!checkbox.offsetParent || (checkbox.checked === status)) {
                return;
            }

            checkbox.checked = status;
            checkbox.dispatchEvent(new Event('change'));
        };

        let checkallClicks = 0;

        element.addEventListener('click', (e) => {
            const checkboxes = document.querySelectorAll(element.dataset.checkall + ' input[type="checkbox"]');

            if (checkboxes.length) {
                element.indeterminate = true;
            }

            checkboxes.forEach(checkbox => {
                if (typeof checkbox.dataset.checkallPrevious === 'undefined') {
                    checkbox.dataset.checkallPrevious = checkbox.checked;
                }
            });

            e.stopPropagation();

            if (checkallClicks === 0) {
                element.checked = true;
                element.indeterminate = false;

                checkboxes.forEach(checkbox => {
                    checked(checkbox, true);
                });
            } else if (checkallClicks === 1) {
                element.checked = false;
                element.indeterminate = false;

                checkboxes.forEach(checkbox => {
                    checked(checkbox, false);
                });
            } else {
                element.checked = true;
                element.indeterminate = true;

                checkboxes.forEach(checkbox => {
                    checked(checkbox, checkbox.dataset.checkallPrevious === 'true');
                });
            }

            checkallClicks++;

            if (checkallClicks > 2) {
                checkallClicks = 0;
            }
        });
    });
})();
