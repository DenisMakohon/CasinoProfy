<?php 

$best_online_casinos = get_option('best_online_casinos');

if(isset($args['pageSettings'])) $pageSettings = $args['pageSettings'];
if(empty($best_online_casinos) || $best_online_casinos == 'best_online_casinos' ) $best_online_casinos = ['-1'];

$casinos_args = [
    'date_format'       => get_option('date_format'),
    'meta_key'			=> 'rating',
	'orderby'           => 'post__in', 
    'post_type'         => 'page',
    'post_status'       => array('publish'),
    'posts_per_page'    => 5,
    'order'				=> 'DESC',
    'post__in'          => $best_online_casinos,
    'meta_query' => [
        'relation' => 'AND',
        [
            // условие для шаблона страницы
            'key'   => '_wp_page_template',
            'value' => 'casinos.php',
            'compare' => '='
        ]
    ]
];

if(strpos($lang_settings['html'],'en') !== false) $casinos_args['posts_per_page'] = 3;

$casinos = new WP_Query( $casinos_args );
?>

<section class="container game">
    <?php get_template_part( 'tmp/common/breadcrumbs', null ); ?>
    <div class="row">
        <h1 class="col-12 text-center"><?=the_title()?></h1>
    </div>
    <div class="row">
        <div class="col-lg-8 iframe">
            <?php get_template_part('tmp/common/rating', null); ?>
            <div class="iframe-container js-iframeContainer">  
                <div class="iframeContainerPopup js-iframeContainerPopup">
                    <?php get_template_part( 'tmp/games/popup-uk-demo', null ); ?>
                    <div style="background-image: url(<?=$pageSettings['game_iframe']['image']?>);" class="iframe-overlay"></div>
                    <iframe src="" frameborder="0"></iframe>
                    <img src="<?=IMG_URL?>games/startGame.svg" class="startGameImg js-startIframe" data-iframe="<?=$pageSettings['game_iframe']['src']?>" alt="start the game button" width="166" height="166">
                    <div class="js-iframeFullScreenButtons iframeFullScreen">
                        <img class="js-iframeFullScreen" src="<?=IMG_URL?>fullscreen.svg" width="20" height="20" alt="iframeFullScreen">
                        <img class="js-iframeLowScreen" src="<?=IMG_URL?>lowscreen.svg" width="20" height="20" alt="iframeLowScreen">
                    </div>
                </div>
            </div>
            
            <div class="iframe-start text-center">
                <a class="btn btn-js" rel="nofollow" href="<?php echo !empty($pageSettings['ref_link']) ? $pageSettings['ref_link'] : $GLOBALS['domain_url'].get_site()->path.'goto/casino/'; ?>" target="_blank"><span class="class4-<?=$lang_settings['html']?>"><?=$GLOBALS['translations_page']['play_btn']?></span></a>
            </div>
        </div>
        <?php if(count($casinos->posts)): ?>
        <div class="col-lg-4 best-list-container">
            <h2><?=$GLOBALS['translations_page']['best_online_casinos']?></h2>
            <ul class="best-list">
                <?php

                    foreach($casinos->posts as $post):

                    $bonuses = get_field('bonus_block',$post->ID);
                    $outBonus = empty(array_values(array_filter($bonuses, "welcomeBonus"))) ? reset($bonuses) : array_values(array_filter($bonuses, "welcomeBonus"));

                    $block_casino_info = block_casino(get_fields($post->ID));
                    $ref_link = $block_casino_info['ref_link'];
                    $casino_block = $block_casino_info['casino_block'];
                    $popup_btn = $ref_link == $casino_block ? 'get_popup' : '';
                ?>
                    <li class="best-item">
                        <div class="best-item-container class5-<?=$lang_settings['html']?>">
                            <a data-popup="<?=$popup_btn?>" target="_blank" rel="nofollow" href="<?=$ref_link?>" class="class5-<?=$lang_settings['html']?> d-flex align-items-center justify-content-between">
                                <img src="<?=get_the_post_thumbnail_url( $post, 'image-md' )?>" alt="casino logo" class="class5-<?=$lang_settings['html']?> best-item-logo imageShadow js-imageShadow" width="72" height="72">
                                <span class="best-item-text class5-<?=$lang_settings['html']?> ">
                                    <?=strip_tags($outBonus[0]['text'])?>
                                </span>
                                <img src="<?=IMG_URL?><?php if($popup_btn) {echo "play_gray.svg";} else{echo "play_red.svg";} ?>" alt="play" class="class5-<?=$lang_settings['html']?> best-item-play" width="40" height="40">
                            </a>
                            <?php if($outBonus[0]['t_c']): ?>
                                <div class="best-item-description">
                                    <?=$outBonus[0]['t_c']?>
                                </div>                                
                            <?php endif; ?>
                        </div>
                    </li>
                <?php endforeach; wp_reset_postdata(); ?>
            </ul>
        </div>
        <?php endif; ?>
    </div>
</section>