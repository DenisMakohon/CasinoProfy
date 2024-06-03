<?php // Шорткод для вывода контактов казино
function casinoContacts( $post_id ){
    if(!is_admin()):
    global $post;    

    $contactsList = get_field('shortcode_casino_contacts', $post->ID);
    
    $contacts = '';
    
    foreach($contactsList as $key => $value){
        if(!empty(trim($value))){

            $contactTitle = '';
            $contactImg = '';

            switch($key) {
                case 'email':
                    $contactTitle = $GLOBALS['translations_page']['email_support'];
                    $contactImg = IMG_URL.'message_icon.svg';
                break;
                case 'chat':
                    $contactTitle = $GLOBALS['translations_page']['live_chat_support'];
                    $contactImg = IMG_URL.'chat_icon.svg';
                break;
                case 'phone':
                    $contactTitle = $GLOBALS['translations_page']['phone_support'];
                    $contactImg = IMG_URL.'calling_icon.svg';
                break;
            }

            $contacts .= '
                <div class="col-lg-4 casinoContacts-item">
                    <div class="smallCards">
                        <p class="smallCards-title text d-flex justify-content-between">
                            <span>'.$contactTitle.'</span>
                            <img src="'.$contactImg.'" width="29" height="25" alt="'.$contactTitle.' icon">
                        </p>
                        <span class="grayBgBlock">
                            '.$value.'                      
                        </span>
                    </div>
                </div>
            ';
        }
    }

    $out = '<div class="row casinoContacts">'.$contacts.'</div>';

	return $out;

    endif;
}
add_shortcode( 'casino-contacts', 'casinoContacts' );           // Шорткод для вывода контактов казино