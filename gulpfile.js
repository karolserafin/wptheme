// ------------------------------------------------ requires
const gulp         = require('gulp');
const sass         = require('gulp-sass');
const util         = require('gulp-util');
const cleanCSS     = require('gulp-clean-css');
const sourcemaps   = require('gulp-sourcemaps');
const autoprefixer = require('gulp-autoprefixer');
const imagemin     = require('gulp-image');
const watch        = require('gulp-watch');
const source       = require('vinyl-source-stream');
const buffer       = require('vinyl-buffer');
const rollup       = require('@rollup/stream');
const babel        = require('rollup-plugin-babel');
const commonjs     = require('@rollup/plugin-commonjs');
const nodeResolve  = require('@rollup/plugin-node-resolve');
const livereload   = require('gulp-livereload');
const jshint       = require('gulp-jshint');
const uglify       = require('gulp-uglify');
const rename       = require('gulp-rename');
const concat       = require('gulp-concat');

// ------------------------------------------------- configs
const paths = {
    scss: {
        src: './wp-content/themes/wctheme/assets/src/scss/**/*.scss',
        dest: './wp-content/themes/wctheme/assets/css/'
    },
    js: {
        watchSrc: './wp-content/themes/wctheme/assets/src/js/**/*.js',
        src: './wp-content/themes/wctheme/assets/src/js',
        file: '/app.js',
        dest: './wp-content/themes/wctheme/assets/js/'
    },
    img: {
        src: './wp-content/themes/wctheme/assets/src/img/**/*',
        dest: './wp-content/themes/wctheme/assets/img/'
    },
    fonts: {
        src: './wp-content/themes/wctheme/assets/src/fonts/*',
        dest: './wp-content/themes/wctheme/assets/fonts'
    }
};

// ---------------------------------------------- Gulp Tasks
gulp.task('sass', function () {
    return gulp.src(paths.scss.src)
        .pipe(sourcemaps.init())
        .pipe(sass({
            includePaths: ['node_modules'],
            outputStyle: 'compressed'
        }).on('error', sass.logError))
        .pipe(autoprefixer({
            cascade: false
        }))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest(paths.scss.dest))
        .pipe(livereload());
});

gulp.task('minify-css', function () {
    return gulp.src(paths.scss.dest + 'style.css')
        .pipe(sourcemaps.init())
        .pipe(cleanCSS())
        .pipe(sourcemaps.write())
        .pipe(gulp.dest(paths.scss.dest))
        .pipe(livereload());
});

gulp.task('scripts', function () {
    return gulp.src(paths.js.src)
        .pipe(sourcemaps.init())
        .pipe(concat('scripts.js'))
        .pipe(babel({
            presets: ['@babel/env']
        }))
        .pipe(rename('scripts.min.js'))
        .pipe(uglify())
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest(paths.js.dest))
});

let cache;

gulp.task('js', function () {
    return rollup({
        input: paths.js.src + paths.js.file,
        output: {
            sourcemap: true,
            format: 'iife',
        },
        plugins: [
            babel(),
            commonjs(),
            nodeResolve()
        ],
        cache: cache,
    })
        .on('bundle', function (bundle) {
            cache = bundle;
        })
        .pipe(source(paths.js.file, paths.js.src))
        .pipe(buffer())
        .pipe(sourcemaps.init({loadMaps: true}))
        .pipe(rename('scripts.min.js'))
        //.pipe(uglify())
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest(paths.js.dest))
});

gulp.task('scripts-map', function () {
    return gulp.src(paths.js.dest + 'scripts.min.js')
        .pipe(sourcemaps.init())
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest(paths.js.dest));
});

gulp.task('images', function () {
    return gulp.src(paths.img.src)
        .pipe(imagemin())
        .pipe(gulp.dest(paths.img.dest))
});

gulp.task('jslint', function () {
    return gulp.src(paths.js.src)
        .pipe(jshint())
        .pipe(jshint.reporter('default'));
});

gulp.task('fonts', function () {
    return gulp.src(paths.fonts.src)
        .pipe(gulp.dest(paths.fonts.dest))
});

// ---------------------------------------------- Gulp Watch
gulp.task('watch', function () {
    livereload.listen();
    gulp.watch(paths.js.dest, gulp.series(['jslint']));
    gulp.watch(paths.scss.src, gulp.series('sass'));
    gulp.watch(paths.js.watchSrc, gulp.series('js'));
    // gulp.watch(paths.html.src, gulp.series('html'));
});

// -------------------------------------------- Default task
gulp.task('default', gulp.series(
    'jslint',
    'sass',
    'js',
    'fonts',
    'watch'
));