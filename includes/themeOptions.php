<?php
//Add Menu in admin dashboard
function add_theme_menu_item(){
    add_menu_page("Налаштування теми", "Налаштування теми", "manage_options", "theme-panel", "theme_settings_page", null, 99);
}
// Add Html code to that menu
add_action("admin_menu", "add_theme_menu_item");
if ( !function_exists( 'get_current_screen' ) ) { 
    require_once ABSPATH . '/wp-admin/includes/screen.php'; 
} 

require_once('themeOptions/theme-functions.php'); 
require_once('themeOptions/themeOptions-display.php'); 
require_once('themeOptions/themeOptions-upload.php'); 
require_once('themeOptions/themeOptions-comments.php');

function theme_settings_page(){
?>
    <div class="wrap row">
        <script defer async>
            window.blog_id = <?=get_blog_details()->blog_id?>;
        </script>
        <h1 class="col-12">Налаштування теми</h1>
        <div class="d-flex flex-column js-tabsSettingsList tabs-settings-list col-2">
            <p data-tab="basic" class="active">Базові налаштування</p>
            <p data-tab="translations">Переклади</p>
            <p data-tab="autors">Автори</p>
            <p data-tab="popup_casinos">Попап рекомендованих казино</p>
            <p data-tab="popup_cookie">Попап куки</p>
            <p data-tab="plashka">Помітки</p>
            <p data-tab="payment">Методи оплати у хедері</p>
            <p data-tab="uk_casinos">Попап для UK demo</p>
            <p data-tab="casino_left_sidebar">Казино у лівому сайдбарі</p>
            <p data-tab="casino_filters">Налаштування фільтрів казино</p>
            <p data-tab="redirections">Перевірка редиректи</p>
            <p data-tab="comments">Завантажити коментарі</p>            
            <p data-tab="alternates">Завантажити alternate</p>            
            <p data-tab="reviews_clients">Відгуки клієнтів</p>
            <p data-tab="spin_wheel">Колесо фортуни</p>
            <p data-tab="content">Приховування контенту</p>
            <img src="<?= get_stylesheet_directory_uri() ?>/setting_pages_static/walk.gif" class="walk js-walk" alt="walk">
        </div>
        <div class="col-10">
            <div class="settings-item js-settingsItem active" data-settings="basic">
                <form method="post" class="js-settingsForm" data-action="save_theme_settings" action="options.php" enctype="multipart/form-data">
                    <?php
                    settings_fields("section");
                    do_settings_sections("theme-options");
                    submit_button('Зберегти налаштування');
                    ?>
                </form>
            </div>
            <div class="settings-item js-settingsItem" data-settings="translations">
                <form method="post" class="js-settingsForm" data-action="save_theme_settings" action="options.php" enctype="multipart/form-data">
                    <?php
                    settings_fields("translations");
                    do_settings_sections("translations-options");
                    submit_button('Зберегти переклади');
                    ?>
                </form>
            </div>

            <div class="settings-item js-settingsItem" data-settings="autors">
                <form method="post" class="js-settingsForm" data-action="save_theme_settings" action="options.php" enctype="multipart/form-data">
                    <?php
                    settings_fields("autors");
                    do_settings_sections("autors-options");
                    submit_button('Зберегти авторів');
                    ?>
                </form>
            </div>
            <div class="settings-item js-settingsItem" data-settings="popup_casinos">
                <form method="post" class="js-settingsForm" data-action="save_theme_settings" action="options.php" enctype="multipart/form-data">
                    <?php
                    settings_fields("popup_casinos");
                    do_settings_sections("popup_casinos-options");
                    submit_button('Зберегти список');
                    ?>
                </form>
            </div>
            <div class="settings-item js-settingsItem" data-settings="popup_cookie">
                <form method="post" class="js-settingsForm" data-action="save_theme_settings" enctype="multipart/form-data">
                    <?php
                    settings_fields("popup_cookie");
                    do_settings_sections("popup_cookie-options");
                    submit_button('Зберегти налаштування попапа');
                    ?>
                </form>
            </div>
            <div class="settings-item js-settingsItem" data-settings="plashka">
                <form method="post" class="js-settingsForm" data-action="save_theme_settings" action="options.php" enctype="multipart/form-data">
                    <?php
                    settings_fields("plashka");
                    do_settings_sections("plashka-options");
                    submit_button('Зберегти налаштування плашек');
                    ?>
                </form>
            </div>
            <div class="settings-item js-settingsItem" data-settings="payment">
                <form method="post" class="js-settingsForm" data-action="save_theme_settings" enctype="multipart/form-data">
                    <?php
                    settings_fields("payment");
                    do_settings_sections("payment-options");
                    submit_button('Зберегти методи оплати');
                    ?>
                </form>
            </div>
            <div class="settings-item js-settingsItem" data-settings="uk_casinos">
                <form method="post" class="js-settingsForm" data-action="save_theme_settings" enctype="multipart/form-data">
                    <?php
                    settings_fields("uk_popup_casinos");
                    do_settings_sections("uk_popup_casinos-options");
                    submit_button('Зберегти перелік казино');
                    ?>
                </form>
            </div>
            <div class="settings-item js-settingsItem" data-settings="casino_left_sidebar">
                <form method="post" class="js-settingsForm" data-action="save_theme_settings" enctype="multipart/form-data">
                    <?php
                    settings_fields("casino_left_sidebar");
                    do_settings_sections("casino_left_sidebar-options");
                    submit_button('Зберегти казино');
                    ?>
                </form>
            </div>
            <div class="settings-item js-settingsItem" data-settings="casino_filters">
                <form method="post" class="js-settingsForm" data-action="save_theme_settings" enctype="multipart/form-data">
                    <?php
                    settings_fields("casino_filters");
                    do_settings_sections("casino_filters-options");
                    submit_button('Зберегти фільтри');
                    ?>
                </form>
            </div>
            <div class="settings-item js-settingsItem" data-settings="redirections">
                <h2>Перевірка редіректів</h2>
                <div class="js-get_redirectionsContainer"></div>
                <p class="d-flex justify-content-center"><span class="button button-primary js-get_redirections">Перевірити редіректи</span></p>
            </div>
            <div class="settings-item js-settingsItem" data-settings="comments">
                <form id="csv_upload_form" enctype="multipart/form-data">
                    <h3>Завантажити коментарі</h3>
                    <?php
                        $input_file_args = [
                            'accept' => ".csv",
                            'name' => 'ahrefs_csv', 
                            'action' => 'handle_csv_upload'
                        ];
                        get_template_part( 'includes/themeOptions/tmp/input/input', 'file', $input_file_args );
                    ?>
                    <p class="d-flex justify-content-center"><button class="button" type="submit">Завантажити CSV</button></p>                
                </form>
                <div id="upload_response"></div>
            </div>        
            <div class="settings-item js-settingsItem" data-settings="alternates">
                <form id="csv_alternates_upload_form" enctype="multipart/form-data">
                    <h3>Завантажити alternate</h3>
                    <?php
                        $input_file_args = [
                            'id'        => "csv_file",
                            'accept'    => ".csv",
                            'name'      => 'csv_file', 
                            'action'     => 'alternates_csv_upload'
                        ];
                        get_template_part( 'includes/themeOptions/tmp/input/input', 'file', $input_file_args );
                    ?>
                    <p class="d-flex justify-content-center"><button class="button" type="submit">Завантажити CSV</button></p>                
                </form>
                <div id="alternates_response"></div>
            </div>
            <div class="settings-item js-settingsItem" data-settings="reviews_clients">
                <form method="post" class="js-settingsForm" data-action="save_theme_settings" enctype="multipart/form-data">
                    <?php
                    settings_fields("reviews_clients");
                    do_settings_sections("reviews_clients_options");
                    submit_button('Зберегти перелік відгуків');
                    ?>
                </form>
            </div>
            <div class="settings-item js-settingsItem" data-settings="spin_wheel">
                <form method="post" class="js-settingsForm" data-action="save_theme_settings" enctype="multipart/form-data">
                    <?php
                    settings_fields("spin_wheel_fix");
                    do_settings_sections("spin_wheel_fix_options");
                    submit_button('Зберегти налаштування');
                    ?>
                </form>
            </div>
            <div class="settings-item js-settingsItem" data-settings="content">
                <form method="post" class="js-settingsForm" data-action="save_theme_settings" enctype="multipart/form-data">
                    <?php
                    settings_fields("content");
                    do_settings_sections("content_options");
                    submit_button('Зберегти налаштування');
                    ?>
                </form>
            </div>
        </div>
        <div class="js-response settingsResponse">Помилка збереження налаштувань.</div>
    </div>
    <?php
}