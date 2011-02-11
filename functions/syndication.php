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
		$output = '<p>';
		$output .= '<a href="'.get_permalink().'" title="'.comicpress_the_hovertext($post).'">'.comicpress_display_comic_thumbnail('rss',$post,true).'</a>';
		$output .= '</p>';
		return apply_filters('comicpress_comic_feed', $output);
	}
}

// removed the comicpress_in_comic_category so that if it has a post-image it will add it to the rss feed (else rss comic thumb)
if (!function_exists('comicpress_insert_comic_feed')) {
	function comicpress_insert_comic_feed($content) {
		global $wp_query, $post;
		$category = get_the_category($post->ID);
		if (is_feed() && comicpress_in_comic_category($category[0]->cat_ID)) {
			echo comicpress_comic_feed();
		}
		return apply_filters('comicpress_insert_comic_feed', $content);
	}
}

add_filter('the_content','comicpress_insert_comic_feed');
add_filter('the_excerpt','comicpress_insert_comic_feed');

// Using the_content and the_excerpt instead of the_content_rss cause it doesn't work properly otherwise
/*
add_filter('comicpress_comic_feed', 'comicpress_test_feed');

function comicpress_test_feed($output) {
	$output .= '<table width="500" style="border: none;" cellpadding="0" cellpadding="0">';
	$output .= '<tr>';
	$output .= '<td style="border: none;"><img src="http://www.zfcomics.com/graphics/footer/top.jpg" alt="" style="width: 500px; height:72px; border: none;" /></td>';
	$output .= '</tr>';
	$output .= '<tr>';
	$output .= '<td><img src="http://www.zfcomics.com/graphics/footer/1.jpg" alt="" style="height:39px; width:25px; border: none;" /><a href="http://www.zfcomics.com"><img src="http://www.zfcomics.com/graphics/footer/read.jpg" alt="" height="39" width="113" padding="0" border="0" /></a><a href="http://www.zfcomics.com/store"><img src="http://www.zfcomics.com/graphics/footer/store.jpg" alt="" width="57" height="39" padding="0" border="0" /></a><a href="http://www.facebook.com/dgriff13"><img src="http://www.zfcomics.com/graphics/footer/fb.jpg" alt="" width="85" height="39" padding="0" border="0" /></a><a href="http://www.twitter.com/dgriff13"><img src="http://www.zfcomics.com/graphics/footer/twitter.jpg" alt="" width="67" height="39"padding="0" border="0" /></a><img src="http://www.zfcomics.com/graphics/footer/2.jpg" alt="" width="61" height="39" padding="0" border="0" /><a href="http://www.facebook.com/dgriff13"><img src="http://www.zfcomics.com/graphics/footer/FBicon.jpg" alt="" width="36" height="39" padding="0" border="0" /></a><a href="http://www.twitter.com/dgriff13"><img src="http://www.zfcomics.com/graphics/footer/twittericon.jpg" alt="" width="37" height="39" padding="0" border="0" /></a><img src="http://www.zfcomics.com/graphics/footer/3.jpg" alt="" style="width: 18px; height:39px; border: none;" /></td>';
	$output .= '</tr>';
	$output .= '<tr>';
	$output .= '<td><img src="http://www.zfcomics.com/graphics/footer/4.jpg" alt="" width="280" height="156" padding="0" border="0" /><a href="http://www.zfcomics.com/store"><img src="http://www.zfcomics.com/graphics/footer/book.jpg" alt="" width="220" height="156" padding="0" border="0" /></a></td>';
	$output .= '</tr>';
	$output .= '</table>';
	return $output;
}
*/

?>
