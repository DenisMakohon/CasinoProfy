import jQuery from 'jquery';
window.jQuery = window.$ = jQuery

export default (function() {

    function getAverageRGB(imgEl) {

        var blockSize = 5, // only visit every 5 pixels
            defaultRGB = { r: 0, g: 0, b: 0 }, // for non-supporting envs
            canvas = document.createElement('canvas'),
            context = canvas.getContext && canvas.getContext('2d'),
            data, width, height,
            i = -4,
            length,
            rgb = { r: 0, g: 0, b: 0 },
            count = 0;

        if (!context) {
            return defaultRGB;
        }

        height = canvas.height = imgEl.naturalHeight || imgEl.offsetHeight || imgEl.height;
        width = canvas.width = imgEl.naturalWidth || imgEl.offsetWidth || imgEl.width;

        try {
            context.drawImage(imgEl, 0, 0);
            data = context.getImageData(0, 0, width, height);
        } catch (e) {
            /* security error, img on diff domain */
            return defaultRGB;
        }

        length = data.data.length;

        while ((i += blockSize * 4) < length) {
            ++count;
            rgb.r += data.data[i];
            rgb.g += data.data[i + 1];
            rgb.b += data.data[i + 2];
        }

        // ~~ used to floor values
        rgb.r = ~~(rgb.r / count);
        rgb.g = ~~(rgb.g / count);
        rgb.b = ~~(rgb.b / count);

        return rgb;

    }

    let $imgs = $('img.js-imageShadow')

    $imgs.on("load", function() {
        $imgs.each(function() {
            if (!$(this).hasClass('lazyload') && !$(this).hasClass('shadowOk')) {
                let bs = getAverageRGB(this)
                $(this).css({
                    'box-shadow': '0px 20px 30px rgba(' + bs.r + ',' + bs.g + ',' + bs.b + ', .5)'
                }).addClass('shadowOk')
            }
        })
    })

    $('img.imageShadow').each(function() {
        $(this).on('load', function() {
            if (!$(this).hasClass('lazyload') && !$(this).hasClass('shadowOk')) {
                let bs = getAverageRGB(this)
                $(this).css({
                    'box-shadow': '0px 20px 30px rgba(' + bs.r + ',' + bs.g + ',' + bs.b + ', .5)'
                }).addClass('shadowOk')
            }
        });
    });


})()