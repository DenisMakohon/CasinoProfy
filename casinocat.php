<?php 

/* Template Name: Casino Category */

get_header();

$pageSettings = get_fields();

?>

    <div class="wrapperContent">
        <?php get_template_part( 'tmp/common/casinoLeftSidebar', null ); ?>
        <div class="allContent">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <?php get_template_part( 'tmp/common/breadcrumbs', null ); ?>
                    </div>
                </div>
                <div class="row">
                    <h1 class="col-12 text-center"><?= the_title() ?></h1>
                </div>
            </div>
            <?php 
                get_template_part( 'tmp/common/mainContent', null );
                get_template_part( 'tmp/common/faq', null ); 
            ?>
        </div>
        <?php get_template_part( 'tmp/common/tableOfContents', null ); ?>
    </div>

<?php get_footer(); ?>