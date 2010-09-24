<?php
/**
 * Related posts
 * Displays a list of blog links that are related to this current one using shortcode.
 * 
 * Usage:  [related_posts]
 * 
 */

function comicpress_related_posts_shortcode( $atts = '' ) {
	extract(shortcode_atts(array(
					'limit' => '5',
					), $atts));
	
	global $wpdb, $post, $table_prefix;
	if ($post->ID) {
		// Get tags
		$tags = wp_get_post_tags($post->ID);
		$tagsarray = array();
		foreach ($tags as $tag) {
			$tagsarray[] = $tag->term_id;
		}
		$tagslist = implode(',', $tagsarray);
		if (empty($tagslist)) return;
		if (empty($limit)) $limit = 5;
		// Do the query
		$q = "SELECT p.*, count(tr.object_id) as count
				FROM $wpdb->term_taxonomy AS tt, $wpdb->term_relationships AS tr, $wpdb->posts AS p WHERE tt.taxonomy ='post_tag' AND tt.term_taxonomy_id=tr.term_taxonomy_id AND tr.object_id=p.ID AND tt.term_id IN ($tagslist) AND p.ID != ".$post->ID."
				AND p.post_status = 'publish'
				AND p.post_date_gmt < NOW()
				GROUP BY tr.object_id
				ORDER BY RAND() DESC, p.post_date_gmt DESC
				LIMIT $limit;";
		
		$related = $wpdb->get_results($q);
		$retval = '';
		$goodtogo = false;
		if ( $related ) {
			$retval = '
					<div class="related_posts">
					<h4>Related Posts &not;</h4>';
			$retval .= '
					<ul>';
			$in_comic_cat = 0;
			$counter = 0;
			$retval .= '
					<table class="month-table">';
			foreach($related as $r) :
				$thecats = array();
				$categories = get_the_category($r->ID);
				$thecats[] = $categories[0]->cat_ID;
				if (count(array_intersect(comicpress_all_comic_categories_array(), $thecats)) == 0) {
					$retval .= '
							<tr><td class="archive-date" align="right">'.date('M j, Y',strtotime($r->post_date)).'</td><td class="archive-title"><a title="'.wptexturize($r->post_title).'" href="'.get_permalink($r->ID).'">'.wptexturize($r->post_title).'</a></td></tr>';
					$goodtogo = true;
				}
			endforeach;
			$retval .= '
					</table>';
				$retval .= '
	</ul>';
		$retval .= '
</div>';
		} 
		if ($goodtogo) return $retval;
	}
	return;
}
/*
function related_posts_shortcode( $atts = '' ) {
	extract(shortcode_atts(array(
					'limit' => '5',
					), $atts));
	
	global $wp_query, $wpdb, $post, $non_comic_categories;
	if ($post->ID) {
		if (empty($limit)) $limit = 5;

		//for use in the loop, list 5 post titles related to first tag on current post
		$tags = wp_get_post_tags($post->ID);
		$tagIDs = array();
		if ($tags) {
			$tagcount = count($tags);
			for ($i = 0; $i < $tagcount; $i++) {
				$tagIDs[$i] = $tags[$i]->term_id;
			}
			$args=array(
					'category__in' => array(1,3,31),
					'tag__and' => $tagIDs,
					'showposts'=>5,
					'post__not_in' => array($post->ID),
					'caller_get_posts'=>1
					);
			$my_query = new WP_Query($args);
			$temp_query = $wp_query;
			$wp_query->in_the_loop = true;
			if( $my_query->have_posts() ) {
				while ($my_query->have_posts()) : $my_query->the_post(); ?>
					<li><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></li>
					<?php endwhile;
			}
			$wp_query = $temp_query;
			$temp_query = null;
		}

	}
}
*/
add_shortcode('related_posts', 'comicpress_related_posts_shortcode');

?>