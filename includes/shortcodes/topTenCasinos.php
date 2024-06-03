<?php // Шорткод для вывода казино

function topTenCasinos(){

    if(!is_admin() || isset($_GET['action']) && $_GET['action'] == 'ajax_filter'):

        $args_array = func_get_args(); // Получение аргументов функции

        $cacheKey = generate_cache_key('topTenCasinos', $args_array);  // Генерируем уникальный ключ кэша с указанием шорткода
        add_cache_key('topTenCasinos', $cacheKey);                     // Добавляем ключ к общему списку для соответствующего шорткода
        $cached = get_transient($cacheKey);
    
        if (false !== $cached) {
            return $cached;  // Если данные в кэше найдены, возвращаем их
        }

        // Инициализация переменных
        $local_currency = get_option('currency');
        $lang_settings = get_option('lang', ['html' => 'en', 'hreflang' => 'en', 'hreflang_title' => '']);
        $plashka_casino = get_option('plashka');
        $casinos_args = [
            'post_type'      => 'page',
            'posts_per_page' => -1, // Вывод всех постов за один запрос
            'orderby'        => 'meta_value_num',
            'order'          => 'DESC',
            'meta_query'     => [
                'relation' => 'AND',
                [
                    'key'     => '_wp_page_template',
                    'value'   => 'casinos.php',
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
            ]
        ];
    
        // Условия для разных типов запросов
        if (!empty($args_array[0]['id'])) {
            $casinos_args['orderby'] = 'post__in';
            $casinos_args['post__in'] = explode(',', $args_array[0]['id']);
        } elseif (!empty($args_array[0]['provider']) || !empty($args_array[0]['payment-method'])) {
            $meta_query = ['relation' => 'OR'];
            if (!empty($args_array[0]['provider'])) {
                $meta_query[] = [
                    'key'     => 'providers_$_name',
                    'value'   => $args_array[0]['provider'],
                    'compare' => 'LIKE'
                ];
            }
            if (!empty($args_array[0]['payment-method'])) {
                $meta_query[] = [
                    'key'     => 'payment_methods_$_title',
                    'value'   => $args_array[0]['payment-method'],
                    'compare' => 'LIKE'
                ];
            }
            $casinos_args['meta_query'][] = $meta_query;
        }

    // Дополнительные фильтры из AJAX-запроса
    if (isset($_GET['action']) && $_GET['action'] == 'ajax_filter') {
        parse_str($_GET['form'], $form_args); // Разбор строки запроса

        // Инициализация дополнительного массива для фильтров
        $additional_filters = ['relation' => 'AND'];

        // Фильтр по способам оплаты
        if (!empty($form_args['payment-method'])) {
            foreach ($form_args['payment-method'] as $payment_method) {
                $additional_filters[] = [
                    'key'     => 'payment_methods_$_title',
                    'value'   => $payment_method,
                    'compare' => 'LIKE'
                ];
            }
        }

        // Фильтр по бонусам
        if (!empty($form_args['bonus_on_top'])) {
            foreach ($form_args['bonus_on_top'] as $bonus_on_top) {
                $additional_filters[] = [
                    'key'     => 'bonus_block_$_bonus_type',
                    'value'   => $bonus_on_top,
                    'compare' => 'LIKE'
                ];
            }
        }

        // Фильтр по типам игр
        if (!empty($form_args['games_types'])) {
            foreach ($form_args['games_types'] as $games_types) {
                $additional_filters[] = [
                    'key'     => 'games_types_$_list',
                    'value'   => $games_types,
                    'compare' => 'LIKE'
                ];
            }
        }

        // Фильтр по минимальному депозиту
        if (!empty($form_args['min_deposit'])) {
            $additional_filters[] = [
                'key'     => 'min_deposit_text',
                'value'   => $form_args['min_deposit'],
                'compare' => '>=',
                'type'    => 'NUMERIC'
            ];
        }

        // Фильтр по максимальному депозиту
        if (!empty($form_args['max_deposit'])) {
            $additional_filters[] = [
                'key'     => 'max_deposit',
                'value'   => $form_args['max_deposit'],
                'compare' => '<=',
                'type'    => 'NUMERIC'
            ];
        }

        // Объединение дополнительных фильтров с основным запросом, если есть дополнительные фильтры
        if (count($additional_filters) > 1) { // Проверяем, были ли добавлены дополнительные фильтры (больше одного, учитывая 'relation' => 'AND')
            $casinos_args['meta_query'][] = $additional_filters;
        }
    }
    
    $dateContainer = '';
    $dateTitle = '';
    $title = !empty($args_array[0]['title']) ? $args_array[0]['title'] : '';
    
    $casinos = new WP_Query( $casinos_args );
    
    // Показывать дату обновления страницы или нет
    if(!empty($args_array[0]['show-date'])){
        $dateContainer = 'extendTitle';
        $dateTitle = '<div class="col-12 d-flex align-items-center extendTitle-title">';

        if($title != '' && $GLOBALS['content_hide'] != true) $dateTitle .= '<h2 class="title-line" data-anchor="'.$title.'">
                                            <span>'.$title.'</span>
                                        </h2>';

        $dateTitle .= '<div class="extendTitle-content"><span class="extendTitle-content-title update">'.$GLOBALS['translations_page']['updated'].':</span> '.get_the_modified_date('d M Y').'</div>
                    </div>';
    }else{
        if($title != '' && $GLOBALS['content_hide'] != true) $dateTitle = '<h2 class="title-line" data-anchor="'.$title.'">
                                            <span>'.$title.'</span>
                                        </h2>';
    }
    

    $out_casino = $casinos->posts;
    if(!empty($out_casino)):
    $out = '
    <section class="container '.$dateContainer.'">
        <div class="row">
            '.$dateTitle.'
            <div class="col-lg-12">
                <div class="topCasino text-center">
                    <div class="topCasino-header topCasino-row-container d-lg-flex d-none align-items-center">
                        <p></p>
                        <p>'.$GLOBALS['translations_page']['name'].'</p>
                        <p>'.$GLOBALS['translations_page']['rating'].'</p>
                        <p>'.$GLOBALS['translations_page']['bonus'].'</p>
                        <p>'.$GLOBALS['translations_page']['payment'].'</p>
                        <p>'.$GLOBALS['translations_page']['deposit'].'</p>
                        <p>'.$GLOBALS['translations_page']['licenses'].'</p>
                        <p>'.$GLOBALS['translations_page']['review'].'</p>
                    </div>
                    <div class="topCasino-content">
        ';

        foreach($out_casino as $casino_num => $post){

            $post_fields = get_fields($post->ID);
            
            // минимальный депозит
            $min_deposit = '-';
            
            if(isset($post_fields['min_deposit']) && $post_fields['min_deposit'] && trim($post_fields['min_deposit']['text']) != ''){
                if(isset($post_fields['currency']) && !empty($post_fields['currency'])) $local_currency = $post_fields['currency'];
                $min_deposit = $local_currency.$post_fields['min_deposit']['text'];
            }

            // методы оплат
            $payment_methods = '<div class="topCasino-payment_methods-list">';

            if(isset($post_fields['payment_methods']) && $post_fields['payment_methods']){
                foreach($post_fields['payment_methods'] as $num => $payment_method){
                    if(
                        isset($payment_method['link']) && 
                        $payment_method['link'] == "yes" && 
                        isset($payment_method['inner_link']) && 
                        !empty($payment_method['inner_link'])
                    ){
                        $inner_link_info = get_tech_link($payment_method['inner_link']);

                        if ($num < 6) $payment_methods .= '<div class="text-center topCasino-payment_methods-item d-inline-block" ><img src="' . $inner_link_info['img'] . '" class="d-inline-block" alt="' . $inner_link_info['title'] . ' payment method icon" width="50" height="42"></div>';
                    }else{
                        if ($num < 6) $payment_methods .= '<div class="text-center topCasino-payment_methods-item d-inline-block" ><img src="' . wp_get_attachment_image_src($payment_method['image'], 'image-tiny')[0] . '" class="d-inline-block" alt="' . $payment_method['title'] . ' payment method icon" width="50" height="42"></div>';
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

                            $payment_methods .= '<div class="text-center topCasino-payment_methods-item d-inline-block" ><img src="' . $inner_link_info['img'] . '" class="d-inline-block" alt="' . $inner_link_info['title'] . ' payment method icon" width="50" height="42"></div>';
                        }else{
                            
                            $image = isset(wp_get_attachment_image_src($payment_method['image'], 'image-tiny')[0]) && wp_get_attachment_image_src($payment_method['image'], 'image-tiny')[0] ? wp_get_attachment_image_src($payment_method['image'], 'image-tiny')[0] : IMG_URL . "no-image-svgrepo-com.svg";
                            
                            $payment_methods .= '<div class="text-center topCasino-payment_methods-item d-inline-block" ><img src="' . $image . '" class="d-inline-block" alt="' . $payment_method['title'] . ' payment method icon" width="50" height="42"></div>';  
                        }
                                                 
                    }
                    $payment_methods .= "</div>";
                }
            }
            $payment_methods .= '</div>';

            // Лицензии
            $licences = '';
            if(isset($post_fields['characteristics_of_the_casino']['licences']) && $post_fields['characteristics_of_the_casino']['licences']){
                $licences_array = explode(',', $post_fields['characteristics_of_the_casino']['licences']);
                foreach($licences_array as $licences_item){
                    $licences .= "<p class='text-left d-flex'><span>".trim($licences_item)."</span></p>";
                }
            }

            // Плашка на лого казино
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

            $hidenClass = '';

            // Получаем нужный бонус

            $outBonus = array(
                "bonus_type" => array(
                    "value" => "",
                    "label" => "―"
                ),
                "text" => "―",
                "short_text" => "-",
                "t_c" => "",
                "bonus_ref" => ""
            );

            if(isset($post_fields['bonus_block'])){
                $bonuses = $post_fields['bonus_block'];
                $target_bonus = !empty($args_array[0]['bonus_type']) ? $args_array[0]['bonus_type'] : "welcome_bonus";
                if($bonuses) $outBonus = get_bonus($target_bonus, $bonuses);
            }

            $titleCasono = !empty($post_fields['casino_short_name']) ? $post_fields['casino_short_name'] : get_the_title($post->ID);

            if($casino_num > 9) $hidenClass = 'hidden';

            $moreArrow = '';
            $moreInfo  = '';
            $moreItem = '';

            $block_casino_info = block_casino(get_fields($post->ID));
            $ref_link = $block_casino_info['ref_link'];

            if(isset($outBonus['bonus_ref']) && $outBonus['bonus_ref'] && !$block_casino_info['alt']) $ref_link = $outBonus['bonus_ref'];

            $casino_block = $block_casino_info['casino_block'];

            $popup_btn = $ref_link == $casino_block ? 'get_popup' : '';

            if(!empty($args_array[0]['more-info'])){
                $moreItem = 'moreItem js-moreItem';

                $moreArrow = '<div class="more-arrow-container">
                                <div class="more-arrow js-moreArrow d-flex align-items-center" data-more="'.$GLOBALS["translations_page"]["show_more"].'" data-less="'.$GLOBALS["translations_page"]["show_less"].'">
                                    <img src="'.IMG_URL.'up_arrow.svg" alt="arrow icon" width="22" height="22"><p class="text js-moreArrowText">'.$GLOBALS["translations_page"]["show_more"].'</p>
                                </div>                                
                            </div>';

                $moreInfo  = '<div class="more-info text-left flex-wrap js-moreInfo">';

                // Типы игр
                if($post_fields['games_types']):
                    $moreInfo .='<div class="more-info-part">
                                <p class="text">'.$GLOBALS['translations_page']['games'].'</p>
                                <ul class="grayBgBlock-half d-flex flex-wrap">';
                    foreach($post_fields['games_types'] as $game):
                        if(isset($GLOBALS['translations_page'][$game['list']])){
                            $moreInfo .='<li class="grayBgBlock">'.$GLOBALS['translations_page'][$game['list']].'</li>';
                        }
                    endforeach;

                    $moreInfo .='</ul></div>';
                endif;

                // Валюты
                if($post_fields['currencies']):
                    $moreInfo .= '<div class="more-info-part">
                        <p class="text">'.$GLOBALS['translations_page']['currencies'].'</p>
                        <ul class="currencies">';

                        foreach(explode(',',$post_fields['currencies']) as $currency):
                            $moreInfo .=  '<li class="grayBgBlock grayBgBlock-square">'.trim($currency).'</li>';
                        endforeach;

                    $moreInfo .=  '</ul>
                        </div>';
                endif;

                // Провайдеры
                if($post_fields['providers']):
                    $moreInfo .= '<div class="more-info-part">
                        <p class="text">'.$GLOBALS['translations_page']['providers'].'</p>
                        <ul class="grayBgBlock-half d-flex flex-wrap">';

                        foreach($post_fields['providers'] as $provider):
                            $moreInfo .= '<li class="grayBgBlock">';
                            if(isset($provider['link']) && $provider['link'] == "yes" && isset($provider['inner_link']) && !empty($provider['inner_link'])):
                                $inner_link_info = get_tech_link($provider['inner_link']);

                                $moreInfo .= '<a href="'.$inner_link_info['link'].'">'.$inner_link_info['title'].'</a>';
                            else:
                                $moreInfo .= $provider['name'];
                            endif;
                            $moreInfo .= '</li>';
                            endforeach;

                    $moreInfo .=  '</ul>
                        </div>';
                endif;

                // Языки
                if($post_fields['languages']):
                    $moreInfo .= '<div class="more-info-part">
                        <p class="text">'.$GLOBALS['translations_page']['languages'].'</p>
                        <ul class="grayBgBlock-half d-flex flex-wrap">';

                        foreach($post_fields['languages'] as $language){
                            
                            $moreInfo .= '<li class="grayBgBlock">
                                <span class="grayBgBlock-link-icon d-flex">
                                    <img class="flag" width="21" height="14" src="'.IMG_URL.'flags/'.strtolower($language).'.png" alt="'.$language.' flag">
                                </span>
                            </li>';
                        }

                    $moreInfo .=  '</ul>
                        </div>';
                endif;

                // Платформы
                if($post_fields['platforms']):
                    $moreInfo .= '<div class="more-info-part">
                        <p class="text">'.$GLOBALS['translations_page']['platforms'].'</p>
                        <ul class="grayBgBlock-half d-flex flex-wrap">';

                        foreach($post_fields['platforms'] as $platform){
                            $moreInfo .= '<li class="">';
                            if(isset($platform['link']) && $platform['link'] == "yes" && isset($platform['inner_link']) && !empty($platform['inner_link'])):
                                $inner_link_info = get_tech_link($platform['inner_link']);
                                $moreInfo .= '
                                    <a 
                                        class="grayBgBlock-square d-inline-flex align-items-center justify-content-center" 
                                        href="'.get_permalink($platform['inner_link']).'"> 
                                        <span class="grayBgBlock-link-icon d-flex">
                                            <img src="'.IMG_URL.'casino/platforms/'.$platform['list'].'.svg" alt="'.$platform['list'].' icon" class="no-hover">
                                            <img src="'.IMG_URL.'casino/platforms/'.$platform['list'].'-hover.svg" alt="'.$platform['list'].' icon" class="hover">
                                        </span>                                        
                                        <span>'.$GLOBALS['translations_page'][$platform['list']].'</span>
                                    </a>';
                            else:
                                $moreInfo .= '
                                    <span class="grayBgBlock-square d-inline-flex align-items-center justify-content-center">
                                        <span class="grayBgBlock-link-icon d-flex">
                                            <img src="'.IMG_URL.'casino/platforms/'.$platform['list'].'.svg" alt="'.$platform['list'].' icon">
                                        </span>
                                        <span>'.$GLOBALS['translations_page'][$platform['list']].'</span>                                        
                                    </span>';                                
                            endif;
                            $moreInfo .= '</li>';
                        }

                    $moreInfo .=  '</ul>
                        </div>';
                endif;

                $moreInfo .= '<div class="more-info-btns d-flex justify-content-center flex-md-row flex-column align-items-center text-center">
                                <a data-popup="'.$popup_btn.'" href="'.$ref_link.'" rel="nofollow" target="_black" class="btn btn-js">'.$GLOBALS['translations_page']['play_btn'].'</a>
                                <a href="'.get_permalink($post->ID).'" >'.$GLOBALS['translations_page']['view'].'</a>
                            </div>
                        </div>';

            }

            $location_icon = isset($post_fields['location_icon']) && !empty($post_fields['location_icon']) ?
                            "<img class='topCasino-location' width='24' height='30' src='".$post_fields['location_icon']."'>" :
                            "";

            // звезды рейтинга
            $rating = isset($post_fields['rating']) ? substr($post_fields['rating'],0,1) : "";

            $rating_html = '
                    <p class="stars d-flex align-items-start justify-content-center">
                        
            ';
            for($i = 1; $i < 6; $i++){
                $rating_html .= '<span class="user-rating-item'; 

                if($rating >= $i ) $rating_html .= ' red';

                $rating_html .= '">';
                $rating_html .= '
                    <img src="'.IMG_URL.'star.svg" alt="star" width="21" height="21" class="user-rating-item-red">
                    <img src="'.IMG_URL.'star_gray.svg" alt="star gray" width="21" height="21" class="user-rating-item-gray">
                </span>';
            }

            $rating_html .= '<span class="rating_val">'.$rating.'</span>/5 </p>';

            $out .= '<div class="topCasino-row '.$hidenClass.' '.$moreItem.'">
                        <div class="topCasino-row-container d-flex align-items-center flex-wrap ">
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
                    </div>
                    <div>
                        '.$rating_html.'
                        <p class="topCasino-name" >'.$titleCasono.'</p>                            
                    </div>
                    <div class="topCasino-bonus">
                        <div class="topCasino-bonus-content">
                            '.$outBonus['text'].'
                        </div>
                    </div>
                    <div class="d-lg-flex d-none flex-wrap topCasino-payment_methods">'.$payment_methods.'</div>
                    <div class="text-center text topCasino-min_deposit">
                        <p class="topCasino-min_deposit-text">'.$GLOBALS['translations_page']['min_deposit'].'</p>
                        <p class="topCasino-min_deposit-value">'.$min_deposit.'</p>
                    </div>
                    <div class="topCasino-licences">
                        '.$licences.'
                    </div>
                    <div>
                        <a data-popup="'.$popup_btn.'" href="'.$ref_link.'" rel="nofollow" target="_black" class="btn btn-js">
                            <span class="class1-'.$lang_settings['html'].'">'.$GLOBALS['translations_page']['play_btn'].'</span>
                        </a>
                        <a href="'.get_permalink($post->ID).'">'.$GLOBALS['translations_page']['view'].'</a>
                    </div>';

                    if(!empty($outBonus['t_c'])) $out .= '<div class="topCasino-bonus-description">'.$outBonus['t_c'].'</div>';

                    $out .= $moreArrow.$moreInfo.'</div></div>';

        }

        if($casino_num > 9 && isset($args_array[0]['btn'])) $out .= '<div class="js-showAllCasinos showAllCasinos text-center"><span class="btn btn-js">'.$GLOBALS['translations_page']['all_casinos'].'</span></div>';

        $out .= ' </div></div></div></div></section>';
        if(isset($_GET['action']) && $_GET['action'] == 'ajax_filter' && count($casinos->posts) == 0){
            $out = "<p class='text-center'>".$GLOBALS['translations_page']['no_results_found']."</p>";
        }
        
        $out .= do_shortcode("[additionalText]");

        set_transient($cacheKey, $out, 12 * HOUR_IN_SECONDS);  // Кешируем результат

        return $out;
        endif;
        
    endif;
}

add_shortcode( 'topTenCasinos', 'topTenCasinos' );              // Шорткод для вывода казино