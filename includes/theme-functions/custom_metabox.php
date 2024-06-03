<?php

// Метабокс автора

function autor_metabox() {
 
	add_meta_box(
		'autor_metabox', // ID нашего метабокса
		'Автор страницы', // заголовок
		'autor_metabox_callback', // функция, которая будет выводить поля в мета боксе
		array('page', 'post', 'games', 'bonus', 'providers', 'blank'), // типы постов, для которых его подключим
		'normal', // расположение (normal, side, advanced)
		'default' // приоритет (default, low, high, core)
	);

    add_meta_box(
        'plashka_metabox', // ID нашего метабокса
        'Плашка', // заголовок
        'plashka_metabox_callback', // функция, которая будет выводить поля в мета боксе
        array('page'), // типы постов, для которых его подключим
        'normal', // расположение (normal, side, advanced)
        'default' // приоритет (default, low, high, core)
    );

}

function autor_metabox_callback( $post ) {
 
    // сначала получаем значения этих полей
	// заголовок
    $autors = get_option('autors_site');
    
    if( isset($autors['list']) && ($autors != "autors_site" || (gettype($autors['list']) == "array" && !empty($autors['list']))) ){
        $autors == "autors_site";
        // одноразовые числа, кстати тут нет супер-большой необходимости их использовать
        wp_nonce_field( 'autors_sitesettingsupdate-' . $post->ID, '_truenonce' );

        $meta = get_post_meta( $post->ID, 'autor_name');
        if(!empty($meta)) $meta = $meta[0];

        echo '<table class="form-table">
            <tbody>';
        foreach($autors['list'] as $autor_num => $autor_info){
            echo '<tr><td>';
            $checked = isset($meta[$autor_num]['num']) ? 'checked="checked"' : '';
            echo '<p><label><input '.$checked.' name="autor_name['.$autor_num.'][num]" type="checkbox" value="'.$autor_num.'"/>'.$autor_info['name'].'</label></p>';

            $content =  isset($meta[$autor_num]['text']) ? stripcslashes($meta[$autor_num]['text']) : "";
            $editor_id = "autor_name_" . $autor_num . "_text";

            $settings =   array(
                'wpautop' => false,
                'media_buttons' => false,
                'textarea_name' => "autor_name[$autor_num][text]", //You can use brackets here !
                'textarea_rows' => 8,
                'tabindex' => '323',
                'editor_css' => '',
                'editor_class' => '',
                'teeny' => false,
                'dfw' => false,
                'tinymce' => true,
                'quicktags' => true
            );
            wp_editor($content, $editor_id, $settings);  
            echo '</td></tr>';

        }
        echo '
            </tbody>
        </table>';
    } 
}

function plashka_metabox_callback( $post ){
    // сначала получаем значения этих полей
    
    $plashka_casino = get_option('plashka');
    
    if( $plashka_casino != "plashka" || $plashka_casino != false ){

        $meta = get_post_meta( $post->ID, 'plashka_new');
        
        if(!empty($meta)) $meta = $meta[0];
        
        $selected = empty($meta) ? 'selected="selected"' : '';

        echo '<table class="form-table" id="plashka_new">
            <tbody><select name="plashka_new"><option value="">Не выбрано</option>';
        foreach($plashka_casino as $num => $plashka_info){
            $selected = $meta === $num ? 'selected="selected"' : '';
            echo '<option '.$selected.' value="'.$num.'">'.$plashka_info['name'].'</option>';
        }
        echo '
        </select></tbody>
        </table>';
    } 
}

function autors_meta( $post_id, $post ) {

	// проверяем, может ли текущий юзер редактировать пост
	$post_type = get_post_type_object( $post->post_type );
    
	if ( gettype($post_type) == "object" && property_exists($post_type,'cap') && !current_user_can( $post_type->cap->edit_post, $post_id ) ) {
		return $post_id;
	}
 
	// ничего не делаем для автосохранений
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
		return $post_id;
	}
 
	if( isset( $_POST[ 'autor_name' ] ) ) {
		update_post_meta( $post_id, 'autor_name', $_POST[ 'autor_name' ] );
	} else {
		delete_post_meta( $post_id, 'autor_name' );
	}

    $template_file = get_post_meta($post_id, '_wp_page_template', true);
    if ($template_file != 'casinos.php') {
        // Если не используется нужный шаблон, выходим из функции
        return $post_id;
    }
	
	if( isset( $_POST[ 'plashka_new' ] ) ) {
       if(get_post_meta($post->ID, 'plashka_new', FALSE)){
           update_post_meta( $post_id, 'plashka_new', $_POST[ 'plashka_new' ] );
       }else{
           add_post_meta($post->ID, 'plashka_new', $_POST['plashka_new']);
       }
	}
	return $post_id;
 
}

add_action( 'add_meta_boxes', 'autor_metabox' );
add_action( "save_page", 'autors_meta', 10, 2 );
add_action( "save_post", 'autors_meta', 10, 2 );
add_action( "save_casinos", 'autors_meta', 10, 2 );
add_action( "save_casinocat", 'autors_meta', 10, 2 );
add_action( "save_games", 'autors_meta', 10, 2 );
add_action( "save_bonus", 'autors_meta', 10, 2 );
add_action( "save_providers", 'autors_meta', 10, 2 );