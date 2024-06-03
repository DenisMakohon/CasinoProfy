<?php 

    $user_form = [
        "author" => "",
        "email" => "",
        "readonly" => "",
    ];

    if (is_user_logged_in()) {

        $user = wp_get_current_user();
        // Если пользователь залогинен, то автоматом заполняем поля автора и почты и блокируем им редактирование
        $user_form["author"] = $user->display_name;
        $user_form["email"] = $user->user_email;
        // $user_form["readonly"] = "readonly";
        
    }
    global $wpdb;
    $current_ip = $_SERVER['REMOTE_ADDR']; // Получаем текущий IP
    $post_id = get_the_ID(); // ID текущей страницы/записи
    
    // Учитываем префикс для мультисайта
    $comments_table_name = $wpdb->prefix . 'comments';

    // Запрос к БД для поиска комментария с данным IP на этой странице
    $comment = $wpdb->get_row( $wpdb->prepare( 
        "SELECT * FROM $comments_table_name WHERE comment_post_ID = %d AND comment_author_IP = %s", 
        $post_id, 
        $current_ip
    ) );
    

    if ( $comment && !current_user_can('administrator') ) {        
        echo '<p class="np-form error-msg text-center">'.$GLOBALS['translations_page']['repeated_review'].'</p>';        
    } elseif(!empty($GLOBALS['recaptcha']) && !in_array('', $GLOBALS['recaptcha'])) {
        // Показать форму для комментирования
?>

<form action="" method="post" class="comment-form comment-preloader js-commentPreloader" novalidate="">

    <div class="response js-response d-flex align-items-center justify-content-center"><?=$GLOBALS['translations_page']['error_msg']?></div>
    <!-- Рейтинг -->

    <?php $cur_rating = 5;?>

    <h2><?=$GLOBALS['translations_page']['rate_this_material']?></h2>
    
    <p class="input-name"><?=$GLOBALS['translations_page']['your_rating']?> <span class="required">*</span></p>

    <div class="comment-form-rating user-rating d-inline-flex js-userRating" data-rating="<?=$cur_rating?>">
        <?php for($i = 1; $i < 6; $i++): ?>
            <label class="d-block user-rating-item js-userRatingItem <?php if($cur_rating >= $i ) echo "red"; ?>">
                <input type="radio" class="d-block" name="rating" value="<?=$i?>" <?php if($i == 5) echo "checked"; ?>>
                <img src="<?=IMG_URL?>star.svg" alt="star" data-rating="<?=$i?>" width="21" height="21" class="user-rating-item-red">
                <img src="<?=IMG_URL?>star_gray.svg" alt="star gray" width="21" height="21" class="user-rating-item-gray">
            </label>
        <?php endfor; ?>
        <p class="user-rating-text js-ratingText"><?=$GLOBALS['translations_page']['invalid_rating']?></p>
    </div>


    <!-- Комментарий -->

    <div class="comment-form-comment js-inputContainer">
        <label>
            <p class="input-name"><?=$GLOBALS['translations_page']['your_review']?> <span class="required">*</span></p>
            <textarea id="comment" placeholder="<?=$GLOBALS['translations_page']['placeholder_review']?>" name="comment" cols="45" rows="8" aria-required="true" minlength="10" maxlength="1500" required></textarea>
        </label>
        <p class="error-msg js-errorMsg js-comment hide"><?=$GLOBALS['translations_page']['invalid_review']?></p>
    </div>

    <div class="row">

        <!-- Имя -->

        <div class="col-md-6 col-12 comment-form-author js-inputContainer">
            <p class="input-name"><?=$GLOBALS['translations_page']['placeholder_name']?> <span class="required">*</span></p>
            <label>         
                <input type="text" name="author" placeholder="<?=$GLOBALS['translations_page']['placeholder_name']?>" value="<?=$user_form["author"]?>" minlength="2" maxlength="35" <?=$user_form["readonly"]?> required >
            </label>
            <p class="error-msg js-errorMsg js-author hide"><?=$GLOBALS['translations_page']['invalid_name']?></p>
        </div>

        <!-- Почта -->

        <div class="col-md-6 col-12 comment-form-email js-inputContainer">
            <p class="input-name"><?=$GLOBALS['translations_page']['your_email']?> <span class="required">*</span></p>
            <label>           
                <input type="text" name="email" pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$" placeholder="<?=$GLOBALS['translations_page']['your_email']?>" value="<?=$user_form["email"]?>" <?=$user_form["readonly"]?> required >
            </label>
            <p class="error-msg js-errorMsg js-email hide"><?=$GLOBALS['translations_page']['invalid_email']?></p>
        </div>
    </div>
    
    <div class="row align-items-center">

        <!-- Капча -->            

        <div class="col-12 col-md-6 d-flex justify-content-center justify-content-md-start">
            <div class="form-allowed-tags">
                <!-- <img src="<?=IMG_URL?>casino/qwe.png" alt=""> -->
                <div class="recaptcha-container" id="commentform"></div>
                <p class="error-msg js-errorMsg js-recaptcha hide"><?=$GLOBALS['translations_page']['robot_check']?></p>
            </div>
        </div>

        <!-- Отправить -->        

        <div class="col-md-6 col-12 d-flex justify-content-center justify-content-md-end">
            <p class="form-submit">
                <input name="submit" class="js-sendComment btn-js" type="submit" value="<?=$GLOBALS['translations_page']['send']?>">
                <input type="hidden" name="comment_post_ID" value="<?=$post->ID?>" id="comment_post_ID">
                <input type="hidden" name="comment_parent" id="comment_parent" value="0">
            </p>
        </div>
    </div>
</form>

<?php }elseif (current_user_can('administrator') && (empty($GLOBALS['recaptcha']) || in_array('', $GLOBALS['recaptcha']))) {
    echo '<p class="np-form error-msg text-center">Настойте Google reCAPTCHA!</p>';
} ?>

