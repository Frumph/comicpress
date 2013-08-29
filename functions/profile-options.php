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

function easel_remove_unwanted_contactmethods( $contactmethods ) {
	unset($contactmethods['aim']);
	unset($contactmethods['jabber']);
	unset($contactmethods['yim']);
	return $contactmethods;
}

// add_filter('user_contactmethods','easel_remove_unwanted_contactmethods',10,1);


function add_new_contactmethods($methods){
	$methods['twitter'] = 'Twitter ID';
	$methods['facebook'] = 'Facebook';
	$methods['msn'] = 'MSN';
	return $methods;
}

add_filter('user_contactmethods','add_new_contactmethods');

