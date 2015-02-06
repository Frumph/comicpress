<?php 
get_header();

$count = 'No';
if (have_posts()) :
	$count = $wp_query->found_posts;
?>
	<h2 class="page-title"><?php _e( 'Search for &lsquo;', 'comicpress' ); the_search_query(); _e( '&rsquo;', 'comicpress' ); ?></h2>
	<div class="searchresults"><?php printf(_n( "%d result.", "%d results.", $count, 'comicpress' ),$count); ?></div>
	<div class="clear"></div>
<?php 
	if (comicpress_themeinfo('display_archive_as_links')) { ?>
	<div <?php post_class(); ?>>
		<div class="post-head"></div>
		<div class="entry">
		<table class="archive-table">
			<?php while (have_posts()) : the_post(); ?>
			<tr><td class="archive-date"><?php the_time('M d, Y') ?></td><td class="archive-title"><a href="<?php echo get_permalink($post->ID) ?>" rel="bookmark" title="<?php _e( 'Permanent Link:', 'comicpress' ); ?> <?php the_title() ?>"><?php the_title() ?></a></td></tr>
			<?php endwhile; ?>
		</table>
		</div>
		<div class="post-foot"></div>
	</div>
	<?php } else {
		while (have_posts()) : the_post();
			$post_format = ($post->post_type !== 'post') ? $post->post_type : get_post_format();
			get_template_part( 'content', $post_format );
		endwhile;
	} ?>
	<div class="clear"></div>
	<?php comicpress_pagination();
	else : ?>
		<div class="post post-search uentry type-page">
			<div class="post-head"></div>
			<div class="post-content">
				<div class="entry">
					<h3><?php _e( 'No results found.', 'comicpress' ); ?></h3>
					<p><?php _e( 'Try another search?', 'comicpress' ); ?></p>
					<p><?php get_search_form(); ?></p>
				</div>
			</div>
			<div class="post-foot"></div>
		</div>
<?php
	endif;
	
get_footer();
?>