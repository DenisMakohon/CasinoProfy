import jQuery from 'jquery';
window.jQuery = window.$ = jQuery;

import 'slick-carousel';

export default (function() {

    $(window).on('load', function() {
        let popupCasinos = $('.js-popupCasinosSlider').slick({
            dots: true,
            infinite: true,
            arrows: true,
            slidesToShow: 4,
            slidesToScroll: 4,
            appendArrows: '.popupCasinos-arrows',
            prevArrow: '<span class="popupCasinos-arrows-prev d-inline-block"><img src="/wp-content/themes/casinoprofy/static/images/up_arrow.svg" alt="prev arrow"></span>',
            nextArrow: '<span class="popupCasinos-arrows-next d-inline-block"><img src="/wp-content/themes/casinoprofy/static/images/up_arrow.svg" alt="next arrow"></span>',
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                    }
                },
                {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        })
    })



})()