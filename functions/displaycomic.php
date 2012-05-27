<?php

// If any errors occur while searching for a comic file, the error messages will be pushed into here.
$comic_pathfinding_errors = array();

// If ComicPress Manager is installed, use the date format defined there. If not, default to
// Y-m-d.. It's best to use CPM's date definition for improved operability between theme and plugin.

if (defined("CPM_DATE_FORMAT")) {
	define("CP_DATE_FORMAT", CPM_DATE_FORMAT);
} else {
	define("CP_DATE_FORMAT", "Y-m-d");
}

// If you want to run multiple comics on a single day, define your additional filters here.
// Example: you want to run an additional comic with the filename 2008-01-01-a-my-new-years-comic.jpg.
// Define an additional filter in the list below:
//
// $comic_filename_filters['secondary'] = "{date}-a*.*";
//
// Then show the second comic on your page by calling the_comic with your filter name (PHP tags munged
// to maintain valid file syntax):
//
// < ?php the_comic('secondary'); ? >
//
// Note that it's quite possible to slurp up the wrong file if your expressions are too broad.

$comic_filename_filters = array();
$comic_filename_filters['default'] = "{date}*.*";

if (!function_exists('comicpress_display_comic_area')) {
	function comicpress_display_comic_area() {
		global $post; ?>
		<div id="comic-wrap" class="comic-id-<?php echo $post->ID; ?>">
			<div id="comic-head"><?php if (is_active_sidebar('over-comic')) get_sidebar('over'); ?></div>
			<div class="clear"></div>
				<?php if (is_active_sidebar('left-of-comic')) get_sidebar('comicleft'); ?>
			<div id="comic">
				<?php echo comicpress_display_comic(); ?>
				<!-- Last Update: <?php the_time('M jS, Y'); ?> // -->
			</div>
				<?php if (is_active_sidebar('right-of-comic')) get_sidebar('comicright'); ?>
			<div class="clear"></div>
			<div id="comic-foot"><?php if (is_active_sidebar('under-comic')) get_sidebar('under'); ?></div>
		</div>
	<?php }	
}

function comicpress_display_comic_swf($post, $comic) {
	$file_url = comicpress_themeinfo('baseurl') . comicpress_clean_url($comic);
	$height = get_post_meta( $post->ID, "fheight", true );
	$width = get_post_meta( $post->ID, "fwidth", true );
	if (empty($height)) $height = '300';
	if (empty($width)) $width = '100%';
	$output = "<object id=\"myId\" classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" width=\"{$width}\" height=\"{$height}\">\r\n";
	$output .= "	<param name=\"movie\" value=\"".$file_url."\" />\r\n";
	$output .= "<!--[if !IE]>--><object type=\"application/x-shockwave-flash\" data=\"".$file_url."\" width=\"{$width}\" height=\"{$height}\"><!--<![endif]-->\r\n";
	$output .= "		<div>\r\n";
	$output .= "			<h1>Get Flash!</h1>\r\n";
	$output .= "				<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></p>\r\n";
	$output .= "		</div>\r\n";
	$output .= "<!--[if !IE]>--></object><!--<![endif]--></object>\r\n";
	add_action('wp_footer', 'comicpress_init_comic_swf');
	return apply_filters('comicpress_display_comic_swf',$output);
}

/**
* Display text when image (comic) is hovered
* Text is taken from a custom field named "hovertext"
*/
function comicpress_the_hovertext($override_post = null) {
	global $post;
	$post_to_use = !is_null($override_post) ? $override_post : $post;
	$hovertext = get_post_meta( $post_to_use->ID, "hovertext", true );
	return (empty($hovertext)) ? get_the_title($post_to_use->ID) : $hovertext;
}

function comicpress_init_comic_swf() {
	wp_enqueue_script('swfobject', '', array(), false, true);
}

// This function will let authors who want to use comicpress as a way to output their books/text in a comic area as a page.
function comicpress_display_comic_text($comic) {
	$output = '';
	if (file_exists(comicpress_themeinfo('basedir') . '/' .$comic)) {
		$output = implode('', file(comicpress_themeinfo('basedir') . '/' .$comic));
	}
	return apply_filters('comicpress_display_comic_text', $output);
}


