<?php

function comicpress_add_facebook_meta() { 
	global $post;
	echo '<meta property="og:url" content="'.get_permalink().'" />'."\r\n";
	echo '<meta property="og:site_name" content="'.get_bloginfo('name').'" />'."\r\n";
	echo '<meta property="og:type" content="article" />'."\r\n";
	if (is_single()) {
		$comic_url = get_comic_url('mini', $post);
		if (is_array($comic_url)) $comic_url = reset($comic_url);
		echo '<meta property="og:title" content="'.get_the_title().'" />'."\r\n";
		echo '<meta property="og:description" content="'.get_the_excerpt().'" />'."\r\n";
		if (comicpress_in_comic_category()) {
			echo '<meta property="og:image" content="'.$comic_url.'" />'."\r\n";
		}
	} elseif (is_home()) { 
		echo '<meta property="og:description" content="'.get_bloginfo('description').'" />'."\r\n";
	}
}

add_action('wp_head', 'comicpress_add_facebook_meta');

if (!function_exists('comicpress_display_facebook_like')) {
	function comicpress_display_facebook_like($content) {
		global $post, $wp_query;
		if (!is_page()) {
			if ((comicpress_in_comic_category() && comicpress_themeinfo('facebook_like_comic_post')) || (!comicpress_in_comic_category() && comicpress_themeinfo('facebook_like_blog_post'))) {
				$content .= '<span class="facebook-like"><fb:like layout="box_count" show_faces="false" width="255" href="'.get_permalink().'"></fb:like></span>';
			}
		}
		return $content;
	}
}

add_action('the_content', 'comicpress_display_facebook_like');

?>