	<?php
		$lang_settings = get_option('lang');
		if($lang_settings === false) $lang_settings = array('html' => 'en', 'hreflang' => 'en', 'hreflang_title' => '' );
		if($GLOBALS['cur_template_file'] != 'casinos.php'){
			if(isset(get_option('autors_site')['link']) && $_SERVER['REQUEST_URI'] != get_option('autors_site')['link']) echo do_shortcode( '[autors]' );
		}
        
		get_template_part( 'tmp/common/footer', null );
		
	?>
	
	<!--<div class="up-btn"></div>-->
	<?php get_template_part( 'popup-casinos', '', '#casino_block' ); ?>

<?php 
global $wp_query;
echo '
	<script defer async type="text/javascript">
		window.ajaxurl = "'.admin_url('admin-ajax.php').'";
		window.curLang = "'.$GLOBALS['currentLang'].'";
		window.curBlog = "'.get_blog_details()->blog_id.'";';
if(!empty($post))echo 'window.curId = "'.$wp_query->post->ID.'";	';	
echo '</script>';

wp_footer(); 
echo stripcslashes(get_option('footer'));

?>

</body>
</html> 