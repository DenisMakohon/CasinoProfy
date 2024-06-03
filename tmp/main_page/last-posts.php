<?php

    $post_args = array(
        'numberposts'      => 3,
        'post_type'        => 'post',
        'suppress_filters' => true,
        'post_status'      => 'publish'
    );

    $latest_posts = get_posts( $post_args );
    if(count($latest_posts) > 0){
?>

<section class="container lastPosts">
    <div class="row">
        <h2 class="col-12 title-block"> <span class="title-line"><?=$GLOBALS['translations_page']['blog']?></span> </h2>
    </div>
    <div class="row">
        <?php 
        foreach($latest_posts as $post){
            get_template_part( 'tmp/blog/preview', null, ['post' => $post] );
        } 
        if(isset($GLOBALS['translations_page']['blog_link']) && $GLOBALS['translations_page']['blog_link']){
        ?>        
        <div class="col-12 text-center">
            <a href="<?=$GLOBALS['translations_page']['blog_link']?>" class="btn btn-js"><?=$GLOBALS['translations_page']['blog_all']?></a>
        </div>
        <?php } ?>
    </div>
</section>
<?php } ?>