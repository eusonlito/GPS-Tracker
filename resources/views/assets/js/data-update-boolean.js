import Ajax from './ajax';

(function () {
    'use strict';

    const toogle = function (element, response) {
        if (!response) {
            return;
        }

        const value = response[element.dataset.updateBoolean];

        element.innerHTML = '<span class="hidden">' + (value ? '1' : '0') + '</span>'
            + '<span class="' + (value ? 'text-theme-10' : 'text-theme-24') + '">'
            + '<svg class="feather w-4 h-4"><use xlink:href="' + WWW + '/build/images/feather-sprite.svg#' + (value ? 'check-square' : 'square') + '" /></svg>'
            + '</span>';
    };

    document.querySelectorAll('[data-update-boolean]').forEach(element => {
        element.addEventListener('click', (e) => {
            e.preventDefault();

            new Ajax(element.href)
                .setMethod('POST')
                .setCallback(response => toogle(element, response))
                .setErrorCallback(response => window.alert(response.message))
                .send();
        });
    });
})();
