<?php

if (!function_exists('comicpress_copyright')) {
	function comicpress_copyright() {
		global $wpdb;
		$copyright_dates = $wpdb->get_results("
					SELECT
					YEAR(min(post_date_gmt)) AS firstdate,
					YEAR(max(post_date_gmt)) AS lastdate
					FROM
					$wpdb->posts
					WHERE
					post_status = 'publish'
					");
		$output = '';
		if($copyright_dates) {
			$copyright = "&copy; " . $copyright_dates[0]->firstdate;
			if($copyright_dates[0]->firstdate != $copyright_dates[0]->lastdate) {
				$copyright .= '-' . $copyright_dates[0]->lastdate;
			}
			$output =  $copyright;
		}
		return $output;
	}
}

?>