import jQuery from 'jquery'
import * as cookie from "./cookie.js";
window.jQuery = window.$ = jQuery

export default (function() {

    const isCasinoOfTheMonthMobileBanner = cookie.getCookie('casinoOfTheMonthMobileBanner'),
        $casinoOfTheMonthMobileBanner = $(".casinoOfTheMonth-extra-mob-wrap-div"),
        $casinoOfTheMonthMobileBannerClose = $(".close-btn-mobile-banner");

    if (isCasinoOfTheMonthMobileBanner) {
        $casinoOfTheMonthMobileBanner.removeClass('show').addClass('hidden')
    } else {
        $casinoOfTheMonthMobileBannerClose.on('click', () => {
            $casinoOfTheMonthMobileBanner.removeClass('show')
            $casinoOfTheMonthMobileBanner.addClass('hidden')
            cookie.setCookie('casinoOfTheMonthMobileBanner', 'true')
        })
    }

   })()