// jshint node: true, esversion: 6

// Strict mode
'use strict';

// Configuration
const config = {
    paths: {
        src: {
            css: './node_modules/cookieconsent/build/cookieconsent.min.css',
            js: './node_modules/cookieconsent/build/cookieconsent.min.js'
        },
        dest: {
            css: './dist/css',
            js: './dist/js',
        }
    }
};

// Modules
const del = require('del');
const gulp = require('gulp');

// Plugins
const rename = require('gulp-rename');

// Tasks
function cssCleanTask() {
    return del(config.paths.dest.css);
}

function jsCleanTask() {
    return del(config.paths.dest.js);
}

function cssBundleTask() {
    return gulp.src(config.paths.src.css)
        .pipe(rename({ basename: 'style', suffix: '.min' }))
        .pipe(gulp.dest(config.paths.dest.css));
}

function jsBundleTask() {
    return gulp.src(config.paths.src.js)
        .pipe(rename({ basename: 'script', suffix: '.min' }))
        .pipe(gulp.dest(config.paths.dest.js));
}

const cssTask = gulp.series(cssCleanTask, cssBundleTask);
const jsTask = gulp.series(jsCleanTask, jsBundleTask);

const build = gulp.parallel(cssTask, jsTask);

// Public tasks
exports.default = build;
