import jQuery from 'jquery';

window.jQuery = window.$ = jQuery;

import search from '@modules/search.js'; // Поиск

export default (function() {

    // НАВИГАЦИЯ

    const burger = $('.js-openMenuMobile'), // Бургер на мобайле
        toc = $('.js-openTableOfContents'), // Table Of Content на мобайле
        navToc = $('.nav-tableOfContents'), // Table Of Content на мобайле блок с контентом
        navMob = $('.nav-mobile'), // Мобильная навигация, полоска внизу
        navigation = $('nav'), // Навигация
        menus = $('.menu-item'), // Пункты меню
        openSubmenu = $('.js-openSubmenu'), // Стрелочки для разворачивания/сворачивания сабменю на мобилках 
        subMenus = $('.js-submenu'), // Сабменбшки
        openLanguage = $('.js-openLanguage'), // Кнопка открытия списка языков
        languageList = $('.js-languageList') // Список языков


    // MOBILE NAV

    function margeMultiple(ars) {
        let outArray = []

        for (let i = 0; i <= arguments.length - 1; i++) {
            $.merge(outArray, arguments[i])
        }

        return $(outArray);
    }

    burger.click(() => {
        navigation.hasClass('open') ? navigation.removeClass('open') : navigation.addClass('open').removeClass('show-search')
        navMob.addClass('hide')
        burger.toggleClass('open')
        margeMultiple(search.mobileSearch, search.searchContainer, languageList, toc, navToc).removeClass('open')
    })

    // MOBILE Table Of Content
    toc.click(() => {
        navigation.hasClass('open') ? navigation.removeClass('open') : navigation.addClass('open').removeClass('show-search')
        navMob.addClass('hide')
        toc.toggleClass('open')
        navToc.toggleClass('open')
        margeMultiple(search.mobileSearch, search.searchContainer, languageList, navigation, burger).removeClass('open')
    })

    $('#tableOfContents li a').click(() => {
        margeMultiple(toc, navToc).removeClass('open')
        margeMultiple(navMob).removeClass('hide')
    })

    $('#top-toc-close-btn').click(() => {
        margeMultiple(toc, navToc).removeClass('open')
        margeMultiple(navMob).removeClass('hide')
    })

    $('#top-nav-close-btn').click(() => {
        margeMultiple(burger, navigation, navToc).removeClass('open')
        margeMultiple(navMob).removeClass('hide')
    })

    // Открыть/закрыть сабменю

    function upDownSubMenus() {
        if (window.innerWidth <= 1199) {
            menus.not('.open').find('.js-submenu').slideUp(0)
        } else {
            $('.menu-item').removeClass('open')
            subMenus.slideDown(0)
        }
    };

    upDownSubMenus()

    openSubmenu.click(e => {
        let curMenuItem = $(e.currentTarget).closest('.menu-item'),
            curSubMenu = curMenuItem.find('>.js-submenu')

        curMenuItem.toggleClass('open')
        curSubMenu.slideToggle(400)
    })

    $(window).resize(() => upDownSubMenus())

    // Окно поиска в навигации

    $('.js-search-open,.js-search-close').click(e => {
        $(e.currentTarget).closest('.nav-search-form').toggleClass('open')
    })

    $('.js-search-close').click(e => {
        $('.ajax-results-container').removeClass('open')
    })

    $('.js-search-open').click(e => {
        $('.ajax-results-container').addClass('open')
    })

    // Открыть/закрыть список языков

    openLanguage.click(e => {
        languageList.toggleClass('open')
        margeMultiple(search.mobileSearch, search.searchContainer).removeClass('open')
    })

    // Поиск на моб версии

    $('.nav-search-wrap .search-field').on('input', function() {
        $('.nav-search-wrap').addClass('open')
        $('.nav-search-wrap .js-searchResults').removeClass('hide')
    })

    $('.nav-search-wrap .js-searchClose').click(e => {
        $('.nav-search-wrap').removeClass('open');
        $('.nav-search-wrap .search-field').val('');
        $('.nav-search-wrap .js-searchResults').addClass('hide');
    })

})();