import $ from "jquery";

export default (function() {

    const $popupCookie = $('.js-popupCookie'), // Попап кук
        $popupCookieBtn = $('.js-popupCookieBtn')

    if (!localStorage.getItem('popupCookie')) $popupCookie.addClass('show')

    $popupCookieBtn.on('click', () => {
        $popupCookie.removeClass('show')
        localStorage.setItem('popupCookie', true)
    })

})();