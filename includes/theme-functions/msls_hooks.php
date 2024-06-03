<?php

function langSwitch(){
    global $post;
    $out = '';
    if(!empty($post->post_name)){
        global $wp;

        // Дополнительные альтернейты
        $alternates = get_field('alternate');
        $alternates_resault = [];
        if($alternates){
            
            foreach ($alternates as $item) {
                if(home_url( $wp->request )."/" !== $item['url']){
                    $alternates_resault[substr($item['hreflang'], strlen($item['hreflang']) -2 , 2) ] = $item['url'];
                }
            }
            
            if($alternates_resault){
                $out = '<ul class="language-list js-languageList d-flex flex-column">';
                
                foreach($alternates_resault as $hreflang => $href){
                    
                    $out .= '
                    <li>
                        <a target="_blank" href="'.$href.'">
                            <img decoding="async" src="'.IMG_URL.'langSwitcher/'.strtoupper($hreflang).'.svg" alt="'.strtoupper($hreflang).'">
                        </a>
                    </li>';
    
                }
                $out .= '</ul>';

            }
        }
    }

    return $out;
}