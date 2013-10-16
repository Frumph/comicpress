<?php

add_action('wp_head', 'opengraph_make_thumbnail_for_youtube');

function opengraph_make_thumbnail_for_youtube() {
	global $post;
	if ($post) {
		$pattern = '/(?:youtube\.com\/(?:[^\/]+\/[^\/]+\/|(?:v|e(?:mbed)?)\/|[^#]*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i';
		preg_match($pattern, $post->post_content, $matches);
		$found_id = (isset($matches[1])) ? $matches[1] : false;
		if ($found_id) echo '<meta property="og:image" content="http://img.youtube.com/vi/'.$found_id.'/1.jpg" />'."\r\n";
	}
}

add_action('wp_head', 'comicpress_facebook_thumbnail');

function comicpress_facebook_thumbnail() {
	global $post;
	if (!empty($post) && $post->post_type == 'post') {
		$post_image_id = get_post_thumbnail_id($post->ID);
		$thumbnail = wp_get_attachment_image_src( $post_image_id, 'thumbnail', false);
		if (is_array($thumbnail)) { 
			foreach ($thumbnail as $thumb) {
				echo '<meta property="og:image" content="'.$thumb.'" />'."\r\n";
			}
		}	
	}
}

if (!function_exists('comicpress_add_facebook_meta')) {
	function comicpress_add_facebook_meta() {
		global $post;
		if (is_404() || empty($post)) return;
		if (!is_front_page() && !is_home()) {
			echo '<meta property="og:url" content="'.get_permalink().'" />'."\r\n";
		} else {
			echo '<meta property="og:url" content="'.home_url().'" />'."\r\n";
		}
		echo '<meta property="og:site_name" content="'.strip_tags(get_bloginfo('name')).'" />'."\r\n";
		echo '<meta property="og:type" content="article" />'."\r\n";
		if (is_single()) {
			echo '<meta property="og:title" content="'.strip_tags(get_the_title()).'" />'."\r\n";
		}
		if (!is_front_page()) {
			$quick_excerpt = esc_attr(get_the_excerpt());
			//         $quick_excerpt = str_replace("\r\n", "  ", $quick_excerpt);
			echo '<meta property="og:description" content="'.strip_tags($quick_excerpt).'" />'."\r\n";
		} else {
			echo '<meta property="og:description" content="'.strip_tags(get_bloginfo('description')).'" />'."\r\n";         
		}
	}
}

// if (comicpress_themeinfo('facebook_meta')) add_action('wp_head', 'comicpress_add_facebook_meta');

if (!function_exists('comicpress_display_facebook_like')) {
	function comicpress_display_facebook_like($content) {
		global $post, $wp_query;
		if (!is_page() && (get_post_format() !== 'aside')) {
			$content .= '<div class="facebook-like"><fb:like layout="standard" show_faces="true" href="'.get_permalink().'"></fb:like></div>';
		}
		return $content;
	}
}

// if (comicpress_themeinfo('facebook_like_blog_post')) add_action('the_content', 'comicpress_display_facebook_like');

