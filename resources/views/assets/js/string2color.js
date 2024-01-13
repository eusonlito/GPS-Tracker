'use strict';

const stringToHash = function (num) {
    let hash = 0;
    const str = num.toString();

    for (let i = 0; i < str.length; i++) {
        const char = str.charCodeAt(i);

        hash = (hash << 5) - hash + char;
        hash |= 0;
    }

    return hash;
}

const toHex = (val) => (val * 0x33).toString(16).padStart(2, '0');

export default function (string) {
    string = stringToHash(string);

    const blue = Math.floor(string / 36) % 6;
    const green = Math.floor(string / 6) % 6;
    const red = string % 6;

    return `#${toHex(red)}${toHex(green)}${toHex(blue)}`;
}
