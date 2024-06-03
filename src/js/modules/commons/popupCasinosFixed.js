// Попап, который вызывается на заблокированных казино
import jQuery from 'jquery';
window.jQuery = window.$ = jQuery;

export default (function() {

    let $popupCasinosFixed = $('.js-popupCasinosFixed'),
        $popupCasinosFixedClose = $('.js-popupCasinosFixedClose'),
        $popupCasinosFixedOpen = $('[data-popup="get_popup"]')

    $popupCasinosFixedClose.on('click', () => $popupCasinosFixed.removeClass('show'))
    $popupCasinosFixedOpen.on('click', e => {
        $('body,html').stop();
        e.preventDefault()
        $popupCasinosFixed.addClass('show')
    })

})()