var gulp = require('gulp');
var gutil = require('gulp-util');
var sass = require('gulp-ruby-sass');
var clean = require('gulp-clean');
var concat = require('gulp-concat');
var requirejs = require('requirejs');
var async = require('async');

//
// Variables
//
var srcDir = './web/assets/src';
var distDir = './web/assets/dist';
var isDebug = !gutil.env.prod;

//
// Default
//
gulp.task('default', function() {
  gulp.start('build', 'watch');
});

//
// Clean
//
gulp.task('clean', function(cb) {
  gulp
    .src(distDir, {read: false})
    .pipe(clean())
    .on('end', cb);
});

//
// Build
//
gulp.task('build', ['clean'], function() {
  gulp.start('styles', 'scripts', 'vendor');
});

//
// Watch
//
gulp.task('watch', function() {
  gulp.watch(srcDir + '/scripts/**/*.{js,tpl}', ['scripts']);

  gulp.watch(srcDir + '/styles/**/*.scss', ['styles']);

  gulp.watch(srcDir + '/styles/_variables.scss', ['vendor']);
});

//
// Javascripts
//
gulp.task('scripts', function(cb) {
  // Copy all javascripts files
  var stream = gulp.src(srcDir + '/scripts/**/*')
    .pipe(gulp.dest(distDir + '/js'));

  if (isDebug) {
    stream.on('end', cb);
    return;
  }

  // If no debug, then optimize javascript with requirejs optimizer
  var requirejsConfig = {
    mainConfigFile: srcDir + '/scripts/config.js',
    //appDir: srcDir + 'scripts',
    baseUrl: srcDir + '/scripts',
    dir: distDir + '/js',
    optimize: 'uglify2',
    //optimizeCss: 'none',
    //generateSourceMaps: true,
    //preserveLicenseComments: false,
    //useSourceUrl: true,
    modules: [{
        name: 'config',
      }, {
        name: 'default/init',
        exclude: ['config']
      }, {
        name: 'editor/init',
        exclude: ['config']
      }
    ]
  };

  stream.on('end', function() {
    requirejs.optimize(
      requirejsConfig,
      function(buildResponse) {
        cb();
      }, function(err) {
        cb();
      });

  });

});

//
// Stylesheets
//
gulp.task('styles', function (cb) {
  gulp
    .src([srcDir + '/styles/*.scss', '!**/vendor.scss'])
    .pipe(sass({
      style: isDebug ? 'compressed' : 'nested',
      sourcemap: isDebug,
      loadPath: [
        srcDir + '/vendor/bootstrap-sass-official/vendor/assets/stylesheets/bootstrap/',
        srcDir + '/vendor/font-awesome/scss/'
      ]
    }))
    .pipe(gulp.dest(distDir + '/css'))
    .on('end', cb)
});

//
// Vendor
//
gulp.task('vendor', function (cb) {
  async.parallel([
    function(callback) {
      gulp
        .src(srcDir + '/vendor/**/*.{js,map}')
        .pipe(gulp.dest(distDir + '/vendor'))
        .on('end', callback)
    },
    function(callback) {
      gulp
        .src(srcDir + '/vendor/font-awesome/fonts/*')
        .pipe(gulp.dest(distDir + '/fonts/font-awesome'))
        .on('end', callback)
    },
    function(callback) {
      gulp
        .src(srcDir + '/styles/vendor.scss')
        .pipe(sass({
          style: isDebug ? 'compressed' : 'nested',
          loadPath: [
            srcDir + '/vendor/bootstrap-sass-official/vendor/assets/stylesheets/bootstrap/',
            srcDir + '/vendor/font-awesome/scss/'
          ]
        }))
        .pipe(gulp.dest(distDir + '/css'))
        .on('end', callback)
    }],
    cb
  );
});
