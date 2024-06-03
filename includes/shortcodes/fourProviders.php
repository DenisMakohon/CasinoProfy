<?php // Шорткод для вывода провайдеров
function fourProviders($atts)
{
    if (!is_admin()) {

        $atts = shortcode_atts(
            array(
                'id' => 'null',
            ),
            $atts
        );
        
        $no_whitespaces_ids = preg_replace('/\s*,\s*/', ',', filter_var($atts['id']));
        $ids_array = explode(',', $no_whitespaces_ids);

        ob_start(); ?>

        <section class="container game fourProviders">
            <div class="row fourProviders__row">

                <?php
                foreach ($ids_array as $value) {

                    $providers_id = $value;

                    $lang_settings = get_option('lang');
                    if ($lang_settings === false) $lang_settings = array('html' => 'en', 'hreflang' => 'en', 'hreflang_title' => '');

                    ?>

                    <div class="fourProviders__wrap col-lg-3">
                        <a href="<?php echo get_permalink($value); ?>" target="_blank">
                            <div class="fourProviders__col">
                                <img src="<?= get_the_post_thumbnail_url($value, 'large') ?>"
                                     class="fourProviders__provider_img" alt="provider logo" width="266" height="266">
                            </div>
                            <div class="text-center">
                                <a class="btn btn-js" rel="nofollow"
                                   href="<?php echo get_permalink($value); ?>"
                                   target="_blank"><span
                                            class="class4-<?= $lang_settings['html'] ?>"><?= $GLOBALS['translations_page']['read_more']; ?></span></a>
                            </div>
                        </a>
                    </div>

                <?php } ?>

            </div>
        </section>

        <?php
        $content = ob_get_clean();
        return $content;
    }
}

add_shortcode('four-providers-payment', 'fourProviders');                     // Шорткод для вывода провайдеров