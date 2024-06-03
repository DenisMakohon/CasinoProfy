<?php

// Регистрация настроек
function display_theme_panel_fields()
{

    //=============================//
    //***   Базові налаштування   ***//
    //=============================//

    add_settings_section("section", "Базові налаштування", null, "theme-options");

    add_settings_field("lang", "Мовні налаштування", "lang_settings", "theme-options", "section");
    add_settings_field("hreflang_lgsw", "Приховати hreflang та перемикач мов", "hreflang_lgsw_display", "theme-options", "section");
    add_settings_field("currency", "Валюта сайту", "currency_display", "theme-options", "section");

    add_settings_field("header", "Код у тезі head", "header_display", "theme-options", "section");
    add_settings_field("footer", "Код перед закриваючим body", "footer_display", "theme-options", "section");
    add_settings_field("footer_text", "Текст у футері", "footer_text_display", "theme-options", "section");

    add_settings_field("recaptcha", "Налаштування reCAPTCHA", "recaptcha_display", "theme-options", "section");

    add_settings_field("best_online_casinos", "Кращі онлайн казино (виводиться праворуч від демо на сторінці слота)", "best_online_casinos_display", "theme-options", "section");
    add_settings_field("best_choice_casinos", "Найкращий вибір (відзначається обраною іконкою та червоним кольором у шоткоді [topFourCasinos])", "best_choice_casinos_display", "theme-options", "section");

    register_setting("section", "header", "handle_header_upload");
    register_setting("section", "footer", "handle_footer_upload");
    register_setting("section", "footer_text", "handle_footer_text_upload");
    register_setting("section", "hreflang_lgsw", "handle_hreflang_lgsw_upload");
    register_setting("section", "best_online_casinos", "best_online_casinos_upload");
    register_setting("section", "lang", "handle_lang_upload");
    register_setting("section", "recaptcha", "handle_recaptcha_upload");
    register_setting("section", "best_choice_casinos", "best_choice_casinos_upload");
    register_setting("section", "currency", "currency_upload");

    //===========================//
    //***  Настрока reCAPTCHA  **//
    //===========================//

    add_settings_section("recaptcha", "Налаштування reCAPTCHA", null, "recaptcha-options");
    add_settings_field("recaptcha_site", "", "recaptcha_display", "recaptcha-options", "recaptcha");
    register_setting("recaptcha", "recaptcha_site", "sites_recaptcha_upload");

    //===========================//
    //***  Настрока перевода  ***//
    //===========================//

    add_settings_section("translations", "Налаштування перекладів статичних елементів", null, "translations-options");
    add_settings_field("translations_site", "", "sites_translations_display", "translations-options", "translations");
    register_setting("translations", "translations_site", "sites_translations_upload");

    //===========================//
    //***  Добавление авторов ***//
    //===========================//

    add_settings_section("autors", "Додавання та редагування авторів", null, "autors-options");
    add_settings_field("autors_site", "", "autors_display", "autors-options", "autors");
    register_setting("autors", "autors_site", "sites_autors_upload");

    //=============================//
    //* Добавление казино в попап *//
    //=============================//

    add_settings_section("popup_casinos", "Казино, які виводитимуть у попе, якщо казино, яким клікнув користувач, заблоковано країни поточної локалі", null, "popup_casinos-options");
    add_settings_field("popup_casinos_section", "", "popup_casinos_display", "popup_casinos-options", "popup_casinos");
    register_setting("popup_casinos", "popup_casinos_section", "popup_casinos_upload");

    //=============================//
    //******* Попап с куками ******//
    //=============================//

    add_settings_section("popup_cookie", "Інформація для попапа кукі", null, "popup_cookie-options");
    add_settings_field("popup_cookie_section", "", "popup_cookie_display", "popup_cookie-options", "popup_cookie");
    register_setting("popup_cookie", "popup_cookie_section", "popup_cookie_upload");

    //=============================//
    //******* Плашки казино *******//
    //=============================//

    add_settings_section("plashka", "Плашки для казино", null, "plashka-options");
    add_settings_field("plashka", "", "plashka_display", "plashka-options", "plashka");
    register_setting("plashka", "plashka", "plashka_upload");

    //=============================//
    //*** Методи оплат у хедері ***//
    //=============================//

    add_settings_section("payment", "Методи оплат у хедері", null, "payment-options");
    add_settings_field("payment", "", "payment_display", "payment-options", "payment");
    register_setting("payment", "payment", "payment_upload");

    //=============================//
    //* Налаштування фільтрів казино *//
    //=============================//

    add_settings_section("casino_filters", "Налаштування фільтрів казино", null, "casino_filters-options");
    add_settings_field("casino_filters", "", "casino_filters_display", "casino_filters-options", "casino_filters");
    register_setting("casino_filters", "casino_filters", "casino_filters_upload");

    //========================================//
    //*** Добавление казино в попап для UK ***//
    //========================================//

    add_settings_section("uk_popup_casinos", "Казино, которые выводятся в попапе", null, "uk_popup_casinos-options");
    add_settings_field("uk_popup_casinos", "", "uk_popup_casinos_display", "uk_popup_casinos-options", "uk_popup_casinos");
    register_setting("uk_popup_casinos", "uk_popup_casinos", "uk_popup_casinos_upload");

    //==================================================//
    //* Добавление казино в блок "casino of the month" *//
    //==================================================//

    add_settings_section("casino_left_sidebar", "Казино у лівому сайдбарі", null, "casino_left_sidebar-options");
    add_settings_field("casino_left_sidebar", "", "casino_left_sidebar_display", "casino_left_sidebar-options", "casino_left_sidebar");
    register_setting("casino_left_sidebar", "casino_left_sidebar", "casino_left_sidebar_upload");

    //=============================//
    //****   Отзывы клиентов   ****//
    //=============================//

    add_settings_section("reviews_clients", "Додавання та редагування відгуків", null, "reviews_clients_options");
    add_settings_field("reviews_clients", "Інформація щодо відгуків", "reviews_clients_display", "reviews_clients_options", "reviews_clients");
    register_setting("reviews_clients", "reviews_clients", "reviews_clients_upload");

    //=============================//
    //****   Колесо фортуны   *****//
    //=============================//

    add_settings_section("spin_wheel_fix", "Колесо фортуни", null, "spin_wheel_fix_options");
    add_settings_field("spin_wheel_fix", "", "spin_wheel_fix_display", "spin_wheel_fix_options", "spin_wheel_fix");
    register_setting("spin_wheel_fix", "spin_wheel_fix", "spin_wheel_fix_upload");

    //=============================//
    //****  Скрытие контента  *****//
    //=============================//

    add_settings_section("content", "Приховування контенту", null, "content_options");
    add_settings_field("content", "", "content_display", "content_options", "content");
    register_setting("content", "content", "content_upload");

    global $cached_casinos;

    // Проверяем, находимся ли мы на нужной странице в админке
    if (is_admin() && isset($_GET['page']) && $_GET['page'] === 'theme-panel') {
        $cached_casinos = get_casinos_data();
    }
}

