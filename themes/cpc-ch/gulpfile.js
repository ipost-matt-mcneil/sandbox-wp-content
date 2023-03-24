/**
* SVG concatenator and css creator
*
*/

const gulp = require('gulp'),
			runSequence = require('gulp4-run-sequence'),
			svgSprite   = require('gulp-svg-sprites'),
			replace     = require('gulp-replace'),
			del 				= require('del'),
			svg2png   	= require('gulp-svg2png');


gulp.task('svg', function(){
	return gulp.src('./svg/**/*.svg')
	.pipe(svgSprite({
		selector: 'icon--%f',
		common: 'icon',
		cssFile: '../scss/base/_icons.scss',
		svgPath: '../img/%f',
		svg: { sprite: '../img/sprite.svg' },
		preview: 'false'
	}))
	.pipe(gulp.dest('./img'));
});

gulp.task('png', function(){
	return gulp.src('./img/sprite.svg')
	.pipe(svg2png())
	.pipe(gulp.dest('./img'));
});

gulp.task('delete', function(cb){
	return del(['./img/sprite.svg', './img/sprite.png'], cb);
});

gulp.task('replace', function(){
	return gulp.src(['./scss/base/_icons.scss'])
	.pipe(replace('-hover', ':hover'))
	.pipe(gulp.dest('./scss/base/'));
});

gulp.task('default', function (cb) {
	return new Promise(function(resolve, reject) {
		runSequence('delete', 'svg', 'png', 'replace');
    resolve();
  });
});
