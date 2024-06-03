<?php

//=============================//
//***   Базовые настройки   ***//
//=============================//

// Загрузка доп кода для хэдэра
function header_display(){

    $input_text_args = [
        'name' => 'header',
        'value' => get_option('header')
    ];

    echo "<div class='row'>";
    get_template_part( 'includes/themeOptions/tmp/input/input', 'textarea',  $input_text_args);
    echo "</div>";

}

function currency_display(){
    $input_text_args = [
        'css-class' => 'col-md-2',
        'type'=>'text', 
        'name' => 'currency',
        'value' => get_option('currency')
    ];

    echo "<div class='row'>";
    get_template_part( 'includes/themeOptions/tmp/input/input', 'text',  $input_text_args);
    echo "</div>";

}

// Загрузка доп кода для футера
function footer_display(){
    $input_text_args = [
        'name' => 'footer',
        'value' => get_option('footer')
    ];

    echo "<div class='row'>";
    get_template_part( 'includes/themeOptions/tmp/input/input', 'textarea',  $input_text_args);
    echo "</div>";

}

// Загрузка текста в футере
function footer_text_display(){
    $input_text_args = [
        'name' => 'footer_text',
        'value' => get_option('footer_text')
    ];

    echo "<div class='row'>";
    get_template_part( 'includes/themeOptions/tmp/input/input', 'textarea',  $input_text_args);
    echo "</div>";

}

// Показать/скрывать hreflang и переключатель языков
function hreflang_lgsw_display(){
    $hreflang_lgsw = get_option('hreflang_lgsw');

    $input_checkbox_args = [
        'type'=>'checkbox', 
        'name' => 'hreflang_lgsw', 
        'value' => $hreflang_lgsw,
        'options' => [ 
            [
                'label' => '',
                'value' => 'yes'
            ]
         ]
    ];
    
    echo "<div class='row'>";
    get_template_part( 'includes/themeOptions/tmp/input/input', 'checkbox', $input_checkbox_args );
    echo "</div>";
}

// Настройка капчи
function recaptcha_display(){
    $recaptcha = get_option('recaptcha');
    
    if(empty($recaptcha)) $recaptcha = ["site" => '', 'secret' => ''];

    $input_text_args = [
        [
            'css-class' => 'col-md-6',
            'label' => 'Ключ сайта ',
            'type'=>'text', 
            'name' => 'recaptcha[site]',
            'value' => $recaptcha['site']
        ],
        [
            'css-class' => 'col-md-6',
            'label' => 'Секретный ключ ',
            'type'=>'text', 
            'name' => 'recaptcha[secret]',
            'value' => $recaptcha['secret']
        ],
    ];

    echo "<div class='row'>";
    foreach($input_text_args as $args){
        get_template_part( 'includes/themeOptions/tmp/input/input', 'text',  $args);
    }
    echo "</div>";
}

// Настройки языковой версии 
function lang_settings(){
    $lang = get_option('lang');
    if(empty($lang)) $lang = array('html' => 'en', 'hreflang' => 'en', 'hreflang_title' => '' );

    $input_text_args = [
        [
            'css-class' => 'col-md-4',
            'label' => 'HTML lang * ',
            'type'=>'text', 
            'name' => 'lang[html]',
            'value' => $lang['html']
        ],
        [
            'css-class' => 'col-md-4',
            'label' => 'Hreflang * ',
            'type'=>'text', 
            'name' => 'lang[hreflang]',
            'value' => $lang['hreflang']
        ],
        [
            'css-class' => 'col-md-4',
            'label' => 'Hreflang title ',
            'type'=>'text', 
            'name' => 'lang[hreflang_title]',
            'value' => $lang['hreflang_title']
        ],
    ];

    echo "<div class='row'>";
    foreach($input_text_args as $args){
        get_template_part( 'includes/themeOptions/tmp/input/input', 'text',  $args);
    }
    echo "</div>";
}

function best_online_casinos_display(){
    global $cached_casinos;
    $best_online_casinos = get_option('best_online_casinos');
    
    if(empty($best_online_casinos) || $best_online_casinos == 'best_online_casinos' ) $best_online_casinos = ['-1'];

    $input_dropdownlist_args = [
        'options' => $best_online_casinos,
        'all'     => $cached_casinos,
        'name'    => 'best_online_casinos'
    ];

    echo "<div class='row'>";
    get_template_part( 'includes/themeOptions/tmp/dropdownlist', null,  $input_dropdownlist_args);
    echo "</div>";
}

// Иконка Best Choice Casino
function best_choice_casinos_display(){
    global $cached_casinos;
    $best_choice_casino = get_option('best_choice_casinos');
    
    if(empty($best_choice_casino) || $best_choice_casino == 'best_choice_casino' || gettype($best_choice_casino) != 'array' ) $best_choice_casino = ['img' => '', 'ids' => ['-1']];

    $input_image_args = [
        'css-class' => "col-md-3",
        'label' => "Иконка",
        'name' => 'best_choice_casinos[img]',
        'value' => $best_choice_casino['img']
    ];

    $input_dropdownlist_args = [
        'options' => $best_choice_casino['ids'],
        'all'     => $cached_casinos,
        'name'    => 'best_choice_casinos[ids]',
        'css-class' => 'col-md-9'
    ];

    echo "<div class='row'>";
    get_template_part( 'includes/themeOptions/tmp/input/input', 'image',  $input_image_args);
    get_template_part( 'includes/themeOptions/tmp/dropdownlist', null,  $input_dropdownlist_args);
    echo "</div>";
}

