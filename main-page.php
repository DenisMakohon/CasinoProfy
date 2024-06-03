<?php 

/* Template Name: Main page */ 

$pageSettings = get_fields();

get_header(); ?>

    <div class="wrapperContent">

        <?php get_template_part( 'tmp/common/casinoLeftSidebar', null ); ?>
        <div class="allContent">
            <div class="container">
                <div class="row">
                    <h1 class="col-12 text-center"><?= the_title() ?></h1>
                </div>
            </div>
            <?php 
                get_template_part( 'tmp/common/mainContent', null );
                get_template_part( 'tmp/main_page/reviews-clients', null );
                get_template_part( 'tmp/main_page/last-posts', null );
                get_template_part( 'tmp/common/faq', null ); 
            ?>
        </div>
        <?php get_template_part( 'tmp/common/tableOfContents', null ); ?>
    </div>

<?php wp_reset_postdata();
get_footer(); ?>