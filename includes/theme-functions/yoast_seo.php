<?php
// Генерация hreflang и canonical

// Проверка на бота
function isBot(){
    $agent = $_SERVER['HTTP_USER_AGENT'];

    // 'rambler', 'googlebot', 'aport', 'yahoo', 'msnbot', 'turtle', 'mail.ru', 'omsktele',
    // 'yetibot', 'picsearch', 'sape.bot', 'sape_context', 'gigabot', 'snapbot', 'alexa.com',
    // 'megadownload.org', 'askpeter.info', 'igde.ru', 'ask.com', 'qwartabot', 'yanga.co.uk',
    // 'scoutjet', 'similarpages', 'oozbot', 'shrinktheweb.com', 'aboutusbot', 'followsite.com',
    // 'dataparksearch', 'google-sitemaps', 'appEngine-google', 'feedfetcher-google',
    // 'liveinternet.ru', 'xml-sitemaps.com', 'agama', 'metadatalabs.com', 'h1.hrn.ru',
    // 'googlealert.com', 'seo-rus.com', 'yaDirectBot', 'yandeG', 'yandex',
    // 'yandexSomething', 'Copyscape.com', 'AdsBot-Google', 'domaintools.com',
    // 'Nigma.ru', 'bing.com', 'dotnetdotcom'
    
    $bots = array('googlebot');

    foreach ($bots as $bot) {
        if (stripos(strtolower($agent), $bot) !== false) {
            return true;
        }
    }

    return false;
}

// Генерация hreflang

function getHreflang(){
    global $post;

    // $isBot = isBot();
    $isBot = true;

    if(!empty($post->post_name) && $isBot){

        // Дополнительные альтернейты
        $alternates = get_field('alternate');

        if($alternates){
            
            foreach($alternates as $alternate){
                $href = $alternate['url'];
                $hreflang = $alternate['hreflang'];

                echo '<link rel="alternate" hreflang="'.$hreflang.'" href="'.$href.'" />';

            }
        }
    }
    
}

// END Генерация hreflang

// Генерация canonical

function custom_canonical( $filter ){
	// Показываем только для ботов и URL копии и зеркала меняем на основной URL
    global $wp;
    return home_url( $wp->request )."/";
}

// END Генерация canonical

function rewrite_rule_my(){
	add_rewrite_tag( '%pagetype%', '' );

    global $wp_rewrite;
    $GLOBALS['wp']->add_query_var( 'sitemap' );
    $GLOBALS['wp']->add_query_var( 'sitemap_n' );
    add_rewrite_rule( 'websitemap.xml$', 'index.php?sitemap=1', 'top' );
    add_rewrite_rule( '([^/]+?)-websitemap([0-9]+)?.xml$', 'index.php?sitemap=$matches[1]&sitemap_n=$matches[2]', 'top' );
    $wp_rewrite->flush_rules();
}

// Вывод урлов в сайтмэпе 

function filter_wpseo_sitemap_entry( $url) { 

    $url['loc'] = str_replace("/./","/",$url['loc']);

    return $url; 
};

function mod_loc($link){
    
    $link = array(
        'loc' => str_replace('-sitemap', "-websitemap", $link['loc']),
        'lastmod' => $link['lastmod']
    );
    return $link;
}

function add_sub_sitemaps( $links ){
    $links = array_map('mod_loc', $links);
    if(get_main_site_id() == get_current_blog_id()){

        $sites_path = getBlogsList();
        
        foreach($sites_path as $path => $mod_date){
            if($path != 'ua'){
                $links[] = array(                    
                    'loc' => get_home_url()."/".$path."/websitemap.xml",
                    'lastmod' => false
                );
            }            
        }
    }    

	return $links;
}

function add_extra_links( $output, $url ){

    $sites_path = getBlogsList();
    // Выводим урлы только на "главном" сайте сразу после вывода алреса домашней страницы
    if(get_main_site_id() == get_current_blog_id() && trim(get_home_url(), "/") == trim($url['loc'], "/")){   
        foreach($sites_path as $path => $mod_date){
            $output .= "<url>
                    <loc>".get_home_url()."/".$path."/</loc>
                    <lastmod>".$mod_date."+00:00</lastmod>
                </url>";
        }        
    }
	return $output;
}

add_action('init', 'rewrite_rule_my');
add_filter('wpseo_sitemap_url', 'add_extra_links', 10, 2 );
add_filter('wpseo_sitemap_index_links', 'add_sub_sitemaps');
add_filter('wpseo_sitemap_entry', 'filter_wpseo_sitemap_entry', 10, 3); // Вывод урлов в сайтмэпе

add_filter('wpseo_canonical', 'custom_canonical'); // вывод канониклов
add_filter('wpseo_json_ld_output', '__return_false');