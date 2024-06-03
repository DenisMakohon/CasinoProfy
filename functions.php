<?php
/**
 * Intentionally Blank Theme functions
 *
 * @package WordPress
 * @subpackage intentionally-blank
 */

use function PHPSTORM_META\type;

include 'includes/MyDebug.php';                             // Дебаг. Исползование: d(переменная);
function d($value, $die = false){ // Инициализация дебага
    MyDebug::dump($value, $die);
}

if (!session_id()) {
    session_start();
}

define('IMG_URL', get_stylesheet_directory_uri() . "/static/images/");
define('STYLE_URL', get_stylesheet_directory_uri() . "/static/css/");
define('SCRIPT_URL', get_stylesheet_directory_uri() . "/static/js/");
define('OCP_TEMPLATE_DIRECTORY', get_template_directory() );

global $current_url, $currentLang, $user_location, $currency, $translations_page, $recaptcha, $isGoogleBot;

$protocol = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
$GLOBALS['current_url'] = $protocol.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; 
$GLOBALS['domain_url'] = $protocol.$_SERVER['HTTP_HOST']; 
$GLOBALS['isGoogleBot'] = strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "googlebot") !== false; // В вашем PHP скрипте, который отвечает за генерацию HTML или начальный JS

$lang_settings_def = array('html' => 'en', 'hreflang' => 'en', 'hreflang_title' => '' );

if(isset($lang_settings) && $lang_settings === false) $lang_settings = $lang_settings_def;

$GLOBALS['translations_page'] = get_option('translations_site');
$GLOBALS['recaptcha'] = get_option('recaptcha');

$GLOBALS['currency'] = get_option('currency');
// END Определение страны юзера
// Функционал темы
include 'includes/themeOptions.php';                        // Страница дополнительных настроек
include 'includes/translations.php';                        // Файл с переводами всех статических текстов

include 'includes/theme-functions/yoast_seo.php';           // Хуки плагина YoastSeo Генерация hreflang и canonical
include 'includes/theme-functions/menu.php';                // Кастомизация меню
include 'includes/theme-functions/ajax_functions.php';      // Ajax функционал
include 'includes/theme-functions/msls_hooks.php';          // Хуки вывода вёрстки для выюора языка
include 'includes/theme-functions/custom_metabox.php';      // Кастомные метабоксы
include 'includes/theme-functions/registerPostType.php';    // Регистрация новых типов постов
include 'includes/theme-functions/scriptsStyles.php';       // Регистрация стилей и скриптов
include 'includes/theme-functions/tech_links.php';          // Хункции для работы с "техничкими" линками казино
include 'includes/theme-functions/comments_edit.php';       // Комментарии
include 'includes/theme-functions/hide_content.php';        // Скрытие контента

// END Функционал темы

// ШОРТКОДЫ
include 'includes/shortcodes/casinoGames.php';              // Шорткод для вывода типов игр казино
include 'includes/shortcodes/casinoContacts.php';           // Шорткод для вывода контактов казино 
include 'includes/shortcodes/moreGames.php';                // Шорткод для вывода игр
include 'includes/shortcodes/demoGame.php';                 // Шорткод для вывода игры
include 'includes/shortcodes/fourProviders.php';            // Шорткод для вывода провайдеров и оплат
include 'includes/shortcodes/topFourCasinos.php';           // Шорткод для вывода казино
include 'includes/shortcodes/topTenCasinosBonus.php';       // Шорткод для вывода казино на странице бонусов 
include 'includes/shortcodes/topTenCasinos.php';            // Шорткод для вывода казино
include 'includes/shortcodes/contains.php';                 // Шорткод автогенерации сорержания
include 'includes/shortcodes/steps.php';                    // Шорткод вывода шагов
include 'includes/shortcodes/things.php';                   // Шорткод "вещей" 
include 'includes/shortcodes/gameTypes.php';                // Шорткод категорий игр
include 'includes/shortcodes/gameTable.php';                // Шорткод таблицы игр 
include 'includes/shortcodes/gameFeauters.php';             // Шорткод слайдера преимуществ игр 
include 'includes/shortcodes/plusesMinuses.php';            // Шорткод плюсов и минусов 
include 'includes/shortcodes/benefits.php';                 // Шорткод вывода преимуществ 
include 'includes/shortcodes/autors.php';                   // Шорткод вывода авторов
include 'includes/shortcodes/casino_filter.php';            // Шорткод фильтра казино
include 'includes/shortcodes/faq.php';                      // Шорткод вывода FAQ в табах казино
include 'includes/shortcodes/bonusSlider.php';              // Шорткод вывода bonus-slider в табах казино
include 'includes/shortcodes/additionText.php';              // Шорткод вывода bonus-slider в табах казино

// END ШОРТКОДЫ

$lang_settings = get_option('lang');

