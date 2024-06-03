<?php

// Подгрузка блоговых статей по аяксу
function ajax_posts_function(){
    switch_to_blog($_GET['curBlog']);
    $transForShortcode = $GLOBALS['translations'][$_GET['curLang']];
    $preview_info = array();
    $postsOut = '';
    $posts = new WP_Query(array(
        'posts_per_page'   => 6,
        'post_type'        => 'post',
        'post_status'      => 'publish',
        'offset'           => $_GET['offset']
    ));

    $btnHide = ($posts->found_posts - $_GET['offset'] - 6) <= 0 ? true : false ;
    
    foreach($posts->posts as $post){
        $postsOut .= '<div class="col-md-4 blogPreview">
                        <a href="'.get_permalink($post).'" class="d-block">
                            <span class="blogPreview-img d-flex justify-content-center" style="background-image: url('.get_the_post_thumbnail_url($post).');">
                                <span class="blogPreview-date text-center d-flex align-items-center justify-content-center flex-column">
                                    <span>'.get_the_date('d M',$post).'</span>
                                    <span>'.get_the_date('Y', $post).'</span>
                                </span>
                            </span>
                            <span class="blogPreview-title d-block">
                                <span class="d-block">'. $post->post_title .'</span>
                                <span class="blogPreview-title-read d-block text-center">'.$transForShortcode['read_more'].'</span>
                            </span>
                        </a>
                    </div>';
    }

    $preview_info['posts']   = $postsOut;
    $preview_info['btnHide'] = $btnHide;
    
    echo json_encode($preview_info);
    restore_current_blog();
    wp_reset_postdata();
    wp_die();

}

// AJAX поиск по сайту (ищет только по тайтлам, хук posts_search)
function ajax_search(){
    switch_to_blog($_POST['curBlog']); // получаем номер блога для поиска
    $translations_page = get_option('translations_site');
    if($translations_page === false) $translations_page = $GLOBALS['translations']['en'];
    
    $the_query = new WP_Query( array( 
        'posts_per_page'    => -1, 
        's'                 => esc_attr( $_POST['search'] ),
        'post_status'       => 'publish',
    ) );

    $search_info = "<ul class='search-list'>";
    if( $the_query->have_posts() ){

        foreach ($the_query->posts as $s_post) {
            $search_info .= "<li class='search-item'>
                                <a href='".get_the_permalink($s_post)."' class=''>".get_the_title($s_post)."</a>
                            </li>";            
        }     
        wp_reset_postdata();  
        
    }else{
        $search_info .= '<li><p>'.$translations_page['no_results_found'].'</p></li>';
    }
    $search_info .= '</ul>';

    restore_current_blog();
    echo $search_info;
    wp_die();   
}

// END AJAX поиск по сайту (ищет только по тайтлам, хук posts_search)

// AJAX пользовательский рейтинг казино
function ajax_rating(){
    switch_to_blog($_POST['curBlog']); // получаем номер блога для поиска

    $user_ip = $_SERVER['REMOTE_ADDR'];
    $rating_data = get_field('rating_schema', $_POST['curId']);
    $votes_list = &$rating_data['ip_list'];
    $is_ip = stripos($votes_list, $user_ip);

    $translations_page = get_option('translations_site');
    if($translations_page === false) $translations_page = $GLOBALS['translations'][$GLOBALS['currentLang']];

    if ($is_ip === false) {

        $rating_avg = &$rating_data['rating_avg'];
        $number_of_votes = &$rating_data['number_of_votes'];

        $response = '';

        // Считаем количество голосов
        if(empty($number_of_votes)) {
            $number_of_votes = 1;
        }else{
            $number_of_votes = (int) $number_of_votes + 1;
        }
        // Вычисляем средний рейтинг
        if(empty($rating_avg) || empty($votes_list)) {
            $rating_avg = $_POST['rating'];
        }else{        
            $rating_avg = ((float) $rating_avg * ((float) $number_of_votes - 1 ) + (float) $_POST['rating']) / (float) $number_of_votes;
        }
        $votes_list .= $user_ip." ";
        
        update_field('rating_schema', $rating_data, $_POST['curId']);
        $response = $translations_page['vote'];

    }else{
        $response = $translations_page['not_vote'];
    }
    restore_current_blog();
    echo $response;

    wp_die();   
}

