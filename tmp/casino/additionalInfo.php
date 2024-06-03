<?php $pageSettings = $args['pageSettings']; ?>

<section class="container additionalInfo">
    <div class="row">
        <?php if(!empty($pageSettings['games_types']) && !empty($pageSettings['games_types'][0]['link'])): ?>
            <div class="col-lg-4">
                <div class="smallCards additionalInfo-games">
                    <h3><?=$GLOBALS['translations_page']['games']?></h3>
                    <ul>
                        <?php foreach($pageSettings['games_types'] as $game): 
                            if(isset($game['link']) && $game['link'] == "yes" && isset($game['inner_link']) && !empty($game['inner_link'])):
                                $inner_link_info = get_tech_link($game['inner_link']);
                        ?>
                            <a class="text d-flex align-items-center justify-content-between" href="<?=$inner_link_info['link']?>">
                                <span><?=$inner_link_info['title']?></span>
                                <span class="smallCards-img d-flex align-items-center justify-content-center">
                                    <img alt="<?=$inner_link_info['title']?> icon" src="<?=$inner_link_info['img']?>" width="24" height="21"  class="<?=$inner_link_info['class']?>">                                    
                                </span>
                            </a>
                        <?php
                            elseif (isset($GLOBALS['translations_page'][$game['list']])):
                        ?>
                            <li class="smallCards-title text d-flex align-items-center justify-content-between">
                                <span><?=$GLOBALS['translations_page'][$game['list']]?></span>
                                <span class="smallCards-img d-flex align-items-center justify-content-center">
                                    <img src="<?=IMG_URL?>yes.svg" width="24" height="21" alt="<?=$GLOBALS['translations_page'][$game['list']]?> icon">
                                </span>
                            </li>
                        <?php 
                            endif; 
                            endforeach; 
                        ?>
                    </ul>
                </div>
            </div> 
        <?php endif; ?>

        <?php if(!empty($pageSettings['providers'])): ?>        
        <div class="col-lg-4">
            <div class="smallCards">
                <h3><?=$GLOBALS['translations_page']['providers']?></h3>
                <ul>
                    <?php 
                        foreach($pageSettings['providers'] as $provider): 
                            if(isset($provider['link']) && $provider['link'] == "yes" && isset($provider['inner_link']) && !empty($provider['inner_link'])):
                                $inner_link_info = get_tech_link($provider['inner_link']);
                    ?>
                        <li class="smallCards-title text d-flex align-items-center justify-content-between">
                            <a class="d-flex align-items-center justify-content-between" href="<?=$inner_link_info['link']?>">
                                <span><?=$inner_link_info['title']?></span>
                                <span class="smallCards-img d-flex align-items-center justify-content-center">
                                    <img src="<?=$inner_link_info['img']?>" width="46" height="28" alt="<?=stripcslashes($inner_link_info['title'])?> icon" class="smallCards-logo <?=$inner_link_info['class']?>">                                    
                                </span>
                            </a>                           
                        </li>
                    <?php else: ?>
                        <li class="smallCards-title text d-flex align-items-center justify-content-between">
                            <span><?=$provider['name']?></span>
                            <span class="smallCards-img d-flex align-items-center justify-content-center">
                                <img src="<?=wp_get_attachment_image_src($provider['logo'], 'image-tiny')[0];?>" width="46" height="28" class="smallCards-logo" alt="<?=$provider['name']?> icon">
                            </span>
                        </li>
                    <?php 
                        endif;
                        endforeach; 
                    ?>
                </ul>
            </div>
        </div> 
        <?php endif; ?>

        <?php if(!empty($pageSettings['payment_methods'])): ?>
        <div class="col-lg-4">
            <div class="smallCards">
                <h3><?=$GLOBALS['translations_page']['payment_methods']?></h3>
                <ul>
                    <?php 
                        foreach($pageSettings['payment_methods'] as $payment_method):
                                                        
                            if(isset($payment_method['link']) && $payment_method['link'] == "yes" && isset($payment_method['inner_link']) && !empty($payment_method['inner_link'])):
                            $inner_link_info = get_tech_link($payment_method['inner_link']);
                    ?>
                        <li class="smallCards-title text d-flex align-items-center justify-content-between">
                            <a class="d-flex align-items-center justify-content-between" href="<?=$inner_link_info['link']?>">
                                <span><?=$inner_link_info['title']?></span>
                                <span class="smallCards-img d-flex align-items-center justify-content-center">
                                    <img src="<?=$inner_link_info['img']?>" width="46" height="28" alt="<?=$inner_link_info['title']?> icon" class="smallCards-logo <?=$inner_link_info['class']?>">                                    
                                </span>
                            </a>                           
                        </li>
                    <?php else: ?>
                        <li class="smallCards-title smallCards-logos text d-flex align-items-center justify-content-between">
                            <span><?=$payment_method['title']?></span>
                            <span class="smallCards-img d-flex align-items-center justify-content-center">
                                <?php if(!empty($payment_method['image'])):
                                    $image = isset(wp_get_attachment_image_src($payment_method['image'], 'image-tiny')[0]) && wp_get_attachment_image_src($payment_method['image'], 'image-tiny')[0] ? wp_get_attachment_image_src($payment_method['image'], 'image-tiny')[0] : IMG_URL . "no-image-svgrepo-com.svg";
                                ?>
                                    <img src="<?=$image?>" width="46" height="28" class="smallCards-logo" alt="<?=$payment_method['title']?> icon">
                                <?php else: ?>
                                    <img src="<?=IMG_URL?>casino/pay/<?=$payment_method['title']?>.png" class="smallCards-logo" width="46" height="28" alt="<?=$payment_method['title']?> icon">
                                <?php endif; ?>
                            </span>
                        </li>
                    <?php 
                        endif;
                        endforeach; ?>
                </ul>
            </div>
        </div>  
        <?php endif; ?>
    </div>
</section>