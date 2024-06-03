<?php 


    while (have_posts()){
		the_post();

	get_header();
	$pageSettings = get_fields();
    
	$breadcrumb = !empty($pageSettings['breadcrumb']) ? $pageSettings['breadcrumb'] : get_the_title();
	
?>

<section class="container">
	<div class="row">
		<ul class="col-12 breadcrumbs text d-flex flex-wrap" itemscope itemtype="https://schema.org/BreadcrumbList">
			<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
				<a href="<?=$GLOBALS['translations_page']['main_page']?>" title="Main page" itemprop="item" itemid="<?=$GLOBALS['translations_page']['main_page']?>">
					<span itemprop="name">CasinoProfy</span>
					<meta itemprop="position" content="0">
				</a>
			</li>
			<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
				<a itemscope itemtype="https://schema.org/WebPage" itemprop="item" itemid="<?=$GLOBALS['translations_page']['main_page']?>blog/" href="<?=$GLOBALS['translations_page']['main_page']?>blog/">
					<span itemprop="name"><?=$translations_page['blog']?></span>
				</a>
				<meta itemprop="position" content="1" />
			</li>
			<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
				<span itemprop="name"><?=$breadcrumb?></span>
				<meta itemprop="position" content="2" />
			</li>
		</ul>
		<h1 class="col-12 text-center"><?php the_title(); ?></h1>
		<div class="col-12">
			<div class="mainContent">
				<div class="post-img" style="background-image: url(<?=get_the_post_thumbnail_url(get_the_ID(),'full')?>);"></div>
				<?php the_content(); ?>
				<div class="post-bottom flex-md-row flex-column">
					<div class="post-nav d-flex align-items-center">
						<?=previous_post_link('%link', $translations_page['prev_blog_post'])?>
						<div class="post-nav-separator"></div>	
						<?=next_post_link('%link', $translations_page['next_blog_post'])?>
					</div>
				</div>			
			</div>
		</div>		
	</div>
</section>

<?php 
    if(isset($pageSettings['additional_field'])) echo do_shortcode('[topFourCasinos id="'.$pageSettings['additional_field'].'"]');    

	}
	get_footer(); 
?>