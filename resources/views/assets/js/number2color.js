'use strict';

const alpha = function (opacity) {
    if ((typeof opacity === 'undefined') || (opacity === '')) {
        return '';
    }

    opacity = parseFloat(opacity);

    if (isNaN(opacity)) {
        return '';
    }

    return Math.round(Math.min(Math.max(opacity, 0), 1) * 255)
        .toString(16)
        .padStart(2, '0')
        .toUpperCase();
}

export default function (number, opacity) {
    number = number * 2654435761;
    number = number ^ (number >>> 16);

    let red = (number & 0xFF0000) >>> 16;
    let green = (number & 0x00FF00) >>> 8;
    let blue = number & 0x0000FF;

    const color = ((1 << 24) + (red << 16) + (green << 8) + blue)
        .toString(16)
        .slice(1)
        .toUpperCase();

    return '#' + color + alpha(opacity);
}
