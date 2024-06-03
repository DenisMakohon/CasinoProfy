import jQuery from 'jquery'

window.jQuery = window.$ = jQuery

import smothScroll from './smothScroll.js'

export default (function() {

    // smothScroll('#tableOfContents a, a[href="#casino_block"]');

    $('#tableOfContents li a').on('click', function() {
        $('#tableOfContents li a.current').removeClass('current');
        $(this).addClass('current');
    });

    $(window).on('mousewheel || keyup', function(e) {
        $('#tableOfContents li a').removeClass('current');
    });

    $('#tableOfContents li a').bind('mousewheel', function(e) {
        $(this).removeClass('current');
    });

})()