if(get_locale() == "pl_PL") {
    $GLOBALS['currentLang'] = "pl";
}else if(get_locale() == "uk"){
    $GLOBALS['currentLang'] = "ua";
}else if(get_locale() == "en_GB"){
    $GLOBALS['currentLang'] = "en";
}else if(get_locale() == "de_DE"){
    $GLOBALS['currentLang'] = "de";
}else if(get_locale() == "es_ES"){
    $GLOBALS['currentLang'] = "es";
}else{
    $GLOBALS['currentLang'] = get_locale();
}

// Кеш для шорткода TOP10

function generate_cache_key($shortcode, $args) {
    return $shortcode . 'Cache_' . md5(serialize($args));
}

function add_cache_key($shortcode, $key) {
    $cacheKey = $shortcode . '_keys';
    $allKeys = get_transient($cacheKey);
    if (false === $allKeys) {
        $allKeys = [];
    }
    $allKeys[$key] = true;
    set_transient($cacheKey, $allKeys, 30 * DAY_IN_SECONDS);
}

function clear_cache_for_shortcode($shortcode) {
    $cacheKey = $shortcode . '_keys';
    $allKeys = get_transient($cacheKey);
    if (false !== $allKeys) {
        foreach (array_keys($allKeys) as $key) {
            delete_transient($key);
        }
    }
    delete_transient($cacheKey);
}

function clear_all_caches() {
    clear_cache_for_shortcode('topTenCasinos');
    clear_cache_for_shortcode('topTenCasinosBonus');
    clear_cache_for_shortcode('topFourCasinos');
}
add_action('save_post', 'clear_all_caches');
/**
 * Extend WordPress search to include custom fields
 *
 * https://adambalee.com
 */

/**
 * Join posts and postmeta tables
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_join
 */
function cf_search_join( $join ) {
    global $wpdb;

    if ( is_search() ) {    
        $join .=' LEFT JOIN '.$wpdb->postmeta. ' ON '. $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
    }

    return $join;
}
// add_filter('posts_join', 'cf_search_join' );

/**
 * Modify the search query with posts_where
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_where
 */
function cf_search_where( $where ) {
    global $pagenow, $wpdb;

    if ( is_search() ) {
        $where = preg_replace(
            "/\(\s*".$wpdb->posts.".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
            "(".$wpdb->posts.".post_title LIKE $1) OR (".$wpdb->postmeta.".meta_value LIKE $1)", $where );
    }

    return $where;
}
// add_filter( 'posts_where', 'cf_search_where' );
function get_image_id_by_url($image_url) {
    global $wpdb;

    // Получение префикса таблицы для текущего сайта
    $table_prefix = $wpdb->get_blog_prefix();
    $sql = $wpdb->prepare("SELECT ID FROM " . $table_prefix . "posts WHERE guid='%s';", $image_url);
    
    $attachment_id = $wpdb->get_var($sql);
    return $attachment_id ? $attachment_id : null;
}

/**
 * Prevent duplicates
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_distinct
 */

function cf_search_distinct( $where ) {
    global $wpdb;

    if ( is_search() ) {
        return "DISTINCT";
    }

    return $where;
}

// --------------------------------------------------------------------------
// Start Modify Editor Width
// --------------------------------------------------------------------------
    function admin_style() {
      wp_enqueue_style('admin-styles', get_stylesheet_directory_uri() . '/admin.css');
    }
    add_action('admin_enqueue_scripts', 'admin_style');
// --------------------------------------------------------------------------
// End Modify Editor Width
// --------------------------------------------------------------------------
 
function my_single_template($single) {
    global $wp_query, $post;
    foreach((array)get_the_category() as $cat) {
        if(file_exists(OCP_TEMPLATE_DIRECTORY . '/single-' . $cat->slug . '.php')) {
            return OCP_TEMPLATE_DIRECTORY . '/single-' . $cat->slug . '.php';
        } elseif(file_exists('/single-' . $cat->term_id . '.php')) {
            return OCP_TEMPLATE_DIRECTORY . '/single-' . $cat->term_id . '.php';
        }
    }
    return $single;
}

function plashka_enqueue_admin_script( $hook_suffix ) {
    // Убедитесь, что скрипты и стили подключаются только на странице редактирования страницы
    if ( 'post.php' !== $hook_suffix && 'post-new.php' !== $hook_suffix ) {
        return;
    }

    // Подключение JavaScript
    wp_enqueue_script( 'plashka-admin-script', get_template_directory_uri() . '/admin-script.js', array( 'wp-blocks', 'wp-dom-ready', 'wp-edit-post' ) );

    // Подключение CSS
    wp_enqueue_style( 'plashka-admin-style', get_template_directory_uri() . '/style.css' );
}
add_action( 'admin_enqueue_scripts', 'plashka_enqueue_admin_script' );


