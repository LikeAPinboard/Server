var gulp    = require("gulp"),
    sass    = require("gulp-sass"),
    uglify  = require("gulp-uglify"),
    concat  = require("gulp-concat");

gulp.task("sass", function() {
    gulp.src("./sass/index.scss")
        .pipe(sass({style: "expanded"}))
        .pipe(gulp.dest("../public/css"));
});

gulp.task("uglify", function() {
    gulp.src(["./node_modules/Retriever/build/retriever.js", "./js/index.js"])
        .pipe(concat("index.js"))
        .pipe(uglify())
        .pipe(gulp.dest("../public/js"));
});

gulp.task("watch", function() {
    gulp.watch(["./sass/*.scss", "./js/index.js"], ["sass", "uglify"]);
});

gulp.task("default", ["sass", "uglify"]);
gulp.task("dev", ["sass", "uglify", "watch"]);