// Настройка авторов
function autors_display($num){
    
    // Добавляем поля для нового автора (флаг)
    $is_ajax = gettype($num) == 'array' ? true : false;

    // Пустые значения по умолчанию
    $autors_default = array(
        "link" => "",
        "list" => array(
            array(
                'photo' => '',
                'name' => '',
                'text' => '',
                'soc_logo' => '',
                'soc_link' => ''
            )
        )
    );

    // Названия полей
    $autors_labels = array(
        'photo' => 'Фото',
        'name' => "Ім'я",
        'text' => 'Опис',
        'soc_logo' => 'Логотип соц. мережі',
        'soc_link' => 'Посилання на лого'
    );
    
    $about_link = isset(get_option('autors_site')['link']) ? get_option('autors_site')['link'] : $autors_default['link'];

    // Если не ajax (добавление нового)
    if(gettype($num) == 'array' && empty($num)){
        $num = 0;
        $input_text_args = [
            'label' => "Посилання на іменах автора (скрізь те саме)", 
            'type'  =>'text', 
            'name'  => "autors_site[link]",
            'value' => stripcslashes($about_link)
        ];

        echo "<div class='row'>";
        get_template_part( 'includes/themeOptions/tmp/input/input', 'text',  $input_text_args);
        echo "</div>";
    } 

    // Добавляем поля для нового автора
    $autors = (isset(get_option('autors_site')['list']) && $is_ajax) ? get_option('autors_site')['list'] : array( $num => $autors_default['list'][0] );

    if($autors == "autors_site" || $autors == false) {
        $autors = $autors_default['list'];
    }else{
        foreach($autors_default['list'] as $key_d => $value_d){
            foreach($autors as $key => $value){
                if(!isset($autors[$key][$key_d])) $autors[$key][$key_d] = '';
            }
        }
    }

    foreach($autors as $autor_num => $autor_info){

        // Для добавления полей нового автора выводим номер последнего автора
        if($autor_info == end($autors)){
            $next_num = $autor_num+1;
            $next_num = "data-next='".$next_num."'";
        }else{
            $next_num = "";
        }
        
        echo "<div class='autor_section' $next_num>
                <div class='row'>";

        foreach($autor_info as $autor_field => $autor_value){
            if(isset($autors_labels[$autor_field])){
                switch ($autor_field) {
                    case 'photo':
                    case 'soc_logo':
                        $input_image_args = [
                            'css-class' => 'col-md-3',
                            'label' => $autors_labels[$autor_field],
                            'name'  => "autors_site[list][$autor_num][$autor_field]",
                            'value' => $autor_value
                        ];                    
                        get_template_part( 'includes/themeOptions/tmp/input/input', 'image',  $input_image_args);
                        break;
                    case 'text':
                        $input_editor_args = [
                            'label'     => $autors_labels[$autor_field],
                            'value'     => stripcslashes($autor_value),
                            'name'      => "autors_site[list][$autor_num][$autor_field]",
                            'editor_id' => "autors_site_".$autor_num."_".$autor_field,
                        ];
                        get_template_part( 'includes/themeOptions/tmp/input/input', 'editor',  $input_editor_args);                
                        break;
                    default:
                        $input_text_args = [
                            'css-class' => 'col-md-9',
                            'label' => $autors_labels[$autor_field], 
                            'type'  =>'text', 
                            'name'  => "autors_site[list][$autor_num][$autor_field]",
                            'value' => $autor_value
                        ];
                        get_template_part( 'includes/themeOptions/tmp/input/input', 'text',  $input_text_args);
                }
            }
        }

        echo "
            <div class='bottom-line-btns col-12'>
                <span class='button js-addAutor'>Додати</span>
                <span class='button red js-removeAutor'>Видалити</span>
            </div>
            ";
        echo "</div></div></div>";
    }
}

