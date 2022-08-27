/* const { series, parallel }= require('gulp');

function hola( done ) {
    console.log('Hola mundo de Gulp');

    done();
}

function css( done ){
    console.log('compilando CSS');

    done();
}

function javascript( done ){
    console.log('compilando JavaScript');

    done();
}

function minificarHTML( done){
    console.log('minificarhtml...');

    done();
}

exports.css= css;
exports.javascript= javascript;
exports.hola = hola;
exports.minificarHTML = minificarHTML;

exports.tareas = series( css, javascript, minificarHTML);
exports.default = parallel( css, javascript, minificarHTML); */



const { series, src, dest, watch, parallel } = require('gulp');
const sass = require('gulp-dart-sass');
const imagemin = require('gulp-imagemin');
const notify = require('gulp-notify');
const webp = require('gulp-webp');
const concat = require('gulp-concat');


// utilidades css
const autoprefixer = require('autoprefixer');
const postcss = require('gulp-postcss');
const cssnano = require('cssnano');
const sourcemaps = require('gulp-sourcemaps');


//utilidades js
const terser = require('gulp-terser-js');
const rename = require('gulp-rename');

const paths = {
    imagenes: 'src/img/**/*',
    scss: 'src/scss/**/*.scss',
    js: 'src/js/**/*.js'
}
// funcion que compila SASS

function css() {
    return src(paths.scss)
        .pipe(sourcemaps.init())
        .pipe(sass({}))
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('./public/build/css'));
}

function minificarcss() {
    return src(paths.scss)
        .pipe(sass({
            outputStyle: 'compressed'
        }))
        .pipe(dest('./public/build/css'));
}

function javascript() {
    return src(paths.js)
        .pipe(sourcemaps.init())
        .pipe(concat('bundle.js'))
        .pipe(terser())
        .pipe(sourcemaps.write('.'))
        .pipe(rename({ suffix: '.min' }))
        .pipe(dest('./public/build/js'));

}

function imagenes() {
    return src(paths.imagenes)
        .pipe(imagemin())
        .pipe(dest('./public/build/img'))
        .pipe(notify({ message: "imagen minificada..." }));
}

function versionWebp() {
    return src(paths.imagenes)
        .pipe(webp())
        .pipe(dest('./public/build/img'))
        .pipe(notify({ message: "Version webp...." }));
}

function watchArchivos() {
    watch(paths.scss, css); // un asterico e igual a la carpeta actual con una extencion
    /** doble asterico es todos los archivo con esa extencion */
    watch(paths.js, javascript);
}
exports.css = css;
exports.minificarcss = minificarcss;
exports.imagenes = imagenes;
exports.watchArchivos = watchArchivos;

exports.default = series(css, javascript, imagenes, versionWebp, watchArchivos);