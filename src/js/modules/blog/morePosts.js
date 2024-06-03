import jQuery from 'jquery';
window.jQuery = window.$ = jQuery;

export default (function() {
    let clickCount = -1
    $('.js-morePosts').click(e => {
        let curBtn = $(e.currentTarget)
        clickCount++

        $.ajax({
            type: 'get',
            url: '/wp-admin/admin-ajax.php',
            data: {
                action: 'ajax_posts_function',
                offset: 12 + 6 * clickCount,
                curBlog: window.curBlog,
                curLang: window.curLang
                    // search: t
            },

            // what happens on success
            success: function(result) {
                let requestObg = JSON.parse(result)
                curBtn.closest('div').before(requestObg.posts)
                if (requestObg.btnHide) curBtn.closest('div').hide(0)
            }

        });
    })
})()