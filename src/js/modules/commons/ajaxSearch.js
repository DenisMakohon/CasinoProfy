import jQuery from 'jquery';
window.jQuery = window.$ = jQuery;

export default (function() {
    let thread = '';
    const $submitBtn = $('.js-ajax-search'),
        $searchField = $('input[type="search"]');

    $searchField.keyup(function(e) {
        // clear our timeout variable - to start the timer again

        clearTimeout(thread);

        // set a variable to reference our current element ajax-search
        let $this = $(this);

        // set a timeout to wait for a second before running the dosearch function
        thread = setTimeout(
            function() {
                if ($this.val().length >= 1) dosearch($this.val());
            },
            200
        );
    });

    $submitBtn.on('click', (e) => {
        e.preventDefault()
        $searchField.keyup()
        return false;
    })

    function dosearch(t) {

        // do the ajax request for job search
        $.ajax({

            type: 'post',
            url: '/casinoprofy/wp-admin/admin-ajax.php',
            data: {
                action: 'ajax_search',
                search: t,
                curBlog: window.curBlog,
                curLang: window.curLang,
            },

            // what happens on success
            success: function(result) {
                $('.js-searchResults').html(result);
            }

        });

    }
})()