<?php
/*
Template Name: Search
*/
?>

<?php get_header(); ?>	
		<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>	
		<?php endwhile; ?>	
		<?php else : ?>
		<div class="row">
			<div class="col-xl-12">
				<h2 class="title-block text-left">OOOOPS! NO RESULTS!</h2>

				<p class="text">
					Sorry, we have no results for your request. 
				</p>

				<p class="text">
					Please try again!
				</p>
			</div>
		</div>
		<?php endif; ?>
</section>	

<?php get_footer(); ?>