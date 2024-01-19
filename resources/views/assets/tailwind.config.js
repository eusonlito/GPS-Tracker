const colors = require('@left4code/tw-starter/dist/js/colors');
const paths = require('./paths');

module.exports = {
    darkMode: 'class',

    content: [
        paths.from.html + '/**/*.html',
        paths.from.app + '/Services/Html/**/*.php',
        paths.from.app + '/View/**/*.php',
        paths.from.js + '**/*.js',
        paths.from.view + 'components/**/*.php',
        paths.from.view + 'domains/**/*.php',
        paths.from.view + 'layouts/**/*.php'
    ],

    theme: {
        borderColor: (theme) => ({
            ...theme('colors'),
            DEFAULT: colors.gray['300'],
        }),
        extend: {
            colors: {
                ...colors,
                primary: {
                    ...colors.primary,
                    1: '#142E71',
                },
                dark: {
                    ...colors.dark,
                    8: '#242b3c',
                },
                theme: {
                    1: '#071A50',
                    2: '#2D427B',
                    3: '#A2AFD5',
                    4: '#C6D4FD',
                    5: '#D32929',
                    6: '#365A74',
                    7: '#D1DFEA',
                    8: '#7F9EB8',
                    9: '#96A5D0',
                    10: '#13B176',
                    11: '#11296d',
                    12: '#1f377d',
                    13: '#9BADE4',
                    14: '#1c3271',
                    15: '#F1F5F8',
                    16: '#102867',
                    17: '#142E71',
                    18: '#172F71',
                    19: '#B2BEDE',
                    20: '#102765',
                    21: '#3160D8',
                    22: '#F78B00',
                    23: '#FBC500',
                    24: '#CE3131',
                    25: '#E2EBF2',
                    26: '#203f90',
                    27: '#8DA9BE',
                    28: '#607F96',
                    29: '#B8F1E1',
                    30: '#FFE7D9',
                    31: '#DBDFF9',
                    32: '#2B4286',
                    33: '#8C9DCA',
                    34: '#0E2561',
                    35: '#E63B1F',
                },
            },
            fontFamily: {
                roboto: ['Roboto'],
            },
            container: {
                center: true,
            },
            maxWidth: {
                '1/4': '25%',
                '1/2': '50%',
                '3/4': '75%',
            },
            screens: {
                sm: '640px',
                md: '768px',
                lg: '1024px',
                xl: '1280px',
                xxl: '1600px',
            },
            strokeWidth: {
                0.5: 0.5,
                1.5: 1.5,
                2.5: 2.5,
            },
        },
    }
};
