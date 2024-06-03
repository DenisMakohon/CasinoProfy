import jQuery from 'jquery';
window.jQuery = window.$ = jQuery;

import 'slick-carousel';

export default (function() {

    $(window).on('load', function() {
        let bonusSliderControl = $('.js-bonusSliderControl .control-title')

        let bonusSlider = $('.js-bonusSlider').slick({
            infinite: true,
            arrows: false,
        })

        bonusSliderControl.click(e => {
            let curBonus = $(e.currentTarget),
                slideNum = bonusSliderControl.index(curBonus)

            bonusSliderControl.not(curBonus).removeClass('active')
            curBonus.addClass('active')

            bonusSlider.slick('slickGoTo', parseInt(slideNum))

        })

        bonusSlider.on('beforeChange', function(event, slick, currentSlide, nextSlide) {

            bonusSliderControl.removeClass('active').eq(nextSlide).addClass('active')

        });
    })
})()