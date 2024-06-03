import jQuery from 'jquery';
window.jQuery = window.$ = jQuery;

export default (function() {

    const $rating = $('.js-userRatingItem'),
        $ratingContainer = $('.js-userRating'),
        $ratingText = $('.js-ratingText')

    let $ratingNum = $ratingContainer.attr('data-rating')


    let time_flag = '';

    // По ховеру подсвечиваем нужное количество зввёзд; остальные - ставим серыми
    $rating.on('mouseover', e => {
        let el_num = $rating.index($(e.currentTarget))
        for (let i = 0; i <= el_num; i++) {
            $rating.eq(i).addClass('red')
        }
        for (let i = ++el_num; i < $rating.length; i++) {
            $rating.eq(i).removeClass('red')
        }
    })

    // Когда пользователь уводи мышь, ставим дэфолтный рейтинг
    $ratingContainer.on('mouseleave', e => {
        for (let i = 0; i < $ratingNum; i++) {
            $rating.eq(i).addClass('red')
        }
        for (let i = $ratingNum; i < $rating.length; i++) {
            $rating.eq(i).removeClass('red')
        }
    })

    $rating.on('click', e => {

        $ratingNum = $rating.index($(e.currentTarget)) + 1;
        for (let i = 0; i < $ratingNum; i++) {
            $rating.eq(i).addClass('red')
        }
        for (let i = $ratingNum; i < $rating.length; i++) {
            $rating.eq(i).removeClass('red')
        }
        console.log($ratingNum)
            // $("[name='rating']:checked").val()
            // $.ajax({
            //     type: 'post',
            //     url: '/wp-admin/admin-ajax.php',
            //     data: {
            //         action: 'ajax_rating',
            //         rating: $rating.index($(e.currentTarget)) + 1,
            //         curBlog: window.curBlog,
            //         curLang: window.curLang,
            //         curId: window.curId
            //     },
            //     success: function(result) {
            //         $ratingText.addClass('show').text(result)
            //         setTimeout(() => {
            //             $ratingText.removeClass('show')
            //         }, 2000)
            //     }

        // });
    })

})()