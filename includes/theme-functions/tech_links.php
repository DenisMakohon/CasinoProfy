<?php
function get_tech_link($item){
    $inner_link_info = get_field('inner_link_info', $item);

    $inner_link_title = isset($inner_link_info['title']) && !empty($inner_link_info['title']) ? $inner_link_info['title'] : $item->post_title;
    $inner_link_img = IMG_URL."yes.svg";
    $image_class = "check-icon";

    $image_src = wp_get_attachment_image_src($inner_link_info['image'], 'image-tiny');
    
    if ($image_src) {
        $inner_link_img = $image_src[0];
    }else if(isset($inner_link_info['image']) && !empty($inner_link_info['image'])){
        $inner_link_img = $inner_link_info['image'];
        $image_class = "";
    }
    return array(
        'link' => get_permalink($item),
        'title' => $inner_link_title,
        'img' => $inner_link_img,
        'class' => $image_class
    );           
}