import jQuery from 'jquery';
window.jQuery = window.$ = jQuery;

export default (function(anchors) {

    $(anchors).on('click', function(event) {
        // Отменяем стандартную обработку нажатия по ссылке
        event.preventDefault();

        // Даем доп отступ сверху на высоту навигации
        let additionalOffset = $('nav').height();

        // Забираем и декодируем идентификатор бока
        let id = decodeURIComponent($(this).prop("hash").substring(1));

        // Проверяем, существует ли элемент с выбранным идентификатором
        let $target = $('[id="' + id + '"]')

        if ($target.length) {
            let top = $target.offset().top - additionalOffset;

            // Анимируем переход на расстояние - top за 400 мс
            $('body,html').animate({ scrollTop: top }, 400);
        }
    });


})