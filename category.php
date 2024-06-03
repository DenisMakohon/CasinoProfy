<?php 
/**
* A Simple Category Template
*/
get_header(); 

$pageSettings = get_fields();


?>
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
    
    $cat_args = array(
        'orderby' => 'name',
        'order' => 'ASC'
    );
    $categories = get_categories($cat_args);

    get_template_part( 'tmp/common/faq', null ); 

    ?>
    
<?php get_footer(); ?>