// Фильтр обзоров
function ajax_filter(){ 

    switch_to_blog($_GET['curBlog']); // получаем номер блога для поиска
    
    echo do_shortcode('[topTenCasinos btn="true" more-info="true"]');
    
    wp_die();   

}

// Сохранение комментария
function save_comment(){
    
    switch_to_blog($_POST['curBlog']); // получаем номер блога для поиска

    // Собираем данные формы
    parse_str($_POST['form'],$formData);

    global $wpdb;

    $comment_post_ID = esc_attr($formData['comment_post_ID']);
    $comment_parent = esc_attr($formData['comment_parent']);
    $email = esc_attr($formData['email']);
    // END Собираем данные формы

    // Данные рекапчи
    $recaptchaSecret = isset($GLOBALS['recaptcha']['secret']) && !empty($GLOBALS['recaptcha']['secret']) ? $GLOBALS['recaptcha']['secret'] : "";
    $recaptchaResponse = esc_attr($formData['g-recaptcha-response']);

    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$recaptchaSecret&response=$recaptchaResponse");
    $responseKeys = json_decode($response, true);
    
    // END Данные рекапчи

    // Проверка на валидность полей
    $errors = [];
    $error_msg = '';
    $success_msg = '';

    // Проверка комментария
    $comment = false;
    // Проверяем оставлял пользователь комментарий ранее или нет
    $current_ip = $_SERVER['REMOTE_ADDR']; // Получаем текущий IP
    
    if(isset($formData['comment_parent']) && $formData['comment_parent'] == 0){
        // Учитываем префикс для мультисайта
        $comments_table_name = $wpdb->prefix . 'comments';

        // Запрос к БД для поиска комментария с данным IP на этой странице
        $comment = $wpdb->get_row( $wpdb->prepare( 
            "SELECT * FROM $comments_table_name WHERE comment_post_ID = %d AND comment_author_IP = %s", 
            $formData['comment_post_ID'], 
            $current_ip
        ) );
    }
    
    // Если пользователь не оставлял комментарий или пользователь - админ, то обрабатываем информацию
    if ( !$comment || current_user_can('administrator') ) {
        if (isset($formData['comment'])) {

            $comment = esc_attr(trim($formData['comment']));

            if ((strlen($comment) < 10 || strlen($comment) > 1500) || preg_match('/(http:\/\/|https:\/\/|www\.)/', $comment)) {                
                $errors['comment'] = $GLOBALS['translations_page']['invalid_review'];
            }
        } else {            
            $errors['comment'] = $GLOBALS['translations_page']['required_review'];
        }
        
        // Проверка имени автора
        if (isset($formData['author'])) {
            $author = esc_attr(trim($formData['author']));
            if (strlen($author) < 2 || strlen($author) > 35) {
                
                $errors['author'] = $GLOBALS['translations_page']['invalid_name'];
            }
        } else {
            $errors['author'] = $GLOBALS['translations_page']['required_name'];
        }
        
        // Проверка электронной почты
        if (isset($formData['email'])) {
            $email = esc_attr(trim($formData['email']));
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = $GLOBALS['translations_page']['invalid_email'];
            }
        } else {
            $errors['email'] = $GLOBALS['translations_page']['required_email'];
        }
    
        // Если это отвер на комментарий, то рейтинг нам не нужен
        if(isset($formData['comment_parent']) && $formData['comment_parent'] == 0){
            // Проверка рейтинга
            if (isset($formData['rating'])) {
                $rating = intval(esc_attr(trim($formData['rating'])));
                if ($rating < 1 || $rating > 5) {
                    $errors['rating'] = $GLOBALS['translations_page']['invalid_rating'];
                }
            } else {
                $errors['rating'] = $GLOBALS['translations_page']['required_rating'];
            }
        }
    
        // Провека на бота
        if (intval($responseKeys["success"]) !== 1) {
            $errors['recaptcha'] = $GLOBALS['translations_page']['robot_check'];
        }
        
        // Всё в порядке, можно обрабатывать данные
        if (!count($errors) > 0) {
    
            // Данные комментария
            $commentdata = array(
                'comment_post_ID' => $comment_post_ID, // Убедитесь, что ID поста действителен
                'comment_author_IP' => $current_ip,
                'comment_author' => $author,
                'comment_author_email' => $email,
                'comment_content' => $comment,
                'comment_parent' => $comment_parent,
                'comment_approved' => 0, // или "0" если вы хотите модерировать комментарии
            );
            
            if (isset($rating)) $commentdata["comment_meta"] = [ 'rating' => $rating ];
            
            // Записываем комментарий
            $comment_id = wp_insert_comment($commentdata);
    
            if(!$comment_id){
                // error_msg - сообщение о том, что не удалось довавить комментарий
                $error_msg = $GLOBALS['translations_page']['error_msg'];
            } else{
                if(isset($formData['comment_parent']) && $formData['comment_parent'] == 0){
                    // success_msg - сообщение о том, что комментарий отправлен на модерацию или о том, что пользователь уже оставлял комментарий
                    $success_msg = htmlspecialchars(stripcslashes($GLOBALS['translations_page']['success_review']));
                }else{
                    // success_msg - сообщение о том, что ответ отправлен на модерацию 
                    $success_msg = htmlspecialchars(stripcslashes($GLOBALS['translations_page']['success_reply']));
                }
                
            }
        } 
    }else{
        // Если пользователь уже оставлял комментарий, то выводим сообщение об этом
        $success_msg = stripcslashes($GLOBALS['translations_page']['repeated_review']);
    }    

    // errors - список невалидных полей
    // error_msg - сообщение о том, что не удалось довавить комментарий
    // success_msg - сообщение о том, что комментарий отправлен на модерацию или о том, что пользователь уже оставлял комментарий
    echo json_encode([
        "errors" => $errors,
        "error_msg" => $error_msg,
        "success_msg" => $success_msg    
    ]);

    wp_die();
}

