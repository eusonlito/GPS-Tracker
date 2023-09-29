export const dateUtc = function (date) {
    return new Date(Date.UTC(
        date.getUTCFullYear(),
        date.getUTCMonth(),
        date.getUTCDate(),
        date.getUTCHours(),
        date.getUTCMinutes(),
        date.getUTCSeconds(),
    ));
}

export const dateToIso = function (date) {
    return date.toISOString().replace('T', ' ').replace('.000Z', '');
}
