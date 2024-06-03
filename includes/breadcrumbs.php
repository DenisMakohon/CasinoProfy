<?php /**
 * Generate breadcrumbs
 * @author CodexWorld
 * @authorURL www.codexworld.com
 */

function get_breadcrumb() {
    $hone_text = get_blog_details()->path == '/en/' ? "Online Casino Reviews UK" : 'CasinoProfy';
    // d(get_blog_details()->path == "\/en\/");
    echo '<a href="'.home_url().'" rel="nofollow">11'.$hone_text.'</a>';
    if (is_category() || is_single()) {
        echo "&nbsp;&nbsp;&#187;&nbsp;&nbsp;";
        the_category(' &bull; ');
            if (is_single()) {
                echo " &nbsp;&nbsp;&#187;&nbsp;&nbsp; ";
                the_title();
            }
    } elseif (is_page()) {
        echo "&nbsp;&nbsp;&#187;&nbsp;&nbsp;";
        echo the_title();
    } elseif (is_search()) {
        echo "&nbsp;&nbsp;&#187;&nbsp;&nbsp;Search Results for... ";
        echo '"<em>';
        echo the_search_query();
        echo '</em>"';
    }
}
?>