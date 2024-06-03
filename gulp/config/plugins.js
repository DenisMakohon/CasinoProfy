import replace from "gulp-replace" // ПОиск и замена
import plumber from "gulp-plumber" // Обработка ошибок
import notify from "gulp-notify" // Сообщения об ошибках
import newer from "gulp-newer" // Сообщения об ошибках
import ifPlugin from "gulp-if" // Сообщения об ошибках

export const plugins = {
    replace: replace,
    plumber: plumber,
    notify: notify,
    newer: newer,
    if: ifPlugin
}