<?php get_header('blank');

$pageSettings = get_fields();

?>
<div class="container">
    <div class="row">
        <h1 class="col-12 text-center"><?= the_title() ?></h1>
    </div>
</div>
<?php 
get_template_part( 'tmp/common/mainContent', null );
get_template_part( 'tmp/common/faq', null ); 

get_footer('blank');