import jQuery from 'jquery';
window.jQuery = window.$ = jQuery;

import 'slick-carousel';

export default (function() {

    $(window).on('load', function() {
        const reviewsClients = $('.js-reviewsClients').slick({
                infinite: true,
                slidesToShow: 4,
                slidesToScroll: 4,
                appendArrows: $('.js-reviewsClientsControls'),
                prevArrow: '<button id="prev" type="button"></button>',
                nextArrow: '<button id="next" type="button"></button>',
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


// у меня есть js код

// import jQuery from 'jquery';
// window.jQuery = window.$ = jQuery;

// import 'slick-carousel';

// export default (function() {

//     $(() => {
//         const reviewsClients = $('.js-reviewsClients').slick({
//                 infinite: true,
//                 slidesToShow: 4,
//                 slidesToScroll: 4,
//                 appendArrows: $('.js-reviewsClientsControls'),
//                 prevArrow: '<button id="prev" type="button"></button>',
//                 nextArrow: '<button id="next" type="button"></button>',
//                 responsive: [{
//                         breakpoint: 1199,
//                         settings: {
//                             slidesToShow: 3,
//                             slidesToScroll: 3,
//                         }
//                     },
//                     {
//                         breakpoint: 991,
//                         settings: {
//                             slidesToShow: 2,
//                             slidesToScroll: 2,
//                         }
//                     },
//                     {
//                         breakpoint: 767,
//                         settings: {
//                             slidesToShow: 1,
//                             slidesToScroll: 1,
//                         }
//                     },
//                 ]
//             })
//             .on('setPosition', function(event, slick) {
//                 slick.$slides.css('height', slick.$slideTrack.height() + 'px');
//             });
//     });


// })()

// это слайдер, но скрипт срабатывает до того, как прогрузятся стили и весь прочий контент из-за чего блоки слайдера в начале принимают некорректную высоту. Как мне это исправить?