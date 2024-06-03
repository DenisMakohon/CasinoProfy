<?php
    $lang_settings = get_option('lang');
    if($lang_settings === false) $lang_settings = array('html' => 'en', 'hreflang' => 'en', 'hreflang_title' => '' );

    $popup_casinos = get_option('popup_casinos_section');

    if(!empty($popup_casinos) && $popup_casinos != 'popup_casinos' && isset($popup_casinos['list']) && isset($popup_casinos['title'])) :

    $popup_casinos_args = array(
        'post_type'         => 'page',
        'orderby'           => 'post__in', 
        'post__in'          => $popup_casinos['list'],
        'posts_per_page'    =>  -1,
        'meta_query' => array(
            'relation' => 'AND',
            array( // условие для шаблона страницы
                'key'   => '_wp_page_template',
                'value' => 'casinos.php',
                'compare' => '='
            )
        )
    );
    $popup_casinos_list = new WP_Query( $popup_casinos_args );

    if(count($popup_casinos_list->posts) && $args == "#casino_block"):
        if (!is_singular('casinos')): ?>
        <div class="container popupCasinosFixed js-popupCasinosFixed" >
        <?php endif; ?>

<div class="row">
    <p id="casino_block" class="col-12 popupCasinos-title text-center"><?=$popup_casinos['title']?></p>
    <div class="col-12 popupCasinos-arrows d-flex justify-content-end"></div>
    <div class="popupCasinos-slider js-popupCasinosSlider">
        <?php 
            foreach($popup_casinos_list->posts as $popup_item):
                $popup_item_fields = get_fields($popup_item->ID);
        ?>
            <div class="popupCasinos-item">
                <div class="popupCasinos-inner">
                    <a href="<?=get_permalink($popup_item->ID)?>" target="_blank" class="mainInfo-logo-img d-flex flex-column" >
                        <img src="<?=get_the_post_thumbnail_url( $popup_item, 'thumbnail' )?>" alt="<?=$popup_item->post_title?> logo" class="imageShadow js-imageShadow">
                    </a>
                    <a rel="nofollow" href="<?=$popup_item_fields['ref_link']?>" target="_blank" class="btn btn-js"><?=$GLOBALS['translations_page']['get_bonus_logo']?></a>   
                </div>                                     
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php 
    if (!is_singular('casinos')): 
    ?>
        <div class="popupCasinosFixed-close js-popupCasinosFixedClose"></div>
    </div>
    <div class="overlay js-popupCasinosFixedClose"></div>
    <?php
    endif;
    endif;
    endif; 
?>