if (!function_exists('casinoprofy_setup')) :
    /**
     * Sets up theme defaults and registers the various WordPress features that
     * this theme supports.
     */
    function casinoprofy_setup() {
        set_post_thumbnail_size(400, 400, true);
        add_image_size( 'image-xmd', 100, 100, true );
        add_image_size( 'image-mini', 32, 32, true );
        add_image_size( 'image-tiny', 0, 27, true );
        add_image_size( 'image-md', 85, 85, true );
        add_image_size( 'benef-marks', 60, 0, true );
        add_image_size( 'benef-marks-sm', 40, 0, true );
        add_image_size( 'image-casino-logo-mob', 44, 44, true );
        load_theme_textdomain('intentionally-blank');
        add_theme_support('automatic-feed-links');
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        add_theme_support('menus');
        register_nav_menus(array(
            'Main_menu'   => 'Верхнее меню',
            'Footer_menu' => 'Меню в футере',
            'Social_menu' => 'Соцсети',
        ));
        add_theme_support(
            'html5',
            array(
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
                'script',
                'style',
            )
        );
        add_theme_support( 'align-wide' );
        // This theme allows users to set a custom background.
        add_theme_support('custom-background', apply_filters('intentionally_blank_custom_background_args', array(
            'default-color' => 'f5f5f5',
        )));
        
        add_theme_support('custom-logo');
        add_theme_support('custom-logo', array(
            'height'      => 256,
            'width'       => 256,
            'flex-height' => true,
            'flex-width'  => true,
            'header-text' => array('site-title', 'site-description'),
        ));

        /**
         * Sets up theme defaults and registers the various WordPress features that
         * this theme supports.
         */
        function blank_custom_logo(){
            if (function_exists('the_custom_logo')) {
                the_custom_logo();
            }
        }

    }
    add_action( 'setup_theme', 'action_function_name_4911' );
    function action_function_name_4911(){
        global $wpdb;

        $table_name = $wpdb->base_prefix . "casinoprofy_emails";
		if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
			
			$sql = "CREATE TABLE " . $table_name . " (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				email tinytext NOT NULL,
				date datetime NOT NULL,
				ip tinytext NOT NULL,
				page tinytext NOT NULL,
				UNIQUE KEY id (id)
			);";

			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);
		}
    }
endif; // end function_exists casinoprofy_setup.

do_action( 'setup_theme' );

function new_excerpt_length($length) {
    return 20;
}

function theme_slug_filter_wp_title( $title ) {
    if ( is_404() ) {
        $title = 'Page not found! - Diceus';
    }
    // You can do other filtering here, or
    // just return $title
    return $title;
}

function get_custom_size_image_url($original_url, $custom_size_name) {
    // Получаем ID вложения на основе URL
    $attachment_id = attachment_url_to_postid($original_url);

    // Если не удалось найти ID вложения, возвращаем оригинальный URL
    if (!$attachment_id) {
        return $original_url;
    }

    // Получаем URL изображения с кастомным размером
    $image_src = wp_get_attachment_image_src($attachment_id, $custom_size_name);

    // Если URL с кастомным размером существует, возвращаем его
    if ($image_src && isset($image_src[0])) {
        return $image_src[0];
    }

    // В противном случае возвращаем оригинальный URL
    return $original_url;
}

/**
 * Search SQL filter for matching against post title only.
 *
 * @link    http://wordpress.stackexchange.com/a/11826/1685
 *
 * @param   string      $search
 * @param   WP_Query    $wp_query
 */
function search_by_title( $search, $wp_query ) {
    if ( ! empty( $search ) && ! empty( $wp_query->query_vars['search_terms'] ) ) {
        global $wpdb;

        $q = $wp_query->query_vars;
        $n = ! empty( $q['exact'] ) ? '' : '%';

        $search = array();

        foreach ( ( array ) $q['search_terms'] as $term )
            $search[] = $wpdb->prepare( "$wpdb->posts.post_title LIKE %s", $n . $wpdb->esc_like( $term ) . $n );

        if ( ! is_user_logged_in() )
            $search[] = "$wpdb->posts.post_password = ''";

        $search = ' AND ' . implode( ' AND ', $search );
    }

    return $search;
}


function my_posts_where( $where ) {
    if(strpos($where,'bonus_block_$') !== false){
        $where = str_replace("meta_key = 'bonus_block_$", "meta_key LIKE 'bonus_block_%", $where);
    }
    if(strpos($where,'payment_methods_$') !== false){
        $where = str_replace("meta_key = 'payment_methods_$", "meta_key LIKE 'payment_methods_%", $where);
    }
    if(strpos($where,'games_types_$') !== false){
        $where = str_replace("meta_key = 'games_types_$", "meta_key LIKE 'games_types_%", $where);
    }
    if(strpos($where,'min_deposit_$') !== false){
        $where = str_replace("meta_key = 'min_deposit_$", "meta_key LIKE 'min_deposit_%", $where);
    }
    return $where;
}

function filterBonus($item){
    return $item['bonus_type']['value'] == $GLOBALS['targetBonus'];
}

