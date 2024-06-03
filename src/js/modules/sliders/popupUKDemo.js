import jQuery from 'jquery';
window.jQuery = window.$ = jQuery;

import 'slick-carousel';

export default (function() {

    $(window).on('load', function() {
        let popupUKDemo = $('.js-popupUKDemoSlider').slick({
            dots: true,
            infinite: true,
            arrows: false,
            slidesToShow: 1,
            slidesToScroll: 1,
            appendArrows: '.popupUKDemo-arrows',
            prevArrow: '<span class="popupUKDemo-arrows-prev d-inline-block"><img src="/wp-content/themes/casinoprofy/static/images/up_arrow.svg" alt="prev arrow"></span>',
            nextArrow: '<span class="popupUKDemo-arrows-next d-inline-block"><img src="/wp-content/themes/casinoprofy/static/images/up_arrow.svg" alt="next arrow"></span>',
            responsive: [{
                    breakpoint: 3048,
                    settings: {
                        settings: 'unslick'
                    }
                },
                {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        })
    })

})()