// Do the thumbnail display functions here.
function comicpress_display_comic_thumbnail($type = 'mini', $override_post = null, $use_post_image = false, $setwidth = 0, $multi = false) {
	global $post;
	
	$post_to_use = !empty($override_post) ? $override_post : $post;

	// use_post_image if its set to true
	if ($use_post_image) {
		$post_image_id = get_post_thumbnail_id($post_to_use->ID);
		if ($post_image_id) {
			$thumbnail = wp_get_attachment_image_src( $post_image_id, 'post-thumbnail', false);
			if ($thumbnail) (string)$thumbnail = $thumbnail[0];
		}
	}
	
	if (empty($thumbnail)) {
		$thumb_found = get_comic_path($type, $post_to_use);
		
		$count = count($thumb_found);
		
		// adjust the thumbnail directories of all of them not just one, time to stop outputting them singularly and do array
		$thumbnail = array();
		if (!empty($thumb_found)) {
			foreach ($thumb_found as $thumb) {
				$thumbnail[] = comicpress_themeinfo('baseurl') . comicpress_clean_url($thumb);
			}
		}
	}
	
	if (empty($thumbnail)) {
		// Catchall non-thumbnails and display the notfound.
		$thumbnail = array();
		$thumbnail[] = $thumbnail[] = get_template_directory_uri() . '/images/notfound.png';
	}
	
	$output = '';
	$alttext = comicpress_the_hovertext($post_to_use);
	if (is_array($thumbnail)) {
		if ($multi) {
			foreach ($thumbnail as $thumb) {
				if ($setwidth) {
					$output .= '<img src="'.$thumb.'" alt="'.$alttext.'" style="max-width:'.$setwidth.'px" class="comicthumbnail" title="'.$alttext.'" />'."\r\n";
				} else {
					$output .= '<img src="'.$thumb.'" alt="'.$alttext.'" class="comicthumbnail" title="'.$alttext.'" />'."\r\n";
				}
			}
		} else {
			$thumb = $thumbnail[0];

			if ($setwidth) {
				$output .= '<img src="'.$thumb.'" alt="'.$alttext.'" style="max-width:'.$setwidth.'px" class="comicthumbnail" title="'.$alttext.'" />'."\r\n";
			} else {
				$output .= '<img src="'.$thumb.'" alt="'.$alttext.'" class="comicthumbnail" title="'.$alttext.'" />'."\r\n";
			}			
		}
	} else {
		if ($setwidth) {
			$output = '<img src="'.$thumbnail.'" alt="'.$alttext.'" style="max-width:'.$setwidth.'px" class="comicthumbnail" title="'.$alttext.'" />'."\r\n";
		} else {
			$output = '<img src="'.$thumbnail.'" alt="'.$alttext.'" class="comicthumbnail" title="'.$alttext.'" />'."\r\n";
		}
	}
//	if ($count > 1) $output = $count.' comics attached.<br />'.$output;

	return apply_filters('comicpress_display_comic_thumbnail', $output);
}

// TODO: Add the hovertext - rascal code and click to next INSIDE this.
if (!function_exists('comicpress_display_comic_image')) {
	function comicpress_display_comic_image($post, $comic) {
		global $wp_query;
		$cdn_url = comicpress_themeinfo('cdn_url');
		if (!empty($cdn_url)) {
			$file_url = trailingslashit($cdn_url) . comicpress_clean_url($comic);
		} else {
			$file_url = comicpress_themeinfo('baseurl') . comicpress_clean_url($comic);		
		}	
		$alt_text = comicpress_the_hovertext($post);
		if (!is_search() && !is_archive() && !is_feed()) {
			$ok = $oktoo = true;;
			$href_to_use = $before_output = $add_href = $after_output = $add_tt_class = '';
			if (comicpress_themeinfo('enable_comic_lightbox')) {
				$tags = wp_get_post_tags($post->ID);
				$tagsarray = array();
				if (is_array($tags) && !empty($tags)) {
					foreach ($tags as $tag) {
						$tagsarray[] = $tag->slug;
					}
					if (in_array('fullpage', $tagsarray)) {
						$add_href = '<a href="'.$file_url.'" title="'.$alt_text.'" rel="lightbox">';
						$after_output = '</a>';
						$ok = false;
					}
				}
			}
			if (comicpress_themeinfo('rascal_says') && !empty($alt_text) && $ok) {
				$hovertext = get_post_meta( $post->ID, "hovertext", true );
				$href_to_use = "#";
				if (!empty($hovertext)) {
					$before_output = '<span class="tooltip"><span class="top">&nbsp;</span><span class="middle">'.$alt_text.'</span><span class="bottom">&nbsp;</span></span>';
					$add_href = '<a href="'.$href_to_use.'" class="tt" title="'.$post->post_title.'">';
					$add_tt_class = ' class="tt"';
					$after_output = '</a>';
					$oktoo = false;
				}
			}
			if (comicpress_themeinfo('comic_clicks_next') && $ok) {
				$href_to_use = comicpress_get_next_comic_permalink();
				$add_href = '<a href="'.$href_to_use.'" title="'.$alt_text.'"'.$add_tt_class.'>';
				$after_output = '</a>';
			}
		}
		$output = $add_href . $before_output . '<img src="'.$file_url.'" alt="'.$alt_text.'" title="'.$alt_text.'"/>' . $after_output;
		return apply_filters('comicpress_display_comic_image', $output);
	}
}

