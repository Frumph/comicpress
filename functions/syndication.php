<?php
/**
 * Syndication 
 * Author: Philip M. Hofer (Frumph)
 * 
 */

// add_filter( 'pre_get_posts' , 'comicpress_include_custom_post_types_in_rss' );

function comicpress_include_custom_post_types_in_rss( $query ) {
	if ($query->is_feed && !isset($query->post_type) && empty($query->post_type)) {
		$args = array(
				'public' => true,
				'_builtin' => false
				);
		$output = 'names';
		$operator = 'and';
		$post_types = get_post_types( $args , $output , $operator );
		// remove 'pages' from the RSS
		$post_types = array_merge( $post_types, array('post') ) ;
		$query->set( 'post_type' , $post_types );
	}
	return $query;
}

?>