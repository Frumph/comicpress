<?php

if (!function_exists('comicpress_copyright_text')) {
	function comicpress_copyright_text() {
		$output = "<p class=\"copyright-info\">\r\n";
		$output .= comicpress_copyright_info();
		$output .= "<span class=\"footer-pipe\">|</span> ";
		$output .= __( 'Powered by', 'comicpress' ) . " <a href=\"http://wordpress.org/\">WordPress</a> " . __( 'with', 'comicpress' ). " <a href=\"http://frumph.net\">ComicPress</a>\r\n";
		$output .= comicpress_hosted_on();
		$output .= "<span class=\"footer-subscribe\">";
			$output .= "<span class=\"footer-pipe\">|</span> ";
			$output .= "Subscribe: <a href=\"" . get_bloginfo('rss2_url') ."\">RSS</a>\r\n";
		$output .= "</span>\r\n";
		if (!comicpress_themeinfo('disable_scroll_to_top')) { 
			$output .= "<span class=\"footer-uptotop\">";
				$output .= "<span class=\"footer-pipe\">|</span> ";
				$output .= "<a href=\"\" onclick=\"scrollup(); return false;\">".__( 'Back to Top &uarr;', 'comicpress' )."</a>";
			$output .="</span>\r\n";
		}
		$output .= "</p>\r\n";
		echo apply_filters('comicpress_copyright_text', $output);
	}
}

if (!function_exists('comicpress_hosted_on')) {
	function comicpress_hosted_on() {
		if (is_multisite()) {
			$current_site = get_current_site();
			if (!isset($current_site->site_name)) {
				$site_name = ucfirst( $current_site->domain );
			} else {
				$site_name = $current_site->site_name;
			}
			$output = "<span class=\"copyright-pipe\">|</span> ";
			$output .= __( 'Hosted on', 'comicpress' ) . ' <a href="http://'. $current_site->domain. $current_site->path. '">'. $site_name. '</a> ';
			return apply_filters('comicpress_hosted_on', $output);
		}
	}
}

if (!function_exists('comicpress_copyright_info')) {
	function comicpress_copyright_info() {
		$copyright_name = comicpress_themeinfo('copyright_name');
		if (empty($copyright_name)) $copyright_name = get_bloginfo('name');
		$copyright_url = comicpress_themeinfo('copyright_url');
		if (empty($copyright_url)) $copyright_url = home_url();
		$copyright = __( '&copy;', 'comicpress' ). comicpress_copyright_dates() . ' ' . apply_filters('comicpress_copyright_info_name', '<a href="'.$copyright_url.'">' . $copyright_name . '</a>') . ' ';
		return apply_filters('comicpress_copyright_info', $copyright);
	}
}

if (!function_exists('comicpress_copyright_dates')) {
	function comicpress_copyright_dates() {
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
		if ($copyright_dates) {
			$copyright = $copyright_dates[0]->firstdate;
			if($copyright_dates[0]->firstdate != $copyright_dates[0]->lastdate) {
				$copyright .= '-' . $copyright_dates[0]->lastdate;
			}
			$output =  $copyright;
		}
		return apply_filters('comicpress_copyright_dates', $output);
	}
}

?>