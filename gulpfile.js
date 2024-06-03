// Модуль Gulp
import gulp from 'gulp'
// Пути
import { path } from './gulp/config/path.js'
// Плагины
import { plugins } from './gulp/config/plugins.js'

global.app = {
    isSet: process.argv.includes('--set'),
    isSetB: process.argv.includes('--setb'),
    isBuild: process.argv.includes('--build'),
    isDev: !process.argv.includes('--build'),
    path: path,
    gulp: gulp,
    plugins: plugins
}

import { copy } from './gulp/tasks/copy.js'
import { reset, reset_set } from './gulp/tasks/reset.js'
import { scss, scss_set } from './gulp/tasks/scss.js'
import { scripts, scripts_set } from './gulp/tasks/scripts.js'
import { images, images_set } from './gulp/tasks/images.js'

function watcher() {
    gulp.watch(path.watch.scss, scss)
    gulp.watch(path.watch.js, scripts)
    gulp.watch(path.watch.images, images)
}

function watcher_css() {
    gulp.watch(path.watch.scss, scss)
}

function watcher_set() {
    gulp.watch(path.settings_watch.scss, scss_set)
    gulp.watch(path.settings_watch.js, scripts_set)
    gulp.watch(path.settings_watch.images, images_set)
}

const mainTasks = gulp.parallel(scss, scripts, images)
const settingsTasks = gulp.parallel(scss_set, scripts_set, images_set)

const dev = gulp.series(reset, mainTasks, watcher)
const build = gulp.series(reset, mainTasks)
const css = gulp.series(reset, gulp.parallel(watcher_css))

const settingsdev = gulp.series(reset_set, settingsTasks, watcher_set)
const settingsbuild = gulp.series(reset_set, settingsTasks)

export { dev }
export { build }
export { css }

export { settingsdev }
export { settingsbuild }

gulp.task('default', dev)