<!-- Форма для ответа на комментарий -->

<div class="form-fixed js-closeForm js-replyForm">
    <div class="js-closeForm close-form"></div>
    <form action="" method="post" class="container mainContent comment-form comment-preloader js-commentPreloader" novalidate="">
        
        <div class="response js-response d-flex align-items-center justify-content-center"><?=$GLOBALS['translations_page']['error_msg']?></div>

        <p class="form-title text-center"><?=$GLOBALS['translations_page']['reply_title']?></p>

        <!-- Комментарий -->

        <div class="comment-form-comment js-inputContainer">
            <label>
                <p class="input-name"><?=$GLOBALS['translations_page']['your_reply']?> <span class="required">*</span></p>
                <textarea id="comment" placeholder="<?=$GLOBALS['translations_page']['placeholder_reply']?>" name="comment" cols="45" rows="8" aria-required="true" minlength="10" maxlength="1500" required></textarea>
            </label>
            <p class="error-msg js-errorMsg js-comment hide"><?=$GLOBALS['translations_page']['invalid_reply']?></p>
        </div>

        <div class="row">

            <!-- Имя -->

            <div class="col-md-6 col-12 comment-form-author js-inputContainer">
                <p class="input-name"><?=$GLOBALS['translations_page']['placeholder_name']?> <span class="required">*</span></p>
                <label>
                    <p><?php  __('Name', 'textdomain')  ?> </p>             
                    <input type="text" name="author" placeholder="<?=$GLOBALS['translations_page']['placeholder_name']?>" value="<?=$user_form["author"]?>" minlength="2" maxlength="35" <?=$user_form["readonly"]?> required >
                </label>
                <p class="error-msg js-errorMsg js-author hide"><?=$GLOBALS['translations_page']['invalid_name']?></p>
            </div>

            <!-- Почта -->

            <div class="col-md-6 col-12 comment-form-email js-inputContainer">
                <p class="input-name"><?=$GLOBALS['translations_page']['your_email']?> <span class="required">*</span></p>
                <label>
                    <p><?php  __('Email', 'textdomain')  ?> </p>             
                    <input type="text" name="email" pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$" placeholder="<?=$GLOBALS['translations_page']['your_email']?>" value="<?=$user_form["email"]?>" <?=$user_form["readonly"]?> required >
                </label>
                <p class="error-msg js-errorMsg js-email hide"><?=$GLOBALS['translations_page']['invalid_email']?></p>
            </div>
        </div>
        
        <div class="row align-items-center">

            <!-- Капча -->            

            <div class="col-12 col-md-6 d-flex justify-content-center justify-content-md-start">
                <div class="form-allowed-tags">
                    <!-- <img src="<?=IMG_URL?>casino/qwe.png" alt=""> -->
                    <div class="recaptcha-container" id="replyform"></div>
                    <p class="error-msg js-errorMsg js-recaptcha hide"><?=$GLOBALS['translations_page']['robot_check']?></p>
                </div>
            </div>

            <!-- Отправить -->        

            <div class="col-md-6 col-12 d-flex justify-content-center justify-content-md-end">
                <p class="form-submit">
                    <input name="submit" class="js-sendComment btn-js" type="submit" value="<?=$GLOBALS['translations_page']['send']?>">
                    <input type="hidden" name="comment_post_ID" value="<?=$post->ID?>">
                    <input type="hidden" name="comment_parent" value="0">
                </p>
            </div>
        </div>
    </form>
</div>

<!-- END Форма для ответа на комментарий -->

<!-- Список комментариев -->
<?php if(has_approved_comments($post_id)): ?>

<div class="comments">
<h2><?=$GLOBALS['translations_page']['reviews']?></h2>

