'use strict';

export default function (number) {
    number = number * 2654435761;
    number = number ^ (number >> 16);

    let red = (number & 0xFF0000) >> 16;
    let green = (number & 0x00FF00) >> 8;
    let blue = number & 0x0000FF;

    const color = ((1 << 24) + (red << 16) + (green << 8) + blue).toString(16).slice(1).toUpperCase();

    return '#' + color;
}
