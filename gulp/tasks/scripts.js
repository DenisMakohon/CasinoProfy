import webpack from "webpack-stream"
import * as path from 'path';

const __dirname = path.resolve();

export const scripts = () => {

    return app.gulp.src(app.path.src.js, { sourcemaps: app.isDev })
        .pipe(app.plugins.plumber(
            app.plugins.notify.onError({
                title: "JS",
                message: "Error <%= error.message %>"
            })
        ))
        .pipe(webpack({
            mode: app.isBuild ? 'production' : 'development',
            entry: {
                'casino-page': './src/js/casino-page.js',
                'main-page': './src/js/main-page.js',
                'games-page': './src/js/games-page.js',
                'bonus-page': './src/js/bonus-page.js',
                'casino-category': './src/js/casino-category.js',
                'game-category': './src/js/game-category.js',
                'providers': './src/js/providers.js',
                'blog': './src/js/blog.js',
                'post': './src/js/post.js',
                'app': './src/js/app.js',
                'blank': './src/js/blank.js',
            },
            output: {
                filename: '[name].min.js',
            },
            resolve: {
                alias: {
                    "@": path.resolve(__dirname, 'src'),
                    "@n_m": path.resolve(__dirname, 'node_modules'),
                    "@modules": path.resolve(__dirname, 'src/js/modules'),
                    "@commons": path.resolve(__dirname, 'src/js/modules/commons'),
                    "@sliders": path.resolve(__dirname, 'src/js/modules/sliders'),
                    "@slidersMainPage": path.resolve(__dirname, 'src/js/modules/sliders/mainPage')
                },
                fullySpecified: false
            }
        }))
        .pipe(app.gulp.dest(app.path.build.js))
}

export const scripts_set = () => {

    return app.gulp.src(app.path.settings_src.js, { sourcemaps: app.isSet })
        .pipe(app.plugins.plumber(
            app.plugins.notify.onError({
                title: "JS",
                message: "Error <%= error.message %>"
            })
        ))
        .pipe(webpack({
            mode: app.isSetB ? 'production' : 'development',
            entry: {
                'app': './includes/themeOptions/src/js/app.js'
            },
            output: {
                filename: '[name].min.js',
            },
            resolve: {
                alias: {
                    "@": path.resolve(__dirname, 'includes/themeOptions/src/'),
                    "@modules": path.resolve(__dirname, 'includes/themeOptions/src/js/modules'),
                    "@commons": path.resolve(__dirname, 'includes/themeOptions/src/js/modules/commons'),
                },
                fullySpecified: false
            }
        }))
        .pipe(app.gulp.dest(app.path.settings_build.js))
}