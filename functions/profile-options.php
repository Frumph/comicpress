<?php
/**
 * User Profile Options
 * by Philip M. Hofer (Frumph)
 * http://frumph.net/
 * 
 * Displays more profile options available to end users.
 */

/**
 * Removed outdated contact methods.
 * 
 * This contact elements are scheduled to be removed from WordPress at some point.
 */
function comicpress_remove_unwanted_contactmethods( $contactmethods ) {
	if (isset($contactmethods['aim'])) unset($contactmethods['aim']);
	if (isset($contactmethods['jabber'])) unset($contactmethods['jabber']);
	if (isset($contactmethods['yim'])) unset($contactmethods['yim']);
	return $contactmethods;
}

add_filter('user_contactmethods','comicpress_remove_unwanted_contactmethods',10,1);

/**
 * Add contact methods to the user profil page.
 * 
 * The contact methods are displayed in the frontend in the author page.
 * Additional contact methods are commented out.
 * Sites that you could be on but not exactly the same reference for an author page.
 * When activated, this must be integrated into author.php in table 'user-contacts'.
 */
function add_new_contactmethods($methods){
	// default contact methods
	$methods['twitter'] = 'Twitter (url)';
	$methods['facebook'] = 'Facebook (url)';
	$methods['googleplus'] = 'Google+ (url)';
	// additional contact methods
	//$methods['myspace'] = 'MySpace (url)';
	//$methods['linkedin'] = 'LinkedIn (url)';
    //$methods['pinterest'] = 'Pinterest (url)';
	//$methods['stumbleupon'] = 'Stumbleupon (url)';
	//$methods['tumblr'] = 'Tumblr (url)';
	//$methods['instagram'] = 'Instagram (url)';
	//$methods['youtube'] = 'Youtube Profile or Channel (url)';
	//$methods['vine'] = 'Vine (url)';
	//$methods['deviantart'] = 'DeviantArt (url)';
	//$methods['inkoutbreak'] = 'InkOutBreak (url)';
	//$methods['comicrocket'] = 'ComicRocket (url)';
	//$methods['kickstarter'] = 'Kickstarter (url)';
	return $methods;
}

add_filter('user_contactmethods','add_new_contactmethods');
