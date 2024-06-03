<?php // Шорткод таблицы игр 
function gameTable(){
    if(!is_admin()):
        
        $lang_settings = get_option('lang');
        if($lang_settings === false) $lang_settings = array('html' => 'en', 'hreflang' => 'en', 'hreflang_title' => '' );

        if(!empty($args_array[0]['id'])){
            $ids = $args_array[0]['id'];
    
            $games_args = array(
                'post_type' => 'games',
                'post__in'  => explode(',', $ids)
            );
        }else{
            $games_args = array(
                'date_format'       => get_option('date_format'),
                'meta_key'			=> 'rating',
                'orderby'           => 'meta_value_num',
                'post_type'         => 'games',
                'post_status'       => array('publish'),
                'posts_per_page'    => -1,
                'order'				=> 'DESC',
            ); 
        }        
        
        $games = new WP_Query($games_args);

        $args_array = func_get_args();

        $title = !empty($args_array[0]['title']) ? $args_array[0]['title'] : '';

        $titleHTML = '';
        if($title != '') $titleHTML .= '<h2 class="title-line" data-anchor="'.$title.'">
                                            <span>'.$title.'</span>
                                        </h2>';
        
        $out = '<section class="container extendTitle">
                    <div class="row">
                        <div class="col-12 d-flex align-items-center extendTitle-title">
                        '.$titleHTML.'
                        <div class="extendTitle-content"> 
                    <span class="extendTitle-content-title update">'.$GLOBALS['translations_page']['updated'].':</span> '.get_the_modified_date('d M Y').'</div>
                        </div>
                        <div class="col-lg-12">
                            <div class="topGames text-center">
                                <div class="topGames-header topGames-row d-lg-flex d-none align-items-center">
                                    <p>№</p>
                                    <p>'.$GLOBALS['translations_page']['thumbnail'].'</p>
                                    <p>'.$GLOBALS['translations_page']['slot'].'</p>
                                    <p>'.$GLOBALS['translations_page']['rating'].'</p>
                                    <p>RTP</p>
                                    <p>'.$GLOBALS['translations_page']['developer'].'</p>
                                    <p>'.$GLOBALS['translations_page']['play_btn'].'</p>
                                </div>
                            <div class="topGames-content">';

        $game_count = 0;
        $hidden = '';
        foreach($games->posts as $game){
            $game_count++;
            if($game_count > 5) $hidden = 'hidden';
            $link = !empty(get_field( 'ref_link', $game->ID )) ? get_field( 'ref_link', $game->ID ) : 'https://onlinecasinoprofy.com/'.$GLOBALS["currentLang"].'/goto/casino/';
            $out .= '<div class="topGames-row d-flex align-items-center '.$hidden.'">
                        <div class="topGames-number d-flex align-items-center justify-content-center"></div>
                        <div class="topGames-logo" style="background-image: url('.get_the_post_thumbnail_url( $game, 'full' ).')"></div>
                        <div class="topGames-name"><a href="'.get_the_permalink($game->ID).'" >'.get_the_title($game).'</a></div>
                        <div class="topGames-rating">
                            <p class="stars js-stars d-flex align-items-start justify-content-center" data-stars="'.get_field('rating',$game->ID).'"></p>
                        </div>
                        <div class="topGames-name topGames-rtp">'.get_field( 'specifications',$game->ID)["rtp"].'</div>
                        <div class="topGames-developer text">'.get_field( 'specifications',$game->ID)["provider"].'</div>
                        <div class="topGames-btn text">
                            <a href="'.$link.'" rel="nofollow" target="_blank" class="btn btn-js"><span class="class6-'.$lang_settings['html'].'">'.$GLOBALS['translations_page']['play_btn'].'</span></a>
                        </div>
                    </div>';
        }

        if($game_count > 5) $out .= '<div class="js-showAllCasinos showAllCasinos text-center"><span class="btn btn-js">'.$GLOBALS['translations_page']['all_slots'].'</span></div>';

        wp_reset_postdata();      
        $out .= '</div>
            </section>';

    return $out;
    endif;
}

add_shortcode( 'game-table', 'gameTable' );                     // Шорткод таблицы игр