// jquery code image swap by @brianarn
function comicpress_display_comic() {
	global $post;
	$comics = get_comic_path('comic', $post);
	$output = '';
	if (is_array($comics)) {
		$count = 1;
		$outputlist = '';
		$outputscript = '';
		foreach ($comics as $comic) {
			$comicsplit = explode(".", $comic); 
			switch (strtolower($comicsplit[1])) {
				case 'swf':
					$output .= '<div id="comic-'.$count.'" class="comicpane">';
					$output .= comicpress_display_comic_swf($post, $comic);
					$output .= "</div>\r\n";
					$outputlist .= "<button id=\"show-".$count."\" type=\"button\">".$count."</button>\r\n";
					$count += 1;
					break;
				case 'txt':
				case 'inc':
				case 'htm':
					$output .= '<div id="comic-'.$count.'" class="comicpane">';
					$output .= comicpress_display_comic_text($comic);
					$output .= "</div>\r\n";
					$outputlist .= "<button id=\"show-".$count."\" type=\"button\">".$count."</button>\r\n";
					$count += 1;
					break;
				case 'png':
				case 'gif':
				case 'jpg':
				case 'jpeg':
				case 'tif':
				case 'tiff':
				case 'bmp':
				default:
					$output .= '<div id="comic-'.$count.'" class="comicpane">';
					$output .= comicpress_display_comic_image($post, $comic);
					$output .= "</div>\r\n";
					$outputlist .= "<button id=\"show-".$count."\" type=\"button\">".$count."</button>\r\n";
					$count += 1;
			}
		}
		if ($count > 2 && comicpress_themeinfo('enable_multicomic_jquery')) {
			// Add the script stuff before the rest here.
			$output = $outputscript . $output;
		}
	}
	return $output;
}

if (!function_exists('comicpress_comic_clicks_next')) {
	function comicpress_comic_clicks_next($output) {
		global $post, $wp_query;
		if (is_search() || is_archive() || is_feed()) return $output;
		$hovertext = comicpress_the_hovertext($post);
		$next_comic = comicpress_get_next_comic_permalink();
		$class = '';
		if (comicpress_themeinfo('rascal_says')) {
			$the_title = get_the_title($post);
			$class='class="tt"';
		} else {
			$the_title = comicpress_the_hovertext($post);
		}
		$output = "<a {$class} href=\"{$next_comic}\" title=\"{$the_title}\">{$output}</a>\r\n";
		return $output;
	}
}

function comicpress_rascal_says($output) {
	global $post, $wp_query;
	if (is_search() || is_archive() || is_feed()) return $output;
	$hovertext = get_post_meta( $post->ID, "hovertext", true );
	$href_to_use = "#";
	if (!empty($hovertext)) {
		$output = preg_replace('#title="([^*]*)"#', '', $output);
		$output = "<span class=\"tooltip\"><span class=\"top\">&nbsp;</span><span class=\"middle\">{$hovertext}</span><span class=\"bottom\">&nbsp;</span></span>{$output}\r\n";
	}
	if (comicpress_themeinfo('comic_clicks_next')) {
		$href_to_use = comicpress_get_next_comic_permalink();
		if (empty($href_to_use)) $href_to_use = "#";
		$output = "<a href=\"{$href_to_use}\" class=\"tt\" title=\"".$post->post_title."\">{$output}</a>";
	} else {
		$output = "<a class=\"tt\" href=\"{$href_to_use}\" title=\"".$post->post_title."\">{$output}</a>";
	}
	return apply_filters('comicpress_rascal_says',$output);
}

/*
Old Method
if (comicpress_themeinfo('rascal_says')) {
	add_filter('comicpress_display_comic_image', 'comicpress_rascal_says');
}

if (comicpress_themeinfo('comic_clicks_next') && !comicpress_themeinfo('rascal_says')) { 
	add_filter('comicpress_display_comic_image', 'comicpress_comic_clicks_next'); 
}
*/


/**
* Find a comic file in the filesystem.
* @param string $folder The folder name to search.
* @param string $override_post A WP Post object to use in place of global $post.
* @param string $filter The $comic_filename_filters to use.
* @return string The relative path to the comic file, or false if not found.
*/