//=======================//
//***  Поля перевода  ***//
//=======================//
function sites_translations_display(){
    $translations_site = get_option('translations_site');
    
    $default_trans = array(
        "author" => array("value" => "Author" , "desc" => "Автор"),
        "updated" => array("value" => "Updated" , "desc" => "Дата обновления"),
        "number_of_games" => array("value" => "Number111 of games" , "desc" => "Количество игр"),
        "platforms" => array("value" => "Platforms" , "desc" => "Платформы"),
        "deposit" => array("value" => "Deposit" , "desc" => "Депозит"),
        "licenses" => array("value" => "Licenses" , "desc" => "Лицензии"),        
        "min_deposit" => array("value" => "Min deposit" , "desc" => "Минимальный депозит"),
        "max_deposit" => array("value" => "Max deposit" , "desc" => "Максимальный депозит"),
        "best_game" => array("value" => "Best game" , "desc" => "Лучшая игра"),
        "games" => array("value" => "Games" , "desc" => "Игры"),
        "name" => array("value" => "Name" , "desc" => "Название"),
        "providers" => array("value" => "Providers" , "desc" => "Провайдеры"),
        "payment_methods" => array("value" => "Payment methods" , "desc" => "Методы оплаты"),
        "payment" => array("value" => "Payment" , "desc" => "Оплата"),
        "website" => array("value" => "Website" , "desc" => "Сайт"),
        "established" => array("value" => "Established" , "desc" => "Основатель"),
        "owner" => array("value" => "Owner" , "desc" => "Владелец"),
        "support" => array("value" => "Support" , "desc" => "Поддержка"),
        "licences" => array("value" => "Licences" , "desc" => "Лицензия"),
        "languages" => array("value" => "Languages" , "desc" => "Языки"),
        "currencies" => array("value" => "Currencies" , "desc" => "Валюты"),
        "welcome_bonus" => array("value" => "Welcome bonus" , "desc" => "Приветственный бонус"),
        "free_spins" => array("value" => "Free spins" , "desc" => "Бесплатные спины"),        
        "no_deposit_bonus" => array("value" => "No deposit bonus" , "desc" => "Бездепозитный бюонус"),
        "cashback_bonus" => array("value" => "Cashback Bonus" , "desc" => "Кэшбэк бонус"),
        "high_roller" => array("value" => "High Roller Bonus" , "desc" => "Бонус для хайроллеров"),
        "reload_bonus" => array("value" => "Reload Bonus" , "desc" => "Бонус за перезагрузку"),
        "special_offer" => array("value" => "" , "desc" => "Специальный бонус"),
        "vip_bonus" => array("value" => "" , "desc" => "Вип бонус"),
        "email_support" => array("value" => "E-mail support" , "desc" => "Е-мэил поддержка"),
        "live_chat_support" => array("value" => "Live chat support" , "desc" => "Лайв-чат"),
        "phone_support" => array("value" => "Phone support" , "desc" => "Телефонная поддержка"),
        "get_bonus_logo" => array("value" => "Get bonus" , "desc" => "Текст на кнопке получения бонуса"),
        "get_bonus_red" => array("value" => "Get bonus" , "desc" => "Текст на кнопке получения бонуса (2й вариант кнопки)"),
        "play_btn" => array("value" => "Play" , "desc" => "Кпопка 'Играть'"),
        "games_2" => array("value" => "Games" , "desc" => "Игры (2й вариант)"),
        "slot_machines" => array("value" => "Slot machines" , "desc" => "Слот-машины"),
        "live_games" => array("value" => "Live games" , "desc" => "Живые игры"),
        "rulette" => array("value" => "Roulette" , "desc" => "Рулетки"),
        "poker" => array("value" => "Poker" , "desc" => "Покер"),
        "video_poker" => array("value" => "Video poker" , "desc" => "Видео-покер"),
        "bingo" => array("value" => "Bingo" , "desc" => "Бинго"),
        "scratch" => array("value" => "Scratch" , "desc" => "Скрєтч"),
        "blackjack" => array("value" => "Blackjack" , "desc" => "Блєк Джек"),
        "baccarat" => array("value" => "Baccarat" , "desc" => "Баккарат"),
        "other" => array("value" => "Other" , "desc" => "Остольное"),
        "more_info" => array("value" => "More info" , "desc" => "Больше информации"),
        "faq" => array("value" => "FAQ" , "desc" => "ЧаВо"),
        "game_info" => array("value" => "Game info" , "desc" => "Информация об игре"),
        "reels" => array("value" => "Reels" , "desc" => "Катушки"),
        "paylines" => array("value" => "Paylines" , "desc" => "Способы выплат"),
        "min_bet" => array("value" => "Min bet" , "desc" => "Минимальный депозит"),
        "max_bet" => array("value" => "Max bet" , "desc" => "Максимальный депозит"),
        "rtp" => array("value" => "RTP" , "desc" => "RTP"),
        "bonus_rounds" => array("value" => "Bonus rounds" , "desc" => "Бонусные раунды"),
        "wild_symbol" => array("value" => "Wild symbol" , "desc" => "Дикий символ"),
        "scatter_symbol" => array("value" => "Scatter symbol" , "desc" => "Символ разброса"),
        "autoplay" => array("value" => "Autoplay" , "desc" => "Автоигра"),
        "multiplier" => array("value" => "Multiplier" , "desc" => "Мультиплєер"),
        "provider" => array("value" => "Provider" , "desc" => "Провайдер"),
        "more_games" => array("value" => "More games" , "desc" => "Больше игр"),
        "play_free_demo" => array("value" => "Play for free" , "desc" => "Играть бесплатно"),
        "play_real_money" => array("value" => "Play for money" , "desc" => "Играть на деньги"),
        "best_online_casinos" => array("value" => "Best online casinos" , "desc" => "Лучшие онлайн-казино"),
        "bonus" => array("value" => "Bonus" , "desc" => "Бонус"),
        "top_ten" => array("value" => "Top 10 casinos" , "desc" => "Топ 10 казино"),
        "review" => array("value" => "Review" , "desc" => "Обзор"),
        "casino" => array("value" => "Casino" , "desc" => "Казино"),
        "view" => array("value" => "View" , "desc" => "Просмотреть"),
        "benefits" => array("value" => "Benefits" , "desc" => "Преимущества"),
        "blog" => array("value" => "Blog" , "desc" => "Блог"),
        "blog_all" => array("value" => "All posts" , "desc" => "Все посты"),
        "blog_link" => array("value" => "" , "desc" => "Ссылка на все посты"),
        "read_more" => array("value" => "Read more" , "desc" => "Читать больше"),
        "all_casinos" => array("value" => "All casinos" , "desc" => "Все казино"),
        "take_bonus" => array("value" => "Take bonus" , "desc" => "Получить бонус"),
        "pluses" => array("value" => "Pluses" , "desc" => "Плюсы"),
        "minuses" => array("value" => "Minuses" , "desc" => "Минусы"),
        "slots" => array("value" => "Slots" , "desc" => "Слоты"),
        "table_games" => array("value" => "Table games" , "desc" => "Настольные игры"),
        "live_game" => array("value" => "Live games" , "desc" => "Живые игры"),
        "jackpot_games" => array("value" => "Jackpot games" , "desc" => "Игры с джекпотом"),
        "betting" => array("value" => "Betting" , "desc" => "Игры со ставками"),
        "card_games" => array("value" => "Card games" , "desc" => "Карточные игры"),
        "steps" => array("value" => "Steps" , "desc" => "Шаги"),
        "top_5_things" => array("value" => "Top 5 things" , "desc" => "5 главных вещей"),
        "game_types" => array("value" => "Game types" , "desc" => "Типы игр"),
        "thumbnail" => array("value" => "Logo" , "desc" => "Лого"),
        "slot" => array("value" => "Slot" , "desc" => "Слот"),
        "rating" => array("value" => "Rating" , "desc" => "Рейтинг"),
        "developer" => array("value" => "Developer" , "desc" => "Разработчик"),
        "all_slots" => array("value" => "All slots" , "desc" => "Все слоты"),
        "game_features" => array("value" => "Game features" , "desc" => "Особенности игры"),
        "yes" => array("value" => "Yes" , "desc" => "Да"),
        "no" => array("value" => "No" , "desc" => "Нет"),
        "follow_us" => array("value" => "Follow us" , "desc" => "Подписывайтесь на нас"),
        "filter" => array("value" => "Filter" , "desc" => "Фильтр"),
        "all" => array("value" => "All" , "desc" => "Все"),
        "bonuses" => array("value" => "Bonuses" , "desc" => "Бонусы"),
        "search" => array("value" => "Search" , "desc" => "Поиск"),
        "menu" => array("value" => "Menu" , "desc" => "Меню"),
        "all_games" => array("value" => "All games" , "desc" => "Все игры"),
        "main_page" => array("value" => "" , "desc" => "Ссылка на главную"),
        "games_link" => array("value" => "best-slot-sites/" , "desc" => "Ссылка на игры в нижнем меню на мобильных устройствах"),
        "bonuses_link" => array("value" => "100-deposit-bonus/" , "desc" => "Ссылка на бонусы в нижнем меню на мобильных устройствах"),
        "all_category_game" => array("value" => "All game categories" , "desc" => "Все категории игр"),
        "next_blog_post" => array("value" => "Next post" , "desc" => "Следующий пост"),
        "prev_blog_post" => array("value" => "Prev post" , "desc" => "Предыдущий пост"),
        "all_providers" => array("value" => "All providers" , "desc" => "Все провайдеры"),
        "logo" => array("value" => "Logo" , "desc" => "Логотип"),
        "description" => array("value" => "Description" , "desc" => "Описание"),
        "top3_casino" => array("value" => "Top-3 Casino" , "desc" => "Топ-3 казино"),
        "pages" => array("value" => "Pages" , "desc" => "Страницы"),
        "casinos" => array("value" => "Casinos" , "desc" => "Казино"),
        "page_not_found" => array("value" => "Page not found" , "desc" => "Страница не найдена"),
        "go_to_homepage" => array("value" => "Back to homepage" , "desc" => "На главную"),
        "no_results_found" => array("value" => "No results found" , "desc" => "Результаты не найдены"),
        "tabel_of_content" => array("value" => "Table of content" , "desc" => "Оглавление"),
        "all_casinos_link" => array("value" => "/en/" , "desc" => "Ссылка на основную страницу"),
        "casinocat" => array("value" => "Casino categories", "desc" => "Категории казино"),
        "alert_title" => array("value" => "Attention", "desc" => "Внимение"),
        "alert_text" => array("value" => "The OnlinecasinoProfy team does not recommend this site.", "desc" => "Текст предупрежденрия"),
        "vote" => array("value" => "Your vote has been counted", "desc" => "Ваш голос засчитан"),
        "not_vote" => array("value" => "You have already voted", "desc" => "Вы уже голосовали"),
        "not_location" => array("value" => "", "desc" => "Сообщения, где есть казино не под текущую страну"),
        "next_step" => array("value" => "Next step", "desc" => "Следующий шаг"),
        "previous_step" => array("value" => "Previous step", "desc" => "Предыдущий шаг"),
        "start_step" => array("value" => "Start over", "desc" => "Начать сначала"),
        "currency_alert" => array("value" => "", "desc" => "Сообщение, что нет чёткой вылюты на сайте (выводится в фильтрах)"),
        "popup_casinos_new_btn" => array("value" => "Claim" , "desc" => "Кнопка казино в попапе"),
        "play_in_casino_of_the_month" => array("value" => "Play in casino of the month" , "desc" => "Играть в казино месяца (на баннере)"),
        "casino_of_the_month" => array("value" => "Casino of the month" , "desc" => "Казино месяца (на баннере)"),
        "mobile" => array("value" => "" , "desc" => "Mobile"),
        "tablet" => array("value" => "" , "desc" => "Tablet"),
        "desktop" => array("value" => "" , "desc" => "Desktop"),
        "download" => array("value" => "" , "desc" => "Download"),
        "show_more" => array("value" => "" , "desc" => "Show More"),
        "show_less" => array("value" => "" , "desc" => "Show Less"),
        "rate_this_material" => array("value" => "Rate this material" , "desc" => "Оцените этот материал"),
        "error_msg" => array("value" => "An error has occurred. Please try again later." , "desc" => "Сообщение об ошибке при отправке комментария"),
        "your_rating" => array("value" => "Your rating" , "desc" => "Ваш рейтинг"),
        "invalid_rating" => array("value" => "Incorrect rating" , "desc" => "Неверный рейтинг"),        
        "required_rating" => array("value" => "Rating is required" , "desc" => "Поле рейтинга обязательно"),        
        "your_review" => array("value" => "Your review" , "desc" => "Ваш обзор"),
        "placeholder_review" => array("value" => "Leave your review..." , "desc" => "Плейсхолдер поля обзора в форме рейтинга"),
        "invalid_review" => array("value" => "The review must contain from 10 to 1500 characters. Links are prohibited." , "desc" => "Ошибка валидации поля обзора/ответа на обзор в форме рейтинга"),        
        "required_review" => array("value" => "Review is required." , "desc" => "Комментарий обязателен."),
        "placeholder_name" => array("value" => "Your name" , "desc" => "Плейсхолдер поля имени в форме рейтинга"),
        "invalid_name" => array("value" => "The name must contain from 2 to 35 characters." , "desc" => "Ошибка валидации поля имени в форме рейтинга"),
        "required_name" => array("value" => "Name is required." , "desc" => "Имя обязательно."),        
        "your_email" => array("value" => "Your Email." , "desc" => "Ваша почта"),
        "required_email" => array("value" => "Email is required." , "desc" => "Требуется электронная почта."),
        "invalid_email" => array("value" => "Invalid email format." , "desc" => "Некорректная почта."),
        "robot_check" => array("value" => "Please confirm that you are not a robot." , "desc" => "Пожалуйста, подтвердите, что вы не робот."),
        "send" => array("value" => "Send" , "desc" => "Отправить"),
        "reply_title" => array("value" => "Reply to review" , "desc" => "Тайтл ответа на комментарий"),
        "your_reply" => array("value" => "Your reply" , "desc" => "Show Less"),
        "placeholder_reply" => array("value" => "Leave your reply..." , "desc" => "Плейсхолдер поля ответа на комментарий"),
        "invalid_reply" => array("value" => "The review reply contain from 10 to 1500 characters. Links are prohibited." , "desc" => "Ошибка валидации поля обзора/ответа на обзор в форме рейтинга"),
        "reviews" => array("value" => "Reviews" , "desc" => "Тайтл над обзорами"),
        "reply" => array("value" => "Reply" , "desc" => "Кнопка реплая"),
        "hide_replies" => array("value" => "Hide replies" , "desc" => "Спрятать ответы"),
        "show_replies" => array("value" => "Show replies" , "desc" => "Показать ответы"),
        "more_replies" => array("value" => "More replies" , "desc" => "Больше ответов"),
        "repeated_review" => array("value" => "You have already left a review on this material. Repeated review are not allowed." , "desc" => "Вы уже оставляли обзор на этой странице. Повторные комментарии не допускаются."),
        "success_review" => array("value" => "Thanks for your review. It will be published after verification by a moderator." , "desc" => "ОБзор отправлен на модерацию"),
        "success_reply" => array("value" => "Thanks for your reply. It will be published after verification by a moderator." , "desc" => "Ответ на оБзор отправлен на модерацию"),
        "more_reviews" => array("value" => "More reviews" , "desc" => "Кнопка 'больше обзоров'"),
        "month_01" => array("value" => "January" , "desc" => "Январь"),
        "month_02" => array("value" => "February" , "desc" => "Февраль"),
        "month_03" => array("value" => "March" , "desc" => "Март"),
        "month_04" => array("value" => "April" , "desc" => "Апрель"),
        "month_05" => array("value" => "May" , "desc" => "Май"),
        "month_06" => array("value" => "June" , "desc" => "Июнь"),
        "month_07" => array("value" => "July" , "desc" => "Июль"),
        "month_08" => array("value" => "August" , "desc" => "Август"),
        "month_09" => array("value" => "September" , "desc" => "Сентябрь"),
        "month_10" => array("value" => "October" , "desc" => "Октябрь"),
        "month_11" => array("value" => "November" , "desc" => "Ноябрь"),
        "month_12" => array("value" => "December" , "desc" => "Декабрь")
    );

    $input_text_args = [
        'css-class' => 'col-md-6',
        'type'=>'text'
    ];

    echo "<div class='row'>";

    foreach($default_trans as $item => $val){

        $input_text_args['name'] = "translations_site[".$item."]";
        $input_text_args['label'] = $val['desc'];

        if($translations_site && isset($translations_site[$item]) && !empty($translations_site[$item])){
            $input_text_args['value'] = $translations_site[$item];
        }else{
            $input_text_args['value'] = $val['value'];
        }

        get_template_part( 'includes/themeOptions/tmp/input/input', 'text',  $input_text_args);

    }
    
    echo "</div>";

}

