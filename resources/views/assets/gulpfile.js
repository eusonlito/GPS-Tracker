'use strict';

const { gulp, src, dest, series, parallel, watch } = require('gulp');

const
    autoprefixer = require('autoprefixer'),
    cleancss = require('gulp-clean-css'),
    concat = require('gulp-concat'),
    del = require('del'),
    filesExist = require('files-exist'),
    imagemin = require('gulp-imagemin'),
    jshint = require('gulp-jshint'),
    merge = require('merge2'),
    mode = require('gulp-mode')({ default: 'production' }),
    postcss = require('gulp-postcss'),
    purgecss = require('gulp-purgecss'),
    purifycss = require('gulp-purifycss'),
    replace = require('gulp-replace'),
    rev = require('gulp-rev'),
    sass = require('gulp-sass')(require('sass')),
    stylish = require('jshint-stylish'),
    tailwindcss = require('tailwindcss'),
    uglify = require('gulp-uglify'),
    webpack = require('webpack-stream'),
    manifest = {};

const paths = require('./paths');

const loadManifest = function(name, key) {
    const hash = name + '.' + key;

    if (manifest[hash]) {
        return manifest[hash];
    }

    let files = require(paths.from.manifest + name + '.json'),
        file = '';

    if (key) {
        files = files[key];
    }

    if (!files.length) {
        return manifest[hash] = '.';
    }

    for (let index in files) {
        file = files[index].split('|');
        files[index] = paths.from[file[0]] + '' + file[1];
    }

    return manifest[hash] = filesExist(files);
};

const clean = function() {
    return del(paths.to.build, { force: true });
};

const directories = function(cb) {
    for (let from in paths.directories) {
        src([from]).pipe(dest(paths.directories[from]));
    }

    cb();
};

const styles = function(cb) {
    return merge(stylesScss(), stylesCss())
        .pipe(mode.production(cleancss({
            specialComments: 0,
            level: 2,
            inline: ['all']
        })))
        .pipe(postcss([ autoprefixer() ]))
        .pipe(concat('main.min.css'))
        .pipe(dest(paths.to.css));
};

const stylesScss = function(cb) {
    return src(loadManifest('scss'))
        .pipe(sass())
        .pipe(postcss([ tailwindcss('./tailwind.config.js') ]))
        .pipe(mode.production(purgecss({
            defaultExtractor: content => content.match(/[\w\.\-\/:]+(?<!:)/g) || [],
            content: [
                paths.from.html + '/**/*.html',
                paths.from.app + '/Services/Html/**/*.php',
                paths.from.app + '/View/**/*.php',
                paths.from.js + '**/*.js',
                paths.from.view + 'components/**/*.php',
                paths.from.view + 'domains/**/*.php',
                paths.from.view + 'layouts/**/*.php'
            ]
        })));
};

const stylesCss = function(cb) {
    return src(loadManifest('css'))
        .pipe(sass());
};

const jsLint = function(cb) {
    const files = loadManifest('js').filter(function(file) {
        return file.indexOf('/node_modules/') === -1;
    });

    if (files.length === 0) {
        return cb();
    }

    return src(files)
        .pipe(jshint())
        .pipe(jshint.reporter(stylish));
};

const javascript = series(jsLint, function() {
    return src(loadManifest('js'))
        .pipe(webpack({
            mode: mode.production() ? 'production' : 'development',
            module: {
                    rules: [{
                    test: /\.svg$/,
                    use: [{
                        loader: 'html-loader',
                        options: { minimize: mode.production() ? true : false }
                    }]
                }]
            }
        }))
        .pipe(concat('main.min.js'))
        .pipe(mode.production(uglify()))
        .pipe(dest(paths.to.js));
});

const images = function() {
    return src(paths.from.images + '**/*')
        .pipe(dest(paths.to.images))
        .pipe(mode.production(imagemin([
            imagemin.gifsicle(),
            imagemin.mozjpeg({ progressive: true }),
            imagemin.optipng(),
            imagemin.svgo({
                plugins: [
                    { removeViewBox: false },
                    { removeEmptyAttrs: false },
                    { removeUnknownsAndDefaults: false },
                    { removeUselessStrokeAndFill: false },
                    { mergeStyles: false },
                    { mergePaths: false }
                ]
            })
        ])))
        .pipe(dest(paths.to.images));
};

const publish = function() {
    return src(paths.from.publish + '**/*')
        .pipe(dest(paths.to.public));
};

const version = function() {
    return src([
            paths.to.css + 'main.min.css',
            paths.to.js + 'main.min.js'
        ], { base: paths.to.build })
        .pipe(dest(paths.to.build))
        .pipe(rev())
        .pipe(dest(paths.to.build))
        .pipe(rev.manifest())
        .pipe(dest(paths.to.build));
};

const taskWatch = function() {
    watch(paths.from.scss + '**/*.scss', styles);
    watch(paths.from.js + '**/*.js', javascript);
    watch(paths.from.images + '**', images);
    watch(paths.from.publish + '**', publish);
};

exports.build = series(clean, directories, parallel(styles, javascript, images, publish), version);
exports.watch = series(clean, directories, parallel(styles, javascript, images, publish), version, taskWatch);
