"use strict";
// var gulp = require("gulp");
// var sass = require("gulp-sass");
// var concat = require("gulp-concat");
// sass.compiler = require("node-sass");
// gulp.task("sass", function () {
//   return gulp
//     .src("./assets/sass/*.scss")
//     .pipe(concat("style.scss"))
//     .pipe(sass().on("error", sass.logError))
//     .pipe(gulp.dest("./public/css/"));
// });

var gulp = require("gulp");
var sass = require("gulp-sass");
var concat = require("gulp-concat");
var cssnano = require("gulp-cssnano");
var rename = require("gulp-rename");
var wait = require("gulp-wait");
var runSequence = require("run-sequence");

gulp.task("sass", function () {
  return gulp
    .src("./assets/sass/*.scss")
    .pipe(concat("style.scss"))
    .pipe(wait(1500))
    .pipe(sass())
    .pipe(gulp.dest("./public/css/"));
});

gulp.task("sass-min", function () {
  return gulp
    .src("./assets/sass/*.scss")
    .pipe(concat("style.scss"))
    .pipe(cssnano())
    .pipe(
      rename({
        suffix: ".min",
      })
    )
    .pipe(gulp.dest("./public/css/"));
});

gulp.task(
  "docss",
  gulp.series("sass", "sass-min", function (done) {
    done();
  })
);

gulp.task("watch", function () {
  gulp.watch("sass/**/*.scss", ["docss"]);
});
