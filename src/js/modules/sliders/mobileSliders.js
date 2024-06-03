import jQuery from 'jquery';
window.jQuery = window.$ = jQuery;

import 'slick-carousel';
export default (function() {

    //Слайдеры, которые срабатывают только на мобайле

    // slick on mobile
    $(window).on('load', function() {
        function case_mobile_slider() {

            let sliders = $('.js-mobile-slider');
            if (window.innerWidth > 767) {
                if (sliders.hasClass('slick-initialized')) {
                    $(sliders).slick('unslick');
                }
                return
            } else {
                sliders.each(function(index) {
                    if (!$(this).hasClass('slick-initialized')) {
                        let current_slider = $(this).slick({
                            dots: false,
                            arrows: false
                        });
                        $(this).closest('.mobile-slider-container').find('.slider-arrows .prev').click(function() {
                            current_slider.slick('slickPrev');
                        })
                        $(this).closest('.mobile-slider-container').find('.slider-arrows .next').click(function() {
                            current_slider.slick('slickNext');
                        })
                    }
                })
            }
        }

        case_mobile_slider();
    })

})()