function getBlogsList(){
    $sites_list = get_sites( 0, 'all' );
    $sites_path = array();
    
    // Собираем урлы подсайтов
    foreach($sites_list as $site){   
        if(!strripos($site->path, "/ua/")){
            switch_to_blog($site->blog_id); // получаем номер блога для поиска
        
            $home_page = get_post(get_option('page_on_front'));
            $site_url_mass = explode("/", get_site_url($site->blog_id));
            $target_path = $site_url_mass[count($site_url_mass)-1]; 

            if(strlen($target_path) <= 3 && !empty($home_page)) 
                $sites_path[$target_path] = date("Y-m-d H:m:s", strtotime(get_post(get_option('page_on_front'))->post_modified));

            restore_current_blog(); // Возвращаем основной блог
        }        
    }
    return $sites_path;
}

function te_css_replacetag($replacetag) {
    return array("</body>","before");
}

function my_custom_mime_types( $mimes ) {
 
    // New allowed mime types.
    $mimes['svg'] = 'image/svg+xml';
    $mimes['svgz'] = 'image/svg+xml';
    $mimes['doc'] = 'application/msword';
    $mimes['webp'] = 'image/webp';
     
    // Optional. Remove a mime type.
    unset( $mimes['exe'] );
     
    return $mimes;
}

function my_acf_json_load_point( $paths ) {
    
    // remove original path (optional)
    unset($paths[0]);    
    
    // append path
    $paths[] = get_stylesheet_directory() . '/';
    
    // return
    return $paths;

}

function my_acf_json_save_point( $path ) {

    // update path
    $path = get_stylesheet_directory() . '/';

    // return
    return $path;

}

function add_class_next_post_link($html){
    $html = str_replace('<a','<a class="post-next"',$html);
    return $html;
}
function add_class_prev_post_link($html){
    $html = str_replace('<a','<a class="post-prev"',$html);
    return $html;
}

function siteMapListRender($title = "", $list = array()){
    if($title) echo "<h2 class='sitemap-list-title'>".$title."</h2>";

    if(!empty($list)){
        echo "<ul class='sitemap-list'>";
        foreach($list as $item){
            echo "<li><a class='text d-inline-block' href='".get_permalink($item->ID)."' >".get_the_title($item->ID)."</a></li>";
        }
        echo "</ul>";
    }
    wp_reset_postdata();

}


function content_anchors($content){

    $pattern = '/data-anchor="([^"]+)"/';
    preg_match_all($pattern, $content, $h2_anchors);
    
    foreach($h2_anchors[1] as $h2_data){
        $spaces_id = preg_replace('/\s/','-', $h2_data);
        $content = str_replace('data-anchor="'.$h2_data.'"', 'data-anchor="'.$spaces_id .'" id="'.$spaces_id.'"' , $content);
    }
    
    return $content;
}

function welcomeBonus($item){
    return $item['bonus_type']['label'] == "Welcome Bonus";
}

function noDepositBonus($item){
    return $item['bonus_type']['label'] == "No Deposit Bonus";
}

function freeSpins($item){
    return $item['bonus_type']['label'] == "Free Spins";
}

function highRollerBonus($item){
    return $item['bonus_type']['label'] == "High Roller Bonus";
}

function cashBackBonus($item){
    return $item['bonus_type']['label'] == "Cashback Bonus";
}

function reloadBonus($item){
    return $item['bonus_type']['label'] == "Reload Bonus";
}

function SpecialOffer($item){
    return $item['bonus_type']['label'] == "Special Offer";
}

function VIPBonus($item){
    return $item['bonus_type']['label'] == "VIP Bonus";
}

function get_bonus($bonus_slug, $bonus_array){
    if(empty($bonus_slug)) $bonus_slug = "welcome_bonus";
    
    if(gettype($bonus_array) != "array"){
        return [
            "bonus_type" =>[
                "value" => "welcome_bonus",
                "label" => "Welcome Bonus"
            ],
            "text" => "-",
            "short_text" => "-",
            "t_c" => "-",
            "bonus_ref"	=> ""
        ];
    }

    $out = array_values(array_filter($bonus_array, function($el) use ($bonus_slug){
        return $el['bonus_type']['value'] == $bonus_slug;
    }));
    
    if(empty($out)) $out = array_values(array_filter($bonus_array, function($el){
        return $el['bonus_type']['value'] == 'welcome_bonus';
    }));

    return $out[0];
}

function in_array_r($needle, $haystack, $strict = false) {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return $item;
        }
    }

    return false;
}

// Подстановка рефок или якоря для попапа, если казино заблокинровано
function block_casino($fields){
    $pageSettings = $fields;
    
    $casino_block = "#casino_block";
    $is_blocked = false;
    $alt = false;

    // Проверка : заблокированно казино или нет
    if( isset($pageSettings['country_block']) && count($pageSettings['country_block']) ) $is_blocked = true;

    // Если казино не заблокированно, то ставим рефку
    if((isset($pageSettings['ref_link']) && $pageSettings['ref_link']) && $is_blocked === false){
        
        global $post;
        
        // Сиотрим текущую страницу и если для нее есть отдельная рефка, то ставим её
        if( isset($pageSettings['alt_ref']) && $pageSettings['alt_ref'] ) $target_link = in_array_r($post->ID, $pageSettings['alt_ref']);

        if( isset($target_link) && $target_link ){
            $ref_link = $target_link['ref_link'];
            $alt = true;
        }else{
            $ref_link = $pageSettings['ref_link'];
        }

    }else{

        $ref_link = $casino_block;

    }
    
    return array(
        'casino_block' => $is_blocked,
        'ref_link' => $ref_link,
        'alt' => $alt
    );
}

