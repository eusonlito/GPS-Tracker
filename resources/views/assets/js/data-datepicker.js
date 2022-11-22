import Litepicker from 'litepicker';

(function () {
    'use strict';

    document.querySelectorAll('[data-datepicker]').forEach(element => {
        const options = {
            autoApply: true,
            format: 'YYYY-MM-DD',
            lang: 'es-ES',
            dropdowns: {
                months: true,
                years: true,
            },
        };

        if (element.dataset.datepickerMinDate) {
            options.minDate = element.dataset.datepickerMinDate;
        }

        if (element.dataset.datepickerMinYear) {
            options.dropdowns.minYear = parseInt(element.dataset.datepickerMinYear);
        }

        if (typeof element.dataset.changeSubmit !== 'undefined') {
            options.setup = (picker) => {
                picker.on('selected', () => element.closest('form').submit());
            };
        }

        new Litepicker({ element, ...options });
    });
})();
