<?php // Шорткод для вывода игр
function moreGames(){
    if(!is_admin()):

        $args_array = func_get_args();

        $lang_settings = get_option('lang');
        if($lang_settings === false) $lang_settings = array('html' => 'en', 'hreflang' => 'en', 'hreflang_title' => '' );
        
        $title = !empty($args_array[0]['title']) ? $args_array[0]['title'] : '';

        global $post;
        $post_slug = $post->post_name;

        if(!empty($args_array[0]['id'])){

            $ids = $args_array[0]['id'];       
            
            if($ids != "all") $args = array(
                'post__in'  => explode(',',$ids)
            );
                                
        }else if(!empty($args_array[0]['provider'])){
            $args = array(
                'meta_query'        => array(
                    array(
                        'relation' => 'OR',
                        array(
                            'key'     => 'specifications_provider',
                            'value'   => $args_array[0]['provider'],
                            'compare' => 'LIKE',
                        )
                    )
                )
            );
        }else{
            $args = array(
                'tax_query' => array(
                    array(
                        'taxonomy' => 'category',
                        'field' => 'slug',
                        'terms' => $post_slug,
                    )
                )
            );
        }
        
        $args['post_type'] = 'games';
        $args['posts_per_page'] = -1;

        $games = new WP_Query( $args );
        
        $filterContainer = '';
        $filterTitle = '';

        if(!empty($args_array[0]['filter'])){
            // Если есть атрибут 'filter' , то добавляем фильтрацию по провайдерам
            global $wpdb;

            $issues = $wpdb->get_col( "
                SELECT pm.meta_value
                FROM {$wpdb->postmeta} pm
                WHERE pm.meta_key = 'specifications_provider' AND pm.meta_value != ''
            " );

            $filterList = array_unique($issues);

            if(!function_exists('trim_elem')){
                function trim_elem($elem){
                    return trim($elem);
                }
            }

            $filterList = array_unique(array_map('trim_elem', $filterList));
            
            $filterRender = '';

            foreach($filterList as $filter){
                $filterRender .= '<li class="js-gameFilter"><span>'.$filter.'</span></li>';
            }
            $filterRender .= '<li class="js-gameFilterReset"><span>'.$GLOBALS['translations_page']['all'].'</span></li>';

            $filterContainer = 'extendTitle';
            $filterTitle = '<div class="col-12 d-flex align-items-center extendTitle-title">';
            if($title !=''){
                $filterTitle .= '<h2 class="title-line" data-anchor="'.$title.'">
                                <span>'.$title.'</span>
                            </h2>';
            }
            $filterTitle .= '<div class="extendTitle-content">
                                <div class="extendTitle-content-title js-openGameFilter">'.$GLOBALS['translations_page']['filter'].'<img src="'.IMG_URL.'up_arrow.svg" alt="filter arrow" width="22" height="22"> <ul class="filter-list">'.trim($filterRender).'</ul></div></div>
                            </div>';

        }else{
            if($title !=''){
                $filterTitle = '<h2 class="col-12 title-line" data-anchor="' . $title . '">
                                <span>' . $title . '</span> 
                            </h2>';
            }
        }
        
        $hidenClass = '';
        $games_count = 0;

        $games = new WP_Query( $args );
             
        $out = '
            <section class="container moreGames '.$filterContainer.'">
                <div class="row">
                    '.$filterTitle.'
                </div>
                <div class="row moreGames-list">
        ';

        foreach($games->posts as $game){
            $games_count++;
            if($games_count > 8) $hidenClass = 'hidden';

            $refLikn = !empty(get_field('ref_link',$game->ID)) ? get_field('ref_link',$game->ID) : get_blog_details()->path.'goto/casino/';
            
            if(isset(get_field('specifications',$game->ID)['provider']) && !empty(get_field('specifications',$game->ID)['provider'])):
            $out .= '
                <div class="col-lg-3 col-md-6 col-12 '.$hidenClass.'" data-filter="'.trim(get_field('specifications',$game->ID)['provider']).'">
                    <div class="moreGames-list-item text-center" >
                        <div class="btn-container text-center d-flex align-items-center justify-content-center flex-column" style="background-image: url('.get_field( 'game_preview_image',$game->ID ).');">
                            <a href="'.get_the_permalink($game->ID).'" class="btn-white btn-js">'.$GLOBALS['translations_page']['play_free_demo'].'</a>
                            <a href="'.$refLikn.'" rel="nofollow" class="btn btn-js"><span class="class2-'.$lang_settings['html'].'">'.$GLOBALS['translations_page']['play_real_money'].'</span></a>
                        </div>
                        <p class="moreGames-name"><span>'.get_the_title($game->ID).'</span></p>
                    </div>
                </div>
            ';
            endif;
        }
        wp_reset_postdata();
        
        $hidenClass = isset($args_array[0]['btn']) && $games_count > 8 ? '' : 'hidden';

        $out .= '<div class="text-center col-12 '.$hidenClass.'"><span class="btn btn-js js-allGames">'.$GLOBALS['translations_page']['all_games'].'</span></div>
                </div>
            </section>
        ';
        
        return $out;

    endif;
}
add_shortcode( 'more-games', 'moreGames' );                     // Шорткод для вывода игр