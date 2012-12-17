<?php 

if ( ! function_exists( 'comicpress_enqueue_comment_reply' ) ) {
    function comicpress_enqueue_comment_reply() {
            if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
                wp_enqueue_script( 'comment-reply' );
            }
    }
}
add_action( 'wp_enqueue_scripts', 'comicpress_enqueue_comment_reply' );
// Text domain - Languages location
load_theme_textdomain( 'comicpress', get_template_directory() . '/lang' );
// the_post_thumbnail('thumbnail/medium/full');
add_theme_support( 'post-thumbnails' );
add_theme_support( 'automatic-feed-links' );
add_editor_style();

if (!isset($content_width)) $content_width = 520;

global $comiccat, $blogcat, $comic_folder, $rss_comic_folder, $mini_comic_folder, $archive_comic_folder,$archive_comic_width, $rss_comic_width, $mini_comic_width, $blog_postcount;

if (is_multisite()) {
	// This section keeps it compatible with comicpress manager's options
	$variables_to_extract = array();
	foreach (array('comiccat' => 'comiccat','blogcat'=> 'blogcat','comics_path' => 'comic_folder','comicsrss_path' => 'rss_comic_folder','comicsarchive_path'  => 'archive_comic_folder','comicsmini_path' => 'mini_comic_folder','archive_comic_width' => 'archive_comic_width',			'rss_comic_width'     => 'rss_comic_width',			'mini_comic_width'    => 'mini_comic_width','blog_postcount' => 'blog_postcount') as $options => $variable_name) {		
		$variables_to_extract[$variable_name] = get_option("comicpress-${options}");
	}
	extract($variables_to_extract);			
} else {	
	@require_once( get_template_directory() . '/comicpress-config.php');
}

/* child-functions.php / child-widgets.php - in the child theme */
get_template_part('child', 'functions');
get_template_part('child', 'widgets');


if ( version_compare( $wp_version, "3.3.999", ">" ) ) {
	// This theme allows users to set a custom background
	// the global if has anything in it from the child theme, use it.
	$comicpress_background_array = array();
	if (function_exists('comicpress_child_theme_background_array')) $comicpress_background_array = comicpress_child_theme_background_array();
// Set defaults if it doesn't exit from the global
	if (!isset($comicpress_background_array)) $comicpress_background_array = array('default-color' => 'fff', 'default-image' => '');
	add_theme_support( 'custom-background', $comicpress_background_array );
} else {
	add_custom_background();
}

// These autoload
foreach (glob(get_template_directory() . "/functions/*.php") as $funcfile) {
	@require_once($funcfile);
}

function comicpress_config() {
	global $comicpress_config;
	if (empty($comicpress_config)) {
		$comicpress_config = get_option('comicpress-config');
		if (empty($comicpress_config)) {
			
			foreach (array(
				'enable_equal_height_sidebars' => false,
				'prefab_design' => 'none'

			) as $field => $value) {
				$comicpress_config[$field] = $value;
			}

			add_option('comicpress-config', $comicpress_config, '', true);
		}
	}
	return $comicpress_config;
}

// Load all the widgets.
foreach (glob(get_template_directory()  . '/widgets/*.php') as $widgefile) {
	@require_once($widgefile);
}

// Load all the widgets from the child theme *if* a child theme exists
if (is_child_theme()) {
	if (is_dir(get_stylesheet_directory() . '/widgets')) {
		$results = glob(get_stylesheet_directory() . '/widgets/*.php');
		if (!empty($results)) {
			foreach ($results as $widgefile) {
				@require_once($widgefile);
			}
		}
	}
}

// Addons
if (comicpress_themeinfo('enable_members_only'))
	@require_once(get_template_directory() . '/addons/membersonly.php');
if (comicpress_themeinfo('enable_related_comics'))
	@require_once(get_template_directory() . '/addons/relatedcomics.php');
if (comicpress_themeinfo('enable_related_posts'))
	@require_once(get_template_directory() . '/addons/relatedposts.php');
if (comicpress_themeinfo('facebook_meta') || comicpress_themeinfo('facebook_like_comic_post') || comicpress_themeinfo('facebook_like_comic_post'))
	@require_once(get_template_directory() . '/addons/facebook.php');
