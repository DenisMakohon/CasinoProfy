import jQuery from 'jquery';
window.jQuery = window.$ = jQuery;

export default (function() {

    let iframe = $('iframe'),
        iframeContainer = $('.js-iframeContainer'),
        iframeContainerPopup = $('.js-iframeContainerPopup'),
        iframeLowScreen = $('.js-iframeLowScreen'),
        iframeFullScreen = $('.js-iframeFullScreen'),
        iframeFullScreenButtons = $('.js-iframeFullScreenButtons'),
        $iframeCurent = ''
        // started
    const $popupUkDemo = $('.js-popupUkDemo'), // Попап кук
        $popupUkDemoClose = $('.js-popupUkDemo-close'),
        $popupUkDemoOk = $('.js-popupUkDemo-ok')

    function setupHeight() {
        $.merge(iframe, iframeContainer).height(iframeContainer.width() / 1.78048)
    }

    $('.js-startIframe').on('click', e => {

        $.ajax({
            url: "https://get.geojs.io/v1/ip/geo.js",
            dataType: "jsonp",
            jsonpCallback_1: "geoip",
            success: function(data) {
                var data_country = data.country_code,
                    data_city = data.city;
                if (data_country != 'GB') {
                    //if (localStorage.getItem('ukDemo')) {
                    let iframeSrc = $(e.currentTarget).attr('data-iframe')

                    iframe.attr('src', iframeSrc)
                    iframeContainer.addClass('started')
                        // } else {
                        //$popupUkDemo.addClass('open')
                        //}
                }
            }
        });
    })

    iframeFullScreen.on('click', e => {
        iframeFullScreenButtons.addClass('full')
        iframeContainerPopup.addClass('open')
    })

    iframeLowScreen.on('click', e => {
        iframeFullScreenButtons.removeClass('full')
        iframeContainerPopup.removeClass('open')
    })

    setupHeight()
    $(window).on('resize', () => {
        setupHeight()
    })

    $popupUkDemoOk.on('click', () => {
        $popupUkDemo.removeClass('open')

        localStorage.setItem('ukDemo', true)
    })

    $popupUkDemoClose.on('click', () => {
        $popupUkDemo.removeClass('open')
    })

})()