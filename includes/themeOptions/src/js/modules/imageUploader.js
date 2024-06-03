import jQuery from 'jquery';
window.jQuery = window.$ = jQuery;

const imageUploader = (() => {
    const attachImageUploadEvent = () => {
        $('body').on('click', '.upload_image_button', function(e) {
            e.preventDefault();
            const $cur_btn = $(this);
            const uploader = wp.media({
                title: 'Custom image',
                button: {
                    text: 'Use this image'
                },
                multiple: false
            }).on('select', function() {
                const attachment = uploader.state().get('selection').first().toJSON();
                $cur_btn.closest('label').find('img').attr('src', attachment.url);
                $cur_btn.closest('label').find('input[type="hidden"]').val(attachment.id);
            });
            uploader.open();
        });
    };

    const attachImageRemoveEvent = () => {
        $('body').on('click', '.remove_image_button', function(e) {
            e.preventDefault();
            if (confirm("Уверены?")) {
                const $prevImg = $(this).parent().prev();
                const src = $prevImg.attr('data-src');
                $prevImg.attr('src', src);
                $(this).prev().prev().val('');
            }
        });
    };

    const init = () => {
        attachImageUploadEvent();
        attachImageRemoveEvent();
    };

    return {
        init
    };
})();

export default imageUploader;