<?php

// Добавление комментария
function insertCommentsAndReplies($data_array) {
    foreach($data_array as $data) {
        $post_id = url_to_postid($data['url']);
        
        if(!$post_id) {
            continue; // Если не удается получить ID записи по URL, пропускаем этот комментарий
        }

        $commentdata = array(
            'comment_post_ID' => $post_id,
            'comment_author' => $data['comment']['comment_author'],
            'comment_author_email' => $data['comment']['comment_author_email'],
            'comment_content' => $data['comment']['comment_content'],
            'comment_date' => handleCommentDate($data['comment']['comment_date']),
            'comment_approved' => 0
        );

        $existing_comments = get_comments(array(
            'author_email' => $data['comment']['comment_author_email'],
            'post_id' => $post_id
        ));

        // Если такого комментария нет        
        if (!$existing_comments) {
            $comment_id = wp_insert_comment($commentdata);
            if ($comment_id) {
                add_comment_meta($comment_id, 'rating', $data['comment']['rating']);
                add_comment_meta($comment_id, 'custom_comment', true);
                
                foreach ($data['replies'] as $reply) {
                    if($reply[0]){
                        $replydata = array(
                            'comment_post_ID' => $post_id,
                            'comment_parent' => $comment_id,
                            'comment_author' => $reply[0],
                            'comment_author_email' => $reply[1],
                            'comment_content' => $reply[3],
                            'comment_date' => handleReplyDate($reply[2], $commentdata['comment_date']),
                            'comment_approved' => 0
                        );
    
                        $reply_id = wp_insert_comment($replydata);
                        if ($reply_id) {
                            add_comment_meta($reply_id, 'custom_comment', true);
                        }
                    }
                }
            }
            echo "<p>Комментарий пользователя ". $data['comment']['comment_author'] . "  для страницы ". get_post($post_id)->post_title . " добавлен</p>";

        }else{
            echo "<p>Комментарий пользователя ". $data['comment']['comment_author'] . "  для страницы ". get_post($post_id)->post_title . " уже существует</p>";
        }
    }
}

function handle_csv_upload(){
    // Указываем путь к вашему CSV-файлу
    if (!empty($_FILES['csv_file']['tmp_name'])) {
        $uploaded_file = $_FILES['csv_file']['tmp_name'];
        // $uploaded_file = dirname(__FILE__) . '/qwert.csv';

        // Открыть файл для чтения
        $file = fopen($uploaded_file, 'r');
        // Прочитать содержимое CSV

        $result = [];

        $keysArray = [];

        while (($row = fgetcsv($file)) !== false) {
            // Проверяем, является ли ряд пустым
            if (empty(array_filter($row))) {
                $keysArray = [];  
                continue;
            }
        
            $data = [
                "url" => $row[0],
                "comment" => [
                    'comment_author' => $row[1],
                    'comment_author_email' => $row[2],
                    'comment_content' => $row[5],
                    'comment_date' => $row[3],
                    'rating'    => $row[4]
                    ]
                ];
            $row = array_slice($row, 7);
            
            $data['replies'] = array_chunk($row, 5);
            array_push($result,$data);
        }

        fclose($file);
        insertCommentsAndReplies($result);

    } else {
        echo 'Ошибка при загрузке или файл не предоставлен.';
    }
    wp_die(); // это необходимо, чтобы корректно завершить функцию для обработчика AJAX в WordPress

}

// Генерация случайной даты между двумя датами
$generated_dates = []; // Массив для хранения уже сгенерированных дат

function randomDateFromGivenDate($startDate) {
    global $generated_dates;

    $startTimestamp = strtotime($startDate);
    $endTimestamp = strtotime('+1 month', $startTimestamp); // Дата через месяц от начальной даты

    do {
        $randomTimestamp = mt_rand($startTimestamp, $endTimestamp); // Генерация случайной даты
        $randomDate = date('Y-m-d H:i:s', $randomTimestamp);
    } while (in_array($randomDate, $generated_dates)); // Повторять, пока не найдем уникальную дату

    $generated_dates[] = $randomDate; // Добавить сгенерированную дату в массив
    return $randomDate;
}


// Функция для обработки даты комментария
function handleCommentDate($commentDate) {
    if (empty($commentDate)) {
        return randomDateInNextMonth();
    } else {
        return DateTime::createFromFormat('d/m/y H:i', $commentDate)->format('Y-m-d H:i:s');
    }
}

function randomDateInNextMonth() {
    $startDate = new DateTime();
    $endDate = (clone $startDate)->modify('+1 month');

    $randomTimestamp = mt_rand($startDate->getTimestamp(), $endDate->getTimestamp());

    return (new DateTime())->setTimestamp($randomTimestamp)->format('Y-m-d H:i:s');
}

// Функция для обработки даты ответа
function handleReplyDate($replyDate, $parentCommentDate) {
    if (empty($replyDate)) {
        return randomDateWithinMonthOf($parentCommentDate);
    } else {
        return DateTime::createFromFormat('d/m/y H:i', $replyDate)->format('Y-m-d H:i:s');
    }
}

function randomDateWithinMonthOf($baseDate) {
    $startDate = DateTime::createFromFormat('Y-m-d H:i:s', $baseDate);
    $endDate = (clone $startDate)->modify('+1 month');

    $randomTimestamp = mt_rand($startDate->getTimestamp(), $endDate->getTimestamp());

    return (new DateTime())->setTimestamp($randomTimestamp)->format('Y-m-d H:i:s');
}

add_action('wp_ajax_handle_csv_upload', 'handle_csv_upload'); // Если пользователь авторизован

// Кронзадачв для публикации комментариев
if (!wp_next_scheduled('publish_pending_comments')) {
    wp_schedule_event(time(), 'daily', 'publish_pending_comments');
}

// обработчик для задачи
function publish_comments_cron_job() {

    // Получить комментарии, которые ожидают одобрения и имеют метаполе 'custom_comment'
    $args = array(
        'status' => 'hold', // Ожидающие одобрения
        'meta_query' => array(
            array(
                'key' => 'custom_comment',
                'compare' => 'EXISTS' // Проверка существования метаполя
            )
        ),
        'date_query' => array(
            array(
                'column' => 'comment_date',
                'before' => current_time('mysql') // Дата комментария раньше текущей
            )
        )
    );
    
    $comments = get_comments($args);
    
    foreach ($comments as $comment) {
        $comment_date = new DateTime($comment->comment_date);
        $current_date = new DateTime();

        if ($comment_date <= $current_date) {
            // Одобрить комментарий
            wp_set_comment_status($comment->comment_ID, 'approve');
        }
    }
}

add_action('publish_pending_comments', 'publish_comments_cron_job');
