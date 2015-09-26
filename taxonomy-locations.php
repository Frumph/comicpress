<?php
get_header();
$location = (isset($wp_query->query_vars['locations'])) ? esc_html($wp_query->query_vars['locations']) : '';

if (!empty($location)) {
	$args = array(
			'post_type' => 'page',
			'meta_key'  => 'location-overwrite',
			'meta_value' => $location
	);

	$insertPage = new WP_Query(); $insertPage->query($args);

	if ($insertPage->have_posts()) {
		while ($insertPage->have_posts()) : $insertPage->the_post();
				get_template_part('content', 'page');
		endwhile;
	}
	wp_reset_query();

	$args = array(
			'nopaging' => true,
			'numberposts' => -1,
			'posts_per_page'  => -1,
			'post_type' => 'comic',
			'orderby' => 'post_date',
			'order' => 'ASC',
			'post_status' => 'publish',
			'locations' => $location,
			);
	$qposts = get_posts( $args );
	if (!empty($qposts)) {
		$output = '<div class="location-stats">';
		$first_seen_object = reset($qposts);
		$first_seen_title = $first_seen_object->post_title;
		$first_seen_id = $first_seen_object->ID;
		$last_seen_object = end($qposts);
		$last_seen_title = $last_seen_object->post_title;
		$last_seen_id = $last_seen_object->ID;
		if ($first_seen_id == $last_seen_id) {
			$output .= '<i>'.__( 'Only Scene:', 'comicpress' ).'</i> <a href="'.get_permalink($first_seen_id).'">'.$first_seen_title.'</a><br />';
		} else {
			$output .= '<i>'.__( 'Recent Scene:', 'comicpress' ).'</i> <a href="'.get_permalink($last_seen_id).'">'.$last_seen_title.'</a><br />';
			$output .= '<i>'.__( 'First Scene:', 'comicpress' ).'</i> <a href="'.get_permalink($first_seen_id).'">'.$first_seen_title.'</a><br />';			
		}
		$output .= '</div>';
		echo $output;
	}
	
	wp_reset_query();
}

// this shows what the 'archive' would show, if you don't want the archive underneith the custom page, remove this
get_template_part('archive');

get_footer();
