<?php


// Убираем лишнее

// определение страницы логина
function is_login_page() {
    return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
}
function wp_deregister_styles() {
    wp_deregister_style( 'crp-style-rounded-thumbs' );
    if ( !is_admin() && !is_login_page() )  {
        wp_dequeue_script( 'jquery');
        wp_deregister_script( 'jquery');
    }
}

// END Убираем лишнее

// Регистрация скриптов и стилей

function mihdan_add_async_attribute( $tag, $handle ) {
    if ( 'my-js-handle' !== $handle ) {
        return $tag;
    }
 
    return str_replace( ' src', ' defer="defer" src', $tag );
}

function remove_block_css() {
    // wp_dequeue_style( 'wp-block-library' ); // WordPress core
    // wp_dequeue_style( 'wp-block-library-theme' ); // WordPress core
    // wp_dequeue_style( 'wc-block-style' ); // WooCommerce
    // wp_dequeue_style( 'storefront-gutenberg-blocks' ); // Storefront theme
}

function scripts_and_styles(){

    $stylesScriptsVersion = "?v=1";
    wp_dequeue_style('contextual-related-posts');

    global $wp_styles;
    // В зависимости от страницы подключаем нужный файл стилей (для того, что бы не грузить лишнее + что бы гугл не сильно ругался).
    // Если что то тут меняете, 100 раз проверьте!!! 
    
    if (is_page_template('main-page.php')) {                                                // Главная страница
        wp_enqueue_script('main_script', SCRIPT_URL . "main-page.min.js"); 
        wp_enqueue_style('main_page_style', STYLE_URL . "main-page.min.css");
    } else if (is_page_template('casinos.php')) {                                           // Страница казино
        wp_enqueue_script('casino_script', SCRIPT_URL . "casino-page.min.js"); 
        wp_enqueue_style('casino_page_style', STYLE_URL . "casino.min.css");       
    } else if (is_singular('games')) {                                                      // Страница игры
        wp_enqueue_script('games_script', SCRIPT_URL . "games-page.min.js"); 
        wp_enqueue_style('games_page_style', STYLE_URL . "games.min.css");       
    } else if (is_page_template('bonus.php')) {                                             // Страница бонуса
        wp_enqueue_script('bonus_script', SCRIPT_URL . "bonus-page.min.js"); 
        wp_enqueue_style('bonus_page_style', STYLE_URL . "bonus.min.css");       
    } else if (is_page_template('casinocat.php')) {                                         // Страница категории казино
        wp_enqueue_script('casino-category', SCRIPT_URL . "casino-category.min.js"); 
        wp_enqueue_style('casino-category_style', STYLE_URL . "casino-category.min.css");
    } else if (is_page_template('gamecat.php')) {                                           // Страница категории игры
        wp_enqueue_script('game-category', SCRIPT_URL . "game-category.min.js"); 
        wp_enqueue_style('game-category_style', STYLE_URL . "game-category.min.css");
    } else if (is_page_template('choice-language.php')) {                                   // Страница выбора языка
        wp_enqueue_style('choiceLanguage', STYLE_URL . "choiceLanguage.min.css");       
    } else if (is_page_template('blog.php')) {                                              // Страница блога
        wp_enqueue_script('blog', SCRIPT_URL . "blog.min.js");
        wp_enqueue_style('blog_style', STYLE_URL . "blog.min.css");
    } else if (is_singular('providers')) {                                                  // Страница провайдера
        wp_enqueue_script('providers', SCRIPT_URL . "providers.min.js"); 
        wp_enqueue_style('providers_style', STYLE_URL . "providers.min.css");
    } else if (is_page_template('providers.php')) {                                         // Страница всех провайдеров
        wp_enqueue_script('providers-main', SCRIPT_URL . "providers-main.min.js"); 
        wp_enqueue_style('providers-main_style', STYLE_URL . "providers-main.min.css");       
    } else if (is_singular('blank')) {                                                      // Пустая страница без весаf
        wp_enqueue_script('blank', SCRIPT_URL . "blank.min.js"); 
        wp_enqueue_style('blank_style', STYLE_URL . "blank.min.css");       
    } else if (is_single() || is_page()) {                                                  // Страница поста
        wp_enqueue_script('post', SCRIPT_URL . "post.min.js"); 
        wp_enqueue_style('post_style', STYLE_URL . "post.min.css");
    } else if (is_404()) {                                                                  // Страница 404
        wp_enqueue_script('404', SCRIPT_URL . "app.min.js"); 
        wp_enqueue_style('404_style', STYLE_URL . "404.min.css");       
    } else if (is_page_template('sitemap.php')) {                                           // Страница Sitemap
        wp_enqueue_script('sitemap', SCRIPT_URL . "app.min.js"); 
        wp_enqueue_style('sitemap_style', STYLE_URL . "sitemap.min.css");       
    } else{                                                                                 // На всякий случай
        wp_enqueue_script('app', SCRIPT_URL . "app.min.js"); 
        wp_enqueue_style('base_style', STYLE_URL . "base.min.css"); 
    }    
}

// END Регистрация скриптов и стилей

add_filter('script_loader_tag', 'mihdan_add_async_attribute', 10, 2 );
add_action( 'wp_enqueue_scripts', 'remove_block_css', 100 );
add_action('wp_footer', 'scripts_and_styles');
add_action('wp_head', 'wp_deregister_styles');
add_action('wp_print_styles', 'wp_deregister_styles', 100);