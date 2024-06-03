// CommonJS

import navigation from '@modules/navigation.js'; // Работа навигации
import popupCasinos from '@sliders/popupCasinos.js'; // Слайдер предлагаемых казино
import popupUKDemo from '@sliders/popupUKDemo.js'; // Слайдер предлагаемых казино на демке UK
import tableOfContents from '@commons/tableOfContents.js'; // Table Of Content
import btnAnimation from '@commons/btnAnimation.js'; // "Волна" на кнопках при клике
import ajaxSearch from '@commons/ajaxSearch.js'; // "Волна" на кнопках при клике
import rating from '@commons/rating.js'; // "Волна" на кнопках при клике
import casinoOfTheMonth from '@commons/casinoOfTheMonth.js'; // скрипты для casino of the month
import * as hide from "@commons/hideFirstP.js";

import popupCookie from '@commons/popupCookie.js'; // Попап про куки
import fuckrussia from '@commons/fuckrussia.js'; // Попап для доната в пользу ребят ЗСУ
import slider from '@commons/slider.js'; // Range slider
import bonusSlider from '@sliders/bonusSlider.js'; // Слайдер game-features
import moreInfo from '@modules/casino/moreInfo.js'; // Открыть/закрыть характеристики казино
import * as webp from '@commons/isWebp.js'; // Проверка поддерживает браузер WebP или нет
import fortuneWheel from '@commons/fortuneWheel.js'; // Проверка поддерживает браузер WebP или нет
hide.hideFirstP()
webp.isWebp()
    // loadGTMWithDelay(5000);
    // CommonJS