var gulp = require('gulp');
var less = require('gulp-less');
var cssnano = require('gulp-cssnano');
var uglify = require('gulp-uglify');
var concat = require('gulp-concat');
var htmlmin = require('gulp-htmlmin');
var clean = require('gulp-clean');
var replace = require('gulp-replace');
var runSequence = require('run-sequence');
var iife = require('gulp-iife');
var rename = require('gulp-rename');

var paths = {};

gulp.task('default', function () {
    return runSequence(
        'build'
    );
});

gulp.task('build', [
    'build:less'
    , 'build:js'
    , 'build:html'
]);

paths.less = [
    './src/less/*.less'
];

gulp.task('build:less', function () {
    return gulp.src(paths.less)
        .pipe(less())
        .pipe(cssnano())
        .pipe(concat('app.css'))
        .pipe(gulp.dest('./dist'));
});

paths.js = [
    'src/js/*.js'
];

gulp.task('build:js', function () {
    return gulp.src(paths.js)
        .pipe(concat('app.js'))
        .pipe(replace(/["']use strict["'];/g, ''))
        .pipe(iife({
            params: ['window'],
            args: ['window']
        }))
        .pipe(uglify({
            mangle: true
        }))
        .pipe(gulp.dest('./dist'));
});

paths.html = [
    './src/*.html',
    './src/*.php'
];

gulp.task('build:html', function () {
    return gulp.src(paths.html)
        .pipe(htmlmin({
            collapseWhitespace: true,
            removeComments: true,
            minifyJS: true,
            minifyCSS: true,
            ignoreCustomFragments: [ /<\?php[\s\S]*?\?>?/ ]
        }))
        .pipe(gulp.dest('./dist'));
});

gulp.task('watch', function () {
    return runSequence(
        'build',
        [
            'watch:js'
            , 'watch:less'
            , 'watch:html'
        ]
    )
});

gulp.task('watch:js', function () {
    gulp.watch(paths.js, ['build:js']);
});

gulp.task('watch:less', function () {
    gulp.watch(paths.less, ['build:less']);
});

gulp.task('watch:html', function () {
    gulp.watch(paths.html, ['build:html']);
});
