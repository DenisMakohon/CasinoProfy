import jQuery from 'jquery';
window.jQuery = window.$ = jQuery;

export default (function() {
    let $get_redirectionsContainer = $('.js-get_redirectionsContainer'),
        $get_redirections = $('.js-get_redirections'),
        $walk = $('.js-walk')

    $get_redirections.on('click', function() {
        let $settingsItem = $(this).closest('.js-settingsItem').addClass('loader')
        $get_redirectionsContainer.html('')
        $.ajax({
            type: 'get',
            url: '/wp-admin/admin-ajax.php',
            data: {
                action: 'get_redirections',
                blog_id: window.blog_id
            },
            success: function(result) {
                $get_redirectionsContainer.html(result)
                $walk.removeClass('show')
                $settingsItem.removeClass('loader')
            }
        })
    })

})()