<?php

// Регистрируем AJAX обработчик для пользователей с правами управления настройками
add_action('wp_ajax_save_theme_settings', 'handle_theme_settings_upload');

function handle_theme_settings_upload() {
    // Проверяем наличие прав у пользователя и валидность nonce для безопасности
    if (!current_user_can('manage_options') || !check_ajax_referer('section-options', 'nonce', false)) {
        wp_send_json_error('Недостаточно прав или ошибка безопасности');
        return;
    }

    $option_name = $_POST['option_page'];

    // Удаление системных служебных полей из данных формы
    $usetFields = ['option_page', 'action', '_wpnonce', '_wp_http_referer', 'nonce'];
    foreach ($usetFields as $field) {
        unset($_POST[$field]);
    }

    // Массив для хранения результатов операций сохранения каждой опции
    $results = [];
    
    foreach ($_POST as $field => $value) {
        // Декодирование HTML-сущностей во входных данных, учитывая возможность вложенных массивов
        $sanitized_value = is_array($value) ? array_map('decode_html_entities', $value) : decode_html_entities($value);

        // Получаем текущее значение опции из базы данных и декодируем его
        $current_value = get_option($field);
        $current_value_decoded = decode_html_entities($current_value);
        
        // Сравнение текущего значения опции с новым значением
        if ($current_value_decoded != $sanitized_value) {
            
            $result = update_option($field, $sanitized_value);
            $results[$field] = $result;
        } else {
            $results[$field] = 'no_change';  // Отметка о том, что изменения не требуются
        }
    }

    if($option_name == 'payment' && count($_POST) == 0) $result = update_option('payment', '');

    // Фильтрация и логирование неудачных обновлений
    $failed_updates = array_filter($results, function($v) { return $v === false; });
    
    if (!count($failed_updates)) {
        wp_send_json_success('Налаштування успішно збережено');
    } else {
        wp_send_json_error('Помилка збереження налаштувань: ' . print_r($failed_updates, true));
    }
}

// Функция для рекурсивного декодирования HTML-сущностей в данных
function decode_html_entities($item) {
    // Проверка на массив и рекурсивная обработка каждого элемента
    if (is_array($item)) {
        return array_map('decode_html_entities', $item);
    }
    // Декодирование HTML-сущностей для строк
    else if (is_string($item)) {
        return html_entity_decode($item);
    }
    // Возврат элемента без изменений, если это не строка и не массив
    return $item;
}

function get_option_keys_for_section($option_page) {
    global $wp_settings_fields;
    
    $option_keys = [];
    if (isset($wp_settings_fields[$option_page])) {
        foreach ($wp_settings_fields[$option_page] as $section => $field_array) {
            foreach ($field_array as $field_key => $field) {
                $option_keys[] = $field['id'];  // Предполагаем, что 'id' содержит ключ настройки
            }
        }
    }
    
    return $option_keys;
}

// Сохранение доп кода для хэдэра
function handle_header_upload(){
    global $option;
    if (isset($_POST["header"])) {
        $temp = $_POST["header"];
        return $temp;
    }
    return $option;
}

// Сохранение валюты
function currency_upload(){
    global $option;
    if (isset($_POST["currency"])) {
        $temp = $_POST["currency"];
        return $temp;
    }
    return $option;
}

// Сохранение доп кода для футера
function handle_footer_upload()
{
    global $option;
    if (isset($_POST["footer"])) {
        $temp = $_POST["footer"];
        return $temp;
    }
    return $option;
}

// Сохранение текста в футере
function handle_footer_text_upload()
{
    global $option;
    if (isset($_POST["footer_text"])) {
        $temp = $_POST["footer_text"];
        return $temp;
    }
    return $option;
}

// Сохранение текста в футере
function handle_lang_upload()
{
    global $option;
    if (isset($_POST["lang"])) {
        $temp = $_POST["lang"];
        return $temp;
    }
    return $option;
}


//=============================//
//***  Сохранение перевода  ***//
//=============================//
function sites_translations_upload(){
    global $option;
    if ($_POST["translations_site"]) {
        $temp = $_POST["translations_site"];
        return $temp;
    }
    return $option;
}

// Сохранение авторов
function sites_autors_upload(){
    global $option;
    if ($_POST["autors_site"]) {
        $temp = $_POST["autors_site"];
        return $temp;
    }
    return $option;
}

// Сохранение списка казино в попапе
function popup_casinos_upload(){
    global $option;
    if ($_POST["popup_casinos_section"]) {
        $temp = $_POST["popup_casinos_section"];
        return $temp;
    }
    return $option;
}

// Сохранение данных для попапа
function popup_cookie_upload(){
    global $option;
    if ($_POST["popup_cookie_section"]) {
        $temp = $_POST["popup_cookie_section"];
        return $temp;
    }
    return $option;
}

// Иконка Best Choice Casino
function best_choice_casinos_upload()
{
    global $option;
    
    if (isset($_POST["best_choice_casinos"])) {
        $temp = $_POST["best_choice_casinos"];
        return $temp;
    }
    return $option;
}

// Плашки казино
function plashka_upload()
{
    global $option;
    
    if (isset($_POST["plashka"])) {
        $temp = $_POST["plashka"];
        return $temp;
    }
    return $option;
}

// Плашки казино
function payment_upload()
{
    global $option;
    
    if (isset($_POST["payment"])) {
        $temp = $_POST["payment"];
        return $temp;
    }
    return $option;
}

