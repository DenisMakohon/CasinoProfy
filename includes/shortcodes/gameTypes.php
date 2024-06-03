<?php // Шорткод категорий игр
function gameTypes(){
    if(!is_admin()):

        global $post;

        $args_array = func_get_args();
        
        $title = !empty($args_array[0]['title']) ? $args_array[0]['title'] : '';

        $titleHTML = '';

        if($title != '') $titleHTML .= '<h2 class="title-line" data-anchor="'.$title.'">
                                            <span>'.$title.'</span>
                                        </h2>';

        $out = '<section class="container gameTypes extendTitle">
                    <div class="row">
                        <div class="col-12 d-flex align-items-center extendTitle-title">
                            '.$titleHTML.'
                            <div class="extendTitle-content">
                                <div class="js-gameTypesControls"></div>
                            </div>
                        </div>            
                    </div>
                    <div class="row js-gameTypes">
        ';
        
        $cat_args = array(
            'orderby' => 'name',
            'order' => 'ASC'
        );
        $categories = get_categories($cat_args);
        

        foreach($categories as $category){
            
            if($category->slug != $post->post_name && $category->slug != 'blog'){
                $title = get_category($category->cat_ID)->cat_name;
                $count = get_category($category->cat_ID)->category_count;
                $catLink = str_replace("/./","/",get_category_link($category->cat_ID));
                
                $out .= '
                    <div class="col-12 d-flex">
                        <div class="gameTypes-item d-flex flex-column">
                            <p class="gameTypes-title">'.$title.'</p>
                            <div class="gameTypes-count">
                                <span>'.$count.'</span> 
                            </div>
                            <a class="" href="'.$catLink.'">'.$GLOBALS['translations_page']['all_category_game'].'<img src="'.IMG_URL.'up_arrow.svg" width="22" height="22" alt="arrow icon"></a>
                        </div>
                    </div>
                ';
            }
        }

        $out .= '</div>
            </section>';

    return $out;
    endif;
}

add_shortcode( 'game-types', 'gameTypes' );                     // Шорткод категорий игр