import jQuery from 'jquery'
window.jQuery = window.$ = jQuery

const $inputFile = $('.js-inputFile input[type="file"]')

$inputFile.on('change', e => {
    let $curInput = $(e.currentTarget),
        filePath = $curInput.val(),
        fileName = filePath.replace(/^.*[\\\/]/, '')

    $curInput.closest('.js-inputFile').find('.js-inputFileName').text(fileName)
})

$inputFile.change()