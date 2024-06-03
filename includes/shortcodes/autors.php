<?php

function autors(){
    
    if(!is_admin() && !(isset($GLOBALS['hide_content']['content']['shortcodes']) && in_array('autors', $GLOBALS['hide_content']['content']['shortcodes']))):

    global $post;
    
    if(!empty($post)) :

		$autors_meta = get_post_meta( url_to_postid($GLOBALS['current_url']), 'autor_name');
        
		$autors = get_option('autors_site');
        
		if(!empty($autors_meta) && isset($autors_meta[0]) && !empty($autors_meta[0]) && ($autors != "autors_site" || (gettype($autors) == "array" && !empty($autors)))) : 
            $out = '<section class="container">';
            
            foreach($autors_meta[0] as $autor){
                if(isset($autor['num']) && isset($autors['list'][$autor['num']])){

                    if(empty($autor['text'])) $autor['text'] = $autors['list'][$autor['num']]['text'];

                    $out .= '<div class="row autor-item">
                    <div class="col-md-2">
                        <div class="autor-photo d-flex align-items-start">
                            <img width="170" height="170" src="'.wp_get_attachment_image_src( $autors['list'][$autor['num']]['photo'], array(200, 200) )[0].'" alt="autor photo" >
                        </div>
                    </div>
                    <div class="col-md-10">
                        <p class="autor-name-container">';
                        if(isset($autors['link']) && !empty($autors['link'])){
                            $out .= '<a 
                                class="autor-name" 
                                href="'.$autors['link'].'" 
                                title="Reviewed by '.stripcslashes($autors['list'][$autor['num']]['name']).'" 
                                rel="author"
                            >'.stripcslashes($autors['list'][$autor['num']]['name']).'</a>';
                        }else{
                            $out = '<span
                                class="autor-name" 
                                title="Reviewed by '.stripcslashes($autors['list'][$autor['num']]['name']).'" 
                                rel="author"
                            >'.stripcslashes($autors['list'][$autor['num']]['name']).'</span>';
                        }
                        
                        if(isset($autors['list'][$autor['num']]['soc_link']) && !empty($autors['list'][$autor['num']]['soc_link']) && isset($autors['list'][$autor['num']]['soc_logo']) && !empty($autors['list'][$autor['num']]['soc_logo'])){
                            $out .= '<a href="'.$autors['list'][$autor['num']]['soc_link'].'" class="autor-soc" rel="nofollow" target="_blank"><img width="27" height="26" src="'.wp_get_attachment_image_src( $autors['list'][$autor['num']]['soc_logo'], array(25, 25) )[0].'" alt="soc logo"></a>';
                        }
                        
                        $out .= '
                        </p>
                        <div class="autor-text">'.$autor['text'].'</div>
                    </div>
                </div>';
                }
            }
            $out .= "</section>";
            return $out;

            endif;
        endif;
    endif;
}

add_shortcode( 'autors', 'autors' );                        // Шорткод вывода авторов
