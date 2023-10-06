'use strict';

export default function (element, icon, style, success) {
    let html = '';

    if (typeof success === 'boolean') {
        html += '<span class="text-theme-' + (success ? '10' : '24') + '">';
    }

    style = element.getElementsByTagName('svg')[0].getAttribute('class') + ' ' + (style || '');

    html += '<svg class="' + style.trim() + '">';
    html += '<use xlink:href="' + WWW + '/build/images/feather-sprite.svg#' + icon + '"></use>'
    html += '</svg>';

    if (typeof success === 'boolean') {
        html += '</span>';
    }

    element.innerHTML = html;
};
