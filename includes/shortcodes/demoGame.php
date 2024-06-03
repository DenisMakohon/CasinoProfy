<?php // Шорткод для вывода демо игры в слоте на странице

function demoGame($atts)
{
    if (!is_admin()) {

        $atts = shortcode_atts(
            array(
                'slot_id' => 'null',
            ),
            $atts
        );

        $slot_id = $atts['slot_id'];

        $pageSettings = get_fields($slot_id);

        $lang_settings = get_option('lang');
        if ($lang_settings === false) $lang_settings = array('html' => 'en', 'hreflang' => 'en', 'hreflang_title' => '');
        ob_start();
        ?>
        <section class="container game demoGame">
            <div class="row">
                <div class="col-lg-12 iframe">
                    <div class="iframe-container js-iframeContainer">
                        <div class="iframeContainerPopup js-iframeContainerPopup">
                            <?php if(get_blog_details()->path == "/en/"){ ?>
                                <div class="popup js-popupUkDemo popup-ukdemo text-center">
                                    <p class="heading-4">Playing from the UK? <br> Please confirm your age to continue with the demo game</p>
                                    <p class="mainText">OnlineCasinoProfy & the UKGC are committed to preventing underage gambling.</p>
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="btn btn-green js-popupUkDemo-ok">Yes, I'm 18 years or older</div>
                                        <div class="btn js-popupUkDemo-close">No, take me back</div>
                                    </div>
                                </div>
                                <div class="overlay"></div>
                            <?php } ?>	
                            <div style="background-image: url(<?= $pageSettings['game_iframe']['image'] ?>);"
                                 class="iframe-overlay"></div>
                            <iframe src="" frameborder="0"></iframe>
                            <img src="<?= IMG_URL ?>games/startGame.svg" class="startGameImg js-startIframe"
                                 data-iframe="<?= $pageSettings['game_iframe']['src'] ?>"
                                 alt="start the game button" width="166" height="166">
                            <div class="js-iframeFullScreenButtons iframeFullScreen">
                                <img class="js-iframeFullScreen" src="<?= IMG_URL ?>fullscreen.svg" width="20"
                                     height="20" alt="iframeFullScreen">
                                <img class="js-iframeLowScreen" src="<?= IMG_URL ?>lowscreen.svg" width="20"
                                     height="20" alt="iframeLowScreen">
                            </div>
                        </div>
                    </div>
                    <div class="iframe-start text-center">
                        <a class="btn btn-js" rel="nofollow"
                           href="<?php echo !empty($pageSettings['ref_link']) ? $pageSettings['ref_link'] : home_url() . '/goto/casino/'; ?>"
                           target="_blank"><span
                                class="class4-<?= $lang_settings['html'] ?>"><?= $GLOBALS['translations_page']['play_btn'] ?></span></a>
                    </div>
                </div>
            </div>
        </section>
        <?php
        $content = ob_get_clean();
        return $content;
    }
}

add_shortcode('demo-game', 'demoGame');                     // Шорткод для вывода игры