<?php
/*
Template Name: Year Archive
*/
get_header(); 

if (isset($_GET['archive_year'])) { 
	$archive_year = (int)$_GET['archive_year']; 
}
if (empty($archive_year)) $archive_year = date('Y');
?>
<div <?php post_class(); ?>>
	<div class="post-head"></div>
	<div class="post-content">
		<div class="post-info">
			<div class="post-text">
				<h2><?php the_title(); ?> - <?php echo $archive_year; ?></h2>
			</div>
		</div>
		<div class="archive-yearlist">| 
			<?php $years = $wpdb->get_col("SELECT DISTINCT YEAR(post_date) FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post' ORDER BY post_date ASC");
				foreach ( $years as $year ) {
				if ($year != (0) ) { ?>	
				<a href="<?php echo add_query_arg('archive_year', $year) ?>"><strong><?php echo $year ?></strong></a> |
			<?php } } ?>
		</div>
		<div class="clear"></div>
		<table class="month-table">
		<?php
			$args = array(
				'showposts' => 99999,
				'year' => (int)$archive_year,
				'post_type' => array('post')
			);
			Protect();
			$posts = &query_posts($args);
			while (have_posts()) : the_post() ?>
				<tr class="archive-tr"><td class="archive-date"><?php the_time('M j') ?></td><td class="archive-title"><a href="<?php echo get_permalink($post->ID) ?>" rel="bookmark" title="<?php _e('Permanent Link:','easel'); ?> <?php the_title() ?>"><?php the_title() ?></a></td></tr>
			<?php endwhile;
			 UnProtect(); ?>
		</table>
		<div class="clear"></div>
		<?php edit_post_link(__('Edit this page.','easel'), '', ''); ?>
	</div>
	<div class="post-foot"></div>
</div>

<?php get_footer(); ?>