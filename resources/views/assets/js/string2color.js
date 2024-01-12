export default function (str) {
    let hash = 0;

    btoa(str.toString()).split('').forEach(char => {
        hash = char.charCodeAt(0) + ((hash << 5) - hash);
    });

    let colour = '#';

    for (let i = 0; i < 3; i++) {
        colour += ((hash >> (i * 8)) & 0xff).toString(16).padStart(2, '0');
    }

    return colour;
}
