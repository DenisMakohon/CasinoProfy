import jQuery from 'jquery';
window.jQuery = window.$ = jQuery;
import Coloris from "@melloware/coloris";
Coloris.init();

export default (function() {
    let $addPlashka = $('.js-addPlashka'),
        $plashkaContainer = $('.js-plashkaContainer'),
        plashkaNum = $('[data-plashkanum]').last().attr('data-plashkanum')

    $addPlashka.on('click', function(e) {

        plashkaNum++
        $.ajax({
            type: 'GET',
            url: ajaxurl,
            data: {
                action: 'add_plashka_field',
                plashka_num: plashkaNum
            },
            success: function(response) {
                $plashkaContainer.append(response)
                Coloris({ el: '.coloris' })
            }
        });

    })

    $('body').on('click', '.js-removePlaska', function(e) {
        e.preventDefault();
        $(this).closest('.js-plashkaItem').remove()
    });

})();