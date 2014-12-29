var gulp    = require("gulp"),
    sass    = require("gulp-sass"),
    uglify  = require("gulp-uglify");

gulp.task("sass", function() {
    gulp.src("./sass/index.scss")
        .pipe(sass({style: "expanded"}))
        .pipe(gulp.dest("../public/css"));
});

gulp.task("uglify", function() {
    gulp.src("./js/index.js")
        .pipe(uglify())
        .pipe(gulp.dest("../public/js"));
});

gulp.task("watch", function() {
    gulp.watch(["./sass/*.scss", "./js/index.js"], ["sass", "uglify"]);
});

gulp.task("default", ["sass", "uglify"]);
gulp.task("dev", ["sass", "uglify", "watch"]);
