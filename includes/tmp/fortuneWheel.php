<div class="wheel-fixed js-spinWheel" data-ref="<?=$args['banner_link']?>">
    <div class="wheel-close js-wheelClose"></div>
    <div class="wheel-border-gold wheel-border-gold-big"></div>
    <div class="wheel-container">
        <div class="wheel-mark">
            <img src="<?=IMG_URL?>picker.png" alt="wheel mark" width="30" height="36">
        </div>
        <div class="wheel-border-gold wheel-border-gold-small"></div>
        <div class="wheel-center">
            <p class="text"><?=$args['bonus']?></p>
        </div>        
    </div>
</div>
<div class="wheel-fixed wheel-bonus-container js-spinWheelBanner hide">
    <div class="wheel-bonus">
        <p class="wheel-bonus-title text-center"><?=$args['up_text']?></p>
        <a class="wheel-bonus-banner d-flex flex-column justify-content-center align-items-center" href="<?=$args['banner_link']?>">
            <span class="wheel-bonus-banner-title"><?=$args['title_banner']?></span>
            <span class="wheel-bonus-banner-cost"><?=$args['bonus_text']?></span>
            <span class="wheel-bonus-banner-subtext"><?=$args['bottom_banner_text']?></span>        
        </a>
        <a href="<?=$args['banner_link']?>" class="btn"><?=$args['btn_text']?></a>
        <?php if(
            (isset($args['under_btn_text']) && !empty($args['under_btn_text'])) &&
            (isset($args['under_btn_link']) && !empty($args['under_btn_link']))
            ): ?>
        <p class="text-center"><a href="/" class="wheel-bonus-read">Read More</a></p>
        <div class="glowing-element"></div>
        <?php endif; ?>
    </div>
</div>
<div class="wheel-overlay js-spinWheelOverlay">
</div>
