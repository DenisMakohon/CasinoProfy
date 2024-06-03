<?php

// Скрытие контента

global $hide_content,$content;

$GLOBALS['hide_content'] = get_option('content'); 

$GLOBALS["content"] = isset($GLOBALS['hide_content']['hide']) ? $GLOBALS['hide_content']['hide'] : "";

// END Скрытие контента

// Выводим шорткоды
function shortcodes_only($content){

    // Получаем шорткоды и добавляем 'additionalText'    
    $shortcodes = $GLOBALS['hide_content']['shortcodes'] ?? []; 
    $shortcodes[] = "additionalText"; // Добавляем 'additionalText' в список шорткодов
 
    $pattern = get_shortcode_regex($shortcodes);    
    preg_match_all('/'.$pattern.'/s', $content, $matches);

    // Проверяем, есть ли шорткоды
    if (is_array($matches) && array_key_exists(2, $matches)) {
        $new_content = '';
        foreach ($matches[2] as $index => $shortcode) {
            if (in_array($shortcode, $shortcodes)) {
                // Добавляем шорткод в новый контент, если он есть в списке допустимых шорткодов
                $new_content .= $matches[0][$index];
            }
        }
        return $new_content;
    }

    // Возвращаем исходный контент, если шорткодов нет
    return '';
}


/**
 * Фильтр для изменения SEO заголовка с помощью Yoast SEO.
 */
function custom_yoast_seo_title($title) {
    // Ваша логика для изменения $title
    // Например, изменить заголовок для определенной страницы:
    global $post;

    $new_title = get_field('custom_y_title', $post->ID);

    if ($new_title && $GLOBALS['hide_content']['title_meta'] == "custom") {
        $title = $new_title;
    }elseif ($GLOBALS['hide_content']['title_meta'] == "title"){
        $title = $post->post_title;
    }

    return $title;
}

/**
 * Фильтр для изменения SEO описания с помощью Yoast SEO.
 */
function custom_yoast_seo_description($description) {
    // Ваша логика для изменения $description
    // Например, изменить описание для определенной категории:
    global $post;

    $new_description = get_field('custom_y_description', $post->ID);
    
    if ($new_description && isset($GLOBALS['hide_content']['title_meta']) && $GLOBALS['hide_content']['title_meta'] == "custom" && !empty($new_description) ) {
        $description = $new_description;
    }elseif (isset($GLOBALS['hide_content']['title_meta']) && $GLOBALS['hide_content']['title_meta'] == "title"){
        $description = $post->post_title;
    }
        
    return $description;
}

function custom_modify_title($title, $id = null) {
    // Пример: добавление префикса к заголовку для определенной категории постов
    global $post;
    if(is_a($post, 'WP_Post') && $id === $post->ID){
        $new_title = get_field('custom_title', $id);
        if ($new_title && isset($GLOBALS['hide_content']['title_meta']) && $GLOBALS['hide_content']['title_meta'] == "custom") {
            $title = $new_title;
        }elseif (isset($GLOBALS['hide_content']['title_meta']) && $GLOBALS['hide_content']['title_meta'] == "title"){
            $title = $post->post_title;
        }
    }

    return $title;
}

function remove_title_filter_nav_menu( $nav_menu, $args ) {
    // we are working with menu, so remove the title filter
    remove_filter( 'the_title', 'custom_modify_title', 10, 2 );
    return $nav_menu;
}

function title_filter_non_menu( $items, $args ) {
    // we are done working with menu, so add the title filter back
    add_filter( 'the_title', 'custom_modify_title', 10, 2 );
    return $items;
}

if($GLOBALS["content"] && !is_404()){
    add_filter('pre_wp_nav_menu', 'remove_title_filter_nav_menu', 10, 2 );
    // this filter fires after nav menu item creation is done
    add_filter('wp_nav_menu_items', 'title_filter_non_menu', 10, 2 );
    add_filter('the_content', 'shortcodes_only');
}

if(isset($GLOBALS['hide_content']['title_meta'])){
    add_filter('the_title', 'custom_modify_title', 10, 2);
    add_filter('wpseo_title', 'custom_yoast_seo_title');
    add_filter('wpseo_metadesc', 'custom_yoast_seo_description');
}