// filter
function providers_where( $where ) {
    $where = str_replace("meta_key = 'providers_$", "meta_key LIKE 'providers_%", $where);
    return $where;
}
function payment_method_where( $where ) {
    $where = str_replace("meta_key = 'payment_methods_$", "meta_key LIKE 'payment_methods_%", $where);
    return $where;
}

add_filter('posts_where', 'providers_where');
add_filter('posts_where', 'payment_method_where');
add_filter('the_content', 'content_anchors');
add_filter('next_post_link','add_class_next_post_link',10,1);
add_filter('previous_post_link','add_class_prev_post_link',10,1);
add_filter('posts_search', 'search_by_title', 10, 2);
add_filter('upload_mimes', 'my_custom_mime_types' );
add_filter('acf/settings/save_json', 'my_acf_json_save_point');
add_filter('acf/settings/load_json', 'my_acf_json_load_point');
add_filter('excerpt_length', 'new_excerpt_length');
add_filter('single_template', 'my_single_template');
add_filter('posts_where', 'my_posts_where');
add_filter('excerpt_more', function($more) {
    return ' ...';
});

remove_filter( 'wp_robots', 'wp_robots_max_image_preview_large' );
remove_filter( 'get_the_excerpt', 'wp_trim_excerpt' );
remove_action( 'template_redirect', 'redirect_canonical' );
remove_action( 'wp_head', 'print_emoji_detection_script', 7);
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'wp_head', [ lloc\Msls\MslsPlugin::class, 'print_alternate_links' ] );

add_action('after_setup_theme', 'casinoprofy_setup');

function change_post_type_for_all_sites() {

    $sites = get_sites();

    foreach ($sites as $site) {

        switch_to_blog($site->blog_id);

        global $wpdb;

        $post_types_list = array(
            'casinos',
            'casinocat',
            'bonus',
        );
    
        foreach($post_types_list as $post_type){
            $sql = "
                INSERT INTO {$wpdb->postmeta} (post_id, meta_key, meta_value)
                SELECT ID as post_id, '_wp_page_template' as meta_key, '{$post_type}.php' as meta_value
                FROM {$wpdb->posts}
                WHERE post_type = '{$post_type}'
                ON DUPLICATE KEY UPDATE meta_value = VALUES(meta_value)
            ";

            $wpdb->query($sql);

            
            $args = array(
                'post_type' => $post_type,
                'posts_per_page' => -1
            );
            
            $casinos_posts = new WP_Query($args);
            
            if($casinos_posts->have_posts()) {
                while($casinos_posts->have_posts()) {
                    $casinos_posts->the_post();
        
                    set_post_type(get_the_ID(), 'page');
                    
                }
            }
        }

        restore_current_blog();
    }
}

function delete_post_type_for_all_sites(){
    $sites = get_sites();

    foreach ($sites as $site) {
        switch_to_blog($site->blog_id);

        $post_types_list = array(
            'casinos',
            'casinocat',
            'bonus',
        );
    
        foreach($post_types_list as $post_type){
            unregister_post_type( $post_type );
        }

        restore_current_blog();
    }
}

// add_action('init', 'change_post_type_for_all_sites');
// add_action('init', 'delete_post_type_for_all_sites', 100);

function filter_pages_by_template() {
    global $typenow;
    if ('page' === $typenow) {
        $templates = get_page_templates();
        $output = array();
        foreach ($templates as $template_name => $template_file) {
            $output[$template_file] = $template_name;
        }
        ksort($output);
        ?>
        <select name="page_template" id="page_template">
            <option value="">Все шаблоны</option>
            <?php
            $current_v = isset($_GET['page_template'])? $_GET['page_template']:'';
            foreach ($output as $value => $label) {
                // Убираем из селекта фаблон page-casinocat.php
                if($value != "page-casinocat.php")
                    printf
                        (
                            '<option value="%s"%s>%s</option>',
                            $value,
                            $value == $current_v? ' selected="selected"':'',
                            $label
                        );
            }
            ?>
        </select>
        <?php
    }
}

function sort_pages_by_template($query) {
    global $pagenow;
    
    if (is_admin() && 'edit.php' === $pagenow && isset($_GET['page_template']) && $_GET['page_template'] != '') {
        $query->query_vars['meta_key'] = '_wp_page_template';
        $query->query_vars['meta_value'] = $_GET['page_template'];
    }
}

add_filter( 'theme_page_templates', 'remove_theme_page_templates' );
add_filter( 'theme_post_templates', 'remove_theme_page_templates' );

function remove_theme_page_templates( $templates ) {
    // Убираем из селекта фаблон page-casinocat.php
	unset( $templates['page-casinocat.php'] );

	return $templates;
}

