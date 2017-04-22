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
var inlinesource = require('gulp-inline-source');

var paths = {};

gulp.task('default', function () {
    return runSequence(
        'build'
        , 'inlinesource'
    );
});

gulp.task('build', [
    'build:less'
    , 'build:js'
    , 'build:html'
]);

gulp.task('inlinesource', function () {
    return runSequence(
        'inlinesource:html'
        , 'inlinesource:clean'
    );
});

gulp.task('inlinesource:html', function () {
    return gulp.src('./dist/*.php')
        .pipe(inlinesource())
        .pipe(gulp.dest('./dist'));
});

gulp.task('inlinesource:clean', function () {
    return gulp.src([
        './dist/app.*'
    ], {read: false})
        .pipe(clean());
});

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
    'src/js/app.js'
    ,'src/js/*.js'
];

gulp.task('build:js', function () {
    return gulp.src(paths.js)
        .pipe(concat('app.js'))
        .pipe(replace(/["']use strict["'];/g, ''))
        .pipe(iife())
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
            ignoreCustomFragments: [
                /<\?php[\s\S]*?\?>/g,
                /<style>[\s\S]*<\?php[\s\S]*?\?>[\s\S]*<\/style>/g
            ]
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
