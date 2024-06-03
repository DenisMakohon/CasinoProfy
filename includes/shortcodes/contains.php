<?php // Шорткод автогенерации сорержания
function contains(){
    
    if(!is_admin() && !(isset($GLOBALS['hide_content']['content']['shortcodes']) && in_array('contains', $GLOBALS['hide_content']['content']['shortcodes']))):
        
        global $post;

        // $pattern = '/<h2[^>]*id="(.+?)"/u';
        $pattern = '/data-anchor="([^"]+)"/';

        preg_match_all($pattern, get_the_content(), $h2_anchors);

        $out = "
            <div class='contains-btn js-containsBtn mobile text-center'>".$GLOBALS['translations_page']['tabel_of_content']."</div>
            <div id='contains' class='flex-wrap js-contains'>
            <ul>
        ";

        foreach($h2_anchors[1] as $anchor){
            $spaces_id = preg_replace('/\s/','-', $anchor);
            $out .= '<li><a href="#'.$spaces_id .'">'.$anchor.'</a></li>';
        }
        
        if(!empty(get_field('faq'))){
            $out .= '<li><a href="#'.$GLOBALS['translations_page']['faq'].'-❓">'.$GLOBALS['translations_page']['faq'].' ❓</a></li>';
        }

        $out .= "</ul>              
            </div>";

        if(count($h2_anchors[1]) ){
            $out .= "<div class='containsMore text-center desktop'>
                <img src='".IMG_URL."up_arrow.svg' class='js-containsMore up' alt='arrow icon' width='22' height='22'>
            </div>  ";
        }
            
        return $out;
    endif;

}

add_shortcode( 'contains', 'contains' );                        // Шорткод автогенерации сорержания