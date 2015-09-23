<?php
get_header();
$character = (isset($wp_query->query_vars['characters'])) ? esc_html($wp_query->query_vars['characters']) : '';

if (!empty($character)) {
	$args = array(
			'post_type' => 'page',
			'meta_key'  => 'location-overwrite',
			'meta_value' => $character
	);

	$insertPage = new WP_Query(); $insertPage->query($args);

	if ($insertPage->have_posts()) {
		while ($insertPage->have_posts()) : $insertPage->the_post();
				get_template_part('content', 'page');
		endwhile;
		$args = array(
				'nopaging' => true,
				'numberposts' => -1,
				'posts_per_page'  => -1,
				'post_type' => 'comic',
				'orderby' => 'post_date',
				'order' => 'ASC',
				'post_status' => 'publish',
				'characters' => $character,
				);
		$qposts = get_posts( $args );
		if (!empty($qposts)) {
			$output = '<div class="character-stats">';
			$first_seen_object = reset($qposts);
			$first_seen_title = $first_seen_object->post_title;
			$first_seen_id = $first_seen_object->ID;
			$last_seen_object = end($qposts);
			$last_seen_title = $last_seen_object->post_title;
			$last_seen_id = $last_seen_object->ID;
			if ($first_seen_id == $last_seen_id) {
				$output .= '<i>'.__( 'Only Appearance:', 'comicpress' ).'</i> <a href="'.get_permalink($first_seen_id).'">'.$first_seen_title.'</a><br />';
			} else {
				$output .= '<i>'.__( 'Recent Appearance:', 'comicpress' ).'</i> <a href="'.get_permalink($last_seen_id).'">'.$last_seen_title.'</a><br />';
				$output .= '<i>'.__( 'First Appearance:', 'comicpress' ).'</i> <a href="'.get_permalink($first_seen_id).'">'.$first_seen_title.'</a><br />';			
			}
			$output .= '</div>';
			echo apply_filters('comicpress-character-stats', $output);
		}		
		
	}
	wp_reset_query();
}

// this shows what the 'archive' would show, if you don't want the archive underneith the custom page, remove this
get_template_part('archive');

get_footer();
