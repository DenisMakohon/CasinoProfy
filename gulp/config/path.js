// Имя папки проекта
import * as nodePath from 'path'
const rootFolder = nodePath.basename(nodePath.resolve())

const srcSettingsFolder = './includes/themeOptions/src'
const buildSettingsFolder = './includes/themeOptions/static'
const buildFolder = './static'
const srcFolder = './src'

export const path = {
    build: {
        js: `${buildFolder}/js/`,
        php: `./`,
        css: `${buildFolder}/css/`,
        files: `${buildFolder}/`,
        images: `${buildFolder}/images/`
    },
    src: {
        js: `${srcFolder}/js/*.js`,
        svg: `${srcFolder}/images/**/*.svg`,
        php: `${srcFolder}/pages/**/*.php`,
        scss: `${srcFolder}/scss/**/*.scss`,
        files: `${srcFolder}/**/*.*`,
        images: `${srcFolder}/images/**/*.{jpg,jpeg,png,gif,webp,ico,svg}`
    },
    watch: {
        js: `${srcFolder}/js/**/*.js`,
        php: `${srcFolder}/**/*.php`,
        scss: `${srcFolder}/scss/**/*.scss`,
        files: `${srcFolder}/**/*.*`,
        images: `${srcFolder}/images/**/*.{jpg,jpeg,png,gif,ico,svg,webp}`
    },
    settings_build: {
        js: `${buildSettingsFolder}/js/`,
        php: `./`,
        css: `${buildSettingsFolder}/css/`,
        files: `${buildSettingsFolder}/`,
        images: `${buildSettingsFolder}/images/`
    },
    settings_src: {
        js: `${srcSettingsFolder}/js/*.js`,
        svg: `${srcSettingsFolder}/images/**/*.svg`,
        php: `${srcSettingsFolder}/pages/**/*.php`,
        scss: `${srcSettingsFolder}/scss/**/*.scss`,
        files: `${srcSettingsFolder}/**/*.*`,
        images: `${srcSettingsFolder}/images/**/*.{jpg,jpeg,png,gif,webp,ico}`
    },
    settings_watch: {
        js: `${srcSettingsFolder}/js/**/*.js`,
        php: `${srcSettingsFolder}/**/*.php`,
        scss: `${srcSettingsFolder}/scss/**/*.scss`,
        files: `${srcSettingsFolder}/**/*.*`,
        images: `${srcSettingsFolder}/images/**/*.{jpg,jpeg,png,gif,ico,svg,webp}`
    },
    clean: buildFolder,
    buildFolder: buildFolder,
    clean_set: buildSettingsFolder,
    srcFolder: srcFolder,
    rootFolder: rootFolder
}