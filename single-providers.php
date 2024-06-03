<?php 

get_header();

$pageSettings = get_fields();

?>

    <div class="wrapperContent">
        <?php get_template_part( 'tmp/common/casinoLeftSidebar', null ); ?>
        <div class="allContent">
            <section class="container">
                <div class="col-lg-12">
                    <?php get_template_part( 'tmp/common/breadcrumbs', null ); ?>
                </div>
                <div class="row">
                    <h1 class="col-12 text-center"><?= the_title() ?></h1>
                    <?php if (get_the_content()): ?>
                        <section class="container mainContent">
                            <img src="<?= get_the_post_thumbnail_url() ?>" class="provider-img" alt="provider logo">
                            <?php the_content(); ?>
                        </section>
                    <?php endif; ?>
                </div>
            </section>                 
            <?php get_template_part( 'tmp/common/faq', null ); ?>
        </div>
        <?php get_template_part( 'tmp/common/tableOfContents', null ); ?>
    </div>

<?php get_footer(); ?>