import jQuery from 'jquery'
window.jQuery = window.$ = jQuery
import * as cookie from './cookie'

export default (function() {

    const isfixedPopup = cookie.getCookie('fixedPopup'),
        $fixedPopup = $(".js-fixedPopup"),
        $fixedPopupClose = $(".js-fixedPopupClose"),
        $fixedPopupContent = $(".js-fixedPopupContent"),
        $fixedPopupTCBtn = $(".js-fixedPopupTCBtn"),
        $fixedPopupTC = $('.js-fixedPopupTC'),
        $fixedPopupShowBtn = $('.js-fixedPopupShowBtn')

    if (isfixedPopup) {
        $fixedPopup.removeClass('show').addClass('hidden')
        $fixedPopupShowBtn.addClass('show')
    } else {
        if (($(window).scrollTop() > $(document).height() / 5)) $fixedPopup.addClass("show")
        $fixedPopupShowBtn.removeClass('show')
    }

    $fixedPopupClose.on('click', () => {
        $fixedPopup.removeClass('show')
        cookie.setCookie('fixedPopup', 'true')
    })

    $(window).on('scroll', e => {
        if (($(window).scrollTop() > $(document).height() / 5) && !$fixedPopup.hasClass('hidden')) $fixedPopup.addClass("show hidden")
    })

    $fixedPopup.find(".bonus-click").on('click', () => cookie.setCookie('fixedPopup', 'true'))
    $fixedPopupTCBtn.on('mouseover', () => {
        $fixedPopupTC.addClass('show').outerHeight($fixedPopupContent.outerHeight() - $fixedPopupTCBtn.outerHeight())
    }).on('mouseleave', () => $fixedPopupTC.removeClass('show'))

    $fixedPopupShowBtn.on('click', () => $fixedPopup.addClass('show hidden'))

})()