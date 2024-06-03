<?php // Шорткод слайдера преимуществ игр 
function gameFeauters(){
    if(!is_admin()):
        global $post;
    
        $gameFeatures = get_field('game_features', $post->ID);
            if(!empty($gameFeatures)){
            $args_array = func_get_args();

            $title = !empty($args_array[0]['title']) ? $args_array[0]['title'] : '';

            $titleHTML = '';
            
            if($title != '') $titleHTML .= '<h2 class="col-12 title-line" data-anchor="'.$title.'">'.$title.'</h2>';

            $out = '<section class="container gameFeauters bonusSlider">
                    <div class="row">
                        '.$titleHTML.'
                        <div class="col-12 js-bonusSliderControl bonusSlider-control d-flex align-items-md-end align-items-center justify-content-center flex-md-row flex-column">';

            foreach($gameFeatures as $features){
                $activeSlide = reset($gameFeatures) == $features ? "active" : "";
                $out .= '<div class="control-title '. $activeSlide .'">'.$features['title'].'</div>';
            }

            $out .= '</div></div>
                <div class="js-bonusSlider">';
                    foreach($gameFeatures as $features){
                        $out .= '
                        <div class="bonusSlider-item d-flex flex-wrap align-items-start">
                            <p class="bonusSlider-title">'.$features['title'].'</p>
                            <div class="text">
                                '.$features['text'].'
                            </div>
                        </div>';
                    }
            $out .='</div>
                </section>';
            
            wp_reset_postdata();      

            return $out;
        }
    endif;
}

add_shortcode( 'game-features', 'gameFeauters' );               // Шорткод слайдера преимуществ игр