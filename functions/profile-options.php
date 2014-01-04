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
// These array elements are scheduled to be removed from WordPress at some point
	if (isset($contactmethods['aim'])) unset($contactmethods['aim']);
	if (isset($contactmethods['jabber'])) unset($contactmethods['jabber']);
	if (isset($contactmethods['yim'])) unset($contactmethods['yim']);
// --^
	return $contactmethods;
}

add_filter('user_contactmethods','comicpress_remove_unwanted_contactmethods',10,1);

function add_new_contactmethods($methods){
// Social Media & Contact Sites
	$methods['twitter'] = 'Twitter (url)';
	$methods['facebook'] = 'Facebook (url)';
	$methods['googleplus'] = 'Google+ (url)';
/*
// The following I have a question about adding to the profile author pages (of importance to include)

// Direct Contact URL Sites (not necessarily a good idea to include)
	$methods['skype'] = 'Skype (url)';

// Sites that you could be on but not exactly the same reference for an author page
	$methods['myspace'] = 'MySpace (url)';
	$methods['linkedin'] = 'LinkedIn (url)';
	$methods['pinterest'] = 'Pinterest (url)';
	$methods['stumbleupon'] = 'Stumbleupon (url)';
	$methods['tumblr'] = 'Tumblr (url)';
	$methods['instagram'] = 'Instagram (url)';
	$methods['youtube'] = 'Youtube Profile or Channel (url)';
	$methods['vine'] = 'Vine (url)';
	$methods['deviantart'] = 'DeviantArt (url)';
	$methods['inkoutbreak'] = 'InkOutBreak (url)';
	$methods['comicrocket'] = 'ComicRocket (url)';
	$methods['kickstarter'] = 'Kickstarter (url)';
*/
	return $methods;
}

add_filter('user_contactmethods','add_new_contactmethods');

