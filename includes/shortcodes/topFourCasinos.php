<?php // Шорткод для вывода казино
function topFourCasinos($atts){
    
    if(!is_admin()):
    $args_array = func_get_args();

    $cacheKey = generate_cache_key('topFourCasinos', $args_array);  // Генерируем уникальный ключ кэша с указанием шорткода
    add_cache_key('topFourCasinos', $cacheKey);                     // Добавляем ключ к общему списку для соответствующего шорткода
    $cached = get_transient($cacheKey);

    if (false !== $cached) {
        return $cached;  // Если данные в кэше найдены, возвращаем их
    }

    $lang_settings = get_option('lang');
    if($lang_settings === false) $lang_settings = array('html' => 'en', 'hreflang' => 'en', 'hreflang_title' => '' );

    $cols = strpos($lang_settings['html'],'en') !== false ? 4 : 3;

    $args = array();
    
    $ids = '';
    $title = '';

    if(!empty($args_array[0]['id'])){
        $ids = $args_array[0]['id'];        
    }
    
    $args = array(
        'post_type' => 'page',
        'post__in'  => explode(',', $ids),
        'orderby'   => 'post__in',
        'meta_query' => array(
            'relation' => 'AND',  // Соответствует всем условиям
            [ // условие для шаблона страницы
                'key'   => '_wp_page_template',
                'value' => 'casinos.php',
                'compare' => '='
            ],
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
        )
    );
    if(strpos($lang_settings['html'],'en') !== false) $args['posts_per_page'] = 3; 

    $topCasinos = new WP_Query( $args );
    
    if(!empty($topCasinos) && count($topCasinos->posts) > 0){
        $out = '
            <section class="container topFourCasinos">
                <div class="row">'.$title.'</div>
                <div class="row justify-content-center topFourCasinos-list">
        ';

        $best_choice_casino = get_option('best_choice_casinos');

        $best_choice_casino_img = isset($best_choice_casino['img']) ? $best_choice_casino['img'] : '';
        $best_choice_casino_list = isset($best_choice_casino['ids']) ? $best_choice_casino['ids'] : ['-1'];

        foreach($topCasinos->posts as $topCasino){
            $topCasino_fields = get_fields($topCasino->ID);

            $location_icon = isset($topCasino_fields['location_icon']) && !empty($topCasino_fields['location_icon']) ? 
                            "<img class='topFourCasinos-location' width='24' height='30' src='".$topCasino_fields['location_icon']."'>" : 
                            "";

            $titleCasono = !empty($topCasino_fields['casino_short_name']) ? $topCasino_fields['casino_short_name'] : get_the_title($topCasino->ID);

            $bonuses = $topCasino_fields['bonus_block'];
            $target_bonus = $topCasino_fields['bonus_on_top']['value'];

            $outBonus = array_filter($bonuses, function($bonus) use ($target_bonus){
                return $bonus['bonus_type']['value'] == $target_bonus;
            });
            $outBonus = array_values($outBonus);

            $block_casino_info = block_casino($topCasino_fields);
            $ref_link = $block_casino_info['ref_link'];
            $casino_block = $block_casino_info['casino_block'];
            $popup_btn = $ref_link == $casino_block ? 'get_popup' : '';

            $best_choice_casino = '';
            $best_choice_casino_icon = '';
            
            if(in_array( $topCasino->ID,$best_choice_casino_list)){
                $best_choice_casino = 'best-choice-casino';
                $best_choice_casino_icon = wp_get_attachment_image( $best_choice_casino_img, 'full' );
            }

            $out .= '
                <div class="col-xl-'.$cols.' col-sm-6 col-12">
                    <div class="topFourCasinos-list-item text-center" >
                        <div class="text-center d-flex align-items-center justify-content-between flex-wrap">
                            <a href="'.$ref_link.'" rel="nofollow" class="topFourCasinos-logo d-flex" target="_blank" >'.
                                $location_icon
                                .'
                                <picture>
                                    <source media="(max-width: 767px)" srcset="'.get_the_post_thumbnail_url($topCasino->ID, 'image-xmd').'">
                                    <img src="'.get_the_post_thumbnail_url($topCasino->ID, 'thumbnail').'" alt="casino logo" class="class3-'.$lang_settings['html'].' imageShadow js-imageShadow" width="150" height="150">
                                </picture>
                            </a>
                            <p class="topFourCasinos-rating d-flex justify-content-between">
                                <span class="number trext-center"></span>
                                <span class="rating">
                                    <img src="'.IMG_URL.'star.svg" width="21" alt="star" height="20">'.$topCasino_fields['rating'][0].'
                                </span>
                            </p>
                            <div class="'.$best_choice_casino.' topFourCasinos-links text-center d-flex align-items-center justify-content-between flex-wrap">
                            '.$best_choice_casino_icon.'
                            <a href="'.get_permalink($topCasino->ID).'" class="topFourCasinos-review text">'.$GLOBALS['translations_page']['view'].' '.$titleCasono.'</a>
                            <a data-popup="'.$popup_btn.'" href="'.$ref_link.'" rel="nofollow" target="_blank" class="topFourCasinos-name text"><span class="class3-'.$lang_settings['html'].'">'.$titleCasono.'</span></a>';

            if(!empty($outBonus[0]['short_text']))
                $out .= '<a data-popup="'.$popup_btn.'" href="'.$ref_link.'" rel="nofollow" target="_blank" class="topFourCasinos-bonus class3-'.$lang_settings['html'].'">'.strip_tags($outBonus[0]['short_text']).'</a>';

            if(!empty($outBonus[0]['t_c']))
            $out .= '<div class="topFourCasinos-bonus-description">'.$outBonus[0]['t_c'].'</div>';

            $out .= '</div><a data-popup="'.$popup_btn.'" href="'.$ref_link.'" rel="nofollow" target="_blank" class="btn btn-js btn-red"><span class="class3-'.$lang_settings['html'].'">'.$GLOBALS['translations_page']['play_btn'].'</span></a>
                        </div>                        
                    </div>
                </div>
            ';
        }

        wp_reset_postdata();
        
        $out .= '
                </div>
            </section>
        ';
        set_transient($cacheKey, $out, 12 * HOUR_IN_SECONDS);  // Кешируем результат
        
        return $out;
    }
    endif;
}

add_shortcode( 'topFourCasinos', 'topFourCasinos' );            // Шорткод для вывода казино