function CheckIfEditorFieldIsRequired($editorMarkup){
  if (stripos($editorMarkup, 'my-required-field') !== false) {
    $editorMarkup = str_replace('<textarea', '<textarea required', $editorMarkup);
  }
  return $editorMarkup;
}

// Добавление казино в попап
function popup_casinos_display(){

    global $cached_casinos;

    $popup_casinos = get_option('popup_casinos_section');

    if(empty($popup_casinos) || $popup_casinos == 'popup_casinos' ) $popup_casinos = array('title' => '', 'list' => '');
    if(!isset($popup_casinos['title']) || !$popup_casinos['title']) $popup_casinos['title'] = '';
    if(!isset($popup_casinos['list']) || !$popup_casinos['list']) $popup_casinos['list'] = ['-1'];

    $input_text_args = [
        'label'=>'Заголовок попапа:', 
        'type'=>'text', 
        'name' => 'popup_casinos_section[title]',
        'value' => $popup_casinos['title'],
        'css-class' => 'col-md-3'
    ];
    
    $input_dropdownlist_args = [
        'options' => $popup_casinos['list'],
        'all'     => $cached_casinos,
        'name'    => 'popup_casinos_section[list]',
        'css-class' => 'col-md-9'
    ];

    echo "<div class='row'>";
    get_template_part( 'includes/themeOptions/tmp/input/input', 'text',  $input_text_args);
    get_template_part( 'includes/themeOptions/tmp/dropdownlist', null,  $input_dropdownlist_args);
    echo "</div>";
    
}

