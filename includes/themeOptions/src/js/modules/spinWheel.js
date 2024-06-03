import jQuery from 'jquery';
window.jQuery = window.$ = jQuery;
import Coloris from "@melloware/coloris";
Coloris.init();

export default (() => {
    $('body').on('click', '.js-removeSpinWheelItem', function() { $(this).closest('.js-spinWheelItem').remove() })

    $('.js-addSpinWheelItem').on('click', () => {
        let $tmp = $('.js-spinWheelItem').last(),
            spin_num = $('.js-spinWheelItem').length ? parseInt($tmp.attr('data-spinNum')) + 1 : 0

        $.ajax({
            type: 'GET',
            url: ajaxurl,
            data: {
                action: 'add_spinWheel_fields',
                spin_num: spin_num
            },
            success: function(response) {
                console.log({
                    action: 'add_spinWheel_fields',
                    spin_num: spin_num
                })
                $('.js-spinWheelContainer').append(response)
                Coloris({ el: '.coloris' })
            }
        });

        Coloris({ el: '.coloris' })
    })

})()