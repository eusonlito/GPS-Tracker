'use strict';

const isWatch = process.argv.includes('watch');

const { src, dest, series, parallel, watch } = require('gulp');

const
    autoprefixer = require('autoprefixer'),
    cleancss = require('gulp-clean-css'),
    concat = require('gulp-concat'),
    copy = require('gulp-copy'),
    { deleteAsync } = require('del'),
    filesExist = require('files-exist'),
    jshint = require('gulp-jshint'),
    merge = require('merge2'),
    mode = require('gulp-mode')({ default: isWatch ? 'development' : 'production' }),
    postcss = require('gulp-postcss'),
    purgecss = require('gulp-purgecss'),
    rev = require('gulp-rev').default,
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
    return deleteAsync(paths.to.build, { force: true });
};

const directories = function(cb) {
    for (let from in paths.directories) {
        src(from, { encoding: false }).pipe(dest(paths.directories[from]));
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
    return src(loadManifest('scss'), { allowEmpty: true })
        .pipe(sass({
            quietDeps: true,
            silenceDeprecations: ['import', 'global-builtin', 'color-functions']
        }).on('error', sass.logError))
        .pipe(postcss([ tailwindcss('./tailwind.config.js') ]))
        .pipe(mode.production(purgecss({
            defaultExtractor: content => content.match(/[\w\.\-\/:]+(?<!:)/g) || [],
            content: [
                paths.from.html + '/**/*.html',
                paths.from.app + '/Services/Html/**/*.php',
                paths.from.app + '/View/**/*.php',
                paths.from.js + '**/*.js',
                paths.from.view + 'domains/**/*.php',
                paths.from.view + 'components/**/*.php',
                paths.from.view + 'layouts/**/*.php',
                paths.from.view + 'molecules/**/*.php',
                paths.from.theme + '**/*.js'
            ]
        })));
};

const stylesCss = function(cb) {
    return src(loadManifest('css'), { allowEmpty: true })
        .pipe(sass({
            quietDeps: true,
            silenceDeprecations: ['import', 'global-builtin', 'color-functions']
        }).on('error', sass.logError));
};


const jsLint = function(cb) {
    const files = loadManifest('js').filter(function(file) {
        return (file.indexOf('/node_modules/') === -1)
            && (file.indexOf('/theme/') === -1);
    });

    if (files.length === 0) {
        return cb();
    }

    return src(files)
        .pipe(jshint())
        .pipe(jshint.reporter(stylish));
};

const js = series(jsLint, function() {
    return src(loadManifest('js'), { allowEmpty: true })
        .pipe(webpack({
            watchOptions: {
                ignored: /node_modules/
            },
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

const images = async function() {
    const imagemin = (await import('gulp-imagemin')).default;
    const imageminMozjpeg = (await import('imagemin-mozjpeg')).default;
    const imageminOptipng = (await import('imagemin-optipng')).default;

    return src(paths.from.images + '**/*', { encoding: false })
        .pipe(imagemin([
            imageminMozjpeg(),
            imageminOptipng(),
        ]))
        .pipe(dest(paths.to.images));
};

const publish = function() {
    return src(paths.from.publish + '**/*', { allowEmpty: true })
        .pipe(copy(paths.to.public, { prefix: 1 }));
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
    watch(paths.from.js + '**/*.js', js);
    watch(paths.from.images + '**', images);
    watch(paths.from.publish + '**', publish);
};

exports.build = series(clean, directories, parallel(styles, js), images, publish, version);
exports.watch = series(clean, directories, parallel(styles, js), images, publish, version, taskWatch);
exports.default = exports.build;
