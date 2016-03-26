<?php
/**
 * 
 * Author: Philip M. Hofer (Frumph)
 * Author URI: http://frumph.net/
 * Version: 1.0.8
 * 
 */

add_filter('body_class','comicpress_body_class');

function comicpress_body_class($classes = array()) {
	global  $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone, $post, $wp_query, $comicpress_is_signup;
	
	if (is_user_logged_in()) {
		$current_user = wp_get_current_user();
		$user_login = $current_user->user_login;
		if (!empty($user_login)) $classes[] = 'user-'.strtolower($user_login);
	} else {
		$classes[] = 'user-guest';
	}
	
	if (comicpress_is_signup()) $classes[] = 'signup';

	if($is_lynx) $classes[] = 'lynx';
	elseif($is_gecko) $classes[] = 'gecko';
	elseif($is_opera) $classes[] = 'opera';
	elseif($is_NS4) $classes[] = 'ns4';
	elseif($is_safari) $classes[] = 'safari';
	elseif($is_chrome) $classes[] = 'chrome';
	elseif($is_IE) $classes[] = 'ie';
	else $classes[] = 'unknown';
	if($is_iphone) $classes[] = 'iphone';
	if (wp_is_mobile()) $classes[] = 'is-mobile';


// Hijacked from the hybrid theme, http://themehybrid.com/
	if (is_single()) {
		foreach ( (array)get_the_category( $wp_query->post->ID ) as $cat ) :
			$classes[] = 'single-category-' . sanitize_html_class( $cat->slug, $cat->term_id );
		endforeach;
		$classes[] = 'single-author-' . get_the_author_meta( 'user_nicename', $wp_query->post->post_author );
	}

	if (is_page()) {
		if ( isset($wp_query->query_vars['pagename']) )
			$classes[] = 'page-' . $wp_query->query_vars['pagename'];
	}

	if ( is_single() && is_sticky( $post->ID ) ) {
		$classes[] = 'sticky-post';
	}

// NOT hijacked from anything, doi! people should do this.
	$timestamp = current_time('timestamp');
	$rightnow = (int)date('Gi',$timestamp);
	$ampm = date('a', $timestamp);
	$classes[] = $ampm;
//	$classes[] = 'time-'.$rightnow;
	if ($rightnow > 559 && (int)$rightnow < 1800) $classes[] = 'day';
	if ($rightnow < 600 || (int)$rightnow > 1759) $classes[] = 'night';
	
	if ($rightnow > 2329 || $rightnow < 30) $classes[] = 'midnight';
	if ($rightnow > 459 && $rightnow < 1130) $classes[] = 'morning';
	if ($rightnow > 1129 && $rightnow < 1230) $classes[] = 'noon';
	if ($rightnow > 1759 && $rightnow < 2330) $classes[] = 'evening';
	
	$classes[] = strtolower(date('D', $timestamp));

	if ( is_attachment() ) {
		$classes[] = 'attachment attachment-' . $wp_query->post->ID;
		$mime_type = explode( '/', get_post_mime_type() );
		foreach ( $mime_type as $type ) :
			$classes[] = 'attachment-' . $type;
		endforeach;
	}
	
	if (comicpress_sidebars_disabled()) $classes[] = 'wide';
	
	$layout = get_theme_mod('comicpress-customize-select-layout', '3c');
	if (empty($layout)) $layout = '3c';
	$classes[] = 'layout-'.$layout;

	return $classes;
}

add_filter('post_class','comicpress_post_class');

function comicpress_post_class($classes = '') {
	global $post;
	static $post_alt;

	$args = array(
		'entry_tax' => array( 'category', 'post_tag' )
	);

	/* Microformats. */
	$classes[] = 'uentry';
	
	/* Post alt class. */
	$classes[] = 'postonpage-' . ++$post_alt;
	
	if ( $post_alt % 2 )
		$classes[] = 'odd';
	else
		$classes[] = 'even';
	
	/* Sticky class (only on home/blog page). */
	if( is_sticky() && is_home() )
		$classes[] = 'sticky';
	
	/* Author class. */
	if ( !is_attachment() )
		$classes[] = 'post-author-' . sanitize_html_class( get_the_author_meta( 'user_nicename' ), get_the_author_meta( 'ID' ) );
	
	/* User-created classes. */
	if ( !empty( $class ) ) :
		if ( !is_array( $class ) )
			$class = preg_split( '#\s+#', $class );
		$classes = array_merge( $classes, $class );
	endif;

	/* Password-protected posts. */
	if ( post_password_required() )
		$classes[] = 'protected';

	return $classes;
}

add_filter('comment_class','comicpress_comment_class');

function comicpress_comment_class($classes = '') {
	global $current_user;
	/*
	* http://microid.org
	*/
	
	$email = get_comment_author_email();
	$url = get_comment_author_url();
	if(!empty($email) && !empty($url)) {
		$microid = 'microid-mailto+http:sha1:' . sha1(sha1('mailto:'.$email).sha1($url));
		$classes[] = $microid;
	}
	if ($current_user->user_email == $email) $classes[] = 'ucomment';
	return $classes;
}

?>