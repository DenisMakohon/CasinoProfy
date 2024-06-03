<?php 

/* Template Name: Sitemap */ 

get_header(); 

$pageSettings = get_fields();

?>

    <section class="container">
        <div class="row">
            <?php get_template_part( 'tmp/common/breadcrumbs', null ); ?>
        </div>
        <div class="row">
            <h1 class="col-12 text-center"><?= the_title() ?></h1>
        </div>
    </section>
    <section class="container">
        <div class="row sitemap">
            <?php
                global $post;
                $pages = new WP_Query(array(
                    'post_type' => 'page',
                    'posts_per_page' => -1,
                    'post__not_in' => array( $post->ID ),
                    'meta_query' => array(
                        'relation' => 'AND',  // Удалить, если любое из условий верно
                        array( // условие для шаблона страницы
                            'key'   => '_wp_page_template',
                            'value' => 'casinos.php',
                            'compare' => '!='
                        ),
                        array( // условие для шаблона страницы
                            'key'   => '_wp_page_template',
                            'value' => 'casinocat.php',
                            'compare' => '!='
                        )
                    )
                ));
                if($pages->posts):
            ?>
                <div class="col-md-3">
                    <?php siteMapListRender($translations_page['pages'], $pages->posts); ?>
                </div>
            <?php endif; ?>
            <div class="col-md-6 text-center sitemap-img">
                <img src="<?=IMG_URL?>sitemap/maskot-with-map.svg" alt="Maskot with map decore image">
            </div>
            <?php 
                global $post;
                $pages = new WP_Query(array(
                    'post_type' => 'page',
                    'posts_per_page' => -1,
                    'meta_query' => array(
                        'relation' => 'AND',
                        array( // условие для шаблона страницы
                            'key'   => '_wp_page_template',
                            'value' => 'casinos.php',
                            'compare' => '='
                        )
                    )
                ));
                if($pages->posts):
            ?>
                <div class="col-md-3">
                    <?php siteMapListRender('Casinos', $pages->posts); ?>
                </div>
            <?php endif; ?>
            <?php 
                $categories = get_categories(array(
                    'orderby' => 'name',
                    'order' => 'ASC'
                ));
                if(count($categories)):
            ?>
            <div class="col-md-3">
            <?php 
                echo "<h2 class='sitemap-list-title'>".$translations_page['games']."</h2><ul class='sitemap-list'>";
                foreach($categories as $category){
                        $title = get_category($category->cat_ID)->cat_name;
                        $catLink = str_replace("/./","/",get_category_link($category->cat_ID));
                        
                        $games = new WP_Query(array(
                            'post_type'      => 'games',
                            'post_status'    => 'publish',
                            'category__in'   => array($category->cat_ID),
                            'posts_per_page' => -1,
                        ));
                        echo "<li><a class='text d-inline-block sitemap-category' href='$catLink'>$title</a>";

                        siteMapListRender('', $games->posts);
                        
                        echo "</li>";
                }
                echo "</ul>";
            ?>
            </div>
            <?php endif; ?>
            <?php
                global $post;
                $pages = new WP_Query(array(
                    'post_type' => 'post',
                    'posts_per_page' => -1,
                ));
                if($pages->posts):
            ?>
                <div class="col-md-3">
                    <?php siteMapListRender($translations_page['blog'], $pages->posts); ?>
                </div>
            <?php endif; ?>
            <?php 
                global $post;
                $pages = new WP_Query(array(
                    'post_type' => 'providers',
                    'posts_per_page' => -1,
                ));
                if($pages->posts):
            ?>
                <div class="col-md-3">
                    <?php siteMapListRender($translations_page['providers'], $pages->posts); ?>
                </div>
            <?php endif; ?>
            <?php 
                global $post;
                $pages = new WP_Query(array(
                    'post_type' => 'page',
                    'posts_per_page' => -1,
                    'meta_query' => array(
                        'relation' => 'AND',
                        array( // условие для шаблона страницы
                            'key'   => '_wp_page_template',
                            'value' => 'casinocat.php',
                            'compare' => '='
                        )
                    )
                ));
                if($pages->posts):
            ?>
                <div class="col-md-3">
                    <?php siteMapListRender($translations_page['casinocat'], $pages->posts); ?>
                </div>
            <?php endif; ?>
            
        </div>    
    </section>

<?php get_footer(); ?>