<?php
    $post = $args['post'];
    $post_link = get_field('custom_link');
    if(!$post_link) $post_link = get_permalink($post);
?>
<div class="col-md-4 blogPreview">
    <a href="<?=$post_link?>" class="d-block">
        <span class="blogPreview-img d-flex justify-content-center" style="background-image: url(<?=get_the_post_thumbnail_url()?>);">
            <span class="blogPreview-date text-center d-flex align-items-center justify-content-center flex-column">
                <span><?=get_the_date('d M')?></span>
                <span><?=get_the_date('Y')?></span>
            </span>
        </span>                    
        <span class="blogPreview-title d-block">
            <span class="d-block"><?php the_title(); ?></span>
            <span class="blogPreview-title-read d-block text-center"><?=$GLOBALS['translations_page']['read_more']?></span>
        </span>
    </a>
</div>