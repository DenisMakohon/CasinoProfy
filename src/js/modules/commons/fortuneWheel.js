import jQuery from 'jquery'
window.jQuery = window.$ = jQuery
import { Wheel } from '@modules/libs/spin-wheel-esm';
import * as easing from '@modules/libs/easing';

export default (function() {
    const userAgent = navigator.userAgent.toLowerCase(),
        // Расширяем проверку для включения других известных ботов
        isBot = userAgent.includes("googlebot") || userAgent.includes("pagespeed")

    // 1. Настройка свойств колеса
    if (($(window).width() < 768 && !sessionStorage.getItem('popupShown')) && !isBot) {
        // if (true) {
        // Если новая сессия и мобильный экран, то запускаем колесо фортуны
        document.addEventListener("DOMContentLoaded", () => {
            setTimeout(() => {

                $.ajax({
                    type: 'get',
                    url: window.ajaxurl,
                    data: {
                        action: 'spin_wheel',
                    },
                    success: function(result) {
                        if (result) {
                            sessionStorage.setItem('popupShown', 'true');
                            console.log(result)
                            result = JSON.parse(result)

                            $('body').append(result.html)

                            // Конфигурация колеса фортуны
                            const props = {
                                items: result.spin_settings.items,
                                itemBackgroundColors: result.spin_settings.itemBackgroundColors,
                                itemLabelRadius: 0.65,
                                itemLabelColors: result.spin_settings.itemLabelColors,
                                itemLabelFontSizeMax: parseInt(result.spin_settings.itemLabelFontSizeMax),
                                itemLabelFont: 'Josefin Sans',
                                rotationResistance: 0,
                                itemLabelAlign: 'center',
                                itemLabelRotation: 90,
                                rotationSpeedMax: 1000,
                                rotationSpeed: 1,
                                radius: 1,
                                borderWidth: 3,
                                borderColor: '#282828',
                                isInteractive: false,
                                lineWidth: parseInt(result.spin_settings.lineWidth)
                            }

                            const container = document.querySelector('.wheel-container'),
                                wheel = new Wheel(container, props),
                                winningItemIndex = parseInt(result.spin_settings.winner),
                                duration = parseInt(result.spin_settings.duration),
                                easingFunction = easing.cubicOut,
                                $spinWheel = $('.js-spinWheel'),
                                $spinWheelBanner = $('.js-spinWheelBanner'),
                                $spinWheelOverlay = $('.js-spinWheelOverlay'),
                                $wheelClose = $('.js-wheelClose')

                            // Крутим колесо до нужного итема
                            wheel.spinToItem(winningItemIndex, duration, true, 5, 1, easingFunction);

                            // Прячем колесо, показываем баннер
                            function showBanner() {
                                $spinWheel.addClass('hide')
                                $spinWheelBanner.removeClass('hide')
                            }

                            // Прячем баннер и в первом параграфе оставляем 4 строки  
                            function hideBannerAndShowContent() {
                                $spinWheelBanner.addClass('hide')
                                $spinWheelOverlay.addClass('hide')

                                $(".mainContent section").first().before($spinWheelBanner.html())

                            }

                            let show_banner = setTimeout(showBanner, duration), // Прячес колесо, показываес баннер
                                show_banner_inner = setTimeout(hideBannerAndShowContent, duration * 2)

                            $spinWheel.on('click', e => {
                                if (!$(e.target).hasClass('js-wheelClose')) {
                                    window.open($(e.currentTarget).attr('data-ref'));
                                } else {
                                    clearTimeout(show_banner)
                                    clearTimeout(show_banner_inner)
                                    showBanner() // Вызываем немедленно, если это необходимо
                                    hideBannerAndShowContent() // Вы можете решить, нужно ли вызывать это немедленно
                                }
                            })
                        }
                    }
                })

            }, 50)
        })
    }

})()