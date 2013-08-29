<?php

/**
 * Protect global $post and $wp_query.
 * @param object $use_this_post If provided, after saving the current post, set up this post for template tag use.
 */
function Protect($use_this_post = null) {
	global $post, $wp_query, $__post, $__wp_query;
	if (!empty($post)) {
		$__post = $post;
	}
	if (!empty($wp_query)) {
		$__wp_query = $wp_query;
	}
	if (!is_null($use_this_post)) {
		$post = $use_this_post;
		setup_postdata($post);
	}
}

/**
 * Temporarily restore the global $post variable and set it up for use.
 */
function Restore() {
	global $post, $__post;
	$post = $__post;
	setup_postdata($post);
}

/**
 * Restore global $post and $wp_query.
 */
function Unprotect() {
	global $post, $wp_query, $__post, $__wp_query;
	if (!empty($__post)) {
		$post = $__post;
	}
	if (!empty($__wp_query)) {
		$wp_query = $__wp_query;
	}

	$__post = $__wp_query = null;
}

?>