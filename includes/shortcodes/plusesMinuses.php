<?php // Шорткод плюсов и минусов 
function plusesMinuses(){
    if(!is_admin()):

        global $post;
    
        $plusesMinuses = get_field('pluses_minuses', $post->ID);

        $out = '<section class="container plusesMinuses">
                    <div class="row">';

        if(!empty($plusesMinuses['pluses'])){
            $out .= '<div class="col-md-6">
                        <div class="pluses plusesMinuses-item">';

            if(!empty($plusesMinuses['title_pluses'])){

                $out .= '<h3 class="plusesMinuses-title">'.$plusesMinuses['title_pluses'].'</h3>';

            }

            $out .='<ul class="simpleList plusesMinuses-simpleList--pluses">';

            foreach($plusesMinuses['pluses'] as $pluses){
                $out .= '<li>'."<strong>".$pluses['title_item']."</strong> ".$pluses['text'].'</li>';
            }
            $out .= '</ul>
                </div>
            </div>';
        }

        if(!empty($plusesMinuses['minuses'])){
            $out .= '<div class="col-md-6">
                        <div class="minuses plusesMinuses-item">';
            if(!empty($plusesMinuses['title_minuses'])){

                $out .= '<h3 class="plusesMinuses-title">'.$plusesMinuses['title_minuses'].'</h3>';

            }

            $out .='<ul class="simpleList plusesMinuses-simpleList--minuses">';

            foreach($plusesMinuses['minuses'] as $pluses){
                $out .= '<li>'."<strong>".$pluses['title_item']."</strong> ".$pluses['text'].'</li>';
            }
            $out .= '</ul>
                </div>
            </div>';
        }
    
        $out .= '</div>
            </section>';

        return $out;

    endif;
}
add_shortcode( 'pluses-minuses', 'plusesMinuses' );             // Шорткод плюсов и минусов