if (comicpress_themeinfo('enable_page_options')) 
	@require_once(get_template_directory() . '/addons/page-options.php');
// Dashboard Menu Comicpress Options and ComicPress CSS
if (is_admin()) {
	@require_once(get_template_directory() . '/comicpress-admin.php');
}

// Register Sidebar and Define Widgets

add_action( 'widgets_init', 'comicpress_sidebar_init' );

function comicpress_sidebar_init() {
	if (comicpress_themeinfo('enable_caps')) {
		$before_widget = "<div id=\"".'%1$s'."\" class=\"widget ".'%2$s'."\">\r\n<div class=\"widget-head\"></div>\r\n<div class=\"widget-content\">\r\n";
		$after_widget = "</div>\r\n<div class=\"clear\"></div>\r\n<div class=\"widget-foot\"></div>\r\n</div>\r\n";
	} else {
		$before_widget = "<div id=\"".'%1$s'."\" class=\"widget ".'%2$s'."\">\r\n<div class=\"widget-content\">\r\n";
		$after_widget = "</div>\r\n<div class=\"clear\"></div>\r\n</div>\r\n";
	}
	$widgets_list = array(
			array('id' => 'left-sidebar', 'name' => __('Left Sidebar', 'comicpress'), 'description' => __('The sidebar that appears to the left of the content.','comicpress')),
			array('id' => 'right-sidebar', 'name' => __('Right Sidebar', 'comicpress'), 'description' => __('The sidebar that appears to the right of the content.','comicpress')),
			array('id' => 'above-header', 'name' => __('Above Header', 'comicpress'), 'description' => __('This sidebar appears to above all of the site information.  This sidebar is not encased in CSS, you will need to create CSS for it.','comicpress')),
			array('id' => 'header', 'name' => __('Header', 'comicpress'), 'description' => __('This sidebar appears inside the #header block.','comicpress')),
			array('id' => 'menubar', 'name' => __('Menubar', 'comicpress'), 'description' => __('This sidebar is under the header and above the content-wrapper block','comicpress')),
			array('id' => 'over-comic', 'name' => __('Over Comic', 'comicpress'), 'description' => __('This sidebar appears over the comic section right after the #comic-wrap','comicpress')),
			array('id' => 'left-of-comic', 'name' => __('Left of Comic', 'comicpress'), 'description' => __('This sidebar appears before #comic, it has no CSS so you need to define it yourself.','comicpress')),
			array('id' => 'right-of-comic', 'name' => __('Right of Comic', 'comicpress'), 'description' => __('This sidebar appears after #comic, it has no CSS so you need to define it yourself.','comicpress')),
			array('id' => 'under-comic', 'name' => __('Under Comic', 'comicpress'), 'description' => __('This sidebar appears after #sidebar-right-of-comic, below the rest of the comic sidebars','comicpress')),
			array('id' => 'over-blog', 'name' => __('Over Blog', 'comicpress'), 'description' => __('This sidebar appears over the blog within the #column .narrowcolumn','comicpress')),
			array('id' => 'under-blog', 'name' => __('Under Blog', 'comicpress'), 'description' => __('This sidebar appears under the blog within the #column .narrowcolumn','comicpress')),
			array('id' => 'the-footer', 'name' => __('Footer', 'comicpress'), 'description' => __('This sidebar is below the #content-wrapper block at the bottom of the page','comicpress')),
	);
	foreach ($widgets_list as $widget_info) {
		register_sidebar(array(
					'name'=> $widget_info['name'],
					'id' => 'sidebar-'.sanitize_title($widget_info['id']),
					'description' => $widget_info['description'],
					'before_widget' => $before_widget,
					'after_widget'  => $after_widget,
					'before_title'  => "<h2 class=\"widgettitle\">",
					'after_title'   => "</h2>\r\n"
		));
	}
}

function comicpress_get_sidebar($location = '') {
	if (empty($location)) { get_sidebar(); return; }
	if (file_exists(get_template_directory().'/sidebar-'.$location.'.php') || file_exists(get_stylesheet_directory().'/sidebar-'.$location.'.php')) {
		get_sidebar($location);
	} elseif (is_active_sidebar('sidebar-'.$location)) { ?>
		<div id="sidebar-<?php echo $location; ?>" class="sidebar">
			<?php dynamic_sidebar('sidebar-'.$location); ?>
			<div class="clear"></div>
		</div>
	<?php }
}

