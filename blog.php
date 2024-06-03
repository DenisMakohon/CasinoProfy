<?php /* Template Name: Blog */ ?>

<?php 
    get_header(); 
    $pageSettings = get_field('additional_field');
?>

    <section class="container">
    <?php get_template_part( 'tmp/common/breadcrumbs', null ); ?>
        <div class="row">
            <h1 class="col-12"><?= the_title() ?></h1>
        </div>
    </section>
    <?php 

    get_template_part( 'tmp/common/mainContent', null );

    $post_args = array(
        'numberposts'      => 12,
        'post_type'        => 'post',
        'suppress_filters' => true,
        'post_status'      => 'publish'
    );

    $latest_posts = get_posts( $post_args );
    $blog_posts = array();
    if(count($latest_posts) > 0){
       
        if(count($latest_posts) >= 5) {
            $blog_posts = array_chunk($latest_posts, ceil(count(get_posts( $post_args )) / 2))[0];
        }else{
            $blog_posts = $latest_posts;
        }
    ?>
        <section class="container lastPosts">
            <div class="row">
                <?php foreach($blog_posts as $post){ get_template_part( 'tmp/blog/preview', null, [ 'post' => $post ] ); } ?>
            </div>
        </section>
    <?php } 

    if($pageSettings) echo do_shortcode('[topFourCasinos id="'.$pageSettings.'"]');    

    if(count($latest_posts) >= 5){
        $blog_posts = array_chunk($latest_posts, ceil(count(get_posts( $post_args )) / 2))[1];
    ?>
        <section class="container lastPosts">
            <div class="row">
                <?php foreach($blog_posts as $post){ get_template_part( 'tmp/blog/preview', null, [ 'post' => $post ] ); }?>
                <div class="col-12 text-center">
                    <span class="btn btn-js js-morePosts"><?=$translations_page['blog_all']?></span>
                </div>
            </div>
        </section>
    <?php } ?>
<?php get_footer(); ?>