// Загрузить больше комментариев
function comments_load_more(){

    $post_id = $_GET['post_id'];
    $paged = $_GET['page'];
    $comments_per_page = get_option('comments_per_page');

    $comments_args = array(
        'post_id' => $post_id,
        'status' => 'approve', // Получение только одобренных комментариев
        'number' => $comments_per_page,
        'parent'  => 0, // это извлекает только комментарии верхнего уровня
        'offset' => ($paged - 1) * $comments_per_page
    );
    
    $comments = get_comments($comments_args);
    $comments_args['count'] = true;
    $comments_args['offset'] = 0;
    $total_comments = get_comments($comments_args);
    
    if($comments){
        $out = '';
        foreach($comments as $comment) {
            $rating = get_comment_meta($comment->comment_ID, 'rating', true);
            
            // Исходная дата в формате "Y-m-d H:i:s"
            $originalDate = $comment->comment_date;
    
            // Создаем объект DateTime из исходной даты
            $date = new DateTime($originalDate);
    
            // Преобразовываем формат даты
            $comment_date = $date->format("d/m/y H:i");
            $out .= '<div class="comments-item" itemprop="review" itemscope itemtype="http://schema.org/Review">
            <div class="comments-item-parrent">
                <div class="comments-item-top d-flex justify-content-between">
                    <p class="comments-item-name d-inline-block" itemprop="author">'.$comment->comment_author.'</p>
                    <p class="comments-item-date d-inline-block">'.$comment_date.'</p>
                </div>
                <div class="comments-item-rating user-rating d-inline-flex" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating" data-rating="'.$rating.'">';
    
                for($i = 1; $i < 6; $i++){
                    $out .= '<div class="d-block user-rating-item ';
                    if($rating >= $i ) $out .= 'red';
                    $out .= '" ><img src="'.IMG_URL.'star.svg" alt="star" data-rating="'.$i.'" width="21" height="21" class="user-rating-item-red">
                             <img src="'.IMG_URL.'star_gray.svg" alt="star gray" width="21" height="21" class="user-rating-item-gray">
                        </div>';
                }
                
                $out .= '<span itemprop="ratingValue" class="d-none">'.$rating.'</span>
                    </div>
                    <div class="comments-item-content" itemprop="description">'.$comment->comment_content.'</div>
                    <meta itemprop="datePublished" content="'.$comment_date.'">
                    <div class="comments-item-bottom d-flex">
                        <div class="comments-item-reply js-commentsReply" data-comment_ID="'.$comment->comment_ID.'">
                            <img src="'.IMG_URL.'casino/reply.svg" alt="reply icon">'.$GLOBALS['translations_page']['reply'].'
                        </div>                
                    </div>
                </div>
                <div class="comments-item-child-container">';
    
                    $child_comments_args = [
                        'status' => 'approve', // Получение только одобренных комментариев
                        'number' => 5,
                        'parent' => $comment->comment_ID // это извлекает дочерние комментарии текущего комментария
                    ];
                    $child_comments = get_comments($child_comments_args);
    
                    $child_comments_args['count'] = true;
    
                    foreach($child_comments as $child_comment){
                        // Исходная дата в формате "Y-m-d H:i:s"
                        $originalDate = $child_comment->comment_date;
    
                        // Создаем объект DateTime из исходной даты
                        $date = new DateTime($originalDate);
    
                        // Преобразовываем формат даты
                        $child_comment_date = $date->format("d/m/y H:i");
                        $out .= '
                            <div class="comments-item">
                                <div class="comments-item-top d-flex justify-content-between">
                                    <p class="comments-item-name d-inline-block">'.$child_comment->comment_author.'</p>
                                    <p class="comments-item-date d-inline-block">'.$child_comment_date.'</p>
                                </div>
                                <div class="comments-item-content">'.$child_comment->comment_content.'</div>
                            </div>';
                    }
                $out .= "
                
                </div>";
        }
        $response['comments'] = $out;
        // Проверяем, остались ли еще комментарии

        $loaded_comments = $paged * $comments_per_page;

        if($loaded_comments >= $total_comments || count($comments) < $comments_per_page) {
            $response['more_comments'] = false;
        } else {
            $response['more_comments'] = true;
        }
    }else {
        $response['more_comments'] = false;
    }
    
    echo json_encode($response);
        
    wp_die();
}