register_nav_menus(array(
	'menubar' => __( 'Menubar', 'comicpress' )
));

// put things in here that need to go into the init ONLY
function __comicpress_init() {
	global $wp_query;

	// initiate the scripts
	if (!is_admin()) {
		wp_enqueue_script('jquery');
		if (!comicpress_themeinfo('disable_jquery_menu_code')) {
			wp_enqueue_script('ddsmoothmenu_js', get_template_directory_uri() . '/js/ddsmoothmenu.js', null, null, true); 
			wp_enqueue_script('menubar_js', get_template_directory_uri() . '/js/menubar.js', null, null, true);
		}
		if (comicpress_themeinfo('enable_scroll_to_top')) {
			wp_enqueue_script('comicpress_scroll', get_template_directory_uri() . '/js/scroll.js', null, null, true);
		}
		if (comicpress_themeinfo('enable_multicomic_jquery')) {
			wp_enqueue_script('multicomic', get_template_directory_uri() . '/js/multicomic.js', null, null, true);
		}
		if (is_child_theme() && file_exists(get_stylesheet_directory() . '/images/nav/' . comicpress_themeinfo('graphicnav_directory') . '/navstyle.css')) {
			wp_enqueue_style('navstyle',get_stylesheet_directory_uri() . '/images/nav/' . comicpress_themeinfo('graphicnav_directory') . '/navstyle.css');
		} elseif (file_exists(get_template_directory() . '/images/nav/' .comicpress_themeinfo('graphicnav_directory'). '/navstyle.css')) {
			wp_enqueue_style('navstyle',get_template_directory_uri() . '/images/nav/' . comicpress_themeinfo('graphicnav_directory') . '/navstyle.css');
		} else {
			wp_enqueue_style('navstyle',get_template_directory_uri() . '/images/nav/default/navstyle.css');
		}
		if (is_active_widget('comicpress_google_translate_widget', false, 'comicpress_google_translate_widget', true)) {
			wp_enqueue_script('google-translate', 'http://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit', null, null, true);
			wp_enqueue_script('google-translate-settings', get_template_directory_uri() . '/js/googletranslate.js');
		}
		if (is_active_widget('comicpress_jquery_bookmark_widget', false, 'comicpress_jquery_bookmark_widget', true)) {
			wp_enqueue_script('prototype');
			wp_enqueue_script('cookiejar', get_template_directory_uri() . '/js/cookiejar.js', array('prototype'));
			wp_enqueue_script('bookmark', get_template_directory_uri() . '/js/bookmark.js', array('prototype', 'cookiejar'));
		}
		if (is_active_widget('comicpress_facebook_like_widget', false, 'comicpress_facebook_like_widget', true) || comicpress_themeinfo('facebook_like_blog_post') || comicpress_themeinfo('facebook_like_comic_post'))
			wp_enqueue_script('comicpress-facebook', 'http://connect.facebook.net/en_US/all.js#xfbml=1');	// force to the header instead of footer
	}
	
	do_action('comicpress_init');
		
	add_filter('pre_get_posts', 'comicpress_blogpostcount_filter');
	// Set the posts per page on the home page
	function comicpress_blogpostcount_filter($query) {
		if ( $query->is_home() && $query->is_main_query() ) {
			$query->set('posts_per_page', comicpress_themeinfo('blog_postcount'));
		}
		return $query;
	}
	
	add_filter('pre_get_posts', 'comicpress_archive_query');
	// Set the 'order' of the archive and search
	function comicpress_archive_query($query) {
		if ($query->is_archive() || $query->is_search()) {
			$archive_display_order = comicpress_themeinfo('archive_display_order');
			if (empty($archive_display_order)) $archive_display_order = 'DESC';
			$order = '&order='.$archive_display_order;
			$query->set('order', $archive_display_order);
		}
		return $query;		
	}
	
	if (comicpress_themeinfo('remove_wptexturize')) {
		remove_filter('the_content', 'wptexturize');
	}
}

add_action('init', '__comicpress_init');

