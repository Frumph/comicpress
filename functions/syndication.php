<?php

function comicpress_add_count_to_title_rss($title = '') {
	global $post;
	if (!empty($post)) {
		$count = get_comments_number();
		$count == 0 ? $title = $title.' '.__('(No Comments)','comicpress') : $title = $title.' '.sprintf(_n('(%s Comment)','(%s Comments)', $count, 'comicpress'),$count);
	}
	return apply_filters('comicpress_add_count_to_title_rss', $title);
}

/**
 * Handle making changes to ComicPress before the export process starts.
 */
function comicpress_remove_count_export_wp() {
	remove_filter('the_title_rss', 'comicpress_add_count_to_title_rss');
}

if (comicpress_themeinfo('enable_comment_count_in_rss')) {
	add_filter('the_title_rss', 'comicpress_add_count_to_title_rss');
	// Remove the title count from being in the export.
	add_action('export_wp', 'comicpress_remove_count_export_wp');
}

//Insert the comic image into the RSS feed
if (!function_exists('comicpress_comic_feed')) {
	function comicpress_comic_feed($content = '') { 
		global $wp_query, $post, $comiccat;
		if ($wp_query->query_vars['cat'] == $comiccat ) {
			$content .= '<p><a href="'.get_permalink().'" title="'.comicpress_the_hovertext($post).'">'.comicpress_display_comic_thumbnail('comic',$post,true).'</a></p>';
		} else {
			$content .= '<p><a href="'.get_permalink().'" title="'.comicpress_the_hovertext($post).'">'.comicpress_display_comic_thumbnail('rss',$post,true).'</a></p>';
		}
		return apply_filters('comicpress_comic_feed', $content);
	}
}

// removed the comicpress_in_comic_category so that if it has a post-image it will add it to the rss feed (else rss comic thumb)
if (!function_exists('comicpress_insert_comic_feed')) {
	function comicpress_insert_comic_feed($content = '') {
		global $post;
		$category = get_the_category($post->ID);
		if (comicpress_in_comic_category($category[0]->cat_ID)) {
			$content = comicpress_comic_feed().$content;
		}
		return apply_filters('comicpress_insert_comic_feed', $content);
	}
}

add_filter('the_content_feed','comicpress_insert_comic_feed');
add_filter('the_excerpt_rss','comicpress_insert_comic_feed');
