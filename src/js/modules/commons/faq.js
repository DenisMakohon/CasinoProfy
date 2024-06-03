import jQuery from 'jquery';
window.jQuery = window.$ = jQuery;

export default (function() {

    let openAnswer = $('.js-openAnswer')
    setTimeout(() => {
        $('.js-answer').slideUp(400)
    }, 5000)

    openAnswer.click(e => {
        let currentQuestion = $(e.currentTarget)
        currentQuestion.toggleClass('open').siblings('.js-answer').slideToggle(400)
    })

})()