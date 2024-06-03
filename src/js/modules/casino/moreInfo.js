import jQuery from 'jquery';
window.jQuery = window.$ = jQuery;
import topTenShow from '@commons/topTenShow.js'; // Показать все казино

export default (function() {

    $('.js-moreInfo').slideUp(0)

    $('body').on('click', '.js-moreArrow', e => {

        let $curElem = $(e.currentTarget)

        $curElem.toggleClass('open')
            .closest('.js-moreItem')
            .find('.js-moreInfo')
            .slideToggle(400)
            .closest('.js-casinoFilterBlocks').find('.slick-list').css({
                'height': 'auto',
            })

        let show_more = $curElem.attr('data-more'),
            show_less = $curElem.attr('data-less')

        if ($curElem.hasClass('open')) {
            $curElem.find('.js-moreArrowText').text(show_less)
        } else {
            $curElem.find('.js-moreArrowText').text(show_more)
        }
    })
})()