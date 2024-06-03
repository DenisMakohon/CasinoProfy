import jQuery from 'jquery';
window.jQuery = window.$ = jQuery;

export default (function() {

    const $response = $('.js-response')

    $('.js-settingsForm').on('submit', function(e) {
        e.preventDefault();

        let formData = new FormData(this),
            $settingsItem = $(this).closest('.js-settingsItem')

        $response.removeClass('show')

        // Добавление action и nonce
        formData.set('action', $(this).attr('data-action')); // Соответствует add_action wp_ajax_...
        formData.set('nonce', $('#_wpnonce').val()); // Существующий nonce из формы

        $settingsItem.addClass('loader')

        $.ajax({
            url: ajaxurl, // Это должно быть определено в админке WordPress
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: (response) => {
                if (response.success) {
                    $response.html('Налаштування збережено успішно!')
                } else {
                    $response.addClass('error').html('Помилка: ' + response.data)
                }
            },
            error: (response) => {
                $response.addClass('error').html('Помилка збереження налаштувань.')
            },
            complete: (response) => {
                $response.addClass('show')
                setTimeout(() => {
                    $response.removeClass('show error')
                }, 5000)
                $settingsItem.removeClass('loader')
            }
        })
    })
})()