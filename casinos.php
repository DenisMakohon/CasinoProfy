<?php 

/* Template Name: Casinos */

get_header(); 

$parrent_page_id = wp_get_post_parent_id();

$post_name = $post->post_name;
$pageSettings = get_fields();

$current_page_id = get_the_ID(); // Получаем ID текущей страницы
$args = [
    'post_type'      => 'page',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'post_parent'    => $parrent_page_id ? $parrent_page_id : $current_page_id,
    'meta_query'     => [
        'relation' => 'AND', // Все условия должны быть истинны
        [
            'key'     => '_wp_page_template',
            'value'   => 'casinos.php',
            'compare' => '='
        ],
        [
            'relation' => 'OR', // Любое из следующих условий должно быть истинно
            [
                'key'     => 'is_child',
                'value'   => 'yes', // Строковое значение
                'compare' => '='
            ],
            [
                'key'     => 'is_child',
                'value'   => '1', // Булево значение, представленное как строка
                'compare' => '='
            ]
        ]
    ]
];

$child_pages_query = new WP_Query($args);
            
$template_file = get_post_meta($parrent_page_id, '_wp_page_template', true);

// определяем "основной" URL path
$parrent_path = $template_file == 'casinos.php' ? 
                    parse_url(get_permalink( $post->post_parent ))['path'] : 
                    $_SERVER['REQUEST_URI'];
?>

    <div class="wrapperContent">
        <?php get_template_part( 'tmp/common/casinoLeftSidebar', null, [ 'parrent_page_id' => $parrent_page_id ] ); ?>
        <div class="allContent">
            <?php get_template_part( 'tmp/casino/mainInfo', null, [ 'parrent_page_id' => $parrent_page_id ] ); ?>

            <!-- ВЫВОДИМ ТАБЫ, ЕСЛИ ОНИ ЕСТЬ -->

            <?php if(count($child_pages_query->posts)){ 

                $child_pages = [];

                foreach($child_pages_query->posts as $child_tab){

                    $text_in_tab = get_field('text_in_tab', $child_tab->ID);
                    $text_in_tab_inner = empty($text_in_tab) ? $child_tab->post_title : $text_in_tab;
                    
                    array_unshift($child_pages, [
                        "text" => $text_in_tab_inner,
                        "link" => get_permalink($child_tab),
                        "content" => $child_tab->post_content
                    ]);
                }
                
                array_unshift($child_pages, [
                    "text" => $GLOBALS['translations_page']['review'],
                    "link" => $GLOBALS['domain_url'].$parrent_path
                ]);
                
                ?>

                <div class="container mainInfo-container">
                    <div class="tabs d-flex flex-wrap">
                        <?php                        
                        foreach($child_pages as $tab){
                            if( $tab['link'] == $GLOBALS['current_url']){
                                echo "<p class='active tabs-item text-center'>".$tab['text']."</p>";
                            }else{
                                echo "<a class='tabs-item text-center' href='".$tab['link']."'>".$tab['text']."</a>";
                            }
                        }
                        ?>
                    </div>
                </div>
                <!-- END ВЫВОДИМ ТАБЫ, ЕСЛИ ОНИ ЕСТЬ -->
            <?php }

            // Выводим контент ревью, как это было раньше
            if( !$parrent_page_id ){ 

                get_template_part( 'tmp/casino/secondInfo', null, [ 'pageSettings' => $pageSettings ] );
                get_template_part( 'tmp/casino/additionalInfo', null, [ 'pageSettings' => $pageSettings ] );
                get_template_part( 'tmp/casino/characteristicsOfTheCasino', null, [ 'pageSettings' => $pageSettings ] );
                get_template_part( 'tmp/casino/bonusSlider', null, [ 'pageSettings' => $pageSettings ] );
            ?>
                <section class="container contains">
                    <?=do_shortcode('[contains]')?>
                </section>                
                <?php 
                    get_template_part( 'tmp/common/mainContent', null );

                    if(isset(get_option('autors_site')['link']) && $_SERVER['REQUEST_URI'] != get_option('autors_site')['link']) echo do_shortcode( '[autors]' ); 
                    get_template_part( 'tmp/common/faq', null ); 
                }else{
                // Вывод контента для табов
                $target_content = array_values(array_filter($child_pages, function($tab){
                    return $tab['link'] == $GLOBALS['current_url'];
                }));
                
                $post->post_content = $target_content[0]['content'];

                    get_template_part( 'tmp/common/mainContent', null );

                    if(isset(get_option('autors_site')['link']) && $_SERVER['REQUEST_URI'] != get_option('autors_site')['link']) echo do_shortcode( '[autors]' ); 
            }

            // END Вывод контента для табов
            
            ?>

            <!-- Комментарии -->
            <section class="container mainContent">
                <?php if (comments_open()) comments_template(); ?>
            </section>
            <!-- END Комментарии -->

        </div>
        <?php get_template_part( 'tmp/common/tableOfContents', null ); ?>
    </div>
    
<?php get_footer(); ?>