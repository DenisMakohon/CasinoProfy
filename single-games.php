<?php
get_header(); 

$pageSettings = get_fields();

get_template_part( 'tmp/games/game', null, ['pageSettings' => $pageSettings] );
get_template_part( 'tmp/games/gameInfo', null, ['pageSettings' => $pageSettings] ); 
get_template_part( 'tmp/common/mainContent', null );
get_template_part( 'tmp/common/faq', null );

get_footer();