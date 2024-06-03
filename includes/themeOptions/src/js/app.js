import jQuery from 'jquery';
window.jQuery = window.$ = jQuery;
import imageUploader from '@modules/imageUploader.js';
import Coloris from "@melloware/coloris";
import inputDropdown from "@modules/inputDropdown";
import autors from "@modules/autors";
import plashka from "@modules/plashka";
import tabs from "@modules/tabs";
import fiilter from "@modules/fiilter";
import headerPayment from "@modules/headerPayment";
import review from "@modules/review";
import spinWheel from "@modules/spinWheel";
import redirections from "@modules/redirections";
import comments_upload from "@modules/comments_upload";
import alternates from "@modules/alternates";
import '@modules/inputFile';
import '@modules/ajaxSend';

// Когда DOM полностью загружен
$(function() {
    imageUploader.init()
        // Выбор цвета
    Coloris.init();
    Coloris({ el: '.coloris' })
});