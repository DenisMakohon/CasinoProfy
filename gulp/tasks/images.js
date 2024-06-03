import webp from 'gulp-webp'
import imagemin from 'gulp-imagemin'

export const images = () => {
    return app.gulp.src(app.path.src.images)
        .pipe(app.plugins.plumber(
            app.plugins.notify.onError({
                title: "Images",
                message: "Error <%= error.message %>"
            })
        ))
        .pipe(app.plugins.newer(app.path.build.images))
        .pipe(
            app.plugins.if(
                app.isBuild,
                webp()
            ))
        .pipe(
            app.plugins.if(
                app.isBuild,
                app.gulp.dest(app.path.build.images)
            ))
        .pipe(
            app.plugins.if(
                app.isBuild,
                app.gulp.src(app.path.src.images)
            ))
        .pipe(
            app.plugins.if(
                app.isBuild,
                app.plugins.newer(app.path.build.images)
            ))
        .pipe(
            app.plugins.if(
                app.isBuild,
                imagemin({
                    progressive: true,
                    svgoPlugins: [{ removeViewBox: false }],
                    optimizationLevel: 3
                })
            ))
        .pipe(app.gulp.dest(app.path.build.images))
        .pipe(app.gulp.src(app.path.src.svg))
        .pipe(app.gulp.dest(app.path.build.images))
}

export const images_set = () => {
    return app.gulp.src(app.path.settings_src.images)
        .pipe(app.plugins.plumber(
            app.plugins.notify.onError({
                title: "Images",
                message: "Error <%= error.message %>"
            })
        ))
        .pipe(app.plugins.newer(app.path.settings_build.images))
        .pipe(
            app.plugins.if(
                app.isSetB,
                webp()
            ))
        .pipe(
            app.plugins.if(
                app.isSetB,
                app.gulp.dest(app.path.settings_build.images)
            ))
        .pipe(
            app.plugins.if(
                app.isSetB,
                app.gulp.src(app.path.settings_src.images)
            ))
        .pipe(
            app.plugins.if(
                app.isSetB,
                app.plugins.newer(app.path.settings_build.images)
            ))
        .pipe(
            app.plugins.if(
                app.isSetB,
                imagemin({
                    progressive: true,
                    svgoPlugins: [{ removeViewBox: false }],
                    interlaced: true,
                    optimizationLevel: 3
                })
            ))
        .pipe(app.gulp.dest(app.path.settings_build.images))
        .pipe(app.gulp.src(app.path.settings_src.svg))
        .pipe(app.gulp.dest(app.path.settings_build.images))
}