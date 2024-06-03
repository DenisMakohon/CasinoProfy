import dartSass from 'sass'
import gulpSass from 'gulp-sass'
import rename from 'gulp-rename'

import cleanCss from 'gulp-clean-css'
import webpcss from 'gulp-webpcss'
import autoprefixer from 'gulp-autoprefixer'
import groupCssMediaQueries from 'gulp-group-css-media-queries'

const sass = gulpSass(dartSass)

export const scss = () => {
    return app.gulp.src(app.path.src.scss, { sourcemaps: app.isDev })
        .pipe(app.plugins.plumber(
            app.plugins.notify.onError({
                title: "SCSS",
                message: "Error <%= error.message %>"
            })
        ))
        .pipe(app.plugins.replace(/@c_img\//g, '../img/'))
        .pipe(sass({
            outputStyle: "expanded"
        }))
        .pipe(
            app.plugins.if(
                app.isBuild,
                webpcss({
                    webpClass: ".webp",
                    noWebpClass: ".no-webp"
                })
            ))
        .pipe(
            app.plugins.if(
                app.isBuild,
                autoprefixer({
                    overrideBrowserslist: ["last 3 versions"],
                    cascade: true
                })
            ))
        .pipe(app.gulp.dest(app.path.build.css))
        .pipe(
            app.plugins.if(
                app.isBuild,
                cleanCss()
            ))
        .pipe(rename({
            extname: ".min.css"
        }))
        .pipe(app.gulp.dest(app.path.build.css))
}

export const scss_set = () => {
    return app.gulp.src(app.path.settings_src.scss, { sourcemaps: app.isSet })
        .pipe(app.plugins.plumber(
            app.plugins.notify.onError({
                title: "SCSS",
                message: "Error <%= error.message %>"
            })
        ))
        .pipe(app.plugins.replace(/@c_img\//g, '../img/'))
        .pipe(sass({
            outputStyle: "expanded"
        }))
        .pipe(
            app.plugins.if(
                app.isSetB,
                webpcss({
                    webpClass: ".webp",
                    noWebpClass: ".no-webp"
                })
            ))
        .pipe(
            app.plugins.if(
                app.isSetB,
                autoprefixer({
                    overrideBrowserslist: ["last 3 versions"],
                    cascade: true
                })
            ))
        .pipe(app.gulp.dest(app.path.settings_build.css))
        .pipe(
            app.plugins.if(
                app.isSetB,
                cleanCss()
            ))
        .pipe(rename({
            extname: ".min.css"
        }))
        .pipe(app.gulp.dest(app.path.settings_build.css))
}