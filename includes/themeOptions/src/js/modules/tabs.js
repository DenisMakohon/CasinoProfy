import jQuery from 'jquery';
window.jQuery = window.$ = jQuery;

export default (function() {

    const $tabsSettingsList = $('.js-tabsSettingsList p'),
        $settingsItem = $('.settings-item');

    function activateTab(tab) {
        $tabsSettingsList.removeClass('active');
        $settingsItem.removeClass('active');

        // Добавляем класс active к выбранному табу и соответствующему контенту
        tab.addClass('active');
        $('[data-settings=' + tab.attr('data-tab') + ']').addClass('active');
    }

    $tabsSettingsList.on("click", function() {
        // Добавляем хеш в URL
        location.hash = $(this).attr('data-tab');
        activateTab($(this));
    });

    // Функция для активации таба на основе текущего хеша URL
    function activateTabFromHash() {
        const currentHash = location.hash.replace('#', '');

        if (currentHash) {
            const tab = $tabsSettingsList.filter(`[data-tab="${currentHash}"]`);
            if (tab.length) {
                activateTab(tab);
                return;
            }
        }

        // Если хеш не существует или нет соответствующего таба, активируем первый таб
        activateTab($tabsSettingsList.first());
    }

    // Вызываем функцию при загрузке страницы
    activateTabFromHash();

    // Обработчик изменения хеша
    $(window).on('hashchange', function() {
        activateTabFromHash();
    })

})()