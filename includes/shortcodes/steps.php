<?php // Шорткод вывода шагов
function steps(){
    if(!is_admin()):

        global $post;

        $steps = get_field('steps', $post->ID);
        
        if(!empty($steps)):
            $args_array = func_get_args();
            $out = '<section class="container steps">
                        <div class="row">';
            $title = !empty($args_array[0]['title']) ? $args_array[0]['title'] : '';
            if($title != ''){
                $out .= '<h2 class="col-12 title-line" data-anchor="'.$title .'">'.$title .'</h2>';
            }
            $out .= '</div><div class="row">';

            foreach($steps as $step):
                $out .= '<div class="col-lg-3 col-md-6 d-flex">
                            <div class="steps-item d-flex flex-column">
                                <p class="steps-item-title">'.$step['title'].'</p>
                                <p class="text">'.$step['text'].'</p>
                                <div class="steps-item-img" style="background-image: url('.$step['image'].');"></div>
                            </div>
                        </div>';
            endforeach;

            $out .= '</div>
                </section>';
            
            return $out;
        endif;

    endif;
}

add_shortcode( 'steps', 'steps' );                              // Шорткод вывода шагов