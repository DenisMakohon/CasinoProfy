// Добавить новый баннер
var $ = jQuery;
$(document).ready(function() {

    var $addBanner = $('.js-addBanner'),
        $bannerContainer = $('.js-bannerContainer'),
        bannerTemplate = `<div class="banner-item js-bannerItem">
            <div class="banner-item-delete button button-primary red js-bannerItemDelete">Delete banner</div>  
            <input type="text" name="banner[#{number}][title]" value="title" required placeholder="Заголовок"/>
            <textarea name="banner[#{number}][content]" cols="30" rows="10" required placeholder="Контент">content</textarea>
            <input type="text" name="banner[#{number}][btn_text]" value="btn_text" required placeholder="Текст кнопки"/>
            <input type="text" name="banner[#{number}][btn_link]" value="btn_link" required placeholder="Ссылка кнопки"/>
            <input type="text" name="banner[#{number}][list]" value="" placeholder="Список под текстом, элементы списка разделяются вертикальной линией | "/>
            <input type="file" name="banner[#{number}][img]" accept="image/*" />
            <input type="hidden" name="banner[#{number}][img_src]" value="" />
        </div>`,
        $tabsSettingsList = $('.js-tabsSettingsList p'),
        $settingsItem = $('.settings-item')

    $addBanner.on("click", function() {
        var bannersCount = $('.js-bannerItem').length
        console.log(bannersCount);
        $(this).before(bannerTemplate.replaceAll('#{number}', bannersCount));
    })

    $bannerContainer.on("click", function(e) {
        if ($(e.target).attr('class') !== undefined && $(e.target).attr('class').indexOf('js-bannerItemDelete') != -1) {
            $(e.target).closest('.js-bannerItem').remove()
        }
    })

    var $addService = $('.js-addService'),
        $serviceContainer = $('.js-servicesContainer'),
        servicesTemplate = `<div class="services-item js-servicesItem">
            <div class="services-item-delete button button-primary red js-servicesItemDelete">Delete service</div>  
            <input type="text" name="services[#{number}][title]" required placeholder="Заголовок"/>
            <input type="text" name="services[#{number}][link]" required placeholder="Ссылка кнопки"/>
            <input type="file" name="services[#{number}][img]" accept="image/*" />
            <input type="hidden" name="services[#{number}][img_src]" value="" />
        </div>`

    $addService.on("click", function() {
        var servicesCount = $('.js-servicesItem').length
        $(this).before(servicesTemplate.replaceAll('#{number}', servicesCount));
    })
    $serviceContainer.on("click", function(e) {
        if ($(e.target).attr('class') !== undefined && $(e.target).attr('class').indexOf('js-servicesItemDelete') != -1) {
            $(e.target).closest('.js-servicesItem').remove()
        }
    })

    $tabsSettingsList.on("click", function() {
        $tabsSettingsList.removeClass('active')
        $(this).addClass('active')
        $settingsItem.removeClass('active')
        $('[data-settings=' + $(this).attr('data-tab') + ']').addClass('active')
    })


    // Загрузка картинок в медиатеку 
    /*
     * действие при нажатии на кнопку загрузки изображения
     * вы также можете привязать это действие к клику по самому изображению
     */
    $('.upload_image_button').click(function() {
        var send_attachment_bkp = wp.media.editor.send.attachment;
        var button = $(this);
        wp.media.editor.send.attachment = function(props, attachment) {
            $(button).parent().prev().attr('src', attachment.url)
            $(button).prev().val(attachment.id);
            wp.media.editor.send.attachment = send_attachment_bkp
        }
        wp.media.editor.open(button)
        return false
    });
    /*
     * удаляем значение произвольного поля
     * если быть точным, то мы просто удаляем value у input type="hidden"
     */
    $('.remove_image_button').click(function() {
        var r = confirm("Уверены?");
        if (r == true) {
            var src = $(this).parent().prev().attr('data-src');
            $(this).parent().prev().attr('src', src);
            $(this).prev().prev().val('')
        }
        return false
    });

    $('.upload_image_button').unbind()

    $('body').on('click', '.upload_image_button', function(e) {
        e.preventDefault();
        console.log()
        var $cur_btn = $(this);
        aw_uploader = wp.media({
                title: 'Custom image',
                button: {
                    text: 'Use this image'
                },
                multiple: false
            }).on('select', function() {
                var attachment = aw_uploader.state().get('selection').first().toJSON();
                $cur_btn.closest('label').find('img').attr('src', attachment.url)
                $cur_btn.closest('label').find('input[type="hidden"]').val(attachment.id)
            })
            .open();
    });

    var $addAutor = $('.js-addAutor')
    $addAutor.on('click', addAutor)

    function addAutor(e) {
        var $cur_btn = $(this)
        $addAutor = $('.js-addAutor')
        $removeAutor = $('.js-removeAutor')
        var nuw_field_num = $('[data-next]').last().attr('data-next')

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                action: 'add_autor_field',
                autor_num: nuw_field_num
            },
            success: function(response) {
                $cur_btn.closest('tbody').append(response)
                $removeAutor = $('.js-removeAutor')
                $addAutor = $('.js-addAutor')
                $addAutor.unbind('click').on('click', addAutor)
                $removeAutor.unbind('click').on('click', removeAutor)

                tinyMCE.execCommand('mceAddEditor', false, "autors_site_" + nuw_field_num + "_text")
                quicktags({ id: "autors_site_" + nuw_field_num + "_text" })
            },
            complete: function(response) {


            }

        });
    }

    var $removeAutor = $('.js-removeAutor')
    $removeAutor.on('click', removeAutor)

    function removeAutor(e) {
        var $cur_btn = $(this).closest('tr').remove()
    }

    //reviews clients

    var $addReview = $('.js-addReview')
    $addReview.on('click', addReview)

    function addReview(e) {
        var $cur_btn = $(this)
        $addReview = $('.js-addReview')
        $removeReview = $('.js-removeReview')
        var nuw_field_num = $('[data-next-review]').last().attr('data-next-review')

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                action: 'add_review_field',
                review_num: nuw_field_num
            },
            success: function(response) {
                $cur_btn.closest('tbody').append(response)
                $removeReview = $('.js-removeReview')
                $addReview = $('.js-addReview')
                $addReview.unbind('click').on('click', addReview)
                $removeReview.unbind('click').on('click', removeReview)

                tinyMCE.execCommand('mceAddEditor', false, "reviews_clients_" + nuw_field_num + "_text")
                quicktags({ id: "reviews_clients_" + nuw_field_num + "_text" })
            },
            complete: function(response) {


            }

        });
    }

    var $removeReview = $('.js-removeReview')
    $removeReview.on('click', removeReview)

    function removeReview(e) {
        var $cur_btn = $(this).closest('tr').remove()
    }

    var $filterSelect = $('.js-filterSelect'),
        $inputDropdown = $('.js-inputDropdown'),
        $inputDropdownContainer = $('.js-inputDropdownContainer'),
        $inputDropdownLi = $('.js-inputDropdown li'),
        $popupCasinoContainer = $('.js-popupCasinoContainer'),
        $activeList = ''

    $filterSelect.on('keyup', selectFilter)
    $filterSelect.on('click', getActiveList)
    $inputDropdownLi.on('click', setCasinoId)

    function selectFilter(e) {
        var cur_value = $(this).val()
        var $active_items = $activeList.filter(function(index, elem) {
            return $(elem).text().toLowerCase().indexOf(cur_value.toLowerCase()) !== -1;
        })
        $activeList.removeClass('show')
        $active_items.addClass('show')
    }

    function setCasinoId(e) {
        var id = $(this).attr('data-id'),
            title = $(this).text(),
            $sameCasinos = $(this).closest('.js-inputDropdownContainer').find('.js-popupCasinoContainer [value="' + id + '"]'),
            $curPopupCasinoContainer = $(this).closest('.js-inputDropdownContainer').find('.js-popupCasinoContainer'),
            option_name = $(this).closest('.js-inputDropdownContainer').attr('data-oplion')

        $('.js-popupCasinoItem').removeClass('same')
        $sameCasino = $(this).closest('.js-inputDropdownContainer').find('.js-sameCasino').removeClass('show')
        var nextCasino = 0
        if ($(this).closest('.js-inputDropdownContainer').find('[data-curcasino]').last().length) {
            console.log($(this).closest('.js-inputDropdownContainer').find('[data-curcasino]').last().attr('data-curcasino'))
            nextCasino = parseInt($(this).closest('.js-inputDropdownContainer').find('[data-curcasino]').last().attr('data-curcasino')) + 1
        }

        if (!$sameCasinos.length) {
            $curPopupCasinoContainer.append(
                "<div class='popup-casino js-popupCasinoItem'>" +
                "<span>" + title + "</span>" +
                "<span class='js-popupCasinoRemove popup-casino-remove'></span>" +
                "<input type='hidden' data-curcasino='" + nextCasino + "' value='" + id + "' name='" + option_name + "[" + nextCasino + "]' class='js-casinoId'/>" +
                "</div> "
            )
        } else {
            $sameCasinos.closest('.js-popupCasinoItem').addClass('same')
            $sameCasino.addClass('show')
        }

        $inputDropdown.removeClass('show')
        $filterSelect.keyup()
    }

    function getActiveList(e) {
        $inputDropdown.removeClass('show')
        $activeList = $(this).closest('.js-inputDropdownContainer').find('.js-inputDropdown').addClass('show').find('li')
        console.log($(this))
    }

    $popupCasinoContainer.on('click', '.js-popupCasinoRemove', function(e) {
        $(this).closest('.js-popupCasinoItem').remove()
    });

    $(document).mouseup(function(e) { // событие клика по веб-документу
        var div = $inputDropdownContainer; // тут указываем ID элемента
        if (!div.is(e.target) // если клик был не по нашему блоку
            &&
            div.has(e.target).length === 0) { // и не по его дочерним элементам
            div.find('.js-inputDropdown').removeClass('show'); // скрываем его
        }
    });

    // Выбор цвета
    Coloris({
        el: '.coloris'
    });

    var $addPlashka = $('.js-addPlashka'),
        $plashkaContainer = $('.js-plashkaContainer')

    $addPlashka.click(function(e) {
        // var plashkaNum = $('[data-plashkaNum]').length ? parseInt($('[data-plashkaNum]').last().attr('data-plashkaNum')) + 1 : 0
        var plashkaNum = 0;
        $.ajax({
            type: 'GET',
            url: ajaxurl,
            data: {
                action: 'plashka_id'
            },
            success: function(response) {
                console.log(response)
                plashkaNum = response;
                var newPlashka = "<div class='plashka-item' data-plashkaNum='" + plashkaNum + "'>" +
                    "<div class='plashka-item-part'>" +
                    "<p>Название</p>" +
                    "<input required type='text' value='' name='plashka[" + plashkaNum + "][name]' />" +
                    "</div>" +
                    "<div class='plashka-item-part'>" +
                    "<p>Цвет</p>" +
                    "<input type='text' value='#828282' name='plashka[" + plashkaNum + "][color]' class='coloris' />" +
                    "</div>" +
                    "<span class='button red js-removePlaska'>Удалить плашку</span>" +
                    "</div>";

                $plashkaContainer.append(newPlashka);

                Coloris({
                    el: '.coloris'
                });
            }

        });

    })

    $('body').on('click', '.js-removePlaska', function(e) {
        e.preventDefault();
        $(this).closest('.plashka-item').remove()
    });

    // методы оплаты в хедере
    var $addPayment = $('.js-addPayment'),
        $paymentContainer = $('.js-paymentContainer')

    $addPayment.click(function(e) {
        // var paymentNum = $('[data-paymentNum]').length ? parseInt($('[data-paymentNum]').last().attr('data-paymentNum')) + 1 : 0
        var paymentNum = $('[data-paymentNum]').length ? parseInt($('[data-paymentNum]').last().attr('data-paymentNum')) + 1 : 0

        // var paymentNum = 0;
        $.ajax({
            type: 'GET',
            url: ajaxurl,
            data: {
                action: 'payment_id'
            },
            success: function(response) {
                console.log(response)
                $('[data-paymentNum]').attr('data-paymentNum', response)
                var newPayment = "<div class='payment-item' data-paymentNum='" + paymentNum + "'>" +
                    "<div class='payment-item-part'>" +
                    "<p>Название</p>" +
                    "<input required type='text' value='' name='payment[" + paymentNum + "][name]' />" +
                    "</div>" +
                    "<div class='payment-item-part'>" +
                    "<p>Ссылка</p>" +
                    "<input required type='text' value='' name='payment[" + paymentNum + "][link]' />" +
                    "</div>" +
                    "<span class='button red js-addPayment'>Удалить метод</span>" +
                    "</div>";

                $paymentContainer.append(newPayment);

                Coloris({
                    el: '.coloris'
                });
            }

        });

    })

    $('body').on('click', '.js-removePayment', function(e) {
        e.preventDefault();
        $(this).closest('.payment-item').remove()
    });

    var $get_redirectionsContainer = $('.js-get_redirectionsContainer'),
        $get_redirections = $('.js-get_redirections'),
        $walk = $('.js-walk')

    $get_redirections.on('click', function() {
        $walk.addClass('show')
        $get_redirectionsContainer.html('')
        $.ajax({
            type: 'get',
            url: '/wp-admin/admin-ajax.php',
            data: {
                action: 'get_redirections',
                blog_id: window.blog_id
            },
            success: function(result) {
                $get_redirectionsContainer.html(result)
                $walk.removeClass('show')
            }
        })
    })

    // методы оплаты в хедере
    var $addFilterPayment = $('.js-addPaymentMethods')

    $addFilterPayment.click(function(e) {
        var paymentNum = $('[data-paymentMethodsNum]').length ? parseInt($('[data-paymentMethodsNum]').attr('data-paymentMethodsNum')) + 1 : 0
        $('[data-paymentMethodsNum]').attr('data-paymentMethodsNum', paymentNum)
        $.ajax({
            type: 'GET',
            url: ajaxurl,
            data: {
                action: 'payment_filter_id',
                paymentMethodsNum: paymentNum
            },
            success: function(response) {
                console.log(response)

                $('.js-payment_methods .js-filter_item-container').last().after(response);
            }

        });

    })

    $('body').on('click', '.js-removePaymentMethods', function(e) {
        e.preventDefault();
        $(this).closest('.js-filter_item-container').remove()
    })

    let $customSlugs = $('.js-customSlugs'),
        $addCustomSlugs = $('.js-addCustomSlugs')

    // Слаг
    $customSlugs.on('keyup', '.js-slugFiled', function(e) {
        let $row_input = $(e.currentTarget),
            $row_input_val = $row_input.closest('.js-customTranslationsRow').find('.js-slugFiledHidden')

        $row_input_val.attr('name', 'translations_site[custom_slugs][' + $row_input.val() + ']')

    })

    // Присваиваем перевод к слагу
    $customSlugs.on('keyup', '.js-translationsFiled', function(e) {
        let $row_input = $(e.currentTarget),
            $row_input_bh = $row_input.closest('.js-customTranslationsRow').find('.js-slugFiledHidden')

        $row_input_bh.val($row_input.val())

    })

    // Add row from associate fields
    $addCustomSlugs.on('click', function(e) {
        let $curBtn = $(e.currentTarget),
            new_row = "<div class='custom-translations js-customTranslationsRow'>" +
            "<label>" +
            "Слаг" +
            "<input type='text' class='js-slugFiled' value=''>" +
            "<input class='js-slugFiledHidden' type='hidden' name='' value=''>" +
            "</label>" +
            "<label>" +
            "Перевод" +
            "<input type='text' class='js-translationsFiled' value=''>" +
            "</label>" +
            "<div class='removeRow js-removeRow'>x</div>" +
            "</div>"

        $(new_row).insertBefore($curBtn);
        // curBtn.closest('.input-container').before(new_row)
    })

    // Remove row from associate fields

    $customSlugs.on('click', '.js-removeRow', function(e) {
        var $cur_elem = $(e.currentTarget)

        $cur_elem.closest('.js-customTranslationsRow').remove()

    })

    $('#csv_upload_form').on('submit', function(e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: ajaxurl, // В WordPress это глобальная переменная для обработчика AJAX
            type: 'POST',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                $('#upload_response').html(response);
            },
            error: function() {
                $('#upload_response').html('Ошибка при загрузке файла.');
            }
        });
    });


    $('#csv_alternates_upload_form').on('submit', function(e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: ajaxurl, // В WordPress это глобальная переменная для обработчика AJAX
            type: 'POST',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                $('#alternates_response').html(response);
            },
            error: function() {
                $('#alternates_response').html('Ошибка при загрузке файла.');
            }
        });
    });

    $('body').on('click', '.js-removeSpinWheelItem', function(e) {
        $(this).closest('.js-spinWheelItem').remove()
    })

    $('.js-addSpinWheelItem').on('click', function(e) {
        var $tmp = $('.js-spinWheelItem').last()

        var num = $('.js-spinWheelItem').length ? parseInt($tmp.attr('data-spinNum')) + 1 : 0;

        var new_item = "<div class='spin_wheel-item js-spinWheelItem' data-spinNum='" + num + "'>" +
            "<label>" +
            "<p>Значение</p>" +
            "<input type='text' required value='' name='items[" + num + "][label]' />" +
            "</label>" +
            "<label>" +
            "<p>Цвет фона</p>" +
            "<input type='text' required value='' name='itemBackgroundColors[" + num + "]'class='coloris' />" +
            "</label>" +
            "<label>" +
            "<p>Цвет текста</p>" +
            "<input type='text' required value='' name='itemLabelColors[" + num + "]' class='coloris' />" +
            "</label>" +
            "<label>" +
            "<p>Выигрышный вариант</p>" +
            "<input type='radio' value='" + num + "' name='winner' />" +
            "</label>" +
            "<div class='spin_wheel-item-remove'><span class='button red js-removeSpinWheelItem'>Удалить</span></div>" +
            "</div>"

        $('.js-spinWheelContainer').append(new_item)
        Coloris({
            el: '.coloris'
        });
    })

    $serviceContainer.on("click", function(e) {
        if ($(e.target).attr('class') !== undefined && $(e.target).attr('class').indexOf('js-servicesItemDelete') != -1) {
            $(e.target).closest('.js-servicesItem').remove()
        }
    })
});