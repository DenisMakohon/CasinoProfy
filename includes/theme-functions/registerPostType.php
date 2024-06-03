<?php

// Кастомные типы постов

$post_types_list = array(
    'games',
    'providers',
    'blank'
);

function register_custom_post_types() {

    // Конфигурация каждого типа
    $post_types = array(
        'games' => array(
            "labels" => array(
                'name'               => 'Слоты',
                'singular_name'      => 'Слот',
                'add_new'            => 'Добавить новый',
                'add_new_item'       => 'Добавить новый слот',
                'edit_item'          => 'Редактировать слот',
                'new_item'           => 'Новый слот',
                'view_item'          => 'Просмотреть слот',
                'search_items'       => 'Найти слот',
                'menu_name'          => 'Слоты',
                'not_found'          => 'Слот не найден',
                'not_found_in_trash' => 'Слот не найден в корзине',
                'parent_item_colon'  => 'Родительский ' . ucwords( str_replace( '_', ' ', 'games' ) ) . ':'
            ),
            'menu_icon'          => 'games_icon.png',
            'capability_type'    => 'games_page'        
        ),
        'providers' => array(
            "labels" => array(
                'name'               => 'Провайдеры',
                'singular_name'      => 'Провайдер', 
                'add_new'            => 'Добавить нового',
                'add_new_item'       => 'Добавить нового провайдера',
                'edit_item'          => 'Редактировать провайдера',
                'new_item'           => 'Новый провайдер',
                'view_item'          => 'Посмотреть провайдера',
                'search_items'       => 'Найти провайдера',
                'menu_name'          => 'Провайдеры',
                'not_found'          => 'Провайдер не найден',
                'not_found_in_trash' => 'Провайдер не найден в корзине',
                'parent_item_colon'  => 'Родительский ' . ucwords( str_replace( '_', ' ', 'providers' ) ) . ':'
            ),
            'menu_icon'          => 'providers_icon.png',
            'capability_type'    => 'providers_page',
        ),
        'blank' => array(
            "labels" => array(
                'name'               => 'Страницы без веса',
                'singular_name'      => 'Страницы без веса', 
                'add_new'            => 'Добавить новую',
                'add_new_item'       => 'Добавить новую страницу',
                'edit_item'          => 'Редактировать страницу',
                'new_item'           => 'Новая страница',
                'view_item'          => 'Посмотреть страницу',
                'search_items'       => 'Найти страницу',
                'menu_name'          => 'Страницы без веса',
                'not_found'          => 'Страницы без веса не найдено',
                'not_found_in_trash' => 'Страницы без веса не найдено в корзине',
                'parent_item_colon'  => 'Родительская ' . ucwords( str_replace( '_', ' ', 'blank' ) ) . ':'
            ),
            'menu_icon'          => 'blank_icon.png',
            'capability_type'    => 'blank_page',
        )
    );

    // Список функционпла
    $supports = array(
        'title',
        'editor',
        'excerpt',
        'author',
        'thumbnail',
        'revisions',
        'custom-fields',
        'show_in_rest',
        'template',                 
        'page-attributes',
        'category'
    );

    // 
    foreach ( $post_types as $post_type => $post_type_set ) {
        $labels = $post_type_set['labels'];

        $args = array(
            'labels'              => $labels,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'query_var'           => true,
            'rewrite'             =>  array( 
                'slug' => '%pagetype%',
                'with_front' => false
            ),
            'has_archive'         => false,
            'hierarchical'        => true,
            'menu_position'       => 5,
            'supports'            => $supports,
            'show_in_rest'        => true,
            'rest_base'           => $post_type,
            'menu_icon'           => IMG_URL.$post_type_set['menu_icon'],
            'capability_type'      => 'post',
            'rest_controller_class' => 'WP_REST_Posts_Controller',
            'taxonomies'         => array('category')
        );
        
        register_post_type( $post_type, $args );
    }
}

// END Кастомные типы постов

// Убираем слаг типа поста с URL адреса

function na_remove_slug( $post_link, $post, $leavename ) {

    if ( 'providers' != $post->post_type && 
        'games' != $post->post_type && 
        'blank' != $post->post_type &&        
        '%pagetype%' != $post->post_type || 'publish' != $post->post_status) {
        return $post_link;
    }

    $post_link = str_replace( '/' . $post->post_type . '/', '/', $post_link );

    return $post_link;
}

function na_parse_request( $query ) {

    if ( ! $query->is_main_query() || 2 != count( $query->query ) || ! isset( $query->query['page'] ) ) {
        return;
    }

    if ( ! empty( $query->query['name'] ) ) {
        $query->set( 'post_type', array( 'post', 'page', 'games', 'providers', 'blank','%pagetype%' ) );
    }
}

function changePermalinks($permalink, $post) {
    if ( strpos($permalink, '/%pagetype%') ) return str_replace('/%pagetype%', '', $permalink);
    return $permalink;
}

// END Убираем слаг типа поста с URL адреса

add_action( 'init', 'register_custom_post_types' );                     // Кастомные типы постов

// Убираем слаг типа поста с URL адреса
add_filter( 'post_link', 'changePermalinks', 10, 3);
add_filter( 'page_link', 'changePermalinks', 10, 3);
add_filter( 'post_type_link', 'changePermalinks', 10, 3);
add_filter( 'category_link', 'changePermalinks', 11, 3);
add_filter( 'tag_link', 'changePermalinks', 10, 3);
add_filter( 'author_link', 'changePermalinks', 11, 3);
add_filter( 'day_link', 'changePermalinks', 11, 3);
add_filter( 'month_link', 'changePermalinks', 11, 3);
add_filter( 'year_link', 'changePermalinks', 11, 3);
add_action('pre_get_posts', 'na_parse_request');
add_filter('post_type_link', 'na_remove_slug', 10, 3 );
// END Убираем слаг типа поста с URL адреса

flush_rewrite_rules();