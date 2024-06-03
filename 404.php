<?php 
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package WordPress
 * @subpackage diceus
 * @since 1.0
 * @version 1.0
 */

get_header(); 
?>

<section class="page404">
	<div class="container">
		<div class="title-404 text-center">
			<img src="<?=IMG_URL?>404/404.svg" alt="Maskot error decore image">
		</div>
		<h1 class="text-center"><?=$GLOBALS['translations_page']['page_not_found']?></h1>
		<div class="text-center">
			<a href="<?=$GLOBALS['translations_page']['main_page']?>" class="btn btn-js"><?=$GLOBALS['translations_page']['go_to_homepage']?></a>
		</div>
	</div>
</section>

<?php get_footer(); ?>