add_action('parse_query', 'sort_pages_by_template');                // Убираем из селекта фаблон page-casinocat.php
add_action('restrict_manage_posts', 'filter_pages_by_template');    // Убираем из селекта фаблон page-casinocat.php

function has_approved_comments($post_id) {
    $args = array(
        'status' => 'approve', // Одобренные комментарии
        'post_id' => $post_id // ID страницы или записи
    );

    $comments = get_comments($args);

    return count($comments); // Если количество комментариев больше 0, вернуть true, иначе - false
}


function custom_title(){
    // Указываем путь к вашему CSV-файлу

        $uploaded_file = dirname(__FILE__) . '/titles.csv';
        // Открыть файл для чтения
        $file = fopen($uploaded_file, 'r');
        // Прочитать содержимое CSV

        while (($row = fgetcsv($file)) !== false) {

            // Проверяем, является ли ряд пустым
            if (empty(array_filter($row))) {
                $keysArray = [];  
                continue;
            }
            $post_id = url_to_postid($row[0]);
        
            if(isset($row[1]) && !empty($row[1])) update_field('custom_y_title', $row[1], $post_id);
            if(isset($row[2]) && !empty($row[2])) update_field('custom_y_description', $row[2], $post_id);
            if(isset($row[3]) && !empty($row[3])) update_field('custom_title', $row[3], $post_id);
            
        }

        fclose($file);

}
// custom_title();

function replace_2023_with_2024() {
    if (!current_user_can('manage_options')) {
        return;
    }

    $blog_ids = get_sites(['fields' => 'ids']);
    foreach ($blog_ids as $blog_id) {
        switch_to_blog($blog_id);

        global $wpdb;

        // Получаем все посты
        $posts = $wpdb->get_results("SELECT ID, post_content, post_title FROM {$wpdb->posts}");

        foreach ($posts as $post) {
            // Исключаем замену в URL, используя регулярные выражения
            $content = preg_replace_callback('/\bhttps?:\/\/\S+/i', function($matches) {
                return $matches[0]; // Возвращаем исходный URL без изменений
            }, $post->post_content);

            // Замена в контенте и заголовке
            $updated_content = str_replace(' 2023', ' 2024', $content);
            $updated_title = str_replace(' 2023', ' 2024', $post->post_title);

            // Обновляем пост, если есть изменения
            if ($updated_content !== $post->post_content || $updated_title !== $post->post_title) {
                $wpdb->update(
                    $wpdb->posts,
                    ['post_content' => $updated_content, 'post_title' => $updated_title],
                    ['ID' => $post->ID]
                );
            }
        }

        // Замена в метаданных
        $wpdb->query("UPDATE {$wpdb->postmeta} SET meta_value = REPLACE(meta_value, ' 2023 ', ' 2024')");

        restore_current_blog();
    }
}