// Регистрация скриптов и стилей для административной панели
function theme_options_enqueue_scripts($hook) {
    // Проверка, что мы находимся на нужной странице админки
    if ('toplevel_page_theme-panel' !== $hook) {
        return; // Если нет, то не загружаем скрипты и стили
    }

    // Регистрация главного скрипта настроек
    wp_register_script('theme-options', get_stylesheet_directory_uri() . '/includes/themeOptions/static/js/app.min.js', array('media-upload', 'thickbox'), null, true);

    // Регистрация главного стиля настроек
    wp_register_style('theme-options', get_stylesheet_directory_uri() . '/includes/themeOptions/static/css/settings.min.css');

    // Подключение стилей и скриптов
    if ('toplevel_page_theme-panel' == get_current_screen()->id) {
        wp_enqueue_style('thickbox'); // Стиль для thickbox
        wp_enqueue_script('thickbox'); // Скрипт для thickbox

        wp_enqueue_script('media-upload'); // Скрипт для функционала загрузки медиафайлов

        // Допустим, есть стиль и скрипт для color-picker, которые мы также подключаем
        wp_enqueue_style('theme-options-color-picker-main');
        wp_enqueue_script('theme-options-color-picker-main');

        // Подключаем зарегистрированные стиль и скрипт для опций темы
        wp_enqueue_style('theme-options');
        wp_enqueue_script('theme-options');
    }

    // Подключение медиа загрузчика, если он еще не подключен
    if (!did_action('wp_enqueue_media')) {
        wp_enqueue_media();
    }
}

