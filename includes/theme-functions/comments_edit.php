<?php
// Добавляем метабокс на страницу редактирования комментария
function add_rating_meta_box() {
    add_meta_box(
        'rating_meta_box_id',              // ID метабокса
        'Rating',                          // Заголовок метабокса
        'rating_meta_box_callback',        // Callback-функция
        'comment',                         // Тип страницы (comment для комментариев)
        'normal'                           // Контекст
    );
}

// Callback-функция для отображения содержимого метабокса
function rating_meta_box_callback($comment) {
    // Получение значения метаполя
    $rating = get_comment_meta($comment->comment_ID, 'rating', true);
    $custom_comment = get_comment_meta($comment->comment_ID, 'custom_comment', true);
    wp_nonce_field('rating_meta_box', 'rating_meta_box_nonce');


    echo '<label for="rating">Rating:</label>';
    // get_comment_meta($comment->comment_ID, 'rating', true)
    echo '<select id="rating" name="rating">';
    for ($i = 1; $i <= 5; $i++) {
        echo "<option value='$i'" . selected($rating, $i, false) . ">$i</option>";
    }
    echo '</select>';
    if($custom_comment) echo '<p><strong>КОММЕНТАРИЙ С ФАЙЛА.</strong></p>';

}

// Вычисление рейтинга при редактировании комментария
function update_post_rating_and_count($comment_ID) {
    
    // Получаем комментарий
    $comment = get_comment($comment_ID);
    // Получаем ID поста
    $post_id = $comment->comment_post_ID;

    // Получаем все одобренные комментарии верхнего уровня для этого поста
    $args = array(
        'post_id' => $post_id,
        'status' => 'approve',
        'parent' => 0 // Этот аргумент гарантирует, что будут возвращены только комментарии верхнего уровня
    );
    $comments = get_comments($args);

    $total_rating = 0;
    $comments_count = count($comments);

    // Считаем общий рейтинг
    foreach ($comments as $comment) {
        $rating = get_comment_meta($comment->comment_ID, 'rating', true);
        $total_rating += (int) $rating;
    }

    // Вычисляем среднее арифметическое
    $average_rating = $comments_count ? $total_rating / $comments_count : 5;

    // Записываем среднее арифметическое и количество комментариев верхнего уровня в мета данные поста    
    $rating_schema = get_field('rating_schema',$post_id);

    // на услучай пустого поля
    if(empty($rating_schema)){
        $rating_schema = [
            "rating_type" => "users",
            "rating" => "5",
            "rating_avg" => "5",
            "number_of_votes" => "1"
        ];
    }

    $rating_schema['rating_avg'] = $average_rating;
    $rating_schema['number_of_votes'] = $comments_count;

    // обновляем поля в посте
    update_field('rating_schema', $rating_schema, $post_id);
}

function save_rating_meta_data($comment_id) {
    // Проверка nonce
    if (!isset($_POST['rating_meta_box_nonce']) || !wp_verify_nonce($_POST['rating_meta_box_nonce'], 'rating_meta_box')) {
        return;
    }

    // Проверка текущего пользователя на право редактирования комментария
    if (!current_user_can('edit_comment', $comment_id)) {
        return;
    }

    // Сохранение значения метаполя
    if (isset($_POST['rating']) && in_array($_POST['rating'], [1, 2, 3, 4, 5])) {
        update_comment_meta($comment_id, 'rating', $_POST['rating']);
    }
}

add_action('edit_comment', 'save_rating_meta_data');                    
add_action('edit_comment', 'update_post_rating_and_count', 10, 2);      // Вычисление рейтинга при редактировании комментария
add_action('add_meta_boxes_comment', 'add_rating_meta_box');            // Добавляем метабокс на страницу редактирования комментария
