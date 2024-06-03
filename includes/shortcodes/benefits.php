<?php // Шорткод вывода преимуществ
function benefits(){
    if(!is_admin()):

    global $post;

    $args_array = func_get_args();

    
    $benefits = get_field('benefits', $post->ID);
    $benefits = array_chunk($benefits, ceil(count($benefits) / 2));

    $out = '
        <div class="benefits">
            <div class="row">
    ';
    $title = !empty($args_array[0]['title']) ? $args_array[0]['title'] : '';
    if($title != ''){
        $out .= '<h2 class="col-12 title-block" data-anchor="'.$title.'">'.$title.'</h2>';
    }
    $out .= '<div class="benefits-list benefits-list-left col-md-4">';

    foreach($benefits[0] as $benefit){
        
        $mark = '<picture>
                <img src="'.IMG_URL.'benefits-icon.svg" alt="benefits icon" width="60" height="63">
            <picture>';

        if(isset($benefit['mark']) && $benefit['mark']){
            $mark = '<picture>
                <source media="(max-width: 767px)" srcset="'.wp_get_attachment_image_src($benefit['mark'], 'benef-marks-sm')[0].'">
                <img src="'.wp_get_attachment_image_src( $benefit['mark'], 'benef-marks' )[0].'" alt="benefits icon" width="60" height="63">
            <picture>';
        } 
        $out .= '            
            <div class="benefits-item d-flex" id="#'.strtolower(str_replace(" ", "_", $benefit['title'])).'">
                <div class="benefits-icon">'.
                    $mark
                .'</div>
                <div class="benefits-content">
                    <p class="benefits-title">'.$benefit['title'].'</p>
                    <p class="text">'.$benefit['text'].'</p>
                </div>
            </div>
        ';
    }

    $out .= '
        </div>
        <div class="benefits-img text-center col-md-4">
            <img src="'.IMG_URL.'maskot-benefits.svg" alt="maskot benefits image" width="334" height="519">
        </div>
        <div class="benefits-list benefits-list-right col-md-4">
    ';

    foreach($benefits[1] as $benefit){
        $mark = '<picture>
                <img src="'.IMG_URL.'benefits-icon.svg" alt="benefits icon" width="60" height="63">
            <picture>';

            if(isset($benefit['mark']) && $benefit['mark']){
            $mark = '<picture>
                <source media="(max-width: 767px)" srcset="'.wp_get_attachment_image_src($benefit['mark'], 'benef-marks-sm')[0].'">
                <img src="'.wp_get_attachment_image_src( $benefit['mark'], 'benef-marks' )[0].'" alt="benefits icon" width="60" height="63">
            <picture>';
        } 

        $out .= '            
            <div class="benefits-item d-flex">
                <div class="benefits-icon">'.
                    $mark 
                .'</div>
                <div class="benefits-content">
                    <p class="benefits-title">'.$benefit['title'].'</p>
                    <p class="text">'.$benefit['text'].'</p>
                </div>
            </div>
        ';
    }

    $out .= '</div></div></div>';

    return $out;
    
    endif;

}
add_shortcode( 'benefits', 'benefits' );                        // Шорткод вывода преимуществ