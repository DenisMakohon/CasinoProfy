<?php

$casino_left_sidebar = get_option('casino_left_sidebar');

if(isset($casino_left_sidebar['is_show']) && $casino_left_sidebar['is_show'] && isset($casino_left_sidebar['casinos'])):

    if(isset($args['parrent_page_id']) && $GLOBALS['cur_template_file'] == 'casinos.php'){
        $parrent_page = get_post( $args['parrent_page_id'] );
        $casino_left_sidebar = $parrent_page;
    }else{
        $casino_left_sidebar_args = array(
            'post_type' => 'page',
            'orderby' => 'post__in',
            'post__in' => $casino_left_sidebar['casinos'],
            'posts_per_page' => 1,
            'meta_query' => array(
                'relation' => 'AND',
                array( // условие для шаблона страницы
                    'key' => '_wp_page_template',
                    'value' => 'casinos.php',
                    'compare' => '='
                )
            )
        );
        
        $casino_left_sidebar_list = new WP_Query($casino_left_sidebar_args);
        if(isset($casino_left_sidebar_list->posts[0])){
            $casino_left_sidebar = $casino_left_sidebar_list->posts[0];
        }else{
            $casino_left_sidebar = NULL;
        }
    }
    
    if ($casino_left_sidebar) :

        $cur_casino_left_sidebar = get_fields($casino_left_sidebar->ID);
        $block_casino_info = block_casino($cur_casino_left_sidebar);
        $ref_link = $block_casino_info['ref_link'];
        $casino_block = $block_casino_info['casino_block'];

        $popup_btn = $ref_link == $casino_block ? 'get_popup' : '';

        $titleCasino = !empty($cur_casino_left_sidebar['casino_short_name']) ? $cur_casino_left_sidebar['casino_short_name'] : get_the_title($casino_left_sidebar->ID);

        $bonuses = $cur_casino_left_sidebar['bonus_block'];

        $casino_left_sidebar_bonus = empty(array_values(array_filter($bonuses, "welcomeBonus"))) ? reset($bonuses) : array_values(array_filter($bonuses, "welcomeBonus"));

        ?>

        <div class="casinoSidebar casinoOfTheMonth" data-user="1">
            <div class="casinoOfTheMonth-item--wrap-block">
                <div class="casinoOfTheMonth-item--img-block">
                    <?php if (has_post_thumbnail($casino_left_sidebar->ID)): ?>
                        <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($casino_left_sidebar->ID), 'single-post-thumbnail'); ?>
                        <img src="<?php echo $image[0]; ?>" alt="">
                    <?php endif; ?>
                </div>
                <div class="casinoOfTheMonth-item--info-block">
                    <p class="casinoOfTheMonth-title"><?= $titleCasino ?></p>
                </div>
            </div>
            <div class="casinoOfTheMonth-item-bonus-wrap">
                <div class="casinoOfTheMonth-bonus"><?= $casino_left_sidebar_bonus[0]['text'] ?></div>
            </div>
            <div class="casinoOfTheMonth-btn-wrap">
                <a data-popup="<?= $popup_btn ?>" href="<?= $ref_link ?>" class="btn btn-js" target="_blank"
                    rel="nofollow"><?= $GLOBALS['translations_page']['get_bonus_red'] ?></a>
            </div>
            <div class="casinoOfTheMonth-item-t_c-wrap">
                <?php
                if ($casino_left_sidebar_bonus[0]['t_c']) { ?>
                    <div class="casinoOfTheMonth-bonus-t_c">
                        <?php echo $casino_left_sidebar_bonus[0]['t_c'] ?>
                    </div>
                <?php } ?>
            </div>

            <?php if (isset($GLOBALS['translations_page']['casino_of_the_month'])) { ?>

                <a target="_blank" href="<?= $ref_link ?>" class="casinoOfTheMonth-banner-wrap"
                    style="background:#E4322B;">
                    <div class="casinoOfTheMonth-banner-title">
                        <?= $GLOBALS['translations_page']['casino_of_the_month'] ?>
                    </div>
                    <img src="<?=IMG_URL?>casino-of-the-month--banner-upd.svg" alt="casino-of-the-month"
                            width="100%"
                            height="88"
                            class="casinoOfTheMonth-banner">
                </a>

            <?php } ?>

        </div>

    <?php endif;

endif;
if(isset($args['parrent_page_id'])) wp_reset_postdata();  
?>