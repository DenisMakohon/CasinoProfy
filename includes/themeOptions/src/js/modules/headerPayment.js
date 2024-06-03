import jQuery from 'jquery';
window.jQuery = window.$ = jQuery;

export default (function() {
    // методы оплаты в хедере
    const $addPayment = $('.js-addPayment'),
        $paymentContainer = $('.js-paymentContainer')

    $addPayment.on('click', () => {

        let paymentNum = $('[data-paymentNum]').length ? parseInt($('[data-paymentNum]').last().attr('data-paymentNum')) + 1 : 0

        $('[data-paymentNum]').attr('data-paymentNum', paymentNum)

        $.ajax({
            type: 'GET',
            url: ajaxurl,
            data: {
                action: 'payment_id',
                paymentNum: paymentNum
            },
            success: (response) => {
                $paymentContainer.append(response);
            }
        });
    })

    $('body').on('click', '.js-removePayment', (e) => {
        e.preventDefault();
        $(e.currentTarget).closest('.payment-item').remove()
    });
})();