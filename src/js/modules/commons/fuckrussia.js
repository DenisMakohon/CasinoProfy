import jQuery from 'jquery'
window.jQuery = window.$ = jQuery

export default (function() {

    const noWar = $('.js-noWar'),
        noWarClose = $('.js-noWarClose')

    noWarClose.on('click', () => noWar.removeClass('show'))

})()