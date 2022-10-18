'use strict';

export default function (icon, style, success) {
    let html = '';

    if (typeof success === 'boolean') {
        html += '<span class="text-theme-' + (success ? '10' : '24') + '">';
    }

    html += '<svg class="feather ' + (style || 'w-4 h-4') + '">';
    html += '<use xlink:href="' + WWW + '/build/images/feather-sprite.svg#' + icon + '"></use>'
    html += '</svg>';

    if (typeof success === 'boolean') {
        html += '</span>';
    }

    return html;
};
