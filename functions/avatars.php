<?php

if (!function_exists('comicpress_random_default_avatar')) {
	function comicpress_random_default_avatar($id_or_email = '') {
		$current_avatar_directory = comicpress_themeinfo('avatar_directory');
		
		if (!empty($current_avatar_directory) && ($current_avatar_directory !== 'none')) {
			if (is_dir(get_stylesheet_directory() . '/images/avatars/' . $current_avatar_directory)) {
				$count = count($results = glob(get_stylesheet_directory() . '/images/avatars/'.$current_avatar_directory.'/*'));
				$blogurl = get_stylesheet_directory_uri();
			} else {
				$count = count($results = glob(get_template_directory() . '/images/avatars/'.$current_avatar_directory.'/*'));
				$blogurl = get_template_directory_uri();
			}		
			if ($count) { 
				$default = '';
				
				$checknum = hexdec(substr(md5($id_or_email),0,5)) % $count;
				if ($count > 0) {
					$default = basename($results[(int)$checknum]); 
				} else {
					return false;
				}
				return $blogurl.'/images/avatars/'.$current_avatar_directory.'/'.$default;
			}
		}
		return get_option('avatar_default');
	}
}
