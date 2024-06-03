import jQuery from 'jquery';
window.jQuery = window.$ = jQuery;

export default (function() {

    $('body').on('click', '.js-showAllCasinos', e => {
        let curBtn = $(e.currentTarget),
            rows = curBtn.closest('.topCasino-content').find('.topCasino-row.hidden'),
            per_page = 10

        rows.each(function(i, row) {
            if (i < per_page) $(row).removeClass('hidden')
        })

        if (rows.length <= per_page) curBtn.hide(0)

        if (curBtn.closest('.topGames').length) {
            curBtn.closest('.topGames').find('.hidden').removeClass('hidden')
            curBtn.hide(0)
        }
    })


    $('body').on('click', '.js-topCasinoPaymentMethodsMore', e => {
        let $curPaymentMethods = $(e.currentTarget),
            $methodsPaymentMethods = $curPaymentMethods.find('.topCasino-payment_methods-hidden')

        $methodsPaymentMethods.toggleClass('hidden')
        $curPaymentMethods.toggleClass('hidden')

    })

})()