<?php
get_header();

// set to empty
$order = $post_count = $theCatID = $is_comic = '';
if (is_category()) {
	$theCatID = get_term_by( 'slug', $wp_query->query_vars['category_name'], 'category' );
	if (!empty($theCatID))
		$theCatID = $theCatID->term_id;
	if (isset($wp_query->query_vars['cat'])) $theCatID = (int)$wp_query->query_vars['cat'];
}

if (!empty($theCatID) && comicpress_in_comic_category($theCatID)) $is_comic = true;

$count = "No";

if (have_posts()) :
	$count = $wp_query->found_posts;
	$post = $posts[0]; // Hack. Set $post so that the_date() works
	$post_title_type = $title_string = '';
	if ($post->post_type !== 'post') $post_title_type = $post->post_type.'-'; // extra space at the end for visual
	if (is_category()) { /* Category */
		$title_string = __('Archive for &#8216;','comicpress').$post_title_type.single_cat_title('',false).__('&#8217;', 'comicpress');
	} elseif(is_tag()) { /* Tag */
		$title_string = __('Posts Tagged &#8216;','comicpress').$post_title_type.single_tag_title('',false).__('&#8217;', 'comicpress');
	} elseif (is_day()) {
		$title_string = __('Archive for &#8216;','comicpress').$post_title_type.get_the_time('F jS, Y').__('&#8217;', 'comicpress');
	} elseif (is_month()) {
		$title_string = __('Archive for &#8216;','comicpress').$post_title_type.get_the_time('F, Y').__('&#8217;', 'comicpress');
	} elseif (is_year()) {
		$title_string = __('Archive for &#8216;','comicpress').$post_title_type.get_the_time('Y').__('&#8217;', 'comicpress');
	} elseif (is_author()) {
		$title_string = __('Author Archive &#8216;','comicpress').$post_title_type.get_the_time('Y').__('&#8217;', 'comicpress');
	} elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {
		$title_string = __('Archives','comicpress');
	} elseif (taxonomy_exists($wp_query->query_vars['taxonomy'])) {
		if (term_exists($wp_query->query_vars['term'])) {
			$title_string = __('Archive for &#8216;','comicpress').$post_title_type.$wp_query->query_vars['term'].__('&#8217;', 'comicpress');
		} else {
			$title_string = __('Archive for &#8216;','comicpress').$post_title_type.$wp_query->query_vars['taxonomy'].__('&#8217;', 'comicpress');
		}
	} elseif ($post->post_type !== 'post') {
		$title_string = __('Archive for &#8216;','comicpress').$post->post_type.__('&#8217;', 'comicpress');
	} else {
		$title_string = __('Archive is unable to be found.','comicpress');
	}
?>
	<h2 class="page-title"><?php echo $title_string; ?></h2>
	<div class="archiveresults"><?php printf(_n("%d result.", "%d results.", $count,'comicpress'),$count); ?></div>
	<div class="clear"></div>
	<?php 
	if (comicpress_themeinfo('display_archive_as_text_links') && !($is_comic && comicpress_themeinfo('archive_display_comic_thumbs_in_order'))) { ?>
	<div <?php post_class(); ?>>
		<?php if (comicpress_themeinfo('enable_caps')) { ?><div class="post-head"></div><?php } ?>
		<div class="entry">
		<table class="archive-table">
			<?php while (have_posts()) : the_post(); ?>
			<tr><td class="archive-date"><?php the_time('M d, Y') ?></td><td class="archive-title"><a href="<?php echo get_permalink($post->ID) ?>" rel="bookmark" title="<?php _e('Permanent Link:','comicpress'); ?> <?php the_title() ?>"><?php the_title() ?></a></td></tr>
			<?php endwhile; ?>
		</table>
		</div>
		<?php if (comicpress_themeinfo('enable_caps')) { ?><div class="post-foot"></div><?php } ?>
	</div>
	<?php } elseif (comicpress_themeinfo('archive_display_comic_thumbs_in_order') && ($is_comic)) { ?>
		<div <?php post_class(); ?>>
			<?php if (comicpress_themeinfo('enable_caps')) { ?><div class="post-head"></div><?php } ?>
			<div class="post-content">	
				<?php while (have_posts()) : the_post(); ?>
				<div class="comicthumbwrap">
					<?php global $mini_comic_width; ?>
					<div class="comicthumbdate"><?php echo get_the_time('M jS, Y'); ?></div>
					<div class="comicarchiveframe" style="width: <?php echo $mini_comic_width; ?>px;">
						<a href="<?php the_permalink() ?>" title="<?php echo the_title(); ?>"><?php echo comicpress_display_comic_thumbnail('mini', $post, true); ?></a><br />
					</div>
				</div>
				<?php endwhile; ?>
				<div class="clear"></div>
			</div>
			<?php if (comicpress_themeinfo('enable_caps')) { ?><div class="post-foot"></div><?php } ?>
		</div>	
		<?php } else {
		while (have_posts()) : the_post();
			comicpress_display_post();
		endwhile;
	}
	?>
	<div class="clear"></div>
	<?php comicpress_pagination(); ?>
	
<?php endif; ?>

<?php get_footer(); ?>