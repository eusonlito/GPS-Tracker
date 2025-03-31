import flatpickr from "flatpickr";

import { Arabic } from "flatpickr/dist/l10n/ar.js"
import { Spanish } from "flatpickr/dist/l10n/es.js"
import { French } from "flatpickr/dist/l10n/fr.js"
import { Hebrew } from "flatpickr/dist/l10n/he.js"
import { Portuguese } from "flatpickr/dist/l10n/pt.js"

(function () {
    'use strict';

    const locale = (document.documentElement.lang || 'es_ES').split('_')[0];

    const altFormat = {
        'en': 'm/d/Y',
    }[locale] || 'd/m/Y';

    document.querySelectorAll('[data-datepicker]').forEach(element => {
        const options = {
            dateFormat: 'Y-m-d',
            altInput: true,
            altFormat: altFormat,
            locale: locale,
        };

        if (element.dataset.datepickerMinDate) {
            options.minDate = element.dataset.datepickerMinDate;
        }

        if (element.dataset.datepickerMinYear) {
            options.minDate = element.dataset.datepickerMinYear;
        }

        flatpickr(element, options);
    });
})();