// Загрузить больше ответов на комментарии
function replies_load_more(){

    $commentID = $_GET['commentID'];
    $paged = $_GET['page'];
    $comments_per_page = 5;

    $child_comments_args = [
        'status' => 'approve', // Получение только одобренных комментариев
        'number' => $comments_per_page,
        'parent' => $commentID, // это извлекает дочерние комментарии текущего комментария
        'offset' => ($paged - 1) * $comments_per_page
    ];
    $child_comments = get_comments($child_comments_args);

    $child_comments_args['count'] = true;
    $child_comments_args['offset'] = 0;
    $child_comments_count = get_comments($child_comments_args);

    if($child_comments){
        $out = '';
        foreach($child_comments as $comment) {
            
            // Исходная дата в формате "Y-m-d H:i:s"
            $originalDate = $comment->comment_date;
    
            // Создаем объект DateTime из исходной даты
            $date = new DateTime($originalDate);
    
            // Преобразовываем формат даты
            $comment_date = $date->format("d/m/y H:i");
            $out .= '<div class="comments-item">
                        <div class="comments-item-top d-flex justify-content-between">
                            <p class="comments-item-name d-inline-block">'.$comment->comment_author.'</p>
                            <p class="comments-item-date d-inline-block">'.$comment_date.'</p>
                        </div>
                        <div class="comments-item-content">'.$comment->comment_content.'</div>
                    </div>';
        }
        $response['comments'] = $out;
        // Проверяем, остались ли еще комментарии

        $loaded_comments = $paged * $comments_per_page;

        if($loaded_comments >= $child_comments_count || count($child_comments) < $comments_per_page) {
            $response['more_comments'] = false;
        } else {
            $response['more_comments'] = true;
        }
    }else {
        $response['more_comments'] = false;
    }
    
    echo json_encode($response);
        
    wp_die();
}

