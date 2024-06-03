import jQuery from 'jquery';
window.jQuery = window.$ = jQuery;

export default (function() {
    // Сохранение ссылок на элементы DOM
    const $filterSelect = $('.js-filterSelect'),
        $inputDropdown = $('.js-inputDropdown'),
        $inputDropdownContainer = $('.js-inputDropdownContainer'),
        $inputDropdownLi = $('.js-inputDropdown li'),
        $popupCasinoContainer = $('.js-itemContainer');

    // Начальное значение активного списка
    let $activeList = '';

    // Назначение обработчиков событий
    $filterSelect.on('keyup', selectFilter);
    $filterSelect.on('click', getActiveList);
    $inputDropdownLi.on('click', setCasinoId);

    // Фильтрация списка при вводе
    function selectFilter(e) {
        let cur_value = $(this).val(),
            $active_items = $activeList.filter(function(index, elem) {
                return $(elem).text().toLowerCase().indexOf(cur_value.toLowerCase()) !== -1;
            });

        $activeList.removeClass('show');
        $active_items.addClass('show');
    }

    // Установка ID казино при клике на элемент списка
    function setCasinoId(e) {

        let id = $(this).attr('data-id'),
            title = $(this).text(),
            $sameItems = $(this).closest('.js-inputDropdownContainer').find('.js-itemContainer [value="' + id + '"]'),
            $curPopupCasinoContainer = $(this).closest('.js-inputDropdownContainer').find('.js-itemContainer'),
            option_name = $(this).closest('.js-inputDropdownContainer').attr('data-oplion');

        $('.js-dropdownItem').removeClass('same');

        let $sameItem = $(this).closest('.js-inputDropdownContainer').find('.js-sameItem').removeClass('show');

        let nextCasino = 0;

        if ($(this).closest('.js-inputDropdownContainer').find('[data-curcasino]').last().length) {
            console.log($(this).closest('.js-inputDropdownContainer').find('[data-curcasino]').last().attr('data-curcasino'));
            nextCasino = parseInt($(this).closest('.js-inputDropdownContainer').find('[data-curcasino]').last().attr('data-curcasino')) + 1;
        }

        if (!$sameItems.length) {
            $curPopupCasinoContainer.append(
                "<div class='dropdown-item js-dropdownItem'>" +
                "<span>" + title + "</span>" +
                "<span class='js-dropdownItemRemove dropdown-item-remove'></span>" +
                "<input type='hidden' data-curcasino='" + nextCasino + "' value='" + id + "' name='" + option_name + "[" + nextCasino + "]' class='js-dropdownItemId'/>" +
                "</div> "
            );
        } else {
            $sameItems.closest('.js-dropdownItem').addClass('same');
            $sameItem.addClass('show');
        }

        $inputDropdown.removeClass('show');
        $filterSelect.keyup();
    }

    // Получение активного списка при клике на поле ввода
    function getActiveList(e) {
        $inputDropdown.removeClass('show');
        $activeList = $(this).closest('.js-inputDropdownContainer').find('.js-inputDropdown').addClass('show').find('li');
    }

    // Удаление элемента из списка при клике на кнопку удаления
    $popupCasinoContainer.on('click', '.js-dropdownItemRemove ', function(e) {
        $(this).closest('.js-dropdownItem').remove();
    });

    // Обработка клика вне выпадающего списка для его скрытия
    $(document).on('click', function(e) {
        let div = $inputDropdownContainer;
        if (!div.is(e.target) && div.has(e.target).length === 0) {
            div.find('.js-inputDropdown').removeClass('show');
        }
    });

})();