<?php 
    // Получение ID текущего поста
    $post_id = get_the_ID();
    
    // Получение комментариев для этого поста
    $comments_args = array(
        'post_id' => $post_id,
        'status' => 'approve', // Получение только одобренных комментариев
        'number' => get_option('comments_per_page'), // количество комментариев на странице, настраивается в wp-admin/options-discussion.php
        'parent'  => 0 // это извлекает только комментарии верхнего уровня
    );
    
    $comments = get_comments($comments_args);
    $comments_args['count'] = true;
    $comments_count = get_comments($comments_args);
    
    foreach($comments as $comment) {
        $rating = get_comment_meta($comment->comment_ID, 'rating', true);
        
        // Исходная дата в формате "Y-m-d H:i:s"
        $originalDate = $comment->comment_date;

        // Создаем объект DateTime из исходной даты
        $date = new DateTime($originalDate);

        // Преобразовываем формат даты
        $comment_date = $date->format("d/m/y H:i");
?>
        <!-- Выводим комментарий -->
        <div class="comments-item" itemprop="review" itemscope itemtype="http://schema.org/Review">
            <div class="d-none" itemprop="itemReviewed" >
                <h3 itemprop="name"><?= the_title() ?></h3>
            </div>
            <div class="comments-item-parrent">
                <div class="comments-item-top d-flex justify-content-between">
                    <p class="comments-item-name d-inline-block" itemprop="author"><?=$comment->comment_author?></p>
                    <p class="comments-item-date d-inline-block"><?=$comment_date?></p>
                </div>
                <div class="comments-item-rating user-rating d-inline-flex" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating" data-rating="<?=$rating?>">
                    <?php for($i = 1; $i < 6; $i++): ?>
                        <div class="d-block user-rating-item <?php if($rating >= $i ) echo "red"; ?>">
                            <img src="<?=IMG_URL?>star.svg" alt="star" data-rating="<?=$i?>" width="21" height="21" class="user-rating-item-red">
                            <img src="<?=IMG_URL?>star_gray.svg" alt="star gray" width="21" height="21" class="user-rating-item-gray">
                        </div>
                    <?php endfor; ?>
                    <span itemprop="ratingValue" class="d-none"><?=$rating?></span>
                </div>
                <div class="comments-item-content" itemprop="description"><?=$comment->comment_content?></div>
                <meta itemprop="datePublished" content="<?=$comment_date?>">
                <div class="comments-item-bottom d-flex">
                    <div class="comments-item-reply js-commentsReply" data-comment_ID="<?=$comment->comment_ID?>">
                        <img src="<?=IMG_URL?>casino/reply.svg" alt="reply icon"><?=$GLOBALS['translations_page']['reply']?>
                    </div>                
                </div>
            </div>
            <div class="comments-item-child-container">
                <?php
                    $child_comments_args = [
                        'status' => 'approve', // Получение только одобренных комментариев
                        'number' => 5,
                        'parent' => $comment->comment_ID // это извлекает дочерние комментарии текущего комментария
                    ];
                    $child_comments = get_comments($child_comments_args);

                    $child_comments_args['count'] = true;
                    $child_comments_count = get_comments($child_comments_args);

                    foreach($child_comments as $child_comment){
                        // Исходная дата в формате "Y-m-d H:i:s"
                        $originalDate = $child_comment->comment_date;

                        // Создаем объект DateTime из исходной даты
                        $date = new DateTime($originalDate);

                        // Преобразовываем формат даты
                        $child_comment_date = $date->format("d/m/y H:i");
                        ?>
                            <div class="comments-item">
                                <div class="comments-item-top d-flex justify-content-between">
                                    <p class="comments-item-name d-inline-block"><?=$child_comment->comment_author?></p>
                                    <p class="comments-item-date d-inline-block"><?=$child_comment_date?></p>
                                </div>
                                <div class="comments-item-content"><?=$child_comment->comment_content?></div>
                            </div>
                        <?php
                    }
                    
                    if(count($child_comments) && $child_comments_count > 5):
                        ?>
                        <div class="answersControl js-answersControl d-flex justify-content-between">
                            <div class="js-answersHide answersControl-hide" data-hide="<?=$GLOBALS['translations_page']['hide_replies']?>" data-show="<?=$GLOBALS['translations_page']['show_replies']?>"><?=$GLOBALS['translations_page']['hide_replies']?></div>
                            <div class="js-answersMore answersControl-more" data-page="1" data-comment_ID="<?=$comment->comment_ID?>"><?=$GLOBALS['translations_page']['more_replies']?></div>
                        </div>                        
                        <?php
                    endif;
                ?>
            </div>
        </div>
        <!-- END Выводим комментарий -->
<?php 
} 
?>
<!-- Список комментариев -->

</div>
<?php if( has_approved_comments($post_id) > get_option('comments_per_page')): ?>
    <div class="d-flex justify-content-center">
        <div class="comments-more-reviews js-commentsMoreReviews btn btn-js" data-postID="<?=$post->ID?>"><?=$GLOBALS['translations_page']['more_reviews']?> </div>
    </div>
<?php endif; ?>
<?php endif; ?>