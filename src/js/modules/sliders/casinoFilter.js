import jQuery from 'jquery';
window.jQuery = window.$ = jQuery;

import 'slick-carousel';

export default (function() {

    $(window).on('load', function() {
        // Инициализация слайдера
        let casinoFilterBlocks = $('.js-casinoFilterBlocks').slick({
                infinite: false,
                arrows: false,
                swipe: false,
                swipeToSlide: false,
                adaptiveHeight: true
            }),
            $casinoFilterControls = $('.js-casinoFilterControls')

        function focus_on_filter($curForm) {
            let additionalOffset = $('nav').height(),
                top = $curForm.offset().top - additionalOffset;
            $('body,html').animate({ scrollTop: top }, 400);
        }

        // Клики по єлементам управления
        $casinoFilterControls.on('click', e => {
            let $curControls = $(e.currentTarget),
                $controlType = $(e.target),
                $curForm = $curControls.closest('form'),
                $curSlider = casinoFilterBlocks.eq($casinoFilterControls.index($curControls)),
                slide_num = parseInt($curForm.removeClass('last').find('.js-filterStepsCounter').text())

            if ($controlType.hasClass('js-casinoFilter-controlsNext')) {
                slide_num++
            } else if ($controlType.hasClass('js-casinoFilter-controlsPrev')) {
                slide_num--
            } else if ($controlType.hasClass('js-casinoFilter-controlsReset')) {
                slide_num = 1
            }

            // Перед при переходе на последний слайд (с результатами) отправляем запрос, в остальных случаях просто переключаемся
            if (slide_num != $curSlider[0].slick.slideCount) {
                $curControls.closest('form').find('.js-casinoFilter-controlsReset').hide()

                if ($controlType.hasClass('js-casinoFilter-controlsNext')) {
                    $curSlider.slick('slickNext')
                } else if ($controlType.hasClass('js-casinoFilter-controlsReset')) {
                    $curSlider.slick('slickGoTo', 0)
                    focus_on_filter($curForm)
                } else if ($controlType.hasClass('js-casinoFilter-controlsPrev')) {
                    $curSlider.slick('slickPrev')

                    // При возврате назад после получения результатов мы очищаем слайд результатов, и фиксируем юзера на форме
                    if (slide_num == $curSlider[0].slick.slideCount - 1) {
                        $curForm.find('.js-casinoFilterResult').html('')
                        focus_on_filter($curForm)
                    }
                }
            } else {

                // Получаем казино
                let formData = $curControls.closest('form')
                    // Прелоадер
                formData.find('.js-filterPreloader').addClass('show')

                $.ajax({
                    type: 'get',
                    url: '/wp-admin/admin-ajax.php',
                    data: {
                        action: 'ajax_filter',
                        form: formData.serialize(),
                        curBlog: window.curBlog,
                        curLang: window.curLang
                    },
                    // what happens on success
                    success: function(result) {
                        // console.log(result);
                        formData.addClass('last').find('.js-casinoFilterResult').html(result)
                        formData.find('.js-filterPreloader').removeClass('show')
                        formData.find('.js-moreInfo').slideUp(0)
                        formData.find('.js-casinoFilter-controlsReset').show()
                        $curSlider.slick('slickNext')

                    }

                });
            }

        })

        // При смене слайда обновляем номер и тайтл
        casinoFilterBlocks.on('beforeChange', function(event, slick, currentSlide, nextSlide) {

            let $curForm = $(slick.$list[0]).closest('form'),
                $counter = $curForm.find('.js-filterStepsCounter'),
                $title = $curForm.find('.js-casinoFilterTitle'),
                $newTitle = $curForm.find('.slick-slide').eq(nextSlide).find('[data-title]').attr('data-title')

            $curForm.find('.js-casinoFilter-controlsPrev, .js-casinoFilter-controlsNext').removeClass('disable')

            if (nextSlide == 0) $curForm.find('.js-casinoFilter-controlsPrev').addClass('disable')

            if (nextSlide == slick.slideCount - 1) $curForm.find('.js-casinoFilter-controlsNext').addClass('disable')

            $title.text($newTitle)
            $counter.text(++nextSlide)

        })

        let time_flag = ''

        casinoFilterBlocks.on('afterChange', function(event, slick, currentSlide, nextSlide) {
            let $curForm = $(slick.$list[0]).closest('form')

            clearTimeout(time_flag)

            setTimeout(() => {
                if ($curForm.find('.slick-slide').length == currentSlide + 1) {
                    $curForm.find('.slick-list').css({
                        'height': 'auto',
                    })
                } else {
                    $curForm.find('.slick-list').css({
                        'height': $curForm.find('.slick-slide').eq(currentSlide).find('>div').height() + 'px',
                    })
                }

            }, 50)

        })
    });

})()