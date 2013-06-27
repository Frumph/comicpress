<?php

function comicpress_get_first_comic() {
	return comicpress_get_terminal_post_in_category(comicpress_all_comic_categories_string(), true);
}

function comicpress_get_last_comic() {
	return comicpress_get_terminal_post_in_category(comicpress_all_comic_categories_string(), false);
}

function comicpress_get_previous_comic($in_same_category = false, $category = null) { return comicpress_get_adjacent_comic($category, true, $in_same_category); }

function comicpress_get_next_comic($in_same_category = false, $category = null) { return comicpress_get_adjacent_comic($category, false, $in_same_category); }


/**
* Get the hyperlink to the first comic post in the database.
* @return string The hyperlink to the first comic post, or false.
*/
function comicpress_get_first_comic_permalink() {
	$terminal = comicpress_get_first_comic();
	if (!empty($terminal)) 
	return !empty($terminal) ? apply_filters('comicpress_get_first_comic_permalink',get_permalink($terminal->ID)) : false;
}

/**
* Get the hyperlink to the last comic post in the database.
* @return string The hyperlink to the first comic post, or false.
*/
function comicpress_get_last_comic_permalink() {
	$terminal = comicpress_get_last_comic();
	return !empty($terminal) ? apply_filters('comicpress_get_last_comic_permalink',get_permalink($terminal->ID)) : false;
}

/**
 * Get the link to the previous comic from the current one.
 */
function comicpress_previous_comic_link($format, $link) {
	previous_post_link($format, $link, false, comicpress_all_blog_categories_array_and());
}

/**
 * Get the link to the next comic from the current one.
 */
function comicpress_next_comic_link($format, $link) {
	next_post_link($format, $link, false, comicpress_all_blog_categories_array_and());
}

/**
 * This is function comicpress_get_next_comic_permalink
 *
 * @return mixed false if no next comic permalink, else return the permalink
 *
 */
function comicpress_get_next_comic_permalink($in_same_category = false) {
	$next_comic = comicpress_get_next_comic($in_same_category);
	if (is_object($next_comic)) {
		if (isset($next_comic->ID)) {
			return apply_filters('comicpress_get_next_comic_permalink',get_permalink($next_comic->ID));
		}
	}
	return false;
}

/**
 * This is function comicpress_get_previous_comic_permalink
 *
 * @return mixed false if there is no permalink or next previous comic
 *
 */
function comicpress_get_previous_comic_permalink($in_same_category = false) {
	$prev_comic = comicpress_get_previous_comic($in_same_category);
	if (is_object($prev_comic)) {
		if (isset($prev_comic->ID)) {
			return apply_filters('comicpress_get_previous_comic_permalink',get_permalink($prev_comic->ID));
		}
	}
	return false;
}

/**
 * Get the adjacent comic from the current one.
 * @param int $category The category to use.
 * @param boolean $previous True if the previous chronological comic should be retrieved.
 * @return array The WordPress post object for the comic post.
 */
function comicpress_get_adjacent_comic($category, $previous = false, $in_same_category = false) {	
	if (!empty($category)) {
		$categories_to_exclude = comicpress_get_string_to_exclude_all_but_provided_categories($category);
	} else {
		$categories_to_exclude = comicpress_all_blog_categories_array_and();
	}
	return get_adjacent_post($in_same_category, $categories_to_exclude, $previous);
}

/**
 * Find the terminal post in a specific category.
 */
function comicpress_get_terminal_post_in_category($categoryID, $first = true, $storyline = false) {
	global $post;

	if (empty($categoryID)) $categoryID = comicpress_themeinfo('comiccat');
	
	$excluded_cats = array();
	
	if ($storyline) {
//		echo "CAT ID: ".$categoryID."<br />";
		$excluded_catlist = get_categories(array('child_of' => $categoryID));
		foreach ($excluded_catlist as $catlist) {
			$excluded_cats[] = $catlist->cat_ID;
		}
	}
	
	$sortOrder = $first ? "asc" : "desc";
	
	$categoryID = explode(',', $categoryID);
	
	
	if (!empty($excluded_cats)) {
		$args = array(
				'category__in' => $categoryID,
				'category__not_in' => $excluded_cats,
				'order' => $sortOrder,
				'posts_per_page' => 1
				);
	} else {;
		$args = array(
				'category__in' => $categoryID,
				'order' => $sortOrder,
				'posts_per_page' => 1
				);
	}
	
	$terminalComicQuery = new WP_Query($args);
	
	$terminalPost = false;
	if ($terminalComicQuery->have_posts()) {
		$terminalPost = reset($terminalComicQuery->posts);
	}

	return $terminalPost;
}

/**
 * Find the first post in the storyline prior to the current one.
 */
function comicpress_get_previous_storyline_start() {
	global $post;
	
	if (($category_id = comicpress_get_adjacent_storyline_category_id(false)) !== false) {
		
		$terminal_post = comicpress_get_terminal_post_in_category($category_id, true, true);
		
		if ($post->ID == $terminal_post->ID) return false;
		
		$category = get_the_category($post->ID);
		
		$current_terminal_post = comicpress_get_terminal_post_in_category($category[0]->cat_ID);
		
		if ($current_terminal_post->ID == $post->ID) {
			return $terminal_post;
		} else {
			return $current_terminal_post;
		}
	}
	return false;
}

function comicpress_get_previous_storyline_start_permalink() {
	$prev_story = comicpress_get_previous_storyline_start();
	if (is_object($prev_story)) {
		if (isset($prev_story->ID)) {
			return get_permalink($prev_story->ID);
		}
	}
	return false;
}

/**
 * Find the first post in the storyline following to the current one.
 */
function comicpress_get_next_storyline_start() {
	if (($category_id = comicpress_get_adjacent_storyline_category_id(true)) !== false) {
		return comicpress_get_terminal_post_in_category($category_id, true, true);
	}
	return false;
}

function comicpress_get_next_storyline_start_permalink() {
	$next_story = comicpress_get_next_storyline_start();
	if (is_object($next_story)) {
		if (isset($next_story->ID)) {
			return get_permalink($next_story->ID);
		}
	}
	return false;
}

function comicpress_get_adjacent_storyline_category_id($next = false) {
	global $post, $category_tree;
	$categories = get_the_category($post->ID);
	if (is_array($categories)) {
		$category_id = $categories[0]->cat_ID;
		for ($i = 0, $il = count($category_tree); $i < $il; ++$i) {
			$storyline_category_id = end(explode("/", $category_tree[$i]));
			
			if ($storyline_category_id == $category_id) { 
				$target_index = false;
				if ($next) {
					$target_index = $i + 1;
				} else {
					$target_index = $i - 1;
				}
				if (isset($category_tree[$target_index])) {
					return end(explode('/', $category_tree[$target_index]));
				}
			} 
		}
	}
	return false;
}

function comicpress_get_terminal_post_of_chapter_permalink($first = true) {
	global $post;
	$category = get_the_category($post->ID);
	$term_post = comicpress_get_terminal_post_in_category($category[0]->cat_ID, $first, false);
	if (is_object($term_post)) {
		if (isset($term_post->ID)) {
			return get_permalink($term_post->ID);
		}
	}
	return false;
}

?>
