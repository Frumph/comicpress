<?php
/*
Template Name: Comic Archive
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
	</div>
	<?php if (comicpress_themeinfo('enable_caps')) { ?><div class="post-foot"></div><?php } ?>
</div>
<?php 
$years = $wpdb->get_col("SELECT DISTINCT YEAR(post_date) FROM $wpdb->posts WHERE post_status = 'publish' ORDER BY post_date DESC");
foreach ( $years as $year ) { 
	if ($year != (0) ) {
?>
<div <?php post_class(); ?>>
	<?php if (comicpress_themeinfo('enable_caps')) { ?><div class="post-head"></div><?php } ?>
	<div class="post-content">
		<div class="post-info">
			<div class="post-text">
				<h3><?php echo $year ?></h3>
			</div>
		</div>
		<table class="month-table">
			<?php $comicArchive = new WP_Query(); $comicArchive->query('showposts=10000&cat='.comicpress_all_comic_categories_string().'&year='.$year);
			while ($comicArchive->have_posts()) : $comicArchive->the_post() ?>
				<tr><td class="archive-date"><?php the_time('M j') ?></td><td class="archive-title"><a href="<?php echo get_permalink($post->ID) ?>" rel="bookmark" title="<?php _e('Permanent Link:','comicpress'); ?> <?php the_title() ?>"><?php the_title() ?></a></td></tr>
			<?php endwhile; ?>
		</table>
		<div class="clear"></div>
	</div>
	<?php if (comicpress_themeinfo('enable_caps')) { ?><div class="post-foot"></div><?php } ?>
</div>
	<?php } 
} ?>

<?php get_footer() ?>