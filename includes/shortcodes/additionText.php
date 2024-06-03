<?php // Шорткод вывода шагов
function additionalText(){
    if(!is_admin()):

        wp_reset_postdata();

        global $post;

        $additionalText = get_field('table_10_text', $post->ID);
        $out = "";
        
        if(!empty($additionalText)):
            
            if(!isset($GLOBALS['table_10_text'])) {
                $GLOBALS['table_10_text'] = true;
                $out .= $additionalText;
            }
            
        endif;

        return $out;
    endif;
}

add_shortcode( 'additionalText', 'additionalText' );                              // Шорткод вывода шагов