<?php // Шорткод "вещей"
function things(){
    if(!is_admin()):

        global $post;
    
        $things = get_field('things', $post->ID);
        $args_array = func_get_args();

        $title = !empty($args_array[0]['title']) ? $args_array[0]['title'] : '';
    
        $titleHTML = '';
        if($title != '') $titleHTML .= '<div class="row"><h2 class="title-line">'.$title.'</h2></div>';
        
        $out = '<section class="container things">
                    '.$titleHTML.'
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <img src="'.IMG_URL.'things-maskot.svg" class="things-img" alt="things maskot image" width="238" height="556">
                        </div>
                        <div class="col-md-8">
                            <ul class="things-list d-flex flex-column">';

        if(!empty($things)):
            
            foreach($things as $thing):
                $out .= '<li class="things-item">
                            <div class="things-item-content">
                                <p class="things-item-title">'.$thing['title'].'</p>
                                <p class="text">'.$thing['text'].'</p>
                            </div>
                        </li>';
            endforeach;

            $out .= '   </ul>
                    </div>
                </div>
            </section>';
        endif;
    return $out;
    endif;
}
add_shortcode( 'things', 'things' );                            // Шорткод "вещей"