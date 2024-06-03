<?php if(isset($args['pageSettings'])) $pageSettings = $args['pageSettings']; ?>
<section class="container gameInfo">
    <div class="row">
        <h2 class="col-12"><p class="title-line"><?=$GLOBALS['translations_page']['game_info']?></p></h2>
    </div>
    <ul class="row gameInfo-list">    
    <?php 
        if(isset($pageSettings['specifications']) && !empty($pageSettings['specifications'])):
        foreach($pageSettings['specifications'] as $key => $value): 
        if(!empty($value)):
    ?>
        <li class="col-lg-2 col-md-4 col-6 d-flex">
            <div class="gameInfo-list-item d-flex align-items-center flex-column">
                <img src="<?=IMG_URL?>games/<?=$key?>.svg" class="gameInfo-list-item-logo" alt="icon">
                <p class="gameInfo-list-item-title"><?=$value?></p>
                <p class="text text-center"><?=$GLOBALS['translations_page'][$key]?></p>
            </div>
        </li>
    <?php 
        endif;
        endforeach; 
        endif;
    ?>
    </ul>
    <ul class="row gameInfo-list">
        <?php 
            foreach($pageSettings['parameters'] as $key => $value): 
            if(!empty($value)):
        ?>                        
            <li class="col-lg-2 col-md-4 col-6 d-flex">
                <div class="gameInfo-list-item d-flex align-items-center flex-column">
                    <img src="<?=IMG_URL?><?=$value[0]['value']?>.svg" class="gameInfo-list-item-logo" alt="icon">
                    <p class="gameInfo-list-item-title"><?=$GLOBALS['translations_page'][$value[0]['value']]?></p>
                    <p class="text text-center"><?=$GLOBALS['translations_page'][$key]?></p>
                </div>
            </li>
            <?php 
                endif;
                endforeach; 
            ?>            
    </ul>
</section>