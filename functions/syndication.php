<?php
/**
 * Syndication - Feed Count Capturing & adding comic to feed.
 * Author: Philip M. Hofer (Frumph)
 * In Testing
 */

function comicpress_the_title_rss($title = '') {
	switch ($count = get_comments_number()) {
		case 0:
			$title_pattern = __('%s (No Comments)', 'comicpress');
			break;
		case 1:
			$title_pattern = __('%s (1 Comment)', 'comicpress');
			break;
		default:
			$title_pattern = sprintf(__('%%s (%d Comments)', 'comicpress'), $count);
			break;
	}
	
	return sprintf($title_pattern, $title);
}

/**
 * Handle making changes to ComicPress before the export process starts.
 */
function comicpress_export_wp() {
	remove_filter('the_title_rss', 'comicpress_the_title_rss');
}

if (comicpress_themeinfo('enable_comment_count_in_rss')) {
	add_filter('the_title_rss', 'comicpress_the_title_rss');
	// Remove the title count from being in the export.
	add_action('export_wp', 'comicpress_export_wp');
}

//Insert the comic image into the RSS feed
if (!function_exists('comicpress_comic_feed')) {
	function comicpress_comic_feed() { 
		global $post; 
	?>
		<p><a href="<?php the_permalink(); ?>"><?php echo comicpress_display_comic_thumbnail('rss',$post); ?></a></p>
	<?php
/*		$this_permalink = get_permalink();
		$latest_comic = get_permalink( comicpress_get_terminal_post_in_category(comicpress_all_comic_categories_string(), false) );
		$first = comicpress_get_first_comic_permalink(); 
		$last = comicpress_get_last_comic_permalink();
		$prev = comicpress_get_previous_comic_permalink(false);
		$next = comicpress_get_next_comic_permalink(false);

		if (!empty($first) && ($first != $this_permalink)) { ?>
			<a href="<?php echo $first; ?>">First</a>
		<?php }
		if (!empty($prev)) { ?>
			<a href="<?php echo $prev; ?>">Previous</a>
		<?php }
		if (!empty($next)) { ?>
			<a href="<?php echo $next; ?>">Next</a>
		<?php }
		if (!empty($last) && ($last != $this_permalink)) { ?>
			<a href="<?php echo $last; ?>">Latest</a>
		<?php } */
	}
}

// removed the comicpress_in_comic_category so that if it has a post-image it will add it to the rss feed (else rss comic thumb)
if (!function_exists('comicpress_insert_comic_feed')) {
	function comicpress_insert_comic_feed($content) {
		global $wp_query, $post;
		if (is_feed() && comicpress_in_comic_category()) {
			return comicpress_comic_feed() . $content;
		} else {
			return $content;
		}
	}
}

add_filter('the_content','comicpress_insert_comic_feed');
add_filter('the_excerpt','comicpress_insert_comic_feed');

// Using the_content and the_excerpt instead of the_content_rss cause it doesn't work properly otherwise

?>
