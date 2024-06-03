<?php $pageSettings = $args['pageSettings']; ?>

<section class="container characteristicsOfTheCasino">
    <div class="characteristics-open">
        <p class="js-characteristicsOpen btn-red-line btn-js"><?=$GLOBALS['translations_page']['more_info']?></p>
    </div>
    <div class="row js-characteristicsContent">
        <div class="col-12">
            <div class="d-flex flex-wrap characteristics-content">
                <ul class="col-lg-6 characteristics-list d-flex align-items-start flex-wrap">          
                    <?php foreach($pageSettings['characteristics_of_the_casino'] as $key => $value): ?>
                        <?php if($value): ?>
                            <li>
                                <p class="text"><?=$GLOBALS['translations_page'][$key]?></p>
                                <span class="grayBgBlock" <?php if($key == "website") echo 'style="word-break: break-all;"'; ?>><?=$value?></span>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
                <div class="col-lg-6 characteristics-lg-currencies">
                    <?php if(!empty($pageSettings['languages'])): ?>
                        <p class="text"><?=$GLOBALS['translations_page']['languages']?></p>
                        <ul class="characteristics-lg d-flex flex-wrap">
                            <?php foreach($pageSettings['languages'] as $language): ?>
                                <li><img src="<?=IMG_URL?>flags/<?=strtolower($language)?>.png" alt="<?=$language?> flag"></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                    <?php if($pageSettings['currencies']): ?>
                        <div class="text"><?=$GLOBALS['translations_page']['currencies']?></div>
                        <ul class="characteristics-currencies grayBgBlock-list">
                            <?php foreach(explode(',',$pageSettings['currencies']) as $currency): ?>
                                <li class="grayBgBlock grayBgBlock-square"><?=trim($currency)?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div> 
            </div>
        </div>       
    </div>    
</section>