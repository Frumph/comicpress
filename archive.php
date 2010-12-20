<?php
get_header();

// Set them as empty for right now
$order = $post_count = $theCatID = '';

if (is_category()) {
	$theCatID = get_term_by( 'slug', $wp_query->query_vars['category_name'], 'category' );
	if (!empty($theCatID))
		$theCatID = $theCatID->term_id;
}

$category_thumbnail_postcount = comicpress_themeinfo('category_thumbnail_postcount');


if (is_category() && (!empty($theCatID) && comicpress_in_comic_category($theCatID))) $is_comic = true;

if ($is_comic && comicpress_themeinfo('display_comic_archive_as_text_links')) $category_thumbnail_postcount = '-1';

$archive_display_order = comicpress_themeinfo('archive_display_order');

$order = '&order='.$archive_display_order;

if ($is_comic) $post_count = '&showposts='.$category_thumbnail_postcount.'&posts_per_page='.$category_thumbnail_postcount;

// Get the total count no matter what type of archive
$tmp_search = new WP_Query($query_string.'&showposts=-1&posts_per_page=-1');
$count = $tmp_search->post_count;
if (!$count) $count = "no";

$args = $query_string . $post_count . $order;

$posts = &query_posts($args);
	
if (have_posts()) :
?>
	<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
	<?php /* Category Archive */ if (is_category()) { ?>
		<h2 class="pagetitle"><?php _e('Archive for &#8216;','comicpress'); ?><?php single_cat_title() ?>&#8217;</h2>
	<?php /* Tag Archive */ } elseif( is_tag() ) { ?>
		<h2 class="pagetitle"><?php _e('Posts Tagged &#8216;','comicpress'); ?><?php single_tag_title() ?>&#8217;</h2>
	<?php /* Daily Archive */ } elseif (is_day()) { ?>
		<h2 class="pagetitle"><?php _e('Archive for','comicpress'); ?> <?php the_time('F jS, Y') ?></h2>
	<?php /* Monthly Archive */ } elseif (is_month()) { ?>
		<h2 class="pagetitle"><?php _e('Archive for','comicpress'); ?> <?php the_time('F, Y') ?></h2>
	<?php /* Yearly Archive */ } elseif (is_year()) { ?>
		<h2 class="pagetitle"><?php _e('Archive for','comicpress'); ?> <?php the_time('Y') ?></h2>
	<?php /* Author Archive */ } elseif (is_author()) { ?>
		<h2 class="pagetitle"><?php _e('Author Archive','comicpress'); ?></h2>
	<?php /* Paged Archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
		<h2 class="pagetitle"><?php _e('Archives','comicpress'); ?></h2>
	<?php /* taxonomy */ } elseif (taxonomy_exists($wp_query->query_vars['taxonomy'])) {
		if (term_exists($wp_query->query_vars['term'])) { ?>
			<h2 class="pagetitle"><?php _e('Archive for','comicpress'); ?> <?php echo $wp_query->query_vars['taxonomy']; ?> - <?php echo $wp_query->query_vars['term']; ?></h2>
		<?php } else { ?>
			<h2 class="pagetitle"><?php _e('Archive for','comicpress'); ?> <?php echo $wp_query->query_vars['taxonomy']; ?></h2>
		<?php } ?>
	<?php /* Post Type */ } elseif ($post->post_type !== 'post') { ?>
		<h2 class="pagetitle"><?php echo $post->post_type; ?></h2>
	<?php } ?>
	<div class="searchresults"><?php printf(_n("%d item.", "%d items.", $count,'comicpress'),$count); ?></div>
	<div class="clear"></div>

	<?php if (comicpress_themeinfo('archive_display_comic_thumbs_in_order') && !comicpress_themeinfo('display_comic_archive_as_text_links')) { ?>
		<?php if ($is_comic) { ?>

		<div <?php post_class(); ?>>
			<div class="post-head"></div>
			<div class="post-content">	
		<?php } ?>
		
		<?php while (have_posts()) : the_post();
			
			if ($is_comic) { ?>
				<div class="comicthumbwrap">
					<?php global $mini_comic_width; ?>
					<div class="comicthumbdate"><?php echo get_the_time('M jS, Y'); ?></div>
					<div class="comicarchiveframe" style="width: <?php echo $mini_comic_width; ?>px;">
						<a href="<?php the_permalink() ?>" title="<?php echo the_title(); ?>"><?php echo comicpress_display_comic_thumbnail('mini', $post, true); ?></a><br />
					</div>
				</div>
			<?php } else { 
				comicpress_display_post();
			}
		
			endwhile;
		
			if ($is_comic) { ?>
				<div class="clear"></div>
			</div>
			<div class="post-foot"></div>
		</div>	
	
		<?php } 
		} else { 
			if ($is_comic) { ?>
			<table class="month-table">
		<?php }
		while (have_posts()) : the_post();
			if ($is_comic) { ?>
				<tr><td class="archive-date"><?php the_time('M j') ?></td><td class="archive-title"><a href="<?php echo get_permalink($post->ID) ?>" rel="bookmark" title="<?php _e('Permanent Link:','comicpress'); ?> <?php the_title() ?>"><?php the_title() ?></a></td></tr>				
			<?php } else {
				comicpress_display_post(); 
			}
		endwhile;
		if ($is_comic) { ?>
			</table>
	<?php } 
	}?>
	<div class="clear"></div>
	<?php comicpress_pagination(); ?>
	
	<?php else : ?>
		<div <?php post_class(); ?>>
			<div class="post-head"></div>
			<div class="post">
				<h3><?php _e('No entries found.','comicpress'); ?></h3>
				<p><?php _e('Try another search?','comicpress'); ?></p>
				<p><?php the_widget('WP_Widget_Search'); ?></p>
			</div>
			<div class="post-foot"></div>
		</div>
	<?php endif; ?>

<?php get_footer() ?>