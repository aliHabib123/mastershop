"use strict";
var gulp = require("gulp");
var sass = require("gulp-sass");
var concat = require("gulp-concat");
var cssnano = require("gulp-cssnano");
var rename = require("gulp-rename");
var wait = require("gulp-wait");

gulp.task("sass", function () {
  return gulp
    .src("./assets/sass/all.scss")
    //.pipe(concat("style.scss"))
    .pipe(wait(1500))
    .pipe(sass())
    .pipe(gulp.dest("./public/css/"));
});

gulp.task("sass-min", function () {
  return gulp
    .src("./assets/sass/all.scss")
    //.pipe(concat("style.scss"))
    .pipe(cssnano())
    .pipe(
      rename({
        suffix: ".min",
      })
    )
    .pipe(gulp.dest("./public/css/"));
});

// gulp.task(
//   "docss",
//   gulp.series("sass", "sass-min", function (done) {
//     done();
//   })
// );

gulp.task("watch", function () {
  gulp.watch(["./assets/sass/*.scss", "!./assets/sass/all.scss"], gulp.series("sass"));
});
