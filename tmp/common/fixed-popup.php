<?php
	$fixedBonus = get_option('fixed_bonus');
	$fixedBonus_remove_t_c = array();
	
	if($fixedBonus){
		global $fixedBonus_remove_t_c;
		$fixedBonus_remove_t_c = array_filter($fixedBonus, function($fixedBonus) {
			return $fixedBonus != 't_c';
		}, ARRAY_FILTER_USE_KEY);
	}
	
	if(!empty($fixedBonus) && !in_array('',$fixedBonus_remove_t_c)):
?>
	<div class="fixed-popup-showBtn js-fixedPopupShowBtn d-inline-flex align-items-center justify-content-center btn btn-js">
		<img src="<?=IMG_URL?>footer/bell-icon-white.svg" class="fixed-popup-img" width="23" height="23" alt="bell icon">
	</div>
	<div class="fixed-popup js-fixedPopup d-flex">
		<a href="<?=stripcslashes($fixedBonus['link_btn'])?>" target="_blank" rel="nofollow" class="d-flex fixed-popup-mainLink bonus-click-<?=$lang_settings['html']?>">
			<span class="fixed-popup-content js-fixedPopupContent">
				<span class="fixed-popup-title"><?=stripcslashes($fixedBonus['title'])?> <img src="<?=IMG_URL?>footer/bell-icon.svg" class="fixed-popup-img" width="23" height="23" alt="bell icon"> </span>
				<span class="fixed-popup-text-mobile"><?=stripcslashes($fixedBonus['text_mobile'])?></span>	
				<span class="fixed-popup-text"><?=stripcslashes($fixedBonus['text'])?></span>			
			</span>
			<span class="fixed-popup-btn justify-content-center btn btn-js d-flex align-items-center">
				<?=stripcslashes($fixedBonus['text_btn'])?> <img src="<?=IMG_URL?>footer/bell-icon-white.svg" class="fixed-popup-img" width="32" height="32" alt="bell icon">
			</span>	
		</a>
		<?php if(!empty($fixedBonus['t_c'])): ?>
			<div class="text-center js-fixedPopupTCBtn fixed-popup-t_c-btn">
				T&C applies
				<div class="fixed-popup-t_c js-fixedPopupTC"><?=stripcslashes($fixedBonus['t_c'])?></div>
			</div>
		<?php endif; ?>
		<span class="fixed-popup-close js-fixedPopupClose bonus-close-<?=$lang_settings['html']?>"></span>
	</div>
<?php endif; ?>