'use strict';

var gulp        = require('gulp');
var plugin      = require('gulp-load-plugins')();
var browserSync = require('browser-sync');
var plumber     = require('gulp-plumber');
var pagespeed   = require('psi');
var reload      = browserSync.reload;
var publicUrl   = '';
var uglify      = require('gulp-uglify');
var uglifycss   = require('gulp-uglifycss');
var concat      = require('gulp-concat');
var spritesmith = require('gulp.spritesmith');

var paths = {
  build: 'compressed/',
};

var AUTOPREFIXER_BROWSERS = [
'ie >= 8',
'ie_mob >= 10',
'ff >= 15',
'chrome >= 30',
'safari >= 5',
'opera >= 23',
'ios >= 6',
'android >= 2.3',
'bb >= 10'
];

// lint JavaScript
gulp.task('jshint', function () {
  return gulp.src('js/app/*.js')
  .pipe(reload({stream: true, olsnce: true}))
  .pipe(plugin.jshint())
  .pipe(plugin.jshint.reporter('jshint-stylish'))
  .pipe(plugin.if(!browserSync.active, plugin.jshint.reporter('fail')));
});


// Sprites
gulp.task('sprite', function () {
  var spriteData = gulp.src('img/layout/sprites/**/*.png')
  .pipe(spritesmith({
    imgName: 'sprite.png',
    imgPath : 'img/layout/sprite.png',
    cssName: '_sprites.scss',
    algorithm: 'top-down',
    padding: 10
  }));
  spriteData.img.pipe(gulp.dest('img/layout'));
  spriteData.css.pipe(gulp.dest('scss/components'));
});


// copilando o scss e adicionando os prefix
gulp.task('styles', function () {
  return gulp.src(['scss/*.scss'])
  .pipe(plumber(function(error){
    console.log("Error happend!", error.message);
    this.emit('end');
  }))
  .pipe(plugin.changed('styles', {extension: '.scss'}))
  .pipe(plugin.sass().on('error', console.error.bind(console)))
  .pipe(plugin.autoprefixer(AUTOPREFIXER_BROWSERS))
  .pipe(plumber.stop())
  .pipe(uglifycss({
    "uglyComments": true
  }))
  .pipe(gulp.dest('css'));
});


// observando mudanças para da reload
gulp.task('serve', ['styles'], function () {
  browserSync({
    notify: false,
    proxy: 'localhost/cepe-diario'
  });

  gulp.watch(['scss/**/*.scss'], ['styles']);
  gulp.watch(['css/*.css'], reload);
  gulp.watch(['js/**/*.js'], reload);
  gulp.watch(['img/layout/sprites/**/*.png'], ['sprite']);
  gulp.watch(['img/content/*', 'img/layout/*'], reload);
});



// otimizando imagens
gulp.task('images', function () {
  return gulp.src(['img/**/*.png'])
  .pipe(plugin.imagemin({
    progressive: true,
    interlaced: true
  }))
  .pipe(gulp.dest(paths.build));
});

// otimizando imagens
gulp.task('images', function () {
  return gulp.src(['img/**/*.png'])
  .pipe(plugin.imagemin({
    progressive: true,
    interlaced: true
  }))
  .pipe(gulp.dest(paths.build));
});


gulp.task('compress-js', function() {
  gulp.src(['js/**/*.js'])
    .pipe(uglify())
    .pipe(gulp.dest('../build/js'))
});

gulp.task('build', ['compress-js']);


// google pagespeed insights
// trocar a variavel 'publicUrl' quando o site estiver publico
gulp.task('pagespeed-mobile', pagespeed.bind(null, {
  url: publicUrl,
  strategy: 'mobile'
}));

gulp.task('pagespeed-desktop', pagespeed.bind(null, {
  url: publicUrl,
  strategy: 'desktop'
}));

// Task padrão, exibe o menu de tasks
gulp.task('default', function (callback) {
  plugin.menu(this);
});
