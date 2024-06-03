import jQuery from 'jquery';
window.jQuery = window.$ = jQuery;

export default (function() {
    $('#csv_upload_form').on('submit', function(e) {
        e.preventDefault()

        let formData = new FormData(this)

        $.ajax({
            url: ajaxurl, // В WordPress это глобальная переменная для обработчика AJAX
            type: 'POST',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                $('#upload_response').html(response);
            },
            error: function() {
                $('#upload_response').html('Ошибка при загрузке файла.')
            }
        })
    })

})()