// Казино в попап для UK
function uk_popup_casinos_upload(){
    global $option;

    if (isset($_POST["uk_popup_casinos"])) {
        $temp = $_POST["uk_popup_casinos"];
        return $temp;
    }
    return $option;
}

// Добавление казино в блок "casino of the month"
function casino_left_sidebar_upload(){
    global $option;
    
    if (isset($_POST["casino_left_sidebar"])) {
        $temp = $_POST["casino_left_sidebar"];
        return $temp;
    }
    return $option;
}

// Налаштування фільтрів казино
function casino_filters_upload(){
    global $option;
    
    if (isset($_POST["casino_filters"])) {
        $_POST["casino_filters"]["payment_methods"] = array_filter($_POST["casino_filters"]["payment_methods"], function($item) {
            return !empty($item['value']);
        });
        // d($_POST["casino_filters"],1);
        $temp = $_POST["casino_filters"];
        return $temp;
    }
    return $option;
}

// Отзывы клиентов
function reviews_clients_upload(){
    global $option;
    if ($_POST["reviews_clients"]) {
        $temp = $_POST["reviews_clients"];
        return $temp;
    }
    return $option;
}

// Отзывы клиентов
function sites_recaptcha_upload(){
    global $option;
    if ($_POST["recaptcha"]) {
        $temp = $_POST["recaptcha"];
        return $temp;
    }
    return $option;
}

// Колесо фортуны
function spin_wheel_upload(){
    global $option;
    
    if ($_POST["option_page"] == 'spin_wheel') {
        $temp = $_POST;
        return $temp;
    }
    return $option;
}

// Скрыть контент
function content_hide_upload(){
    global $option;
    
    if ($_POST["option_page"] == 'content_hide') {
        $temp = $_POST;
        return $temp;
    }
    return $option;
}

function get_hrefs_from_xlsx(){
    // Указываем путь к вашему CSV-файлу
    if (!empty($_FILES['csv_file']['tmp_name'])) {
        $file_path = $_FILES['csv_file']['tmp_name'];

         // Открываем файл для чтения
        $file = fopen($file_path, 'r');

        $result = [];

        $keysArray = [];

        while (($row = fgetcsv($file)) !== false) {
            // Проверяем, является ли ряд пустым
            if (empty(array_filter($row))) {
                $keysArray = [];  
                continue;
            }
            
            foreach(array_chunk($row,4) as $index => $block){
                
                if(!empty(array_filter($block))){
                    // if(!empty($block[0])) $keysArray[] = str_replace("https://polskiekasynaonline24.com", "http://casinoprofy", $block[0]);
                    if(!empty($block[0])) $keysArray[] = $block[0];
                    $result[$keysArray[$index]][] = ["url" => $block[1], "hreflang" => $block[2]];
                }
            }
        }

        fclose($file);

        return $result;

    } else {
        echo 'Ошибка при загрузке или файл не предоставлен.';
    }
    
}

// Получаем ID на основе URL
function get_custom_postid_by_full_url($url) {
    // Удаляем домен и разбиваем URL на части
    $path = parse_url($url, PHP_URL_PATH);
    $path_segments = explode('/', trim($path, '/'));

    // Если URL не имеет пути (главная страница), возвращаем ID главной страницы
    if (empty($path_segments[0])) {
        // Проверяем, установлена ли статическая главная страница
        $front_page_id = get_option('page_on_front');
        return $front_page_id ? $front_page_id : 0;
    }

    // Определяем все типы записей для проверки
    $post_types = ['post', 'page', 'games', 'providers', 'blank'];

    $last_post_id = 0;

    foreach ($path_segments as $segment) {
        foreach ($post_types as $post_type) {
            $query = new WP_Query([
                'post_type' => $post_type,
                'post_status' => 'publish',
                'name' => $segment,
                'post_parent' => $last_post_id
            ]);

            if ($query->have_posts()) {
                $query->the_post();
                $last_post_id = get_the_ID();
                break;
            }
        }
    }

    return $last_post_id ? $last_post_id : 0;
}


function alternates_csv_upload() {
    $hrefs = get_hrefs_from_xlsx();
    $pages_to_modify = array_keys($hrefs);
    echo "
        <table>
        <tr>
            <td>URL</td>
            <td>Page ID</td>
            <td>Status</td>
        </tr>
    ";
    foreach ($pages_to_modify as $full_url) {
        $url_parts = parse_url($full_url);
        $domain = $url_parts['host'];
        $path = $url_parts['path'];
        $site = get_site_by_path($domain, $path);

        if ($site) {
            switch_to_blog($site->blog_id);
            
            // Получаем ID на основе URL
            $post_ID = get_custom_postid_by_full_url($full_url);
            if ($post_ID) {

                // Обновляем (перезаписываем) значение поля ACF
                update_field('alternate', $hrefs[$full_url], $post_ID);                
                echo "
                    <tr>
                        <td>$full_url</td>
                        <td>$post_ID</td>
                        <td>Done</td>
                    </tr>
                ";
            }else{
                echo "
                    <tr>
                        <td>$full_url</td>
                        <td> - </td>
                        <td>NOT FOUND</td>
                    </tr>
                ";
            }

            restore_current_blog();
        }
    }

    echo "</table><p class='option-title'>All done</p>";
    wp_die(); // это необходимо, чтобы корректно завершить функцию для обработчика AJAX в WordPress

}

add_action('wp_ajax_alternates_csv_upload', 'alternates_csv_upload'); // Если пользователь авторизован