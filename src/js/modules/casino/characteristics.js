import jQuery from 'jquery';
window.jQuery = window.$ = jQuery;

export default (function() {
    let characteristics = $('.js-characteristicsOpen'),
        characteristicsContent = $('.js-characteristicsContent').slideUp(0)

    characteristics.on('click', () => {
        characteristics.toggleClass('open')
        characteristicsContent.slideToggle(400)
    })

})()