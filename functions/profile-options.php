<?php
/**
 * Profile Options
 * by Philip M. Hofer (Frumph)
 * http://frumph.net/
 * 
 * Displays more profile options available to end users
 * 
 * 
 */

function comicpress_remove_unwanted_contactmethods( $contactmethods ) {
	if (isset($contactmethods['aim'])) unset($contactmethods['aim']);
	if (isset($contactmethods['jabber'])) unset($contactmethods['jabber']);
	if (isset($contactmethods['yim'])) unset($contactmethods['yim']);
	return $contactmethods;
}

add_filter('user_contactmethods','comicpress_remove_unwanted_contactmethods',10,1);

function add_new_contactmethods($methods){
	$methods['twitter'] = 'Twitter (url)';
	$methods['facebook'] = 'Facebook (url)';
//	$methods['msn'] = 'MSN';
	$methods['skype'] = 'Skype (url)';
	$methods['googleplus'] = 'Google+ (url)';
	$methods['linkedin'] = 'LinkedIn (url)';
	$methods['pinterest'] = 'Pinterest (url)';
	$methods['stumbleupon'] = 'Stumbleupon (url)';
	$methods['tumblr'] = 'Tumblr (url)';
	$methods['instagram'] = 'Instagram (url)';
	return $methods;
}

add_filter('user_contactmethods','add_new_contactmethods');