add_action('wp_head','comicpress_add_head');

function comicpress_add_head() {
	if (is_active_widget('comicpress_jquery_bookmark_widget', false, 'comicpress_jquery_bookmark_widget', true)) { ?>

<script type="text/javascript">
	var image_root = '<?php echo get_template_directory_uri(); ?>/images/';
	var permalink = '<?php the_permalink() ?>';
</script>
<?php }
}

if (!function_exists('is_cp_theme_layout')) {
	function is_cp_theme_layout($choices) {
		$choices = explode(",", $choices);
		foreach ($choices as $choice) {
			if (comicpress_themeinfo('cp_theme_layout') == $choice) {
				return true;
			}
		}
		return false;
	}
}

function is_cp_layout_avail($layout, $avail_layouts) {
	if (empty($layout)) return false;
	if (empty($avail_layouts)) $avail_layouts = '2cr,2cl,2cvr,2cvl,3c,3c2r,3c2l,v3c,v3cr,v3cl,lgn,rgn';
	$avail_layouts = explode(",",$avail_layouts);
	foreach ($avail_layouts as $able_layout) {
		if ($layout == $able_layout) {
			return true;
		}
	}
	return false;
}

if (!function_exists('storyline_category_list')) {
	function storyline_category_list() {
		$listcats = wp_list_categories('echo=0&title_li=&include='.comicpress_all_comic_categories_string());
		$listcats = str_replace("<ul class='children'>", "<ul class='children'> &raquo; ", $listcats);
		echo $listcats;
	}
}

function comicpress_stripslashes($str_to_strip) {
	$str_to_strip = str_replace("\'", "'", $str_to_strip);
	return $str_to_strip;
}

function comicpress_clean_url($filename) {
	return str_replace("%2F", "/", rawurlencode($filename));
}

function comicpress_is_signup() {
	global $wp_query;
	if (strpos( $_SERVER['SCRIPT_NAME'], 'wp-signup.php' ) || strpos( $_SERVER['SCRIPT_NAME'], 'wp-activate.php' )) return true;
	return false;
}

/*
Comic Category Functions
*/

/**
 * Return true if the current post is in the comics category or a child category.
 * if $cat is not empty, check if that $cat is in the comic category return true:false
 */
function comicpress_in_comic_category($cat = null) {
	if (!empty($cat)) { 
		if (!is_array($cat)) $cat = array($cat);
		return (count(array_intersect(comicpress_all_comic_categories_array(), $cat)) > 0);
	}
	if (in_category(comicpress_all_comic_categories_array())) return true;
	return false;
}

/**
 * Parse all categories and sort them into comics and non-comics categories.
 */
function comicpress_create_category_tree() {
	global $category_tree;
	if (empty($category_tree)) {
		$categories_by_id = comicpress_get_comic_category_objects_by_id();	
		if (empty($categories_by_id) || !is_array($categories_by_id)) return false;
		foreach (array_keys($categories_by_id) as $category_id) {
			$category_tree[] = $categories_by_id[$category_id]->parent . '/' . $category_id;
		}
		
		do {
			$all_ok = true;
			for ($i = 0; $i < count($category_tree); ++$i) {
				$current_parts = explode("/", $category_tree[$i]);
				if (reset($current_parts) != 0) {
					
					$all_ok = false;
					for ($j = 0; $j < count($category_tree); ++$j) {
						$j_parts = explode("/", $category_tree[$j]);
						
						if (end($j_parts) == reset($current_parts)) {
							$category_tree[$i] = implode("/", array_merge($j_parts, array_slice($current_parts, 1)));
							break;
						}
					}
				}
			}
		} while (!$all_ok);
		
		$result = comicpress_themeinfo('storyline-category-order');
		if (comicpress_themeinfo('enable-storyline-support')) {
			if (!empty($result)) {
				$category_tree = explode(",", $result);
			}
		} else {
			$new_category_tree = array();
			foreach ($category_tree as $node) {
				$parts = explode("/", $node);
				if ($parts[1] == comicpress_themeinfo('comiccat')) {
					$new_category_tree[] = $node;
				} 
			}
			$category_tree = $new_category_tree;
		}
	}
	return $category_tree;
}

