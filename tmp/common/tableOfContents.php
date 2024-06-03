<?php

$pattern = '/data-anchor="([^"]+)"/';
// $pattern = '/<h2[^>]*id="([^"]+)"/u';
preg_match_all($pattern, get_the_content(), $h2_anchors);

if(!empty($h2_anchors[1]) && !(isset($GLOBALS['hide_content']['content']['shortcodes']) && in_array('contains', $GLOBALS['hide_content']['content']['shortcodes']))) { 
    wp_reset_postdata();

    ?>

    <div class="casinoSidebar tableOfContents">
        <div class="tableOfContents-title"><?=$GLOBALS['translations_page']['tabel_of_content']?></div>
        <?php

        $out = "
            <div id='tableOfContents' class='flex-wrap'>
            <ul>
        ";

        foreach($h2_anchors[1] as $anchor){
            $spaces_id = preg_replace('/\s/','-', $anchor);
            $out .= '<li><a href="#'.$spaces_id.'">'.$anchor.'</a></li>';
        }
        if(!empty(get_field('faq'))){
            $out .= '<li><a href="#'.$GLOBALS['translations_page']['faq'].'-❓">'.$GLOBALS['translations_page']['faq'].' ❓</a></li>';
        }

        $out .= "</ul>              
            </div>";
        echo $out;

        ?>
    </div>
<?php } ?>