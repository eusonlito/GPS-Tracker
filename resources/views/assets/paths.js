'use strict';

const target = './../../../public/build';

module.exports = {
    from: {
        app: './../../../app/',
        view: './../',
        html: './html/',
        scss: './scss/',
        js: './js/',
        images: './images/',
        theme: './theme/',
        manifest: './manifest/',
        publish: './publish/',
        vendor: './node_modules/'
    },

    to: {
        public: target + '/../',
        build: target + '/',
        css: target + '/css/',
        js: target + '/js/',
        images: target + '/images/'
    },

    directories: {
        './theme/fonts/**': target + '/fonts/',
        './theme/images/**': target + '/images/',
        './node_modules/leaflet/dist/images/**': target + '/css/images/',
        './node_modules/leaflet-draw/dist/images/**': target + '/css/images/'
    }
};
