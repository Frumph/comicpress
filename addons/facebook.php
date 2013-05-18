<?php

add_action('wp_head', 'comicpress_add_facebook_meta');
add_action('the_content', 'comicpress_display_facebook_like');
add_action('wp_head', 'comicpress_add_facebook_meta_thumbnail');

// loop the main query
function comicpress_add_facebook_meta_thumbnail() {
	global $post, $wp_query;
	$output = '';
	if (comicpress_in_comic_category()) {
		$comic_url = get_comic_url('mini', $post);
		if (is_array($comic_url)) $comic_url = reset($comic_url);
		if (!empty($comic_url)) echo '<meta property="og:image" content="'.$comic_url.'" />'."\r\n";
	}
	if ( has_post_thumbnail() ) {
		$post_image_id = get_post_thumbnail_id($post->ID);
		$thumbnail = wp_get_attachment_image_src( $post_image_id );
		if (is_array($thumbnail)) $thumbnail = reset($thumbnail);
		echo '<meta property="og:image" content="'.$thumbnail.'" />'."\r\n";				
	}
}

function comicpress_add_facebook_meta() { 
	global $post;
	if (!is_front_page() && !is_home()) {
		echo '<meta property="og:url" content="'.get_permalink().'" />'."\r\n";
	} else {
		echo '<meta property="og:url" content="'.home_url().'" />'."\r\n";
	}
	echo '<meta property="og:site_name" content="'.get_bloginfo('name').'" />'."\r\n";
	echo '<meta property="og:type" content="article" />'."\r\n";
	if (is_single()) {
		echo '<meta property="og:title" content="'.get_the_title().'" />'."\r\n";
	}
	if (!is_front_page()) {
		$quick_excerpt = esc_attr(get_the_excerpt());
		//         $quick_excerpt = str_replace("\r\n", "  ", $quick_excerpt);
		echo '<meta property="og:description" content="'.$quick_excerpt.'" />'."\r\n";
	} else {
		echo '<meta property="og:description" content="'.get_bloginfo('description').'" />'."\r\n";         
	}
}

function comicpress_display_facebook_like($content) {
	global $post, $wp_query;
	if (!is_page()) {
		if ((comicpress_in_comic_category() && comicpress_themeinfo('facebook_like_comic_post')) || (!comicpress_in_comic_category() && comicpress_themeinfo('facebook_like_blog_post'))) {
			$content .= '<div class="facebook-like"><fb:like layout="standard" show_faces="true" href="'.get_permalink().'"></fb:like></div>';
		}
	}
	return $content;
}