// Добавление казино в попап
function popup_cookie_display(){
    $popup_cookie = get_option('popup_cookie_section');

    $popup_cookie_default = array(
        "text" => array(
            "label" => "Текст",
            "value" => ""
        ),
        "link" => array(
            "label" => "Посилання Privacy policy",
            "value" => ""
        ),
        "link_text" => array(
            "label" => "Текст на посиланні Privacy policy",
            "value" => ""
        ),
        "btn" => array(
            "label" => "Текст на кнопці згоди",
            "value" => ""
        ),
    );

    echo "<div class='row'>";
    foreach($popup_cookie_default as $key => $val){
        if(!isset($popup_cookie[$key]) || !$popup_cookie[$key]) $popup_cookie[$key] = $val['value'];

        $input_text_args = [
            'label'=> $val['label'], 
            'type'=>'text', 
            'name' => "popup_cookie_section[$key]",
            'value' => htmlspecialchars(stripcslashes($popup_cookie[$key])),
            'css-class' => 'col-md-6'
        ];

        if($key == 'link' || $key == 'link_text') $input_text_args['required'] = '';
        
        get_template_part( 'includes/themeOptions/tmp/input/input', 'text',  $input_text_args);
    }
    echo "</div>";

}

// Плашки казино
function plashka_display($ajax_num){
    // $ajax_num = ajax на добавление новой плашки
    // в БД поменять plashka_section на plashka
    $plashka_casino = get_option('plashka');
    
    // дефолтные значения
    $plashka_casino_default = [
        [
            "name" => "",
            "color" => "#828282"
        ]
    ];

    // если значения не заданы или если это ajax на добавление новой плашки
    if(gettype($plashka_casino) != 'array') {
        $plashka_casino = $plashka_casino_default;
    }elseif(!empty($ajax_num)){
        $plashka_casino = [];
        $plashka_casino[$ajax_num] = $plashka_casino_default[0];
    }

    if(empty($ajax_num)) echo "<div class='row js-plashkaContainer'>";
    
    foreach($plashka_casino as $num => $plashka){
        echo "<div class='col-12 js-plashkaItem' data-plashkaNum='$num'><div class='row'>";

        $input_text_args = [
            'label'=>'Назва', 
            'type'=>'text', 
            'name' => "plashka[$num][name]",
            'value' => $plashka['name'],
            'css-class' => 'col-md-5',
            'required' => ''
        ];

        get_template_part( 'includes/themeOptions/tmp/input/input', 'text',  $input_text_args);

        $input_text_args = [
            'label'=>'Колір', 
            'type'=>'text', 
            'name' => "plashka[$num][color]",
            'value' => $plashka['color'],
            'css-class' => 'col-md-5',
            'css-input' => 'coloris',
        ];

        get_template_part( 'includes/themeOptions/tmp/input/input', 'text',  $input_text_args);

        echo "<div class='input-container col-md-2 align-items-end d-flex'><span class='button red js-removePlaska'>×</span></div></div></div>";
    }

    if(empty($ajax_num)) echo "</div><span class='button addPlashka js-addPlashka'>Добавить плашку</span>";
    
}

// Плашки казино
function payment_display($payment_id){
    // В БД замениит payment_section на payment
    $payment = get_option('payment');
    $payment_default = array([
        "name" => "",
        "link" => ""
    ]);

    if($payment == "payment" || $payment == false || !empty($payment_id) || gettype($payment_id) == "array") 
        $payment = $payment_default;

    echo "<div class='js-paymentContainer'>";

    foreach($payment as $num => $pay){
        if(!empty($payment_id)) $num = $payment_id;
        $input_text_args = [
            'label'=>'Назва', 
            'type'=>'text', 
            'name' => "payment[$num][name]",
            'value' => $pay['name'],
            'css-class' => 'col-md-6'
        ];

        
        echo "<div class='row payment-item' data-paymentNum='$num'>";
        get_template_part( 'includes/themeOptions/tmp/input/input', 'text',  $input_text_args);

        $input_text_args = [
            'label'=>'Посилання', 
            'type'=>'text', 
            'name' => "payment[$num][link]",
            'value' => $pay['link'],
            'css-class' => 'col-md-6'
        ];

        get_template_part( 'includes/themeOptions/tmp/input/input', 'text',  $input_text_args);
        echo "<span class='button red js-removePayment'>Видалити</span>
            </div>";
    }

    // Если не ajax
    if(gettype($payment_id) == "array") echo "</div><span class='button addPayment js-addPayment'>Додати</span>";
    
}

// Добавление казино в попап с UK
function uk_popup_casinos_display(){

    global $cached_casinos;
    $uk_popup_casinos = get_option('uk_popup_casinos');
    if($uk_popup_casinos == "uk_popup_casinos" || $uk_popup_casinos == false) $uk_popup_casinos = array('-1');

    if(empty($popup_casinos) || $popup_casinos == 'popup_casinos' ) $popup_casinos = array('title' => '', 'list' => '');
    if(!isset($popup_casinos['title']) || !$popup_casinos['title']) $popup_casinos['title'] = '';
    if(!isset($popup_casinos['list']) || !$popup_casinos['list']) $popup_casinos['list'] = ['-1'];
    
    $input_dropdownlist_args = [
        'options' => $uk_popup_casinos,
        'all'     => $cached_casinos,
        'name'    => 'uk_popup_casinos',
    ];

    echo "<div class='row'>";
    get_template_part( 'includes/themeOptions/tmp/dropdownlist', null,  $input_dropdownlist_args);
    echo "</div>";

}

// Добавление казино в блок "casino of the month"
function casino_left_sidebar_display(){
    // В БД замениит casino_left_sidebar_section на casino_left_sidebar

    global $cached_casinos;
    $casino_left_sidebar = get_option('casino_left_sidebar');

    $casino_left_sidebar_def = [
        'is_show' => '',
        'casinos' => ['-1']
    ];
    
    if(gettype($casino_left_sidebar) != "array") $casino_left_sidebar = $casino_left_sidebar_def;

    $input_checkbox_args = [
        'css-class' => 'col-md-3',
        'type'=>'checkbox', 
        'name' => "casino_left_sidebar[is_show]", 
        'label' => 'Вивести казино у лівому сайдбарі',
        'value' => $casino_left_sidebar['is_show'],
        'options' => [ 
            [
                'label' => '',
                'value' => 'yes'
            ]
         ]
    ];

    $input_dropdownlist_args = [
        'css-class' => 'col-md-9',
        'options' => $casino_left_sidebar['casinos'],
        'all'     => $cached_casinos,
        'name'    => "casino_left_sidebar[casinos]"
    ];

    echo "<div class='row'>";
    get_template_part( 'includes/themeOptions/tmp/input/input', 'checkbox', $input_checkbox_args );
    get_template_part( 'includes/themeOptions/tmp/dropdownlist', null,  $input_dropdownlist_args );
    echo "</div>";

}

