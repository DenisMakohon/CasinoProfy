
<form role="search" method="get" action="<?php echo home_url( '/' ); ?>">
	<div class="search-input">
		<input 
			maxlength="255"
			type="search" 
			class="search-field" 
			placeholder="<?php echo esc_attr_x( $translations_page['search'], 'placeholder' ) ?>" 
			value="<?php echo get_search_query() ?>" 
			name="s" title="<?php echo esc_attr_x( 'Search for:', 'label' ) ?>" 
		/>
		<div class="search-submit">		
			<input type="submit" class="js-ajax-search" value="<?php echo esc_attr_x( 'Search', 'submit button' ) ?>" />
		</div>
	</div>
</form>