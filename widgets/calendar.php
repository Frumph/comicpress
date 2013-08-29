<?php
/*
Widget Name: Calendar
Description: Display a calendar of this months posts.
Author: Philip M. Hofer (Frumph)
Author URI: http://frumph.net/
Version: 1.04
*/

/**
 * Display calendar with days that have posts as links.
 *
 * The calendar is cached, which will be retrieved, if it exists. If there are
 * no posts for the month, then it will not be displayed.
 *
 * @since 1.0.0
 *
 * @param bool $initial Optional, default is true. Use initial calendar names.
 * @param bool $echo Optional, default is true. Set to false for return.
 */
function easel_get_calendar($initial = true, $echo = true, $taxonomy = 'post') {
	global $wpdb, $m, $monthnum, $year, $wp_locale, $posts;

	if (empty($taxonomy)) $taxonomy = 'post';
	$taxonomy = $wpdb->escape($taxonomy);
	
	$cache = array();
	$key = md5( $m . $monthnum . $year );
	if ( $cache = wp_cache_get( 'get_easel_calendar', 'calendar' ) ) {
		if ( is_array($cache) && isset( $cache[ $key ] ) ) {
			if ( $echo ) {
				echo apply_filters( 'get_easel_calendar',  $cache[$key] );
				return;
			} else {
				return apply_filters( 'get_easel_calendar',  $cache[$key] );
			}
		}
	}

	if ( !is_array($cache) )
		$cache = array();

	// Quick check. If we have no posts at all, abort!
	if ( !$posts ) {
		$gotsome = $wpdb->get_var("SELECT 1 as test FROM $wpdb->posts WHERE post_type = '${taxonomy}' AND post_status = 'publish' LIMIT 1");
		if ( !$gotsome ) {
			$cache[ $key ] = '';
			wp_cache_set( 'get_easel_calendar', $cache, 'calendar' );
			return;
		}
	}

	if ( isset($_GET['w']) )
		$w = ''.intval($_GET['w']);

	// week_begins = 0 stands for Sunday
	$week_begins = intval(get_option('start_of_week'));

	// Let's figure out when we are
	if ( !empty($monthnum) && !empty($year) ) {
		$thismonth = ''.zeroise(intval($monthnum), 2);
		$thisyear = ''.intval($year);
	} elseif ( !empty($w) ) {
		// We need to get the month from MySQL
		$thisyear = ''.intval(substr($m, 0, 4));
		$d = (($w - 1) * 7) + 6; //it seems MySQL's weeks disagree with PHP's
		$thismonth = $wpdb->get_var("SELECT DATE_FORMAT((DATE_ADD('${thisyear}0101', INTERVAL $d DAY) ), '%m')");
	} elseif ( !empty($m) ) {
		$thisyear = ''.intval(substr($m, 0, 4));
		if ( strlen($m) < 6 )
				$thismonth = '01';
		else
				$thismonth = ''.zeroise(intval(substr($m, 4, 2)), 2);
	} else {
		$thisyear = gmdate('Y', current_time('timestamp'));
		$thismonth = gmdate('m', current_time('timestamp'));
	}

	$unixmonth = mktime(0, 0 , 0, $thismonth, 1, $thisyear);

	// Get the next and previous month and year with at least one post
	$previous = $wpdb->get_row("SELECT DISTINCT MONTH(post_date) AS month, YEAR(post_date) AS year
		FROM $wpdb->posts
		WHERE post_date < '$thisyear-$thismonth-01'
		AND post_type = '${taxonomy}' AND post_status = 'publish'
			ORDER BY post_date DESC
			LIMIT 1");
	$next = $wpdb->get_row("SELECT	DISTINCT MONTH(post_date) AS month, YEAR(post_date) AS year
		FROM $wpdb->posts
		WHERE post_date >	'$thisyear-$thismonth-01'
		AND MONTH( post_date ) != MONTH( '$thisyear-$thismonth-01' )
		AND post_type = '${taxonomy}' AND post_status = 'publish'
			ORDER	BY post_date ASC
			LIMIT 1");

	/* translators: Calendar caption: 1: month name, 2: 4-digit year */
	$calendar_caption = _x('%1$s %2$s', 'calendar caption', 'easel');
	$calendar_output = '<table id="wp-calendar" summary="' . esc_attr__('Calendar', 'easel') . '">
	<caption>' . sprintf($calendar_caption, $wp_locale->get_month($thismonth), date('Y', $unixmonth)) . '</caption>
	<thead>
	<tr>';

	$myweek = array();

	for ( $wdcount=0; $wdcount<=6; $wdcount++ ) {
		$myweek[] = $wp_locale->get_weekday(($wdcount+$week_begins)%7);
	}

	foreach ( $myweek as $wd ) {
		$day_name = (true == $initial) ? $wp_locale->get_weekday_initial($wd) : $wp_locale->get_weekday_abbrev($wd);
		$wd = esc_attr($wd);
		$calendar_output .= "\n\t\t<th scope=\"col\" title=\"$wd\">$day_name</th>";
	}

	$calendar_output .= '
	</tr>
	</thead>

	<tfoot>
	<tr>';

	if ( $previous ) {
		$calendar_output .= "\n\t\t".'<td colspan="3" id="prev"><a href="' . get_month_link($previous->year, $previous->month) . '" title="' . sprintf(__('View posts for %1$s %2$s', 'easel'), $wp_locale->get_month($previous->month), date('Y', mktime(0, 0 , 0, $previous->month, 1, $previous->year))) . '">&laquo; ' . $wp_locale->get_month_abbrev($wp_locale->get_month($previous->month)) . '</a></td>';
	} else {
		$calendar_output .= "\n\t\t".'<td colspan="3" id="prev" class="pad">&nbsp;</td>';
	}

	$calendar_output .= "\n\t\t".'<td class="pad">&nbsp;</td>';

	if ( $next ) {
		$calendar_output .= "\n\t\t".'<td colspan="3" id="next"><a href="' . get_month_link($next->year, $next->month) . '" title="' . esc_attr( sprintf(__('View posts for %1$s %2$s', 'easel'), $wp_locale->get_month($next->month), date('Y', mktime(0, 0 , 0, $next->month, 1, $next->year))) ) . '">' . $wp_locale->get_month_abbrev($wp_locale->get_month($next->month)) . ' &raquo;</a></td>';
	} else {
		$calendar_output .= "\n\t\t".'<td colspan="3" id="next" class="pad">&nbsp;</td>';
	}

	$calendar_output .= '
	</tr>
	</tfoot>

	<tbody>
	<tr>';

	// Get days with posts
	$dayswithposts = $wpdb->get_results("SELECT DISTINCT DAYOFMONTH(post_date)
		FROM $wpdb->posts WHERE MONTH(post_date) = '$thismonth'
		AND YEAR(post_date) = '$thisyear'
		AND post_type = '${taxonomy}' AND post_status = 'publish'
		AND post_date < '" . current_time('mysql') . '\'', ARRAY_N);
	if ( $dayswithposts ) {
		foreach ( (array) $dayswithposts as $daywith ) {
			$daywithpost[] = $daywith[0];
		}
	} else {
		$daywithpost = array();
	}

	if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false || stripos($_SERVER['HTTP_USER_AGENT'], 'camino') !== false || stripos($_SERVER['HTTP_USER_AGENT'], 'safari') !== false)
		$ak_title_separator = "\n";
	else
		$ak_title_separator = ', ';

	$ak_titles_for_day = array();
	$ak_post_titles = $wpdb->get_results("SELECT ID, post_title, DAYOFMONTH(post_date) as dom "
		."FROM $wpdb->posts "
		."WHERE YEAR(post_date) = '$thisyear' "
		."AND MONTH(post_date) = '$thismonth' "
		."AND post_date < '".current_time('mysql')."' "
		."AND post_type = 'post' AND post_status = 'publish'"
	);
	if ( $ak_post_titles ) {
		foreach ( (array) $ak_post_titles as $ak_post_title ) {

				$post_title = esc_attr( apply_filters( 'the_title', $ak_post_title->post_title, $ak_post_title->ID ) );

				if ( empty($ak_titles_for_day['day_'.$ak_post_title->dom]) )
					$ak_titles_for_day['day_'.$ak_post_title->dom] = '';
				if ( empty($ak_titles_for_day["$ak_post_title->dom"]) ) // first one
					$ak_titles_for_day["$ak_post_title->dom"] = $post_title;
				else
					$ak_titles_for_day["$ak_post_title->dom"] .= $ak_title_separator . $post_title;
		}
	}


	// See how much we should pad in the beginning
	$pad = calendar_week_mod(date('w', $unixmonth)-$week_begins);
	if ( 0 != $pad )
		$calendar_output .= "\n\t\t".'<td colspan="'. esc_attr($pad) .'" class="pad">&nbsp;</td>';

	$daysinmonth = intval(date('t', $unixmonth));
	for ( $day = 1; $day <= $daysinmonth; ++$day ) {
		if ( isset($newrow) && $newrow )
			$calendar_output .= "\n\t</tr>\n\t<tr>\n\t\t";
		$newrow = false;

		if ( $day == gmdate('j', current_time('timestamp')) && $thismonth == gmdate('m', current_time('timestamp')) && $thisyear == gmdate('Y', current_time('timestamp')) )
			$calendar_output .= '<td id="today">';
		else
			$calendar_output .= '<td>';

		if ( in_array($day, $daywithpost) ) // any posts today?
				$calendar_output .= '<a href="' . get_day_link($thisyear, $thismonth, $day) . "\" title=\"" . esc_attr($ak_titles_for_day[$day]) . "\">$day</a>";
		else
			$calendar_output .= $day;
		$calendar_output .= '</td>';

		if ( 6 == calendar_week_mod(date('w', mktime(0, 0 , 0, $thismonth, $day, $thisyear))-$week_begins) )
			$newrow = true;
	}

	$pad = 7 - calendar_week_mod(date('w', mktime(0, 0 , 0, $thismonth, $day, $thisyear))-$week_begins);
	if ( $pad != 0 && $pad != 7 )
		$calendar_output .= "\n\t\t".'<td class="pad" colspan="'. esc_attr($pad) .'">&nbsp;</td>';

	$calendar_output .= "\n\t</tr>\n\t</tbody>\n\t</table>";

	$cache[ $key ] = $calendar_output;

	wp_cache_set( 'get_easel_calendar', $cache, 'calendar' );

	if ( $echo )
		echo apply_filters( 'get_easel_calendar',  $calendar_output );
	else
		return apply_filters( 'get_easel_calendar',  $calendar_output );

}

/**
 * Purge the cached results of get_calendar.
 *
 * @see get_calendar
 * @since 2.1.0
 */
function easel_delete_get_calendar_cache() {
	wp_cache_delete( 'get_easel_calendar', 'calendar' );
}
add_action( 'save_post', 'easel_delete_get_calendar_cache' );
add_action( 'delete_post', 'easel_delete_get_calendar_cache' );
add_action( 'update_option_start_of_week', 'easel_delete_get_calendar_cache' );
add_action( 'update_option_gmt_offset', 'easel_delete_get_calendar_cache' );


class easel_calendar_widget extends WP_Widget {
	
	function easel_calendar_widget($skip_widget_init = false) {
		if (!$skip_widget_init) {
			$widget_ops = array('classname' => __CLASS__, 'description' => __('Display a calendar showing this months posts. (this calendar does not drop lines if there is no title given.)','easel') );
			$this->WP_Widget(__CLASS__, __('Easel Calendar','easel'), $widget_ops);
		}
	}

	function widget($args, $instance) {
		global $post, $wp_query;
		extract($args, EXTR_SKIP);

		echo $before_widget;

		if (!empty($instance)) { extract($instance); } ?>
			<div id="wp-calendar-head"></div>
			<div id="wp-calendar-wrap">
				<?php if (!empty($thumbnail)) { ?>
					<div class="wp-calendar-download">
					<?php if (!empty($link)) { ?>
						<a href="<?php echo esc_attr($link); ?>"><img src="<?php echo esc_attr($thumbnail); ?>" class="wp-calendar-thumb" alt="" /></a>
					<?php } else { ?>
						<img src="<?php echo esc_attr($thumbnail); ?>" class="wp-calendar-thumb" alt="" />
					<?php } ?>
						<div class="wp-calendar-download-links">
							<?php if (!empty($small) || !empty($medium) || !empty($large)) { ?>
								<?php _e('DOWNLOAD','easel'); ?>
								<?php
								  foreach (array(
								    'small' => array(__('Download Small', 'easel'), __('S', 'easel')),
								    'medium' => array(__('Download Medium', 'easel'), __('M', 'easel')),
								  	'large' => array(__('Download Large', 'easel'), __('L', 'easel'))
								 	) as $field => $text) {
								 		if (!empty(${$field})) {
								 			?><a href="<?php echo esc_attr(${$field}); ?>" title="<?php echo esc_attr($text[0]); ?>"><?php echo esc_html($text[1]); ?></a><?php
								 		}
								 	}
							} ?>
						</div>
					</div>
				<?php } ?>
			<?php
				easel_get_calendar(true, true, 'post'); 
			?>
			</div>
			<div id="wp-calendar-foot"></div>
		<?php

		echo $after_widget;
	}

	function update($new_instance, $old_instance = array()) {
		$instance = array();
		foreach (array('thumbnail', 'small', 'medium', 'large', 'link') as $field) {
			if (isset($new_instance[$field])) {	$instance[$field] = strip_tags($new_instance[$field]); }
		}

		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'thumbnail' => '', 'small' => '', 'medium' => '', 'large' => '', 'link' => '') );

		$thumbnail = strip_tags($instance['thumbnail']);
		$small = strip_tags($instance['small']);
		$medium = strip_tags($instance['medium']);
		$large = strip_tags($instance['large']);
		$link = $instance['link'];

		foreach (array(
			'thumbnail' => __('Thumbnail URL (178px by 130px):','easel'),
			'link' => array('label' => __('Add link on thumbnails:','easel'), 'after' => '<hr />'),
			'small' => __('Wallpaper URL (Small):','easel'),
			'medium' => __('Wallpaper URL (Medium):','easel'),
			'large' => __('Wallpaper URL (Large):','easel'),
		) as $field => $label) {
			unset($after);
			if (is_array($label)) { extract($label); }
			?><p>
				<label for="<?php echo $this->get_field_id($field); ?>"><?php echo esc_html($label) ;?>
				<input class="widefat"
							 id="<?php echo $this->get_field_id($field); ?>"
							 name="<?php echo $this->get_field_name($field); ?>"
							 type="text"
							 value="<?php echo esc_attr($instance[$field]); ?>" />
				</label>
			</p><?php

			if (isset($after)) { echo $after; }
		}
	}
}
register_widget('easel_calendar_widget');

?>