// Налаштування фільтрів казино
function casino_filters_display($num){

    $casFilter = get_option('casino_filters');
    // В БД замениит casino_filters_section на casino_filters

    if(empty($num)){

        // Получаем все поля ACF
        $acf_array_args = array(
            'post_type'         => 'acf-field-group',
            'posts_per_page'    => -1
        );
        $acf_array = new WP_Query( $acf_array_args );
        
        // Фильтры на основе ACF
        $acf_filters = array();
        
        // Забираем предустановленные значения ACF
        foreach($acf_array->posts as $field_item){

            $field_group_key = $field_item->post_name; // ключ группы полей
            $fields_info = acf_get_fields($field_group_key);
            foreach($fields_info as $field_info){
                // Вытягиваем бонусы
                if($field_info['name'] == 'bonus_on_top'){
                    $acf_filters[$field_info['name']]['list'] = $field_info['choices'];
                }

                // Вытягиваем типы игр
                if($field_info['name'] == 'games_types'){
                    foreach($field_info['sub_fields'] as $games_types_field){
                        if($games_types_field['name'] == 'list'){
                            $acf_filters[$field_info['name']]['list'] = $games_types_field['choices'];
                        } 
                    }
                }
            }
        }
    }

    $my_filters = [
        "payment_methods" => [
            'title' => "Методи оплати",
            'list' => [['value' => '', 'img' => '' ]]
        ],
        "bonus_on_top" => [
            'title' => "Бонуси",
            'list' => [['value' => '', 'img' => '' ]]
        ],
        "games_types" => [
            'title' => "Види ігор",
            'list' => [['value' => '', 'img' => '' ]]
        ],
        "min_deposit" => [
            'title' => "Мінімальний депозит",
            'list' => [['value' => '']]
        ],
        "max_deposit" => [
            'title' => "Максимальний депозит",
            'list' => [['value' => '']]
        ]
    ];

    if(!empty($num)){
        $casFilter = ['payment_methods' => $my_filters['payment_methods']['list']];
        $my_filters = [
            "payment_methods" => [
                'title' => "Методи оплати",
                'list' => [['value' => '', 'img' => '' ]]
            ]];
    }

    // Формируем поля
    foreach($my_filters as $type => $filter){
        if(isset($casFilter[$type])) $filter['list'] = $casFilter[$type];
        
        $data = '';
        if($type == 'payment_methods' ) $data = "data-paymentMethodsNum='".array_key_last($filter['list'])."'";

        // Новый массив для хранения значений value
        $values_array = [];

        // Цикл для обхода исходного массива
        foreach ($filter['list'] as $item) {
            // Проверка наличия ключа 'value'
            if (isset($item['value'])) {
                // Добавление значения в новый массив
                $values_array[] = $item['value'];
            }
        }

        $section_start = "<div class='filter_item js-$type' $data>
            <div class='input-container'><p class='option-title'>".$filter['title']."</p></div>
            <div class='row'>";
            
        // Рендер типов игр и бонусов
        if( in_array($type, ['games_types', 'bonus_on_top']) ){
            $i = 0;
            
            echo $section_start;

            foreach($acf_filters[$type]['list'] as $val => $acf_filter){   
                // Расставляем галочки в чекбоксах                 
                $input_checkbox_args = [
                    'css-class' => '',
                    'type'=>'checkbox', 
                    'name' => "casino_filters[$type][$i][value]", 
                    'value' => $values_array,
                    'options' => [[
                            'label' => $acf_filter,
                            'value' => $val
                        ]                        
                    ]
                ];

                $input_image_args = [
                    'name' => "casino_filters[$type][$i][img]",
                    'value' => $filter['list'][$i]['img']
                ];

                echo "<div class='col-md-4 filter-option'>";
                get_template_part( 'includes/themeOptions/tmp/input/input', 'checkbox', $input_checkbox_args );
                get_template_part( 'includes/themeOptions/tmp/input/input', 'image',  $input_image_args);
                echo "</div>";

                $i++;
            }
        }else if( $type == 'payment_methods' ){
            if(empty($num)) echo $section_start;

            // Рендер методов оплаты
            foreach($filter['list'] as $val => $item_filter){
                if(!empty($num)) $val = $num;
                $input_text_args = [
                    'type'=>'text', 
                    'name' => "casino_filters[$type][$val][value]",
                    'value' => $item_filter['value'],
                ];

                $input_image_args = [
                    'name' => "casino_filters[$type][$val][img]",
                    'value' => $filter['list'][$val]['img']
                ];

                echo "<div class='col-md-4 filter-option js-filter_item-container'>";

                get_template_part( 'includes/themeOptions/tmp/input/input', 'text', $input_text_args );
                get_template_part( 'includes/themeOptions/tmp/input/input', 'image',  $input_image_args );

                echo '<div class="textright col-12"><span class="button red js-removePaymentMethods">Удалить</span></div>';
                echo "</div>";

            }
            if(empty($num)) echo "<div class='col-12'><span class='button js-addPaymentMethods'>Додвти</span></div>";
        }elseif( in_array($type, ['min_deposit', 'max_deposit']) ){
            if( $type == "min_deposit" ) {
                echo "<div class='row filter_item'>
                <div class='col-md-6'>
                <div class='input-container'><p class='option-title'>".$filter['title']."</p></div>";
            }elseif ( $type == "max_deposit" ){
                echo "<div class='col-md-6'>
                <div class='input-container'><p class='option-title'>".$filter['title']."</p></div>";
            }
            foreach($filter['list'] as $val => $item_filter){

                $input_text_args = [
                    'css-class'=>'', 
                    'type'=>'text', 
                    'name' => "casino_filters[$type][$val][value]",
                    'value' => $item_filter['value'],
                ];

                get_template_part( 'includes/themeOptions/tmp/input/input', 'text', $input_text_args );
            }
            if( $type == "min_deposit" ) echo "</div>";
            if( $type == "max_deposit" ) echo "</div></div>";

            
        }
        if( empty($num) && !in_array($type, ["max_deposit", "min_deposit"] )) echo "</div></div>";
    }
}

