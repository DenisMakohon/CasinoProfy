<?php $pageSettings = $args['pageSettings']; ?>

<section class="container secondInfo">
    <div class="row">
        <div class="col-xl-9 secondInfo-container">
            <div class="row">
                <?php if(!empty($pageSettings['platforms']) && !empty($pageSettings['platforms'][0]['link'])): ?>
                    <div class="col-lg-4">
                        <div class="smallCards platforms">
                            <p class="smallCards-title text d-flex justify-content-between">
                                <span><?=$GLOBALS['translations_page']['platforms']?></span>
                                <img src="<?=IMG_URL?>casino/platfoms_icon.svg" alt="platfoms icon">
                            </p>
                            <div class="grayBgBlock-list">
                                <?php 
                                    foreach($pageSettings['platforms'] as $platform): 
                                    if(isset($platform['link']) && $platform['link'] == "yes" && isset($platform['inner_link']) && !empty($platform['inner_link'])):
                                        $inner_link_info = get_tech_link($platform['inner_link']);
                                ?>
                                    <a class="grayBgBlock-square smallCards-link-icon d-inline-flex align-items-center justify-content-center" 
                                        href="<?=get_permalink($platform['inner_link'])?>"
                                    >
                                        <img src="<?=IMG_URL?>casino/platforms/<?=$platform['list']?>.svg" alt="<?=$platform['list']?> icon">
                                        <img src="<?=IMG_URL?>casino/platforms/<?=$platform['list']?>-hover.svg" alt="<?=$platform['list']?> icon" class="hover">
                                    </a>
                                <?php else: ?>
                                    <span class="grayBgBlock-square d-inline-flex align-items-center justify-content-center">
                                        <img src="<?=IMG_URL?>casino/platforms/<?=$platform['list']?>.svg" alt="<?=$platform['list']?> icon">
                                    </span>
                                <?php 
                                    endif;
                                    endforeach;
                                ?>
                            </div>                        
                        </div>                    
                    </div>
                <?php endif; ?>

                <?php $local_currency = $GLOBALS['currency'];

                    if(isset($pageSettings['currency']) && !empty($pageSettings['currency'])) $local_currency = $pageSettings['currency'];
                    
                    if(isset($pageSettings['min_deposit']['text']) && $pageSettings['min_deposit'] ): ?>
                    <div class="col-lg-4">
                        <div class="smallCards">
                            <p class="smallCards-title text d-flex justify-content-between">
                                <span><?=$GLOBALS['translations_page']['min_deposit']?></span>
                                <img src="<?=IMG_URL?>casino/deposit_icon.svg" width="20" height="20" alt="deposit icon icon">
                            </p>
                            <?php 
                                if(trim($pageSettings['min_deposit']['text']) == '' ||
                                trim($pageSettings['min_deposit']['text']) == '-' ){
                                    $pageSettings['min_deposit']['text'] = '-';
                                } else {
                                    $pageSettings['min_deposit']['text'] = $local_currency.$pageSettings['min_deposit']['text'];
                                }
                                if(isset($pageSettings['min_deposit']['link']) && 
                                    $pageSettings['min_deposit']['link'] == "yes" && 
                                    isset($pageSettings['min_deposit']['inner_link']) && 
                                    !empty($pageSettings['min_deposit']['inner_link'])): 
                            ?>
                                <a class="grayBgBlock smallCards-link-icon" href="<?=get_permalink($pageSettings['min_deposit']['inner_link'])?>">
                                    <?=$pageSettings['min_deposit']['text']?>
                                </a>
                            <?php else: ?>
                                <span class="grayBgBlock">
                                    <?=$pageSettings['min_deposit']['text']?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

                    <div class="col-lg-4">
                        <div class="smallCards">
                            <p class="smallCards-title text d-flex justify-content-between">
                                <span><?=$GLOBALS['translations_page']['max_deposit']?></span>
                                <img src="<?=IMG_URL?>casino/deposit_icon.svg" width="20" height="20" alt="deposit icon icon">
                            </p>
                            <span class="grayBgBlock">
                                <?php if(trim($pageSettings['max_deposit']) == ''){
                                    $pageSettings['max_deposit'] = '-';
                                } else {
                                    $pageSettings['max_deposit'] = $local_currency.$pageSettings['max_deposit'];
                                } ?>
                                <?=$pageSettings['max_deposit']?>
                            </span>
                        </div>
                    </div>
            </div>            
        </div>  
        <?php if($pageSettings['best_game']): ?>
            <div class="col-xl-3 col-lg-6 offset-lg-3 offset-xl-0">
                <div class="smallCards">
                    <p class="smallCards-title text d-flex justify-content-between">
                        <span><?=$GLOBALS['translations_page']['best_game']?></span>
                        <img src="<?=IMG_URL?>casino/deposit_icon.svg" width="20" height="20" alt="deposit icon icon">
                    </p>
                    <div class="smallCards-btn-line d-flex justify-content-between flex-wrap">
                        <span class="grayBgBlock">
                            <?=$pageSettings['best_game']?>
                        </span>
                        <?php if($pageSettings['ref_link']): ?>
                            <a href="<?=$pageSettings['ref_link']?>" rel="nofollow" class="btn-red-line btn-js <?=$extra_class?>"><?=$GLOBALS['translations_page']['play_btn']?></a>
                        <?php endif; ?>
                    </div>                
                </div>
            </div>   
        <?php endif; ?>
    </div>
</section>