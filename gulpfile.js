var async = require('async');
var browserify = require('browserify');
var rimraf = require('rimraf');
var concat = require('gulp-concat');
var gulp = require('gulp');
var gutil = require('gulp-util');
var prettyHrtime = require('pretty-hrtime');
var sass = require('gulp-ruby-sass');
var source = require('vinyl-source-stream');
var watchify = require('watchify');

//
// Variables
//
var srcDir = './client';
var distDir = './web/assets/dist';
var isDebug = !gutil.env.prod;
var isWatching = false;

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
  rimraf(distDir, cb);
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
  runBrowerify(true); // Run Watchify

  gulp.watch(srcDir + '/styles/**/*.scss', ['styles']);

  gulp.watch(srcDir + '/styles/_variables.scss', ['vendor']);
});

//
// Javascripts
//
function runBrowerify(isWatching) {
  var params = {
    entries: [srcDir + '/src/init.js'],
    extensions: ['.coffee', '.hbs'],
  };

  // Core script
  var methodName = isWatching ? watchify : browserify;
  var bundler = methodName(params);

  // Logger
  var startTime;
  var logger = {
    start: function() {
      startTime = process.hrtime();
      gutil.log('Running', gutil.colors.cyan("'browserify'") + '...');
    },

    end: function() {
      var taskTime = process.hrtime(startTime);
      var prettyTime = prettyHrtime(taskTime);
      gutil.log('Finished', gutil.colors.cyan("'browserify'"), 'in', gutil.colors.magenta(prettyTime));
    }
  };

  // Wrapper
  var rebundle = function() {
    logger.start();

    return bundler
      .bundle({debug: isDebug})
      .pipe(source('js/app.js'))
      .pipe(gulp.dest(distDir))
      .on('end', logger.end);
  }

  // Watching mode
  if (isWatching)
    bundler.on('update', rebundle);

  return rebundle();
}

gulp.task('scripts', function() {
  runBrowerify(false);
});

//
// Stylesheets
//
gulp.task('styles', function (cb) {
  gulp
    .src([srcDir + '/styles/[^_]*.scss', '!**/vendor.scss'])
    .pipe(sass({
      style: isDebug ? 'compressed' : 'nested',
      sourcemap: isDebug,
      loadPath: [
        __dirname + '/node_modules/bootstrap-sass/assets/stylesheets/',
        __dirname + '/node_modules/bootstrap-sass/assets/stylesheets/bootstrap/',
        __dirname + '/node_modules/font-awesome/scss/'
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
        .src(__dirname + '/node_modules/font-awesome/fonts/*')
        .pipe(gulp.dest(distDir + '/fonts/font-awesome'))
        .on('end', callback)
    },
    function(callback) {
      gulp
        .src(srcDir + '/styles/vendor.scss')
        .pipe(sass({
          style: isDebug ? 'compressed' : 'nested',
          loadPath: [
            __dirname + '/node_modules/bootstrap-sass/assets/stylesheets/',
            __dirname + '/node_modules/bootstrap-sass/assets/stylesheets/bootstrap/',
            __dirname + '/node_modules/font-awesome/scss/'
          ]
        }))
        .pipe(gulp.dest(distDir + '/css'))
        .on('end', callback)
    }],
    cb
  );
});
