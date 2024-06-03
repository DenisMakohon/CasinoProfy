import jQuery from 'jquery';
window.jQuery = window.$ = jQuery;

export default (function() {

    const gameFilter = $('.js-gameFilter'),
        allGames = $('.js-allGames'),
        gameFilterReset = $('.js-gameFilterReset'),
        openGameFilter = $('.js-openGameFilter')

    let filter = ''

    gameFilter.on('click', e => {
        filter = $(e.currentTarget).text()
        hiddenTrigger()
    })

    gameFilterReset.on('click', e => {
        filter = ''
        hiddenTrigger()
    })

    allGames.on('click', e => {
        $(e.currentTarget).addClass('hidden')
        filter ? $('[data-filter="' + filter + '"]').removeClass('hidden') : $('[data-filter]').removeClass('hidden')
    })

    function hiddenTrigger() {
        $('[data-filter]').addClass('hidden')

        let targetItems = filter ? $('[data-filter="' + filter + '"]') : $('[data-filter]')

        targetItems.slice(0, 8).removeClass('hidden')

        targetItems.length > 8 ? allGames.removeClass('hidden') : allGames.addClass('hidden')
    }

    openGameFilter.click(e => {
        $(e.currentTarget).toggleClass('open')
    })

})()