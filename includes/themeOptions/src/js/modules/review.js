import jQuery from 'jquery';
window.jQuery = window.$ = jQuery;

export default (function() {
    //reviews clients

    let $addReview = $('.js-addReview')
    $addReview.on('click', addReview)

    function addReview(e) {
        let $cur_btn = $(this)
        $addReview = $('.js-addReview')
        $removeReview = $('.js-removeReview')

        let nuw_field_num = $('[data-next-review]').last().attr('data-next-review')

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                action: 'add_review_field',
                review_num: nuw_field_num
            },
            success: function(response) {
                $cur_btn.closest('.reviews_clients_section').after(response)
                $removeReview = $('.js-removeReview')
                $addReview = $('.js-addReview')
                $addReview.off('click').on('click', addReview)
                $removeReview.off('click').on('click', removeReview)

                tinyMCE.execCommand('mceAddEditor', false, "reviews_clients_" + nuw_field_num + "_review")
                quicktags({ id: "reviews_clients_" + nuw_field_num + "_review" })
            }
        });
    }

    let $removeReview = $('.js-removeReview')
    $removeReview.on('click', removeReview)

    function removeReview(e) {
        $(this).closest('.reviews_clients_section').remove()
    }

})();