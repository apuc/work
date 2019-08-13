const yaml = require('js-yaml');
const fs   = require('fs');
const gulp = require('gulp');

var path = {
    build: {
        'swagger' : 'frontend/web/json/swagger.json',
    },
    src: {
        'swagger' : 'work/api/swagger/swagger.yaml',
    },
    watch:{
        'swagger' : 'work/api/swagger/swagger.yaml',
    }
};

gulp.task('swagger:build', function () {
    var doc = yaml.safeLoad(fs.readFileSync(path.src.swagger));
    fs.writeFileSync(
        path.build.swagger,
        JSON.stringify(doc, null, " ")
    )
});

gulp.task('watch', function(){
    gulp.watch([path.watch.swagger], function(event, cb) {
        gulp.start('swagger:build');
    });
});

gulp.task('default', [ 'swagger:build', 'watch']);