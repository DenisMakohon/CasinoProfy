import jQuery from 'jquery';
window.jQuery = window.$ = jQuery;

export default (function() {
    // методы оплаты в хедере
    let $addFilterPayment = $('.js-addPaymentMethods')

    $addFilterPayment.on('click', function(e) {

        let paymentNum = $('[data-paymentMethodsNum]').length ? parseInt($('[data-paymentMethodsNum]').attr('data-paymentMethodsNum')) + 1 : 0

        $('[data-paymentMethodsNum]').attr('data-paymentMethodsNum', paymentNum)
        $.ajax({
            type: 'GET',
            url: ajaxurl,
            data: {
                action: 'payment_filter_id',
                paymentMethodsNum: paymentNum
            },
            success: function(response) {
                $('.js-payment_methods  .js-filter_item-container').last().after(response);
            }

        });

    })

    $('body').on('click', '.js-removePaymentMethods', function(e) {
        e.preventDefault();
        $(this).closest('.js-filter_item-container').remove()
    })

})();