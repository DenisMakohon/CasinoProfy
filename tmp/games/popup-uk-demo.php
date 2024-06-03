

<div class="popup js-popupUkDemo popup-ukdemo text-center">
    <p class="heading-4">According to current legislation, UK residents cannot play free demos on the site.</p>
    <p class="mainText">Otherwise you can try this demo by signing up on the casinos below:</p>
<?php
$presents = get_option('uk_popup_casinos');

if($presents != "uk_popup_casinos" && $presents != false) :
    $presents_args = array(
        'post_type'         => 'page',
        'orderby'           => 'post__in',
        'post__in'          => $presents,
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

    $presents_list = new WP_Query( $presents_args );
    if(count($presents_list->posts)) :
        ?>

        <div class="popupUkDemo">
            <div class="popupUkDemo-container">
                <div class="popupUkDemo-list">
                    <?php
                    foreach($presents_list->posts as $present) :
                        $cur_present = get_fields($present->ID);

                        $titleCasono = !empty($cur_present['casino_short_name']) ? $cur_present['casino_short_name'] : get_the_title($present->ID);

                        $bonuses = $cur_present['bonus_block'];

                        $present_bonus = empty(array_values(array_filter($bonuses, "welcomeBonus"))) ? reset($bonuses) : array_values(array_filter($bonuses, "welcomeBonus"));

                        $ref_link = isset($present_bonus[0]['bonus_ref']) && $present_bonus[0]['bonus_ref'] ? $present_bonus[0]['bonus_ref'] : $cur_present['ref_link'];
                        ?>
                        <div class="popupUkDemo-item">
                            <div class="popupUkDemo-item-wrap">
                                <div class="popupUkDemo-item--wrap-block">
                                    <div class="popupUkDemo-item--img-block">
                                        <?php if (has_post_thumbnail( $present->ID ) ): ?>
                                            <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $present->ID ), 'single-post-thumbnail' ); ?>
                                            <img src="<?php echo $image[0]; ?>" alt="">
                                        <?php endif; ?>
                                    </div>
                                    <div class="popupUkDemo-item--info-block">
                                        <p class="popupUkDemo-title"><?=$titleCasono?></p>
                                    </div>
                                </div>
                                <div class="popupUkDemo-item-bonus-wrap">
                                    <div class="popupUkDemo-bonus"><?=$present_bonus[0]['text']?></div>
                                </div>
                                <div class="popupUkDemo-item-t_c-wrap" >
                                    <?php if (strpos($lang_settings['html'], 'en') !== false && $present_bonus[0]['t_c']) { ?>
                                        <!--<div class="popupUkDemo-bonus-t_c"><?php /*= $present_bonus[0]['t_c'] */?></div>-->
                                        <?php
                                        $text = $present_bonus[0]['t_c'];
                                        $patt = '/"["\']?([^"\'>]+)["\']?/';
                                        preg_match_all($patt, $text, $arr); ?>

                                        <div class="popupUkDemo-bonus-t_c">
                                            <p>
                                                <a target="_blank" href=<?php echo $arr[0][0]; ?>>T&C Apply</a>
                                            </p>
                                        </div>

                                    <?php } ?>
                                </div>
                            </div>

                            <div class="popupUkDemo-btn-wrap">
                                <a href="<?=$ref_link?>" class="btn btn-js" target="_blank" rel="nofollow"><?=$GLOBALS['translations_page']['play_btn']?></a>
                            </div>

                        </div>

                    <?php endforeach; ?>

                </div>
                <div class="popupUkDemo-list-mobile popupUkDemo-list js-popupUKDemoSlider">
                    <?php
                    foreach($presents_list->posts as $present) :
                        $cur_present = get_fields($present->ID);

                        $titleCasono = !empty($cur_present['casino_short_name']) ? $cur_present['casino_short_name'] : get_the_title($present->ID);

                        $bonuses = $cur_present['bonus_block'];

                        $present_bonus = empty(array_values(array_filter($bonuses, "welcomeBonus"))) ? reset($bonuses) : array_values(array_filter($bonuses, "welcomeBonus"));

                        $ref_link = isset($present_bonus[0]['bonus_ref']) && $present_bonus[0]['bonus_ref'] ? $present_bonus[0]['bonus_ref'] : $cur_present['ref_link'];
                        ?>
                        <div class="popupUkDemo-item">
                            <div class="popupUkDemo-item-wrap">
                                <div class="popupUkDemo-item--wrap-block">
                                    <div class="popupUkDemo-item--img-block">
                                        <?php if (has_post_thumbnail( $present->ID ) ): ?>
                                            <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $present->ID ), 'single-post-thumbnail' ); ?>
                                            <img src="<?php echo $image[0]; ?>" alt="">
                                        <?php endif; ?>
                                    </div>
                                    <div class="popupUkDemo-item--info-block">
                                        <p class="popupUkDemo-title"><?=$titleCasono?></p>
                                    </div>
                                    <div class="popupUkDemo-item-bonus-wrap">
                                        <div class="popupUkDemo-bonus"><?=$present_bonus[0]['text']?></div>
                                    </div>
                                    <div class="popupUkDemo-item-t_c-wrap" >
                                        <?php if (strpos($lang_settings['html'], 'en') !== false && $present_bonus[0]['t_c']) { ?>
                                            <?php
                                            $text = $present_bonus[0]['t_c'];
                                            $patt = '/"["\']?([^"\'>]+)["\']?/';
                                            preg_match_all($patt, $text, $arr); ?>

                                            <div class="popupUkDemo-bonus-t_c">
                                                <p>
                                                    <a target="_blank" href=<?php echo $arr[0][0]; ?>>T&C Apply</a>
                                                </p>
                                            </div>

                                        <?php } ?>
                                    </div>
                                    <div class="popupUkDemo-btn-wrap">
                                        <a href="<?=$ref_link?>" class="btn btn-js" target="_blank" rel="nofollow"><?=$GLOBALS['translations_page']['play_btn']?></a>
                                    </div>
                                </div>

                            </div>

                        </div>

                    <?php endforeach; ?>

                </div>
            </div>
        </div>

    <?php endif;
endif; ?>
</div>
<div class="overlay"></div>