function comicpress_vardump_info() {
	global $vardumpinfo;
	echo '<div class="error">';
	echo $vardumpinfo;
	echo '</div>';
}

// if (is_admin()) add_action( 'admin_notices', 'comicpress_vardump_info' );

function comicpress_create_comic_category_tree() {
	$categories_by_id = comicpress_get_comic_category_objects_by_id();
	foreach (array_keys($categories_by_id) as $category_id) {
		$category_tree[] = $categories_by_id[$category_id]->parent . '/' . $category_id;
	}
	do {
		$all_ok = true;
		for ($i = 0; $i < count($category_tree); ++$i) {
			$current_parts = explode("/", $category_tree[$i]);
			if (reset($current_parts) != 0) {
				
				$all_ok = false;
				for ($j = 0; $j < count($category_tree); ++$j) {
					$j_parts = explode("/", $category_tree[$j]);
					
					if (end($j_parts) == reset($current_parts)) {
						$category_tree[$i] = implode("/", array_merge($j_parts, array_slice($current_parts, 1)));
						break;
					}
				}
			}
		}
	} while (!$all_ok);
	return $category_tree;
}

function comicpress_load_options() {

	$comicpress_options = get_option('comicpress-options');
	if (empty($comicpress_options)) {
		
		foreach (array(
			'disable_comic_frontpage' => false,
			'disable_comic_blog_frontpage' => false,
			'disable_comic_blog_single' => false,
			'enable_comments_when_comic_blog_disabled' => false,
			'disable_blog_frontpage' => false,
			'disable_lrsidebars' => false,
			'disable_footer_text' => false,
			'disable_blogheader' => false,
			'disable_page_titles' => false,
			'static_blog' => false,
			'disable_default_comic_nav' => false,
			'enable_post_thumbnail_rss' => true,

			'cp_theme_layout' => '3c',
			'transcript_in_posts' => false,
			'enable_widgetarea_use_sidebar_css' => false,

			'custom_image_header_width' => '980',
			'custom_image_header_height' => '120',

			'enable_numbered_pagination' => true,

			'enable_related_comics' => false,
			'enable_related_posts' => false,

			'comic_clicks_next' => false,
			'rascal_says' => false,

			'enable_post_calendar' => false,
			'enable_post_author_gravatar' => false,
			'enable_comic_post_calendar' => false,
			'enable_comic_post_author_gravatar' => false,
			'disable_tags_in_posts' => false,
			'disable_categories_in_posts' => false,
			'disable_comment_note' => true,
			'blogposts_with_comic' => false,
			'remove_wptexturize' => false,

			'moods_directory' => 'default',
			'graphicnav_directory' => 'default',
			'calendar_directory' => 'none',
			'avatar_directory' => 'none',

			'enable_search_in_menubar' => false,
			'enable_rss_in_menubar' => true,
			'enable_navigation_in_menubar' => true,
			'disable_jquery_menu_code' => false,
			'disable_default_menubar' => false,

			'archive_display_order' => 'desc',
			'excerpt_or_content_archive' => 'content',
			'excerpt_or_content_search' => 'excerpt',
			'archive_display_comic_thumbs_in_order' => false,
			'display_archive_as_text_links' => true,

			'members_post_category' => '',

			'split_column_in_two' => false,
			'author_column_one' => '',
			'author_column_two' => '',
//			'blog_postcount' => '',

			'enable_buy_print' => false,
			'buy_print_email' => 'yourname@yourpaypalemail.com',
			'buy_print_url' => '/shop/',
			'buy_print_amount' => '25.00',
			'buy_print_sell_original' => false,
			'buy_print_orig_amount' => '65.00',
			'buy_print_text' => '*Additional shipping charges will applied at time of purchase.',

			'enable_comicpress_debug' => true,
			'enable_full_post_check' => false,

			'enable_blogroll_off_links' => false,

			'enable_comment_count_in_rss' => false,
			'enable_scroll_to_top' => true,
			'enable_page_load_info' => false,
			'template-comic-year-all-cats' => true,
			'disable_post_titles' => false,
			'archive_start_latest_year' => false,
			'blogheader_text' => '',
			'enable_comment_javascript' => true,
			'disable_showing_members_category' => true,
			'enable_multicomic_jquery' => false,
			'enable_equal_height_sidebars' => false,
			'prefab_design' => 'none',
			'copyright_name' => '',
			'copyright_url' => '',
			'facebook_like_blog_post' => false,
			'facebook_like_comic_post' => false,
			'facebook_meta' => false,
			'enable_comic_lightbox' => false,
			'cdn_url' => '',
/*			'comiccat' => '1',
			'blogcat' => '3',
			'comic_folder' => 'comics',
			'rss_comic_folder' => 'comics-rss',
			'archive_comic_folder' => 'comics-archive',
			'mini_comic_folder' => 'comics-mini',
			'rss_comic_width' => '240',
			'archive_comic_width' => '420',
			'mini_comic_width' => '198' */
			'enable_page_options' => true,
			'enable_caps' => false,
			'display_first_comic_on_home' => false,
			'display_comments_on_home' => false
		) as $field => $value) {
			$comicpress_options[$field] = $value;
		}

		update_option('comicpress-options', $comicpress_options);
	}
	return $comicpress_options;
}

