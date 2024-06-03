<?php $pageSettings = $args['pageSettings']; ?>

<?php if(!empty($pageSettings['bonus_block'])): ?>
    <section class="container bonusSlider">
        <div class="js-bonusSliderControl bonusSlider-control d-flex align-items-md-end align-items-center justify-content-center flex-md-row flex-column">
            <?php foreach($pageSettings['bonus_block'] as $bonus): ?>
                <div class="control-title 
                    <?php if(reset($pageSettings['bonus_block']) == $bonus) echo "active"; ?>">
                    <?=$GLOBALS['translations_page'][$bonus['bonus_type']['value']]?>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="js-bonusSlider">
            <?php 

                $block_casino_info = block_casino($pageSettings);
                $ref_link = $block_casino_info['ref_link'];
                $casino_block = $block_casino_info['casino_block'];
                
                foreach($pageSettings['bonus_block'] as $bonus): 
                    
                $ref_link = $block_casino_info['ref_link'];
                $casino_block = $block_casino_info['casino_block'];

                if(isset($bonus['bonus_ref']) && $bonus['bonus_ref']) $ref_link = $bonus['bonus_ref'];
            ?>
                <div class="bonusSlider-item d-flex align-items-start flex-wrap">
                    <div class="bonusSlider-text">
                        <?=$bonus['text']?>
                    </div>
                        <a 
                        href="<?=$ref_link?>" 
                        <?php if($ref_link != $casino_block) echo 'target="_blank"'; ?> 
                        <?php if ($casino_block) echo 'data-popup="get_popup"'; ?> 
                        rel="nofollow" 
                        class="btn-white js-btn align-self-center <?=$extra_class?>">
                            <?=$GLOBALS['translations_page']['get_bonus_red']?>
                        </a>
                    <?php if($bonus['t_c']): ?>
                        <div class="bonusSlider-item-description">
                            <?=$bonus['t_c']?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
<?php endif; ?>