// Добавляем поля для нового автора
function add_autor_field(){
    if(isset($_POST['autor_num'])){
        autors_display($_POST['autor_num']);
    }    
    wp_die();
}

// Добавляем поля для новой плашки
function add_plashka_field(){
    if(isset($_GET['plashka_num'])){
        plashka_display($_GET['plashka_num']);
    }
    wp_die();
}

function payment_id(){
    if(isset($_GET['paymentNum'])){
        payment_display($_GET['paymentNum']);
    }    
    wp_die();
}

function get_redirections($page, $redirections = array()){

    global $wpdb;
    if(isset($_GET['blog_id'])) {
        $blog_id = $_GET['blog_id'] > 1 ? $_GET['blog_id'].'_' : '';
    }   

    $prefix = $wpdb->prefix;
    $sql = "SELECT * FROM ".$prefix.$blog_id."redirection_items";
    $result = $wpdb->get_results($sql);
    
    if (count($result)) {
        echo "<div class='redirection_table'><div class='d-flex'>
                <div class='num'>Num</div>
                <div class='code'>Status code</div>
                <div class='r_url'>Redirect URL</div>
                <div class='url'>URL</div>
            </div>";
        // Выводим данные каждого редиректа
        foreach($result as $item){
            
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => $item->action_data,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_2_0,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ));

            curl_exec($curl);
            $info = curl_getinfo($curl);
            
            echo "<div class='d-flex table-row'><div class='num'></div><div class='code_" . $info['http_code'] . " code'>" . $info['http_code'] . "</div>";

            curl_close($curl);
            echo "<div class='url'>" . $item->url . "</div>";
            echo "<div class='r_url'>" . $item->action_data . "</div></div>";
        }
        echo "</div>";
    } else {
        echo "0 results";
    }

    wp_die();
}

function payment_filter_id(){
    if(isset($_GET['blog_id'])) {
        switch_to_blog( $_GET['blog_id'] );
    }

    $next_id = $_GET['paymentMethodsNum'];  

    if(isset($_GET['paymentMethodsNum'])){
        casino_filters_display($next_id);
    }  

    wp_die();

}

global $cached_casinos;

function get_casinos_data() {

    global $cached_casinos;
    
    if (!isset($cached_casinos)) {

        $casinos_args = [
            'post_type'      => 'page',
            'posts_per_page' => -1,
            'orderby'        => 'meta_value_num',
            'order'          => 'DESC',
            'meta_query'     => [
                'relation' => 'AND',            
                ['key' => 'ref_link', 'value' => '', 'compare' => '!='],
                [
                    'relation' => 'OR',
                    ['key' => 'is_child','compare' => '!=','value' => '1'], // Считаем, что '1' это "Да"
                    ['key' => 'is_child','compare' => 'NOT EXISTS']
                ]
            ]
        ];
        $cached_casinos = new WP_Query($casinos_args);
    }

    return $cached_casinos->posts;
}

add_action('admin_init','display_theme_panel_fields');
add_action('admin_enqueue_scripts','theme_options_enqueue_scripts');
add_action('wp_ajax_add_autor_field','add_autor_field'); // Добавляем поля для нового автора
add_action('wp_ajax_add_plashka_field','add_plashka_field'); // Добавляем поля для новой плашки
add_action('wp_ajax_add_review_field','add_review_field');
add_action('wp_ajax_add_spinWheel_fields','add_spinWheel_fields');
add_action('wp_ajax_payment_id','payment_id');
add_action('wp_ajax_payment_filter_id','payment_filter_id'); 
add_action('the_editor','CheckIfEditorFieldIsRequired');
add_action('wp_ajax_get_redirections','get_redirections');