function comicpress_themeinfo($whichinfo = null) {
	global $comicpress_themeinfo;
	
	if (empty($comicpress_themeinfo) || ($whichinfo == 'reset')) {
		global $comiccat, $blogcat, $comic_folder, $rss_comic_folder, $mini_comic_folder, $archive_comic_folder, 
		$archive_comic_width, $rss_comic_width, $mini_comic_width, $blog_postcount;				
		$comicpress_themeinfo = '';
//		$comicpress_config = comicpress_load_config();
		$comicpress_options = comicpress_load_options();
		$comicpress_coreinfo = wp_upload_dir();
		$comicpress_addinfo = array(
				'upload_path' => get_option('upload_path'),
				'version' => '2.9.4',
				'siteurl' => trailingslashit(get_option('siteurl')),
				'home' => trailingslashit(home_url()),
				'comiccat' => $comiccat,
				'blogcat' => $blogcat,
				'comic_folder' => $comic_folder,
				'rss_comic_folder' => $rss_comic_folder,
				'archive_comic_folder' => $archive_comic_folder,
				'mini_comic_folder' => $mini_comic_folder,
				'archive_comic_width' => $archive_comic_width,
				'rss_comic_width' => $rss_comic_width,
				'mini_comic_width' => $mini_comic_width,
				'blog_postcount' => $blog_postcount,
				'enable-storyline-support' => get_option('comicpress-enable-storyline-support'),
		);
		
		$comicpress_themeinfo = array_merge($comicpress_coreinfo, $comicpress_addinfo);
		$comicpress_themeinfo = array_merge($comicpress_themeinfo, $comicpress_options);

		if ($comicpress_themeinfo['enable-storyline-support']) {
			// This is now sep. to make sure that it only loads when it needs to
			$comicpress_storyline = array(
						'category_tree' => comicpress_create_category_tree(),
						'storyline-category-order' => get_option('comicpress-storyline-category-order')
			);
			$comicpress_themeinfo = array_merge($comicpress_themeinfo, $comicpress_storyline);
		}

		if (is_multisite()) {
			$comicpress_themeinfo['basedir'] = trailingslashit(ABSPATH.$comicpress_themeinfo['upload_path']);
			$comicpress_themeinfo['baseurl'] = trailingslashit($comicpress_themeinfo['siteurl'].'files');
		} else {
			$comicpress_themeinfo['basedir'] = ABSPATH;
			$comicpress_themeinfo['baseurl'] = trailingslashit($comicpress_themeinfo['siteurl']);
		}
		if ($comicpress_themeinfo['cp_theme_layout'] == 'standard') $comicpress_themeinfo['cp_theme_layout'] = '2cr';
		if ($comicpress_themeinfo['cp_theme_layout'] == 'gn') $comicpress_themeinfo['cp_theme_layout'] = 'lgn';
		if ($comicpress_themeinfo['cp_theme_layout'] == 'v') $comicpress_themeinfo['cp_theme_layout'] = '2cvl';		
	}
	if ($whichinfo && $whichinfo !== 'reset')
		if (isset($comicpress_themeinfo[$whichinfo])) 
			return $comicpress_themeinfo[$whichinfo];
		else
			return false;
	return $comicpress_themeinfo;
}

