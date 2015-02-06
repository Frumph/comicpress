<?php
/*
Plugin Name: WP-PageNavi
Plugin URI: http://lesterchan.net/portfolio/programming/php/
Description: Adds a more advanced paging navigation to your WordPress blog.
Version: 2.40
Author: Lester 'GaMerZ' Chan
Author URI: http://lesterchan.net
*/


/*
	Copyright 2008  Lester Chan  (email : lesterchan@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/
if (comicpress_themeinfo('enable_numbered_pagination')) {
	
	### Function: Page Navigation: Boxed Style Paging
	function comicpress_wp_pagenavi($before = '', $after = '') {
		global $wpdb, $wp_query;
		$pagenavi_options = comicpress_pagenavi_init();
		if (!is_single()) {
			$request = $wp_query->request;
			$posts_per_page = intval(get_query_var('posts_per_page'));
			$paged = intval(get_query_var('paged'));
			$numposts = $wp_query->found_posts;
			$max_page = $wp_query->max_num_pages;
			/*
			$numposts = 0;
			if(strpos(get_query_var('tag'), " ")) {
			    preg_match('#^(.*)\sLIMIT#siU', $request, $matches);
			    $fromwhere = $matches[1];
			    $results = $wpdb->get_results($fromwhere);
			    $numposts = count($results);
			} else {
				preg_match('#FROM\s*+(.+?)\s+(GROUP BY|ORDER BY)#si', $request, $matches);
				$fromwhere = $matches[1];
				$numposts = $wpdb->get_var("SELECT COUNT(DISTINCT ID) FROM $fromwhere");
			}
			$max_page = ceil($numposts/$posts_per_page);
			*/
			if(empty($paged) || $paged == 0) {
				$paged = 1;
			}
			$pages_to_show = intval($pagenavi_options['num_pages']);
			$pages_to_show_minus_1 = $pages_to_show-1;
			$half_page_start = floor($pages_to_show_minus_1/2);
			$half_page_end = ceil($pages_to_show_minus_1/2);
			$start_page = $paged - $half_page_start;
			if($start_page <= 0) {
				$start_page = 1;
			}
			$end_page = $paged + $half_page_end;
			if(($end_page - $start_page) != $pages_to_show_minus_1) {
				$end_page = $start_page + $pages_to_show_minus_1;
			}
			if($end_page > $max_page) {
				$start_page = $max_page - $pages_to_show_minus_1;
				$end_page = $max_page;
			}
			if($start_page <= 0) {
				$start_page = 1;
			}
			if($max_page > 1 || intval($pagenavi_options['always_show']) == 1) {
				$pages_text = str_replace("%CURRENT_PAGE%", number_format_i18n($paged), $pagenavi_options['pages_text']);
				$pages_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pages_text);
				echo $before.'<div id="paginav"><ul>'."\n";
				switch(intval($pagenavi_options['style'])) {
					case 1:
						if(!empty($pages_text)) {
							echo '<li class="paginav-pages">'.$pages_text.'</li>';
						}
						if ($start_page >= 2 && $pages_to_show < $max_page) {
							$first_page_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pagenavi_options['first_text']);
							echo '<li><a href="'.esc_url(get_pagenum_link()).'" title="'.$first_page_text.'">'.$first_page_text.'</a></li>';
							/* if(!empty($pagenavi_options['dotleft_text'])) {
								echo '<li class="paginav-extend">'.$pagenavi_options['dotleft_text'].'</li>';
							} */
						}
						$prev_post_link = get_previous_posts_link( $pagenavi_options['prev_text'] );
						
						if (!empty($prev_post_link)) {
							echo "<li class=\"paginav-previous\">\r\n";
							echo $prev_post_link . "\r\n";
							echo "</li>\r\n";
						}
						
						
						for($i = $start_page; $i  <= $end_page; $i++) {
							if($i == $paged) {
								$current_page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['current_text']);
								echo '<li class="paginav-current">'.$current_page_text.'</li>';
							} else {
								$page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
								echo '<li><a href="'.esc_url(get_pagenum_link($i)).'" title="'.$page_text.'">'.$page_text.'</a></li>';
							}
						}
						$next_post_link = get_next_posts_link($pagenavi_options['next_text'], $max_page);
						if (!empty($next_post_link)) {
							echo "<li class=\"paginav-next\">\r\n";
							echo $next_post_link ."\r\n";
							echo "</li>\r\n";
						}
						if ($end_page < $max_page) {
/*							if(!empty($pagenavi_options['dotright_text'])) {
								echo '<li class="paginav-extend">'.$pagenavi_options['dotright_text'].'</li>';
							} */
							$last_page_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pagenavi_options['last_text']);
							echo '<li><a href="'.esc_url(get_pagenum_link($max_page)).'" title="'.$last_page_text.'">'.$last_page_text.'</a></li>';
						}
						break;
					case 2;
						echo '<form action="'.htmlspecialchars($_SERVER['PHP_SELF']).'" method="get">'."\n";
						echo '<select size="1" onchange="document.location.href = this.options[this.selectedIndex].value;">'."\n";
						for($i = 1; $i  <= $max_page; $i++) {
							$page_num = $i;
							if($page_num == 1) {
								$page_num = 0;
							}
							if($i == $paged) {
								$current_page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['current_text']);
								echo '<option value="'.esc_url(get_pagenum_link($page_num)).'" selected="selected" class="current">'.$current_page_text."</option>\n";
							} else {
								$page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
								echo '<option value="'.esc_url(get_pagenum_link($page_num)).'">'.$page_text."</option>\n";
							}
						}
						echo "</select>\n";
						echo "</form>\n";
						break;
				}
				echo '</ul></div>';
				echo '<div class="pagejumper-wrap">';
				echo '<form id="pagejumper" action="" method="get">';
				echo '<input type="text" size="2" name="paged" id="paged" />';
				echo '<input type="submit" value="'.__( 'Go', 'comicpress' ).'" />';
				echo '</form>';
				echo '</div>';
				echo $after."\n";
			}
		}
	}
	
	function comicpress_pagenavi_init() {
		// Add Options
		$pagenavi_options = array();
		$pagenavi_options['pages_text'] = __( 'Page %CURRENT_PAGE% of %TOTAL_PAGES%', 'comicpress' );
		$pagenavi_options['current_text'] = '%PAGE_NUMBER%';
		$pagenavi_options['page_text'] = '%PAGE_NUMBER%';
		$pagenavi_options['first_text'] = __( '&laquo; First', 'comicpress' );
		$pagenavi_options['last_text'] = __( 'Last &raquo;', 'comicpress' );
		$pagenavi_options['next_text'] = __( '&raquo;', 'comicpress' );
		$pagenavi_options['prev_text'] = __( '&laquo;', 'comicpress' );
		$pagenavi_options['dotright_text'] = __( '...', 'comicpress' );
		$pagenavi_options['dotleft_text'] = __( '...', 'comicpress' );
		$pagenavi_options['style'] = 1;
		$pagenavi_options['num_pages'] = 5;
		$pagenavi_options['always_show'] = 0;
		return $pagenavi_options;
	}

}
?>