// Настройка отзывов
function reviews_clients_display($num){

    // Смотрим Ajax или нет
    $is_ajax = gettype($num) == 'array' ? true : false;
    
    // Пустые значения по умолчанию
    $reviews_default = array(
        "title" => "",
        "list" => array(
            array(
                'photo' => '',
                'name' => '',
                'job_title' => '',
                'name_company' => '',
                'url_company' => '',
                'review' => ''
            )
        )
    );

    $reviews = get_option('reviews_clients');
    
    // Названия полей
    $reviews_clients_labels = array(
        'photo' => 'Фото людини',
        'name' => "Ім'я прізвище",
        'job_title' => 'Посада',
        'name_company' => 'Назва компанії',
        'url_company' => 'URL компанії',
        'review' => 'Відгук',
    );

    if(gettype($num) == 'array' && empty($num)){
        $num = 0;
        
        $input_text_args = [
            'css-class'=>'col-12', 
            'label'=> 'Заголовок блоку відгуків', 
            'type'=>'text', 
            'name' => "reviews_clients[title]",
            'value' => isset($reviews['title']) ? $reviews['title'] : $reviews_default['title'],
        ];

        echo "<div class='row'>";
        get_template_part( 'includes/themeOptions/tmp/input/input', 'text', $input_text_args );
        echo "</div>";
    }

    // 
    $reviews = (isset($reviews['list']) && $is_ajax) ? $reviews['list'] : [$num => $reviews_default['list'][0]];

    if(gettype($reviews) != 'array') {
        $reviews = $reviews_default['list'];
    }else{
        foreach($reviews_default['list'] as $key_d => $value_d){
            foreach($reviews as $key => $value){
                if(!isset($reviews[$key][$key_d])) $reviews[$key][$key_d] = '';
            }
        }
    }

    foreach($reviews as $review_num => $review_info){
        if($review_info == end($reviews)){
            $next_num = $review_num+1;
            $next_num = "data-next-review='".$next_num."'";
        }else{
            $next_num = "";
        }

        echo "<div class='row reviews_clients_section' $next_num>";
        foreach($review_info as $review_field => $review_value){
            if(isset($reviews_clients_labels[$review_field])){
                switch ($review_field) {
                    case 'photo':

                        $input_image_args = [
                            'label' => $reviews_clients_labels[$review_field],
                            'name'  => "reviews_clients[list][$review_num][$review_field]",
                            'value' => $review_value
                        ]; 
                        get_template_part( 'includes/themeOptions/tmp/input/input', 'image',  $input_image_args);

                        break;
                    case 'review':

                        $input_editor_args = [
                            'label'     => $reviews_clients_labels[$review_field],
                            'value'     => stripcslashes($review_value),
                            'name'      => "reviews_clients[list][$review_num][$review_field]",
                            'editor_id' => "reviews_clients_" . $review_num . "_" . $review_field
                        ];
                        get_template_part( 'includes/themeOptions/tmp/input/input', 'editor',  $input_editor_args); 

                        break;
                    default:

                        $input_text_args = [
                            'css-class' => 'col-md-6',
                            'label'     => $reviews_clients_labels[$review_field],
                            'type'      =>'text', 
                            'name'      => "reviews_clients[list][$review_num][$review_field]",
                            'value'     => $review_value
                        ];
                        get_template_part( 'includes/themeOptions/tmp/input/input', 'text',  $input_text_args);
                }
            }

        }
        echo "<div class='col-12 bottom-line-btns'>
                <span class='button js-addReview'>Додати</span>
                <span class='button red js-removeReview'>Видалити</span>
            </div>
            </div>";
    }
}

// Колесо фортуны
function spin_wheel_fix_display(){
    // В БД замениит spin_wheel на spin_wheel_fix

    $spin_wheel_fix = get_option('spin_wheel_fix');

    if(gettype($spin_wheel_fix) != "array"){
        $spin_wheel_fix = [
            'items' => [],
            'itemBackgroundColors' => [''],
            'itemLabelColors' => [''],
            'itemLabelFontSizeMax' => 42,
            'lineWidth' => 0,
            'duration' => 2000,
            'up_text' => 'Get the free bonus!', 
            'bonus' => 'BONUS', 
            'title_banner' => 'Equivalent:', 
            'bonus_text' => '$100', 
            'bottom_banner_text' => 'You got a bonus!', 
            'btn_text' => 'Get bonus', 
            'banner_link' => '/', 
            'under_btn_text' => '', 
            'under_btn_link' => '', 
            'show_more_text' => 'Show more', 
        ];
    }

    if(!isset($spin_wheel_fix['is_show'])) $spin_wheel_fix['is_show'] = '';
    if(!isset($spin_wheel_fix['a_b'])) $spin_wheel_fix['a_b'] = '';

    echo "<div class='row spinWheel-general'><h3 class='col-12'>Загальні</h3>";

    $input_is_show_args = [
        'css-class' => 'col-md-6',
        'type'=>'checkbox', 
        'name' => 'spin_wheel_fix[is_show]', 
        'value' => $spin_wheel_fix['is_show'],
        'options' => [ 
            ['label' => 'Показувати колесо фортуни:',     'value' => 'show']
        ]
    ];
    get_template_part( 'includes/themeOptions/tmp/input/input', 'checkbox', $input_is_show_args );

    $input_a_b_args = [
        'css-class' => 'col-md-6',
        'type'=>'checkbox', 
        'name' => 'spin_wheel_fix[a_b]',
        'value' => $spin_wheel_fix['a_b'],
        'options' => [
            ['label' => 'A/B тест',     'value' => 'a_b']]
    ];
    get_template_part( 'includes/themeOptions/tmp/input/input', 'checkbox', $input_a_b_args );

    echo "</div>";

    // Блок с настройками вариантов колеса
    echo "<h3>Варіанти</h3>
    <div class='js-spinWheelContainer'>";    
    foreach($spin_wheel_fix['items'] as $num => $label){
        // Рендер полей вариантов
        render_spinWheel_fields($num, $label, $spin_wheel_fix);
    }
    echo "</div>
    <div class='row spinWheel-add'>
        <div class='col-12'>
            <span class='button js-addSpinWheelItem'>Додати</span>
        </div>
    </div>";
    // END Блок с настройками вариантов колеса

    // Параметры поведения и настройки виде казино
    $fields_info = [
        'duration'             => ['label' => 'Тривалість анімації колеса*',           'type' => 'number', 'required' => ''],
        'itemLabelFontSizeMax' => ['label' => 'Розмір тексту*',                        'type' => 'number', 'required' => ''],
        'lineWidth'            => ['label' => 'Ширина ліній-розділювачів*',            'type' => 'number', 'required' => ''],
        'up_text'              => ['label' => 'Текст над банером*',                    'type' => 'text',   'required' => ''],
        'title_banner'         => ['label' => 'Тайтл банера*',                         'type' => 'text',   'required' => ''],
        'bonus_text'           => ['label' => 'Текст бонусу*',                         'type' => 'text',   'required' => ''],
        'bottom_banner_text'   => ['label' => 'Текст унизу банера*',                   'type' => 'text',   'required' => ''],
        'btn_text'             => ['label' => 'Текст кнопки*',                         'type' => 'text',   'required' => ''],
        'bonus'                => ['label' => 'Текст у центрі колеса*',                'type' => 'text',   'required' => ''],
        'banner_link'          => ['label' => 'Посилання на банері, колесі та кнопці*','type' => 'text',   'required' => ''],
        'show_more_text'       => ['label' => 'Текст на кнопці для показу тексту*',    'type' => 'text',   'required' => ''],
        'under_btn_text'       => ['label' => 'Текст під кнопкою',                     'type' => 'text'],
        'under_btn_link'       => ['label' => 'Посилання під кнопку',                  'type' => 'text']
    ];

    echo "<div class='row'><h3 class='col-12'>Налаштування колеса</h3>"; 
    foreach ($spin_wheel_fix as $key => $value) {
        if(isset($fields_info[$key])){
            $input_text_args = [
                'css-class' => 'col-md-3',
                'label'     => $fields_info[$key]['label'],
                'type'      => $fields_info[$key]['type'], 
                'name'      => "spin_wheel_fix[$key]",
                'value'     => $value
            ];
            if(isset($fields_info[$key]['required'])) $input_text_args['required'] = '';
            get_template_part( 'includes/themeOptions/tmp/input/input', 'text',  $input_text_args);
        }
    }
    echo "</div>"; 
    // END Параметры поведения и настройки виде казино
}