function comicpress_get_comic_category_objects_by_id() {
	global $categories_by_id;
	if (empty($categories_by_id)) {
		$categories_by_id = array();
		foreach (get_categories("hide_empty=0") as $category_object) {
			if (array_intersect(comicpress_all_comic_categories_array(), array($category_object->term_id))) {
				$categories_by_id[$category_object->term_id] = $category_object;
			}
		}
	}
	return $categories_by_id;
}

// This uses the comicpress_load_config() because it's not yet triggered in themeinfo
function comicpress_all_comic_categories_array() {
	global $comicpress_all_comic_categories_array;
	if (empty($comicpress_all_comic_categories_array)) {
		$comicpress_all_comic_categories_array[] = comicpress_themeinfo('comiccat');
		foreach (get_all_category_ids() as $cats) {
			if (cat_is_ancestor_of(comicpress_themeinfo('comiccat'), $cats)) {
				$comicpress_all_comic_categories_array[] = $cats;
			}
		}
	}
	return $comicpress_all_comic_categories_array;
}

function comicpress_all_blog_categories_array() {
	global $comicpress_all_blog_categories_array;
	if (empty($comicpress_all_blog_categories_array))
		$comicpress_all_blog_categories_array = array_diff(get_all_category_ids(), comicpress_all_comic_categories_array());
	return $comicpress_all_blog_categories_array;
}

function comicpress_all_blog_categories_array_and() {
	global $comicpress_all_blog_categories_array_and;
	if (empty($comicpress_all_blog_categories_array_and)) {
		$comicpress_all_blog_categories_array_and = array_diff(get_all_category_ids(), comicpress_all_comic_categories_array());
		$comicpress_all_blog_categories_array_and = implode(" and ", $comicpress_all_blog_categories_array_and);
	}
	return $comicpress_all_blog_categories_array_and;
}

function comicpress_all_blog_categories_string() {
	global $comicpress_all_blog_categories_string;
	if (empty($comicpress_all_blog_categories_string))
		$comicpress_all_blog_categories_string = implode(',', comicpress_all_blog_categories_array());
	return $comicpress_all_blog_categories_string;
}

function comicpress_all_comic_categories_string() {
	global $comicpress_all_comic_categories_string;
	if (empty($comicpress_all_comic_categories_string))
		$comicpress_all_comic_categories_string = implode(',', comicpress_all_comic_categories_array());
	return $comicpress_all_comic_categories_string;
}

function comicpress_get_all_categories_string() {
	global $comicpress_all_categories_string;
	if (empty($comicpress_all_categories_string))
		$comicpress_all_categories_string = implode(',',get_all_category_ids());
	return $comicpress_all_categories_string;
}

function comicpress_exclude_comic_categories() {
	global $comicpress_exclude_comic_categories;
	if (empty($comicpress_exclude_comic_categories))
		$comicpress_exclude_comic_categories = '-'.str_replace(",",",-",comicpress_all_comic_categories_string());
	return $comicpress_exclude_comic_categories;
}

/**
 * Given a category ID or an array of category IDs, create an exclusion string that will
 * filter out every category but the provided ones.
 */
function comicpress_get_string_to_exclude_all_but_provided_categories($category) {
	$category_ids = get_all_category_ids();
	if (!is_array($category)) { $category = array($category); }
	return implode(" and ", array_diff($category_ids, $category));
}

function comicpress_disable_sidebars() {
	global $post;
	if (comicpress_is_signup() || comicpress_themeinfo('disable_lrsidebars')) return true;
	if (is_page() && !empty($post)) {
		$sidebars_disabled = get_post_meta($post->ID, 'disable-sidebars', true);
		if ($sidebars_disabled) return true;
	}
	return false;
}

add_filter('previous_post_rel_link', 'comicpress_rel_link_removal'); 
add_filter('next_post_rel_link', 'comicpress_rel_link_removal');

if (!function_exists('comicpress_rel_link_removal')) {
	function comicpress_rel_link_removal($link) {
		global $post, $wp_query;
		if (is_single() && !is_attachment()) {
			if (comicpress_in_comic_category()) $link=false;
		}
		return $link;
	}
}

?>
