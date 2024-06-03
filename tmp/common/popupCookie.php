<?php 
$popup_cookie = get_option('popup_cookie_section');

if($popup_cookie):
$link = 'no-link';
if(isset($popup_cookie['link']) && !empty($popup_cookie['link']) && isset($popup_cookie['link_text']) && !empty($popup_cookie['link_text']) ) $link = '';
?>
    <div class="popupCookie <?=$link?> js-popupCookie">
        <div class="popupCookie-text"><img src="<?=IMG_URL?>cookie-icon.svg" class="popupCookie-icon" alt="cookie icon" width="32" height="32"><?=stripcslashes($popup_cookie['text'])?></div>
        <div class="popupCookie-bottom align-items-center d-flex flex-column justify-content-between">
            <?php if(!$link): ?>
                <a href="<?=stripcslashes($popup_cookie['link'])?>" class="align-self-start d-block" target="_blank"><?=stripcslashes($popup_cookie['link_text'])?></a>
            <?php endif; ?>
            <span class="align-self-end btn btn-js js-popupCookieBtn"><?=stripcslashes($popup_cookie['btn'])?></span>
        </div>
    </div>
<?php endif; ?>