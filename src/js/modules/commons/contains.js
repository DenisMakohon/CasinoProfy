import jQuery from 'jquery'
window.jQuery = window.$ = jQuery

import smothScroll from './smothScroll.js'

export default (function() {

    const $contains = $(".js-contains"),
        $containsBtn = $(".js-containsBtn"),
        rows = 2, // Кодичество рядов, которые показаны по умолчанию
        $containsWraper = $('.js-contains ul'), // Высота Контейнера с тегами
        $containsMore = $('.js-containsMore'), // Кнопка показать/скрыть больше тегов
        $containerHeight = $containsWraper.find('li').first().outerHeight(true) * rows;

    let showFlag = false,
        alwaysShowFlag = $containerHeight >= $containsWraper.outerHeight() ? true : false

    if (alwaysShowFlag) $containsMore.remove();

    smothScroll('#tableOfContents a, #contains a, a[href="#casino_block"]')

    // открытие якорей
    $containsBtn.on('click', e => {
        $(e.currentTarget).toggleClass('open')
        if ($(e.currentTarget).hasClass('open')) {
            $contains.height($containsWraper.height())
            $containsMore.addClass('up')
        } else {
            $contains.height(0)
            $containsMore.removeClass('up')
        }
    })

    function mobileSlide(selector) {
        $(window).on('resize', () => {
            if ($(window).width() > 767) {
                $containsBtn.removeClass('open')
            } else {
                if (!$containsBtn.hasClass('open')) {
                    $contains.height(0)
                }
                $containsMore.removeClass('up')
                showFlag = false
            }
            $containsWraper.each((i, elem) => {
                if ($(window).width() > 767) {
                    let $curWraper = $(elem),
                        $curContainer = $(elem).closest('.js-contains'), // Контейнер, который скрывает теги 
                        $curBtn = $curContainer.next().find('.js-containsMore')

                    if ($curWraper.height() >= $containerHeight && !showFlag) {
                        if (alwaysShowFlag) {
                            $contains.css('height', 'auto')
                        } else {
                            $curContainer.height($containerHeight) // Показиваем первые {rows} рядов  
                        }
                        $containsMore.addClass('up')
                    }
                }
            })
        })
        $(window).resize()
    }

    mobileSlide('.js-contains')

    $containsMore.on('click', e => {
        let timeFlag = '',
            $curBtn = $(e.currentTarget),
            $curTaxonomyContainer = $curBtn.closest('.containsMore').prev('.js-contains'), // Контейнер, который скрывает теги  
            $curTaxonomyWraper = $curTaxonomyContainer.find('ul') // Контейнер, который скрывает теги  

        if ($curTaxonomyWraper.height() > $containerHeight) {
            if (showFlag) {
                $curBtn.addClass('up')
                $curTaxonomyContainer.height($curTaxonomyWraper.height())
                    .css('overflow', 'hidden')
                    .height($containerHeight) // Показиваем первые {rows} рядов

            } else {
                $curBtn.removeClass('up')
                $curTaxonomyContainer.height($curTaxonomyWraper.outerHeight())
                timeFlag = setTimeout(() => {
                    $curTaxonomyContainer.css('height', 'auto')
                }, 400)
            }
        }

        showFlag = !showFlag
    })

})()