function render_spinWheel_fields($num, $label, $spin_wheel_fix){
    
    if(!isset($spin_wheel_fix['itemBackgroundColors'][$num])) $spin_wheel_fix['itemBackgroundColors'][$num] = '#ccc8c8';
    if(!isset($spin_wheel_fix['itemLabelColors'][$num])) $spin_wheel_fix['itemLabelColors'][$num] = '#000';
    if(!isset($label['label'])) $label['label'] = '';

    echo "<div class='row spinWheel-item js-spinWheelItem' data-spinNum='".$num."'>";    
    $input_text_args = [
        'css-class' => 'col-md-3',
        'label'     => "Значення",
        'type'      => 'text', 
        'name'      => "spin_wheel_fix[items][".$num."][label]",
        'value'     => $label['label']
    ];
    get_template_part( 'includes/themeOptions/tmp/input/input', 'text',  $input_text_args);
    
    $input_text_args = [
        'css-input' => 'coloris',
        'css-class' => 'col-md-3',
        'label'     => "Колір фону",
        'type'      => 'text', 
        'name'      => "spin_wheel_fix[itemBackgroundColors][".$num."]",
        'value'     => $spin_wheel_fix['itemBackgroundColors'][$num]
    ];
    get_template_part( 'includes/themeOptions/tmp/input/input', 'text',  $input_text_args);

    $input_text_args = [
        'css-input' => 'coloris',
        'css-class' => 'col-md-3',
        'label'     => "Колір тексту",
        'type'      => 'text', 
        'name'      => "spin_wheel_fix[itemLabelColors][".$num."]",
        'value'     => $spin_wheel_fix['itemLabelColors'][$num]
    ];
    get_template_part( 'includes/themeOptions/tmp/input/input', 'text',  $input_text_args);

    $input_text_args = [
        'css-input' => 'coloris',
        'css-class' => 'col-md-1',
        'label'     => "Виграшний",
        'type'      => 'radio', 
        'name'      => "spin_wheel_fix[winner]",
        'value'     => [$spin_wheel_fix['winner']],
        'options'   => [['value' => $num]]
    ];
    get_template_part( 'includes/themeOptions/tmp/input/input', 'checkbox',  $input_text_args);
    
    echo '<div class="align-items-center col-md-2 d-flex justify-content-end spin_wheel_fix-item-remove">
            <span class="button red js-removeSpinWheelItem">Видилити</span>
        </div>        
    </div>';
}

function add_spinWheel_fields(){
    if(isset($_GET['spin_num'])) render_spinWheel_fields($_GET['spin_num'], [], ['winner' => 0]);
    wp_die();
}

function add_review_field(){
    if(isset($_POST['review_num'])) reviews_clients_display($_POST['review_num']);
    wp_die();
}

// Скрыть контент
function content_display(){
    
    $content = get_option('content');
    
    if(gettype($content) != 'array' ){
        $content = [
            'hide' => '',
            'title_meta' => '',
            'shortcodes' => []
        ];
    }
    $fields = ['hide','title_meta','shortcodes'];
    foreach($fields as $field){
        if(!isset($content[$field])) $content[$field] = [];
    }
        
    $input_hide_args = [
        'css-class' => 'col-md-4',
        'type'=>'checkbox',
        'name' => 'content[hide]', 
        'value' => $content['hide'],
        'options' => [ 
            ['label' => 'Увімкнути',    'value' => 'content']
        ]
    ];

    $input_title_args = [
        'css-class' => 'col-md-4',
        'type'=>'radio', 
        'name' => 'content[title_meta]', 
        'label' => 'Як виводити title/meta title/meta description',
        'value' => $content['title_meta'],
        'options' => [
            ['label' => 'З кастомних полів',            'value' => 'custom'],
            ['label' => 'Виводити скрізь title поста',  'value' => 'title'],
            ['label' => 'Без змін',                     'value' => 'default'],
        ]
    ];

    $input_shortcodes_args = [
        'css-class' => 'col-md-4',
        'type'=>'checkbox', 
        'name' => 'content[shortcodes][]', 
        'label' => 'Не приховувати шорткоди:',
        'value' => $content['shortcodes'],
        'options' => [
            ['label' => 'autors',                   'value' => 'autors'],
            ['label' => 'benefits',                 'value' => 'benefits'],
            ['label' => 'bonus-slider',             'value' => 'bonus-slider'],
            ['label' => 'casino_filter',            'value' => 'casino_filter'],
            ['label' => 'casino-contacts',          'value' => 'casino-contacts'],
            ['label' => 'casino-games',             'value' => 'casino-games'],
            ['label' => 'contains',                 'value' => 'contains'],
            ['label' => 'demo-game',                'value' => 'demo-game'],
            ['label' => 'faq',                      'value' => 'faq'],
            ['label' => 'four-providers-payment',   'value' => 'four-providers-payment'],
            ['label' => 'game-features',            'value' => 'game-features'],
            ['label' => 'game-table',               'value' => 'game-table'],
            ['label' => 'game-types',               'value' => 'game-types'],
            ['label' => 'more-games',               'value' => 'more-games'],
            ['label' => 'pluses-minuses',           'value' => 'pluses-minuses'],
            ['label' => 'steps',                    'value' => 'steps'],
            ['label' => 'things',                   'value' => 'things'],
            ['label' => 'topFourCasinos',           'value' => 'topFourCasinos'],
            ['label' => 'topTenCasinos',            'value' => 'topTenCasinos'],
            ['label' => 'topTenCasinosBonus',       'value' => 'topTenCasinosBonus'],
        ]
    ];

    echo "<div class='row'>";
    get_template_part( 'includes/themeOptions/tmp/input/input', 'checkbox', $input_hide_args );
    get_template_part( 'includes/themeOptions/tmp/input/input', 'checkbox', $input_title_args );
    get_template_part( 'includes/themeOptions/tmp/input/input', 'checkbox', $input_shortcodes_args );
    echo "</div>";
}