// Функция для решения, какой вариант использовать
function determine_ab_test_variant() {

    // если на сайте нет опции, то ставим ее
    if(empty(get_option( 'fortuneWheel_A_B'))) update_option( 'fortuneWheel_A_B', "A");

    // даем сессии значение
    if (!isset($_SESSION['fortuneWheel_A_B'])) {
        $_SESSION['fortuneWheel_A_B'] = get_option( 'fortuneWheel_A_B');
    }
    
    // для следующей сессии меняем значение 
    if(get_option( 'fortuneWheel_A_B') == "A"){
        update_option( 'fortuneWheel_A_B', "B");
    }else{
        update_option( 'fortuneWheel_A_B', "A");
    }

    return $_SESSION['fortuneWheel_A_B'];
}

// Данные для колеса фортуны
function spin_wheel(){

    $spin_wheel_fix = get_option('spin_wheel_fix');
    
    if( ($spin_wheel_fix || $spin_wheel_fix != 'spin_wheel_fix') &&
        ((isset($spin_wheel_fix['is_show']) && $spin_wheel_fix['is_show'] && !isset($spin_wheel_fix['a_b'])) || 
        (isset($spin_wheel_fix['is_show']) && $spin_wheel_fix['is_show'] && isset($spin_wheel_fix['a_b']) && determine_ab_test_variant() == "A"))
    ){
        ob_start();

        get_template_part( 'includes/tmp/fortuneWheel', null, $spin_wheel_fix );
            
        $content = ob_get_clean();
        
        echo json_encode([
            "html" => $content,
            "spin_settings" => $spin_wheel_fix
        ]);
    }

    wp_die();
}

add_action('wp_ajax_ajax_posts_function', 'ajax_posts_function');           // Подгрузка блоговых статей по аяксу
add_action('wp_ajax_nopriv_ajax_posts_function', 'ajax_posts_function');    // Подгрузка блоговых статей по аяксу
add_action('wp_ajax_ajax_search', 'ajax_search');                           // Поиск постов и страниц
add_action('wp_ajax_nopriv_ajax_search', 'ajax_search');                    // Поиск постов и страниц
add_action('wp_ajax_ajax_filter', 'ajax_filter');                           // Фильтр обзоров
add_action('wp_ajax_nopriv_ajax_filter', 'ajax_filter');                    // Фильтр обзоров
add_action('wp_ajax_save_comment', 'save_comment');                         // Сохранение комментария
add_action('wp_ajax_nopriv_save_comment', 'save_comment');                  // Сохранение комментария
add_action('wp_ajax_comments_load_more', 'comments_load_more');             // Загрузить больше комментариев
add_action('wp_ajax_nopriv_comments_load_more', 'comments_load_more');      // Загрузить больше комментариев
add_action('wp_ajax_replies_load_more', 'replies_load_more');               // Загрузить больше ответов на комментарии
add_action('wp_ajax_nopriv_replies_load_more', 'replies_load_more');        // Загрузить больше ответов на комментарии
add_action('wp_ajax_spin_wheel', 'spin_wheel');                             // Данные для колеса фортуны
add_action('wp_ajax_nopriv_spin_wheel', 'spin_wheel');                      // Данные для колеса фортуны
