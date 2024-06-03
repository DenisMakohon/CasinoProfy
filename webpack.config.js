const path = require('path')
const webpack = require('webpack')
const { CleanWebpackPlugin } = require('clean-webpack-plugin')
const FileIncludeWebpackPlugin = require('file-include-webpack-plugin')

module.exports = {
    context: path.resolve(__dirname, 'src'),
    mode: 'development',
    watch: true,
    entry: {
        'casino-page': './js/casino-page.js',
        'main-page': './js/main-page.js',
        'games-page': './js/games-page.js',
        'bonus-page': './js/bonus-page.js',
        'casino-category': './js/casino-category.js',
        'game-category': './js/game-category.js',
        'providers': './js/providers.js',
        'providers-main': './js/providers-main.js',
        'blog': './js/blog.js',
        'post': './js/post.js',
        'app': './js/app.js',
        'blank': './js/blank.js',
    },
    output: {
        filename: '[name].min.js',
        path: path.resolve(__dirname, 'static/js')
    },
    devtool: 'eval-source-map',
    resolve: {
        alias: {
            "@": path.resolve(__dirname, 'src'),
            "@modules": path.resolve(__dirname, 'src/js/modules'),
            "@sliders": path.resolve(__dirname, 'src/js/modules/sliders'),
            "@slidersMainPage": path.resolve(__dirname, 'src/js/modules/sliders/mainPage')
        }
    },
    plugins: [
        new CleanWebpackPlugin()
    ],
    module: {
        rules: [{
            test: /\.css$/,
            use: ['style-loader', 'css-loader']
        }]
    }
}