// Запускаем функцию при загрузке админ-панели
// replace_2023_with_2024();
function re_save_all_pages_with_acf_optimized() {
    $args = [
        'post_type'      => ['games', 'page'],
        'posts_per_page' => -1,
        'post_status'    => 'publish'
    ];

    $all_pages = new WP_Query($args);

    if ($all_pages->have_posts()) : 
        while ($all_pages->have_posts()) : $all_pages->the_post();
            $current_post_id = get_the_ID();
            // Получаем все метаданные страницы одним вызовом
            $post_meta = get_post_meta($current_post_id);

            // ОБНОВЛЕНИЕ ДАННЫЙХ ОБЗОРОВ КАЗИНО

            // Обновление min_deposit и max_deposit
            $min_deposit_value_to_update = [
                'link' => $post_meta['min_deposit_link'][0] ?? '',
                'text' => $post_meta['min_deposit_text'][0] ?? '',
            ];
            $inner_link = $post_meta['min_deposit_inner_link'][0] ?? '';
            if (!empty($inner_link)) {
                $min_deposit_value_to_update['inner_link'] = $inner_link;
            }
            update_field('min_deposit', $min_deposit_value_to_update, $current_post_id);
            update_field('max_deposit', $post_meta['max_deposit'][0] ?? '', $current_post_id);

            // Обновление характеристик казино
            $characteristics_value_to_update = [
                'website' => $post_meta['characteristics_of_the_casino_website'][0] ?? '',
                'owner' => $post_meta['characteristics_of_the_casino_owner'][0] ?? '',
                'established' => $post_meta['characteristics_of_the_casino_established'][0] ?? '',
                'support' => $post_meta['characteristics_of_the_casino_support'][0] ?? '',
                'licences' => $post_meta['characteristics_of_the_casino_licences'][0] ?? '',
            ];
            update_field('characteristics_of_the_casino', $characteristics_value_to_update, $current_post_id);

            // Обновление методов оплаты
            $payment_methods = [];
            for ($counter = 0; ; $counter++) {
                $prefix = "payment_methods_{$counter}_";
                // Проверяем, есть ли title для текущего счетчика, чтобы определить, продолжать ли цикл
                if (!isset($post_meta["{$prefix}title"][0])) {
                    break;
                }
                $payment_methods[] = [
                    'image' => $post_meta["{$prefix}image"][0] ?? '',
                    'title' => $post_meta["{$prefix}title"][0],
                    'inner_link' => $post_meta["{$prefix}inner_link"][0] ?? '',
                    'link' => $post_meta["{$prefix}link"][0] ?? '',
                ];
            }
            if (!empty($payment_methods)) {
                update_field('payment_methods', $payment_methods, $current_post_id);
            }

            // Обновление платформ
            $platforms = [];
            for ($counter = 0; ; $counter++) {
                $prefix = "platforms_{$counter}_";
                // Проверяем, есть ли title для текущего счетчика, чтобы определить, продолжать ли цикл
                if (!isset($post_meta["{$prefix}list"][0])) {
                    break;
                }
                $platforms[] = [
                    'inner_link' => $post_meta["{$prefix}inner_link"][0] ?? '',
                    'list' => $post_meta["{$prefix}list"][0] ?? '',
                    'link' => $post_meta["{$prefix}link"][0] ?? '',
                ];
            }
            if (!empty($platforms)) {
                update_field('platforms', $platforms, $current_post_id);
            }

            // Обновление платформ
            $providers = [];
            for ($counter = 0; ; $counter++) {
                $prefix = "providers_{$counter}_";
                // Проверяем, есть ли title для текущего счетчика, чтобы определить, продолжать ли цикл
                if (!isset($post_meta["{$prefix}name"][0])) {
                    break;
                }
                $providers[] = [
                    'inner_link' => $post_meta["{$prefix}inner_link"][0] ?? '',
                    'logo' => $post_meta["{$prefix}logo"][0] ?? '',
                    'name' => $post_meta["{$prefix}name"][0] ?? '',
                    'link' => $post_meta["{$prefix}link"][0] ?? '',
                ];
            }
            if (!empty($providers)) {
                update_field('providers', $providers, $current_post_id);
            }

            // Обновление Количества игр
            update_field('number_of_games', $post_meta['number_of_games'][0] ?? '', $current_post_id);

            // Обновление Списка языков
            update_field('languages', unserialize($post_meta['languages'][0]), $current_post_id);
            
            // Обновление Валют
            update_field('currencies', $post_meta['currencies'][0] ?? '', $current_post_id);

            // Обновление Казино для страны
            update_field('location_icon', $post_meta['location_icon'][0] ?? '', $current_post_id);

            // Обновление Контакты казино
            $shortcode_casino_contacts_value_to_update = [
                'email' => $post_meta['shortcode_casino_contacts_email'][0] ?? '',
                'chat' => $post_meta['shortcode_casino_contacts_chat'][0] ?? '',
                'phone' => $post_meta['shortcode_casino_contacts_phone'][0] ?? ''
            ];
            update_field('shortcode_casino_contacts', $shortcode_casino_contacts_value_to_update, $current_post_id);
            
            // Обновление количество игр по типам
            $shortcode_casino_games_value_to_update = [
                'games' => $post_meta['shortcode_casino_games_games'][0] ?? '',
                'slot_machines' => $post_meta['shortcode_casino_games_slot_machines'][0] ?? '',
                'video_poker' => $post_meta['shortcode_casino_games_video_poker'][0] ?? '',
                'baccarat' => $post_meta['shortcode_casino_games_baccarat'][0] ?? '',
                'roulette' => $post_meta['shortcode_casino_games_roulette'][0] ?? '',
                'blackjack' => $post_meta['shortcode_casino_games_blackjack'][0] ?? '',
                'poker' => $post_meta['shortcode_casino_games_poker'][0] ?? '',
                'bingo' => $post_meta['shortcode_casino_games_bingo'][0] ?? '',
                'live_games' => $post_meta['shortcode_casino_games_live_games'][0] ?? '',
            ];
            update_field('shortcode_casino_games', $shortcode_casino_games_value_to_update, $current_post_id);

            // Обновление Алерта
            update_field('alert', $post_meta['alert'][0] ?? '', $current_post_id);

            // Обновление Сокращенного названия
            update_field('casino_short_name', $post_meta['casino_short_name'][0] ?? '', $current_post_id);

            // Обновление информации про табы
            update_field('is_child', $post_meta['is_child'][0] ?? '', $current_post_id);
            update_field('text_in_tab', $post_meta['text_in_tab'][0] ?? '', $current_post_id);

            // Обновление плюсов на обзорах
            $pluses = [];
            for ($counter = 0; ; $counter++) {
                $prefix = "pluses_{$counter}_";
                if (!isset($post_meta["{$prefix}text"][0])) {
                    break;
                }
                $pluses[] = [
                    'text' => $post_meta["{$prefix}text"][0] ?? ''
                ];
            }
            if (!empty($pluses)) {
                update_field('pluses', $pluses, $current_post_id);
            }

            // Обновление Типов игр
            $games_types = [];
            for ($counter = 0; ; $counter++) {
                $prefix = "games_types_{$counter}_";
                // Проверяем, есть ли title для текущего счетчика, чтобы определить, продолжать ли цикл
                if (!isset($post_meta["{$prefix}list"][0])) {
                    break;
                }
                $games_types[] = [
                    'link' => $post_meta["{$prefix}link"][0] ?? '',
                    'list' => $post_meta["{$prefix}list"][0] ?? '',
                    'inner_link' => $post_meta["{$prefix}inner_link"][0] ?? ''
                ];
            }
            if (!empty($games_types)) {
                update_field('games_types', $games_types, $current_post_id);
            }

            // Обновление Списка бонусов
            $bonus_block = [];
            for ($counter = 0; ; $counter++) {
                $prefix = "bonus_block_{$counter}_";
                // Проверяем, есть ли title для текущего счетчика, чтобы определить, продолжать ли цикл
                if (!isset($post_meta["{$prefix}bonus_type"][0])) {
                    break;
                }
                $bonus_block[] = [
                    'bonus_type' => $post_meta["{$prefix}bonus_type"][0] ?? '',
                    'text' => $post_meta["{$prefix}text"][0] ?? '',
                    'short_text' => $post_meta["{$prefix}short_text"][0] ?? '',
                    't_c' => $post_meta["{$prefix}t_c"][0] ?? '',
                    'bonus_ref' => $post_meta["{$prefix}bonus_ref"][0] ?? ''
                ];
            }
            if (!empty($bonus_block)) {
                update_field('bonus_block', $bonus_block, $current_post_id);
            }

            // Обновление Основного бонуса
            update_field('bonus_on_top', $post_meta['bonus_on_top'][0] ?? '', $current_post_id);
            
            // ОБНОВЛЕНИЕ ДАННЫЙХ СЛОТОВ

            // Обновление Айфрейма
            $game_iframe_value_to_update = [
                'src' => $post_meta['game_iframe_src'][0] ?? '',
                'image' => $post_meta['game_iframe_image'][0] ?? ''
            ];
            update_field('game_iframe', $game_iframe_value_to_update, $current_post_id);
            
            // Обновление превью
            update_field('game_preview_image', $post_meta['game_preview_image'][0] ?? '', $current_post_id);
            
            // Обновление шорткода для шорткода more-games на странице слота
            // $more_games_value_to_update = [
            //     'title' => $post_meta['more_games_title'][0] ?? '',
            //     'id' => $post_meta['more_games_id'][0] ?? ''
            // ];
            // update_field('more_games', $more_games_value_to_update, $current_post_id);

            
            // Обновление Параметров
            $parameters_value_to_update = [
                'bonus_rounds' => unserialize($post_meta['parameters_bonus_rounds'][0]) ?? '',
                'wild_symbol' => unserialize($post_meta['parameters_wild_symbol'][0]) ?? '',
                'scatter_symbol' => unserialize($post_meta['parameters_scatter_symbol'][0]) ?? '',
                'autoplay' => unserialize($post_meta['parameters_autoplay'][0]) ?? '',
                'multiplier' => unserialize($post_meta['parameters_multiplier'][0]) ?? '',
                'free_spins' => unserialize($post_meta['parameters_free_spins'][0]) ?? '',
            ];
            update_field('parameters', $parameters_value_to_update, $current_post_id);

            // Обновление Спецификации
            $specifications_value_to_update = [
                'reels' => $post_meta['specifications_reels'][0] ?? '',
                'paylines' => $post_meta['specifications_paylines'][0] ?? '',
                'min_bet' => $post_meta['specifications_min_bet'][0] ?? '',
                'max_bet' => $post_meta['specifications_max_bet'][0] ?? '',
                'provider' => $post_meta['specifications_provider'][0] ?? '',
                'rtp' => $post_meta['specifications_rtp'][0] ?? '',
            ];
            update_field('specifications', $specifications_value_to_update, $current_post_id);

        endwhile; 
    endif;
    wp_reset_postdata();
}

// Вызов функции или добавление её в хук, например в 'init', если нужно выполнить один раз или по расписанию.
// add_action('init', 're_save_all_pages_with_acf_optimized');
function remove_data_anchor_from_content() {
    // Получаем все посты и страницы
    $args = array(
        'post_type'      => array('post', 'page'),
        'posts_per_page' => -1, // Выбираем все посты
        'post_status'    => 'any'
    );
    $posts = get_posts($args);

    foreach ($posts as $post) {
        // Удаляем атрибут data-anchor из контента
        $content = $post->post_content;
        // Исправленное регулярное выражение для точного удаления атрибута data-anchor
        $updated_content = preg_replace('/\sdata-anchor="[^"]*"/', '', $content);
        $updated_content = preg_replace('/\sidr="[^"]*"/', '', $updated_content);
        // Обновляем пост, если контент изменился
        if ($updated_content !== $content) {
            wp_update_post(array(
                'ID'           => $post->ID,
                'post_content' => $updated_content
            ));
        }
    }
}
// Вызываем функцию (убедитесь, что делаете это в подходящее время, например, во время обслуживания сайта)
// remove_data_anchor_from_content();