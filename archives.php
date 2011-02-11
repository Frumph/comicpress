<?php
/*
Template Name: Archives
*/
get_header(); 
?>

<div <?php post_class(); ?>>
	<?php if (comicpress_themeinfo('enable_caps')) { ?><div class="post-head"></div><?php } ?>
	<div class="post-content">
		<div class="post-info">
			<div class="post-text">
				<h2 class="page-title"><?php the_title(); ?></h2>
			</div>
		</div>
		<div id="archivepage">
			<h2><?php _e('Archives by Month:','comicpress'); ?></h2>
			<ul><?php wp_get_archives('type=monthly') ?></ul>
		</div>
		<div class="clear"></div>
	</div>
	<?php if (comicpress_themeinfo('enable_caps')) { ?><div class="post-foot"></div><?php } ?>
</div>

<div <?php post_class(); ?>>
	<?php if (comicpress_themeinfo('enable_caps')) { ?><div class="post-head"></div><?php } ?>
	<div class="post-content">
		<div id="archivepage">
			<h2><?php _e('Archives by Subject:','comicpress'); ?></h2>
			<ul><?php wp_list_categories() ?></ul>
		</div>
		<div class="clear"></div>
	</div>
	<?php if (comicpress_themeinfo('enable_caps')) { ?><div class="post-foot"></div><?php } ?>
</div>

<?php get_footer() ?>