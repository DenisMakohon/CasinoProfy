import jQuery from 'jquery';
window.jQuery = window.$ = jQuery;
import noUiSlider from 'nouislider';

let sliders = document.querySelectorAll('.slider'),
    currency = $('[data-currency]').attr('data-currency')

if (sliders.length) {

    sliders.forEach(function(slider, index) {
        let $container = $(slider).closest('.js-sliderContainer'),
            min = parseInt($('.js-sliderContainer').attr('data-min')),
            max = parseInt($('.js-sliderContainer').attr('data-max')),
            start = $container.find('.formatting-start'),
            end = $container.find('.formatting-end'),
            formatForSlider = {
                from: function(formattedValue) {
                    return currency + " " + Number(formattedValue.toFixed(0));
                },
                to: function(numericValue) {
                    return currency + " " + Math.round(numericValue.toFixed(0));
                }
            };

        noUiSlider.create(slider, {
            start: [min, max],
            range: {
                'min': min,
                'max': max
            },
            connect: true,
            // format: formatForSlider,
            tooltips: {
                // tooltips are output only, so only a "to" is needed
                to: function(numericValue) {
                    return currency + " " + numericValue.toFixed(0)
                }
            },
        });

        // Values are parsed as numbers using the "from" function in "format"
        slider.noUiSlider.set([min, max])

        let formatValues = [
            start[0],
            end[0]
        ];

        $.merge(start, end).on('change', e => {
            let $curInput = $(e.currentTarget),
                start_val = $curInput.closest('.js-sliderContainer').find('.formatting-start').val(),
                end_val = $curInput.closest('.js-sliderContainer').find('.formatting-end').val()

            slider.noUiSlider.set([start_val, end_val])

        })

        slider.noUiSlider.on('update', function(values, handle, unencoded) {
            // "values" has the "to" function from "format" applied
            // "unencoded" contains the raw numerical slider values
            formatValues[handle].value = Math.round(values[handle]);
        });

    })
}