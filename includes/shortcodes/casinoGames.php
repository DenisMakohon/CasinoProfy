<?php // Шорткод для вывода типов игр казино
function casinoGames( $post_id ){
    if(!is_admin()):
    global $post;    
    
    $gamesInfo = get_field('shortcode_casino_games', $post->ID);
    
    if(!empty($gamesInfo)){
        $games = '';
        
        if(!empty(trim($gamesInfo['slot_machines']))) $games .= '<li class="d-flex align-items-center justify-content-between"><span class="text">'.$GLOBALS['translations_page']["slot_machines"].'</span><span class="grayBgBlock">'.$gamesInfo['slot_machines'].'</span></li>';
        if(!empty(trim($gamesInfo['video_poker']))) $games .= '<li class="d-flex align-items-center justify-content-between"><span class="text">'.$GLOBALS['translations_page']['video_poker'].'</span><span class="grayBgBlock">'.$gamesInfo['video_poker'].'</span></li>';
        if(!empty(trim($gamesInfo['baccarat']))) $games .= '<li class="d-flex align-items-center justify-content-between"><span class="text">'.$GLOBALS['translations_page']['baccarat'].'</span><span class="grayBgBlock">'.$gamesInfo['baccarat'].'</span></li>';
        if(!empty(trim($gamesInfo['roulette']))) $games .= '<li class="d-flex align-items-center justify-content-between"><span class="text">'.$GLOBALS['translations_page']['rulette'].'</span><span class="grayBgBlock">'.$gamesInfo['roulette'].'</span></li>';
        if(!empty(trim($gamesInfo['blackjack']))) $games .= '<li class="d-flex align-items-center justify-content-between"><span class="text">'.$GLOBALS['translations_page']['blackjack'].'</span><span class="grayBgBlock">'.$gamesInfo['blackjack'].'</span></li>';
        if(!empty(trim($gamesInfo['poker']))) $games .= '<li class="d-flex align-items-center justify-content-between"><span class="text">'.$GLOBALS['translations_page']['poker'].'</span><span class="grayBgBlock">'.$gamesInfo['poker'].'</span></li>';
        if(!empty(trim($gamesInfo['bingo']))) $games .= '<li class="d-flex align-items-center justify-content-between"><span class="text">'.$GLOBALS['translations_page']['bingo'].'</span><span class="grayBgBlock">'.$gamesInfo['bingo'].'</span></li>';
        if(!empty(trim($gamesInfo['live_games']))) $games .= '<li class="d-flex align-items-center justify-content-between"><span class="text">'.$GLOBALS['translations_page']['live_games'].'</span><span class="grayBgBlock">'.$gamesInfo['live_games'].'</span></li>';

        $out = '
            <div class="casinoGames d-flex align-items-start">
                <div class="casinoGames-big grayBgBlock text-center">'.$gamesInfo['games'].' <p>'.$GLOBALS['translations_page']['games_2'].'</p></div>
                <ul class="casinoGames-other d-flex flex-wrap">'.$games.'</ul>
            </div>
        ';

        return $out;
    }
    endif;
}
add_shortcode( 'casino-games', 'casinoGames' );                 // Шорткод для вывода типов игр казино