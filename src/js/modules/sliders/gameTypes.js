import jQuery from 'jquery';
window.jQuery = window.$ = jQuery;

import 'slick-carousel';

export default (function() {

    $(window).on('load', function() {
        const gameTypes = $('.js-gameTypes').slick({
                infinite: true,
                slidesToShow: 4,
                slidesToScroll: 4,
                appendArrows: $('.js-gameTypesControls'),
                prevArrow: '<button id="prev" type="button" title="Button Prev"></button>',
                nextArrow: '<button id="next" type="button" title="Button Next"></button>',
                responsive: [{
                        breakpoint: 1199,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3,
                        }
                    },
                    {
                        breakpoint: 991,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2,
                        }
                    },
                    {
                        breakpoint: 767,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                        }
                    },
                ]
            })
            .on('setPosition', function(event, slick) {
                slick.$slides.css('height', slick.$slideTrack.height() + 'px');
            });
    });



})()