import jQuery from 'jquery'
window.jQuery = window.$ = jQuery

export default (function() {

    let starsContainer = $('.js-stars')

    starsContainer.each((i, el) => {
        let rating = $(el).attr('data-stars')

        let out = '';

        for (i = 1; i <= rating; i++) {
            out += '<img src="/' + window.curLang + '/wp-content/themes/casinoprofy/static/images/star.svg" width="21" height="20" alt="star icon">'
        }

        for (i = rating; i < 5; i++) {
            out += '<img src="/' + window.curLang + '/wp-content/themes/casinoprofy/static/images/star_gray.svg" width="21" height="20" alt="star icon">'
        }
        $(el).html(out)

    })

})()