(function () {
    'use strict';

    const setup = function (element) {
        const file = element.querySelector('input[type="file"]');
        const input = element.querySelector('input[type="text"]');

        input.dataset.inputFileCustomValue = input.value;

        input.addEventListener('click', (e) => {
            e.preventDefault();
            file.click();
        });

        file.addEventListener('change', () => {
            if (file.files && file.files.length) {
                input.value = file.value.split('\\').pop();
            } else {
                input.value = input.dataset.inputFileCustomValue;
            }
        });
    };

    function load(element) {
        if (element.dataset.inputFileCustomLoaded) {
            return;
        }

        setup(element);

        element.dataset.inputFileCustomLoaded = true;
    }

    function init () {
        document.querySelectorAll('[data-input-file-custom]').forEach(load);
    }

    init();
})();
