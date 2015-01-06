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
