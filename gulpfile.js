var gulp = require('gulp');
var browserify = require('browserify');
var babelify = require('babelify');
var source = require('vinyl-source-stream');

gulp.task('default', function () {
    return browserify({ entries: ["./source/app.js"] })
        .transform(babelify)
        .bundle()
        .pipe(source('bardzilla.js')).on('error', function(e){
            console.log(e);
        })
        .pipe(gulp.dest('./build/'));
});