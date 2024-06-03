<?php // Шорткод для вывода казино на странице бонусов 
function topTenCasinosBonus() {
    if (!is_admin()):

        $args_array = func_get_args();
        $cacheKey = generate_cache_key('topTenCasinosBonus', $args_array);  // Генерируем уникальный ключ кэша с указанием шорткода
        add_cache_key('topTenCasinosBonus', $cacheKey);                     // Добавляем ключ к общему списку для соответствующего шорткода
        $cached = get_transient($cacheKey);
    
        if (false !== $cached) {
            return $cached;  // Если данные в кэше найдены, возвращаем их
        }
        global $post, $targetBonus;
        $local_currency = get_option('currency');
        $lang_settings = get_option('lang');
        if ($lang_settings === false) $lang_settings = array('html' => 'en', 'hreflang' => 'en', 'hreflang_title' => '');

        $plashka_casino = get_option('plashka');

        $GLOBALS['targetBonus'] = get_field('bonus_on_top', $post->ID)['value'];

        $page_template = array( // условие для шаблона страницы
            'key'   => '_wp_page_template',
            'value' => 'casinos.php',
            'compare' => '=',
            [
                'relation' => 'OR',
                [
                    'key'     => 'is_child',
                    'compare' => '!=',
                    'value'   => '1'  // Считаем, что '1' это "Да"
                ],
                [
                    'key'     => 'is_child',
                    'compare' => 'NOT EXISTS'
                ]
            ]
        );

        if(!empty($args_array[0]['id'])){
            $ids = $args_array[0]['id'];

            $casinos_args = array(
                'post_type' => 'page',
                'orderby' => 'post__in',
                'post__in'  => explode(',', $ids)
            );
        } else if (!empty($args_array[0]['provider'])) {
            $casinos_args = array(
                'date_format' => get_option('date_format'),
                'meta_key' => 'rating',
                'orderby' => 'meta_value_num',
                'post_type' => 'page',
                'post_status' => array('publish'),
                'posts_per_page' => -1,
                'order' => 'DESC',
                'meta_query' => array(
                    array(
                        'relation' => 'OR',
                        array(
                            'key' => 'bonus_block_$_bonus_type',
                            'value' => $targetBonus,
                            'compare' => 'LIKE',
                        )
                    )
                )
            );
        } else {
            $casinos_args = array(
                'date_format' => get_option('date_format'),
                'meta_key' => 'rating',
                'orderby' => 'meta_value_num',
                'post_type' => 'page',
                'post_status' => array('publish'),
                'order' => 'DESC'
            );
            $casinos_args['relation'] = 'AND';
        }

        $casinos_args['posts_per_page'] = '-1'; // всегда выводим все казино за 1 запрос

        if(!isset($casinos_args['meta_query'])){
            $casinos_args['meta_query'] = $page_template;
        }else{
            array_push($casinos_args['meta_query'], array(
                'relation' => 'AND',  // Соответствует всем условиям
                $page_template
            ));
        }

        $casinos = new WP_Query($casinos_args);

        $args_array = func_get_args();

        $title = !empty($args_array[0]['title']) ? $args_array[0]['title'] : '';

        $out = '<section class="container extendTitle">
                <div class="row">';
        $titleHTML = '';

        if ($title != '' && $GLOBALS['content_hide'] != true) $titleHTML .= '<h2 class="d-flex align-items-center extendTitle-title" data-anchor="' . $title . '">
                                <span>' . $title . '</span>
                            </h2>';
                            
        $out .= '<div class="col-12 d-flex align-items-center extendTitle-title">
                ' . $titleHTML . '
                <div class="extendTitle-content"><span class="extendTitle-content-title update">' . $GLOBALS['translations_page']['updated'] . ':</span> ' . get_the_modified_date('d M Y') . '</div>
            </div>
            <div class="col-lg-12 topCasinoBonus">
                <div class="topCasino text-center">
                    <div class="topCasino-header topCasino-row-container d-lg-flex d-none align-items-center">
                        <p></p>
                        <p>'.$GLOBALS['translations_page']['name'].'</p>
                        <p>'.$GLOBALS['translations_page']['bonus'].'</p>
                        <p>'.$GLOBALS['translations_page']['deposit'].'</p>
                        <p>'.$GLOBALS['translations_page']['payment'].'</p>
                        <p>'.$GLOBALS['translations_page']['review'].'</p>
                    </div>
                    <div class="topCasino-content">';

        $casinos_count = 0;

        foreach ($casinos->posts as $post) {
            $casinos_count++;
            $hidenClass = '';
            $post_fields = get_fields($post->ID);

            if ($casinos_count > 10) $hidenClass = ' hidden';

            // минимальный депозит
            $min_deposit = '-';
                        
            if($post_fields['min_deposit'] && trim($post_fields['min_deposit']['text']) != ''){
                if(isset($post_fields['currency']) && !empty($post_fields['currency'])) $local_currency = $post_fields['currency'];
                $min_deposit = $local_currency.$post_fields['min_deposit']['text'];
            }
            // Формируем бонус

            $bonuses = $post_fields['bonus_block'];

            $target_bonus = !empty($args_array[0]['bonus_type']) ? $args_array[0]['bonus_type'] : "welcome_bonus";
    
            $outBonus = get_bonus($target_bonus, $bonuses);

            $block_casino_info = block_casino(get_fields($post->ID));

            // END Формируем бонус
            // методы оплат
            $payment_methods = '<div class="topCasino-payment_methods-list">';

            if($post_fields['payment_methods']){
                foreach($post_fields['payment_methods'] as $num => $payment_method){
                    if(
                        isset($payment_method['link']) && 
                        $payment_method['link'] == "yes" && 
                        isset($payment_method['inner_link']) && 
                        !empty($payment_method['inner_link'])
                    ){
                        $inner_link_info = get_tech_link($payment_method['inner_link']);

                        if($num < 6) $payment_methods .= '<div class="text-center topCasino-payment_methods-item d-inline-block" ><img src="'.$inner_link_info['img'].'" class="d-inline-block" alt="'.$inner_link_info['title'].' payment method icon" width="50" height="42"></div>';
                    }else{
                        if($num < 6) $payment_methods .= '<div class="text-center topCasino-payment_methods-item d-inline-block" ><img src="'.wp_get_attachment_image_src($payment_method['image'], 'image-tiny')[0].'" class="d-inline-block" alt="'.$payment_method['title'].' payment method icon" width="50" height="42"></div>';
                    }
                }
                if(count($post_fields['payment_methods']) > 6){                    
                    $payment_methods .= "</div>
                    <div class='topCasino-payment_methods-more js-topCasinoPaymentMethodsMore text-center'>Show all"; 
                    $payment_methods .= "<div class='topCasino-payment_methods-hidden hidden'>
                        <p class='text-left'>".$GLOBALS['translations_page']['payment_methods']." (".count($post_fields['payment_methods']).") </p>";
                    foreach($post_fields['payment_methods'] as $payment_method){
                        if(
                            isset($payment_method['link']) && 
                            $payment_method['link'] == "yes" && 
                            isset($payment_method['inner_link']) && 
                            !empty($payment_method['inner_link'])
                        ){
                            $inner_link_info = get_tech_link($payment_method['inner_link']);
    
                            $payment_methods .= '<div class="text-center topCasino-payment_methods-item d-inline-block" ><img src="'.$inner_link_info['img'].'" class="d-inline-block" alt="'.$inner_link_info['title'].' payment method icon" width="50" height="42"></div>';
                        }else{
                            $payment_methods .= '<div class="text-center topCasino-payment_methods-item d-inline-block" ><img src="'.wp_get_attachment_image_src($payment_method['image'], 'image-tiny')[0].'" class="d-inline-block" alt="'.$payment_method['title'].' payment method icon" width="50" height="42"></div>';   
                        }
                                                 
                    }
                    $payment_methods .= "</div>";
                }
            }
            $payment_methods .= '</div>';
            // Формируем рефку

            $ref_link = $block_casino_info['ref_link'];

            if(isset($outBonus['bonus_ref']) && $outBonus['bonus_ref'] && !$block_casino_info['alt']) $ref_link = $outBonus['bonus_ref'];

            // END Формируем рефку

            $casino_block = $block_casino_info['casino_block'];

            $popup_btn = $ref_link == $casino_block ? 'get_popup' : '';

            // Формируем плашку

            $plashka_html = '';
            $plashka_meta = get_post_meta( $post->ID, 'plashka_new');

            if(($plashka_casino != "plashka" || $plashka_casino != false) &&
                isset($plashka_meta[0]) && $plashka_meta[0] != '' && isset($plashka_casino[$plashka_meta[0]])){

                $plashka_html = "
                    <span class='topCasino-logo-plashka' >
                        <span class='topCasino-logo-plashka-container' >                        
                            <svg width='70' height='69' viewBox='0 0 70 69' fill='none' xmlns='http://www.w3.org/2000/svg'>
                                <path d='M7.81943 46.8225H0V68.9986H7.81943V46.8225Z' style='filter: brightness(0.70);' fill='".$plashka_casino[$plashka_meta[0]]['color']."'/>
                                <path d='M69.0029 0H46.8242V7.81852H69.0029V0Z' style='filter: brightness(0.70);' fill='".$plashka_casino[$plashka_meta[0]]['color']."'/>
                                <path d='M0 68.9985L68.9985 0.00922131L68.9892 0H44.4946C43.1631 0 41.8846 0.529073 40.9439 1.4708L1.47097 40.9392C0.529135 41.8809 0 43.158 0 44.4894V68.9985Z' fill='".$plashka_casino[$plashka_meta[0]]['color']."'/>
                            </svg>
                            <span class='topCasino-logo-plashka-text'>".
                                $plashka_casino[$plashka_meta[0]]['name']
                            ."
                            </span>
                        </span>
                    </span>";
            }

            // END Формируем плашку

            // Формируем иконку локации

            $location_icon = isset($post_fields['location_icon']) && !empty($post_fields['location_icon']) ?
                            "<img class='topCasino-location' width='24' height='30' src='".$post_fields['location_icon']."'>" :
                            "";
            // END Формируем иконку локации

            $out .= '<div class="topCasino-row topCasinoBonus-row'.$hidenClass.'">
                        <div class="topCasino-row-container d-flex align-items-center flex-wrap">
                            <div class="topCasino-num align-self-start">
                                <span class="d-block">
                                    <span class="triangle"><img src="'.IMG_URL.'triangle_3.svg" alt="arrow icon" width="24" height="6"></span>
                                </span>
                            </div>
                            <div>
                                <a data-popup="'.$popup_btn.'" class="topCasino-logo d-flex align-items-center" href="'.$ref_link.'" rel="nofollow" target="_black">
                                <picture>
                                    <source media="(max-width: 991px)" srcset="'.get_the_post_thumbnail_url($post, 'image-casino-logo-mob').'">
                                    <img src="'.get_the_post_thumbnail_url( $post, 'image-md' ).'" alt="casino logo" class="class1-'.$lang_settings['html'].'" width="76" height="76">
                                </picture>'.
                                        $plashka_html.
                                        $location_icon.
                                '</a>
                            </div>';

            $out .= '
                    <div class="topCasino-bonus">
                        <a data-popup="' . $popup_btn . '" href="' . $ref_link . '" class="topCasino-bonus-content class7-' . $lang_settings['html'] . '" rel="nofollow" target="_blank">' . strip_tags($outBonus['text']) . '</a>
                    </div>
                    <div class="text-center text topCasino-min_deposit">
                        <p class="topCasino-min_deposit-text">'.$GLOBALS['translations_page']['min_deposit'].'</p>
                        <p class="topCasino-min_deposit-value">'.$min_deposit.'</p>
                    </div>
                    <div class="topCasino-payment_methods d-flex flex-wrap">'.$payment_methods.'</div>
                    <div>
                        <a data-popup="'.$popup_btn.'" href="'.$ref_link.'" rel="nofollow" target="_black" class="btn btn-js">
                            <span class="class1-'.$lang_settings['html'].'">'.$GLOBALS['translations_page']['play_btn'].'</span>
                        </a>
                        <a href="'.get_permalink($post->ID).'">'.$GLOBALS['translations_page']['view'].'</a>
                    </div>
                    ';
            if (!empty($outBonus['t_c'])) $out .= '<div class="topCasino-bonus-description">' . $outBonus['t_c'] . '</div>';
            $out .= '</div></div>';

        }
        if ($casinos_count > 10) $out .= '<div class="js-showAllCasinos showAllCasinos text-center"><span class="btn btn-js">' . $GLOBALS['translations_page']['all_casinos'] . '</span></div>';

        $out .= ' </div></div></div></div></section>';
        wp_reset_postdata();
        set_transient($cacheKey, $out, 12 * HOUR_IN_SECONDS);  // Кешируем результат

        return $out;
    endif;
}

add_shortcode('topTenCasinosBonus', 'topTenCasinosBonus');    // Шорткод для вывода казино на странице бонусов