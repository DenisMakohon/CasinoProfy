import jQuery from 'jquery';
window.jQuery = window.$ = jQuery;

export default (function() {
    let $addAutor = $('.js-addAutor'), // кнопки добавления автора
        $removeAutor = $('.js-removeAutor') // кнопки удаления автора

    $addAutor.on('click', addAutor)

    // Функция добавления автора
    function addAutor(e) {
        let $cur_btn = $(this),
            $addAutor = $('.js-addAutor'),
            $removeAutor = $('.js-removeAutor'),
            nuw_field_num = $('[data-next]').last().attr('data-next')

        // Делаем запрос для рендера полей нового автора
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                action: 'add_autor_field',
                autor_num: nuw_field_num
            },
            success: function(response) {
                $cur_btn.closest('tbody').append(response)
                $removeAutor = $('.js-removeAutor')
                $addAutor = $('.js-addAutor')
                $addAutor.off('click').on('click', addAutor)
                $removeAutor.off('click').on('click', removeAutor)

                tinyMCE.execCommand('mceAddEditor', false, "autors_site_" + nuw_field_num + "_text")
                quicktags({ id: "autors_site_" + nuw_field_num + "_text" })
            }
        });
    }

    // Функция удаления автора
    $removeAutor.on('click', removeAutor)

    function removeAutor(e) {
        $(this).closest('.autor_section').remove()
    }

})()