function get_comic_path($folder = 'comic', $override_post = null, $filter = 'default') {
	global $post, $comic_filename_filters, $comic_pathfinding_errors;

	$post_to_use = !empty($override_post) ? $override_post : $post;

	$meta_name = 'comic';
	
	$comicfile = '';
	
	if (function_exists('xlanguage_current_language_code')) 
		$meta_name .= '-'.xlanguage_current_language_code();

	$comicfile = get_post_meta( $post_to_use->ID, $meta_name, false );

// Backswards compatibility here
	
	switch ($folder) {
		case "rss": $subfolder_to_use = comicpress_themeinfo('rss_comic_folder'); break;
		case "archive": $subfolder_to_use = comicpress_themeinfo('archive_comic_folder'); break;
		case "mini": $subfolder_to_use = comicpress_themeinfo('mini_comic_folder'); break;
		case "comic": default: $subfolder_to_use = comicpress_themeinfo('comic_folder'); break;
	}
	
// comic-en comic-esp etc.. language directories
	if (function_exists('qtrans_getLanguage')) {
		$language_to_use = qtrans_getLanguage();
		$subfolder_to_use = $subfolder_to_use . '-' . $language_to_use;
	}
	
	$folder_to_use = comicpress_themeinfo('basedir') . $subfolder_to_use;

//	if (!file_exists($folder_to_use . '/' . $comicfile) && $folder !== 'comic') 
//		$subfolder_to_use = comicpress_themeinfo('comic_folder'); 
	
	if (!empty($comicfile)) {
		// return this as an array if we want to include in the future multiple comics found type thing, keeping it compatible.
		$newresults = array();
		foreach ($comicfile as $comic) {
			if (!file_exists($folder_to_use . '/' . $comic) && $folder !== 'comic') 
				$subfolder_to_use = comicpress_themeinfo('comic_folder'); 
			$newresults[] = trailingslashit($subfolder_to_use) . $comic;
		}
		return $newresults;
		
	} else {
		// backwards compatibility
		if (isset($comic_filename_filters[$filter])) {
			$filter_to_use = $comic_filename_filters[$filter];
		} else {
			$filter_to_use = '{date}*.*';
		}
	
		$post_date = mysql2date(CP_DATE_FORMAT, $post_to_use->post_date);
		$filter_with_date = str_replace('{date}', $post_date, $filter_to_use);
		
		$results = array();
		
		if (count($results = glob("${folder_to_use}/${filter_with_date}")) > 0) {
			$newresults = array();
			if (is_array($results)) {
				foreach ($results as $result) {
					// Strip the base directory off.
					$newresults[] = str_replace(comicpress_themeinfo('basedir'), '', $result);
				}
			} else {
				$newresults[] = str_replace(comicpress_themeinfo('basedir'), '', $result);
			}
			return $newresults;
		} else {
			// fallback to the comics directory
			$folder_to_use = trailingslashit(comicpress_themeinfo('basedir')) . comicpress_themeinfo('comic_folder');
			if (count($results = glob("${folder_to_use}/${filter_with_date}")) > 0) {
				$newresults = array();
				foreach ($results as $result) {
					// Strip the base directory off.
					$newresults[] = str_replace(untrailingslashit(comicpress_themeinfo('basedir')), '', $result);
				}
				return $newresults;
			}
		}
	}
	
	$comic_pathfinding_errors[] = sprintf(__("Unable to find the file in the <strong>%s</strong> folder that matched the pattern <strong>%s</strong>. Check your WordPress and ComicPress settings.", 'comicpress'), $folder_to_use, $filter_with_date);
	return false;
}


/**
* Find a comic file in the filesystem and return an absolute URL to that file.
* @param string $folder The folder name to search.
* @param string $override_post A WP Post object to use in place of global $post.
* @param string $filter The $comic_filename_filters to use.
* @return string The absolute URL to the comic file, or false if not found.
*/
function get_comic_url($folder = 'comic', $override_post = null, $filter = 'default') {
	if (($results = get_comic_path($folder, $override_post, $filter)) !== false) {
		$newresults = array();
		foreach ($results as $result) {
			ltrim($result, '/');
			$newresults[] = trailingslashit( comicpress_themeinfo('baseurl') ) . $result;
		}
		return $newresults;
	}
	return false;
}

add_action('comic-area', 'comicpress_inject_comic_home');

if (!function_exists('comicpress_inject_comic_home')) {
	function comicpress_inject_comic_home() {
		global $wp_query;
		if (!is_paged() && is_home()) {
			if (!comicpress_themeinfo('disable_comic_frontpage')) {
				$order = 'DESC';
				$wp_query->in_the_loop = true; $comicFrontpage = new WP_Query(); 
				if (comicpress_themeinfo('display_first_comic_on_home')) $order = 'ASC';
				$comicFrontpage->query('showposts=1&order='.$order.'&cat='.comicpress_all_comic_categories_string());
				while ($comicFrontpage->have_posts()) : $comicFrontpage->the_post();
					comicpress_display_comic_area();
				endwhile;
			}
		} else {
			if (is_single() && comicpress_in_comic_category()) {
				comicpress_display_comic_area();
			}
		}
	}
}
?>