import jQuery from 'jquery';
window.jQuery = window.$ = jQuery;

export default (function() {
    const burger = $('.js-openMenuMobile'), // Бургер на мобайле
        navigation = $('nav'), // Навигация
        languageList = $('.js-languageList') // Список языков

    let searchContainer = $('.js-searchContainer'),
        openSearch = $('.js-magnifier'),
        closeSearch = $('.js-searchClose'),
        mobileSearch = $('.js-mobileSearch')

    openSearch.click(e => {
        $(languageList).removeClass('open')
        searchContainer.addClass('open')
    })

    closeSearch.click(e => searchContainer.removeClass('open'))

    mobileSearch.click(e => {
        if (mobileSearch.hasClass('open')) {
            $.merge(mobileSearch, searchContainer).removeClass('open')
        } else {
            $.merge(mobileSearch, searchContainer).addClass('open')
            $.merge(burger, navigation, languageList).removeClass('open')
        }
    })
    return { searchContainer, mobileSearch }

})();