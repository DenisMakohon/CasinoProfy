import jQuery from 'jquery';
window.jQuery = window.$ = jQuery

function hideFirstP() {
    if ($(window).width() < 768) {
        // Проверяем, есть ли тег <section> внутри .mainContent
        if ($('.mainContent section').length > 0) {
            let $mainContent = $('.mainContent').children().not('section, section ~ *'),
                $expandButton = $('<span class="spinWheel-more">' + $('.mainContent').attr('data-show_more') + '</span>'),
                $contentWrapper = $('<div>').css({ 'overflow': 'hidden', 'max-height': '96px' }).addClass('spinWheel-more-p');

            $mainContent.wrapAll($contentWrapper);
            $('.spinWheel-more-p').append($expandButton); // Добавляем кнопку непосредственно к .mainContent

            $expandButton.on('click', function() {
                $(this).parent('.spinWheel-more-p').css('max-height', 'none');
                $(this).remove();
                $('.spinWheel-more-p').addClass('spinWheel-more-p-noShadow');
            });
        }

    }

}

export { hideFirstP };