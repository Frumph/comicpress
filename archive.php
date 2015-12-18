<?php
get_header();

do_action('comic-blog-area');

// set to empty
$count = $theCatID = '';
if (is_category()) {
	$theCatID = get_term_by( 'slug', $wp_query->query_vars['category_name'], 'category' );
	if (!empty($theCatID))
		$theCatID = $theCatID->term_id;
	if (isset($wp_query->query_vars['cat'])) $theCatID = (int)$wp_query->query_vars['cat'];	
}

$count = $wp_query->found_posts;
if (empty($count)) $count = 'No';

$title_string = '';

if ($count > 0) {
	if (is_category()) { /* Category */
		$title_string = __( 'Archive for', 'comicpress' ).' '.single_cat_title('',false);
	} elseif(is_tag()) { /* Tag */
		$title_string = __( 'Posts Tagged', 'comicpress' ).' '.single_tag_title('',false);
	} elseif (is_day()) {
		$title_string = __( 'Archive for', 'comicpress' ).' '.get_the_time('F jS, Y').' ';
	} elseif (is_month()) {
		$title_string = __( 'Archive for', 'comicpress' ).' '.get_the_time('F, Y');
	} elseif (is_year()) {
		$title_string = __( 'Archive for', 'comicpress' ).' '.get_the_time('Y');
	} elseif (is_author()) {
		$title_string = __( 'Author Archive', 'comicpress' ).' '.get_the_time('Y');
	} elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {
		$title_string = __( 'Archives', 'comicpress' );
	} elseif (isset($wp_query->query_vars['taxonomy']) && taxonomy_exists($wp_query->query_vars['taxonomy'])) {
		$taxonomy_name = '';
		if (isset($wp_query->query_vars['chapters'])) {
			$taxonomy_name = get_term_by('slug', $wp_query->query_vars['chapters'], 'chapters');
			if (!is_wp_error($taxonomy_name) && !empty($taxonomy_name)) $title_string = $taxonomy_name->name;
		} elseif (isset($wp_query->query_vars['locations'])) {
			$taxonomy_name = get_term_by('slug', $wp_query->query_vars['locations'], 'locations');
			if (!is_wp_error($taxonomy_name) && !empty($taxonomy_name)) $title_string = $taxonomy_name->name;
		} elseif (term_exists($wp_query->query_vars['term'])) {
			$title_string = __( 'Archive for', 'comicpress' ).' '.$wp_query->query_vars['term'];
		} else {
			$title_string = __( 'Archive for', 'comicpress' ).' '.$wp_query->query_vars['taxonomy'];
		}
	} elseif ($wp_query->query_vars['post_type'] !== 'post') {
		$title_string = __( 'Archive for', 'comicpress' ).' '.$wp_query->query_vars['post_type'];
	} else {
		$title_string = __( 'Archive is unable to be found.', 'comicpress' );
	}
} else $title_string = __( 'No Archive Found.', 'comicpress' );
if (have_posts()) { ?>
	<h2 class="page-title"><?php echo $title_string; ?></h2>
	<?php if (isset($wp_query->query_vars['chapters']) || ($wp_query->query_vars['post_type'] == 'comic')) { ?>
		<div class="archiveresults"><?php printf(_n( "%d comic.", "%d comics.", $count, 'comicpress' ),$count); ?></div>
	<?php } else {  ?>
		<div class="archiveresults"><?php printf(_n( "%d result.", "%d results.", $count, 'comicpress' ),$count); ?></div>
	<?php } ?>
	<div class="clear"></div>
	<?php if (function_exists('ceo_pluginfo') && (isset($wp_query->query_vars['chapters']) || isset($wp_query->query_vars['characters']) || isset($wp_query->query_vars['locations']) || ($wp_query->query_vars['post_type'] == 'comic')) && (comicpress_themeinfo('display_archive_as_links') && !comicpress_is_bbpress())) { ?>
		<?php while (have_posts()) : the_post(); ?>
			<div class="archivecomicthumbwrap">
				<div class="archivecomicthumbdate"><?php echo get_the_time('M jS, Y'); ?></div>
				<div class="archivecomicframe">
			<?php 
			$thumbnail = ceo_display_comic_thumbnail('thumbnail', $post);
			$thumbnail = (!$thumbnail) ? __( 'No Thumbnail or Featured Image Found', 'comicpress' ) : $thumbnail; ?>
					<a href="<?php the_permalink() ?>" title="<?php echo the_title(); ?>"><?php echo $thumbnail; ?></a><br />
				</div>
			</div>
		<?php endwhile; ?>
	<?php } elseif (comicpress_themeinfo('display_archive_as_links') || comicpress_is_bbpress()) { ?>
	<div <?php post_class(); ?>>
		<div class="post-head"></div>
		<div class="entry">
		<table class="archive-table">
			<?php while (have_posts()) : the_post(); ?>
			<tr>
				<td class="archive-date">
					<span class="archive-date-month-day"><?php the_time('M d, ') ?></span>
					<span class="archive-date-year"><?php the_time('Y'); ?></span>
				</td>
				<td class="archive-title">
					<a href="<?php echo get_permalink($post->ID) ?>" rel="bookmark" title="<?php _e( 'Permanent Link:', 'comicpress' ); ?> <?php the_title() ?>"><?php the_title() ?></a>
				</td>
			</tr>
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
	}
	?>
	<div class="clear"></div>
	<?php comicpress_pagination(); ?>
	
<?php } else { ?>
	<h2 class="page-title"><?php echo $title_string; ?></h2>
	<div class="archiveresults"><?php printf(_n( "%d result.", "%d results.", $count, 'comicpress' ),$count); ?></div>
	<div class="clear"></div>
<?php } ?>

<?php get_footer(); ?>