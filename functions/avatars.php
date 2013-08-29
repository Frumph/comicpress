<?php

function easel_random_default_avatar($id_or_email = '') {
	$current_avatar_directory = easel_themeinfo('avatar_directory');
	
	if (!empty($current_avatar_directory) && ($current_avatar_directory !== 'none')) {
		if (is_dir(easel_themeinfo('stylepath') . '/images/avatars/' . $current_avatar_directory)) {
			$count = count($results = glob(easel_themeinfo('stylepath') . '/images/avatars/'.$current_avatar_directory.'/*'));
			$blogurl = easel_themeinfo('styleurl');
		} else {
			$count = count($results = glob(easel_themeinfo('themepath') . '/images/avatars/'.$current_avatar_directory.'/*'));
			$blogurl = easel_themeinfo('themeurl');
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
		} else
			return get_option('avatar_default');
	} else {
		return get_option('avatar_default');
	}
	return false;
}

?>