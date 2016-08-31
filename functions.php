<?php
add_action('after_setup_theme', 'comicpress_setup');
add_action('wp_enqueue_scripts', 'comicpress_enqueue_theme_scripts');
add_action('widgets_init', 'comicpress_register_sidebars');
add_filter('excerpt_length', 'comicpress_excerpt_length');
if (comicpress_themeinfo('enable_debug_footer_code'))
	add_action('comicpress-page-foot', 'comicpress_debug_page_foot_code');
add_filter('excerpt_more', 'comicpress_auto_excerpt_more');
if (comicpress_themeinfo('force_active_connection_close')) 
	add_action('shutdown_action_hook','comicpress_close_up_shop');
if (comicpress_themeinfo('menubar_social_icons')) 
	add_action('comicpress-menubar-menunav', 'comicpress_display_social_icons');

if (!is_admin())
	add_action('init', 'comicpress_init');

if (class_exists('MultiPostThumbnails')) {
	new MultiPostThumbnails(
		array(
			'label' => 'Secondary Image',
			'id' => 'secondary-image',
			'post_type' => 'comic'
			));
	add_image_size('secondary-image');
}

// These autoload
foreach (glob(get_template_directory() . '/functions/*.php') as $funcfile) {
	get_template_part('functions/'.basename($funcfile,'.php'));
}

// Load all the widgets.
foreach (glob(get_template_directory()  . '/widgets/*.php') as $widgefile) {
	get_template_part('widgets/'.basename($widgefile,'.php'));
}

function comicpress_setup() {
	load_theme_textdomain('comicpress', get_template_directory().'/lang');
// 	add_editor_style();
	add_theme_support('automatic-feed-links');
	add_theme_support(
		'post-formats', 
		array(
//			'image',
//			'video',
//			'quote',
//			'status',
			'link',
			'aside'
			)
		);
	register_nav_menus(array(
		'Primary' => __( 'Primary', 'comicpress' ),
		'Footer' => __( 'Footer', 'comicpress' )
	));
	add_theme_support('custom-background');
	add_theme_support('post-thumbnails');
	add_theme_support('title-tag');
	add_theme_support('woocommerce'); // PMH
}

function comicpress_enqueue_theme_scripts() {
	global $is_IE, $wp_styles;
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) && !comicpress_themeinfo('disable_comment_javascript')) wp_enqueue_script('comment-reply');
	if (!is_admin()) {
		wp_enqueue_script('jquery');
		if (!comicpress_themeinfo('disable_jquery_menu_code')) {
			wp_enqueue_script('ddsmoothmenu_js', get_template_directory_uri().'/js/ddsmoothmenu.js');
			wp_enqueue_script('menubar_js', get_template_directory_uri().'/js/menubar.js');
		}
		if (!comicpress_themeinfo('disable_scroll_to_top')) {
			wp_enqueue_script('comicpress_scroll', get_template_directory_uri().'/js/scroll.js', null, null, true);
		}
		if (comicpress_themeinfo('enable_avatar_trick') && !$is_IE) {
			wp_enqueue_script('themetricks_historic1', get_template_directory_uri().'/js/cvi_text_lib.js', null, null, true);
			wp_enqueue_script('themetricks_historic2', get_template_directory_uri().'/js/instant.js', null, null, true);
		}
	}
}

function comicpress_init() {
	add_action('pre_get_posts', 'comicpress_pre_parser', 1, 1);
}

function comicpress_pre_parser($query) {
	if ( $query->is_home() && $query->is_main_query()) {
//		$query->set('category__in', '8');
		$query->set('posts_per_page', comicpress_themeinfo('home_post_count'));
	}
	if (($query->is_archive() || $query->is_search() || is_post_type_archive())  && !$query->is_feed() && $query->is_main_query()) {
		$archive_display_order = comicpress_themeinfo('archive_display_order');
		if (empty($archive_display_order)) $archive_display_order = 'desc';
		$query->set('order', $archive_display_order);
	}
	if ($query->is_author() && $query->is_main_query()) {
		$query->set('nopaging', true);
	}
}

if (!function_exists('comicpress_register_sidebars')) {
	function comicpress_register_sidebars() {
		$widgets_list = array(
			array('id' => 'left-sidebar', 'name' => __( 'Left Sidebar', 'comicpress' ), 'description' => __( 'The sidebar that appears to the left of the content.', 'comicpress' )),
			array('id' => 'right-sidebar', 'name' => __( 'Right Sidebar', 'comicpress' ), 'description' => __( 'The sidebar that appears to the right of the content.', 'comicpress' )),
			array('id' => 'above-header', 'name' => __( 'Above Header', 'comicpress' ), 'description' => __( 'This sidebar appears to above all of the site information.  This sidebar is not encased in CSS, you will need to create CSS for it.', 'comicpress' )),
			array('id' => 'header', 'name' => __( 'Header', 'comicpress' ), 'description' => __( 'This sidebar appears inside the #header block.', 'comicpress' )),
			array('id' => 'menubar', 'name' => __( 'Menubar', 'comicpress' ), 'description' => __( 'This sidebar is under the header and above the content-wrapper block', 'comicpress' )),
			array('id' => 'over-blog', 'name' => __( 'Over Blog', 'comicpress' ), 'description' => __( 'This sidebar appears over the blog within the #column .narrowcolumn', 'comicpress' )),
			array('id' => 'under-blog', 'name' => __( 'Under Blog', 'comicpress' ), 'description' => __( 'This sidebar appears under the blog within the #column .narrowocolumn', 'comicpress' )),
			array('id' => 'footer', 'name' => __( 'Footer', 'comicpress' ), 'description' => __( 'This sidebar is at the bottom of the page and is the center of the 3 footer sidebars.', 'comicpress' )),
			array('id' => 'footer-left', 'name' => __( 'Footer Left', 'comicpress' ), 'description' => __( 'This sidebar is at the bottom of the page, the left one.', 'comicpress' )),
			array('id' => 'footer-right', 'name' => __( 'Footer Right', 'comicpress' ), 'description' => __( 'This sidebar is at the bottom of the page, the right one.', 'comicpress' )),
		);
		if (class_exists('Jetpack') && Jetpack::init()->is_module_active('minileven')) { 
			$widgets_list[] = array('id' => '1', 'name' => __( 'Jetpack Mobile Sidebar', 'comicpress' ), 'description' => __( 'Jetpack Mobile Sidebar', 'comicpress' ));
		}
		foreach ($widgets_list as $widget_info) {
			register_sidebar(array(
						'name'=> $widget_info['name'],
						'id' => 'sidebar-'.sanitize_title($widget_info['id']),
						'description' => $widget_info['description'],
						'before_widget' => "<div id=\"".'%1$s'."\" class=\"widget ".'%2$s'."\">\r\n<div class=\"widget-content\">\r\n",
						'after_widget'  => "</div>\r\n<div class=\"clear\"></div>\r\n</div>\r\n",
						'before_title'  => "<h2 class=\"widget-title\">",
						'after_title'   => "</h2>\r\n"
						));
		}
	}
}

function comicpress_get_sidebar($location = '') {
	if (empty($location)) return;
	if (file_exists(get_template_directory().'/sidebar-'.$location.'.php') || file_exists(get_stylesheet_directory().'/sidebar-'.$location.'.php')) {
		get_sidebar($location);
	} elseif (is_active_sidebar('sidebar-'.$location)) { ?>
		<div id="sidebar-<?php echo $location; ?>" class="sidebar">
			<?php dynamic_sidebar('sidebar-'.$location); ?>
			<div class="clear"></div>
		</div>
	<?php }
}

function comicpress_is_signup() {
	global $wp_query;
	if (strpos( $_SERVER['SCRIPT_NAME'], 'wp-signup.php' ) || strpos( $_SERVER['SCRIPT_NAME'], 'wp-activate.php' )) return true;
	return false;
}

function comicpress_debug_page_foot_code() { ?>
	<p><?php echo get_num_queries() ?> queries. <?php if (function_exists('memory_get_usage')) { $unit=array('b','kb','mb','gb','tb','pb'); echo @round(memory_get_usage(true)/pow(1024,($i=floor(log(memory_get_usage(true),1024)))),2).' '.$unit[$i]; ?> Memory usage. <?php } timer_stop(1) ?> seconds.</p>
<?php }

function comicpress_excerpt_length($length) {
	return comicpress_themeinfo('excerpt_length');
}

if (!function_exists('comicpress_auto_excerpt_more')) {
	function comicpress_auto_excerpt_more( $more ) {
		return __( '[&hellip;]', 'comicpress' ) . '<a class="more-link" href="'. get_permalink() . '">' . __( '&darr; Read the rest of this entry...', 'comicpress' ) . '</a>';
	}
}

function comicpress_close_up_shop() {
	@mysql_close();
}

if (!function_exists('comicpress_is_layout')) {
	function comicpress_is_layout($choices) {
		$choices = explode(",", $choices);
		if (in_array(get_theme_mod('comicpress-customize-select-layout', '3c'), $choices)) return true;
		return false;
	}
}

function comicpress_is_bbpress() {
	if (function_exists('bbp_is_single_forum') &&
			(bbp_is_forum()
				|| bbp_is_forum_archive()
				|| bbp_is_topic_archive()
				|| bbp_is_single_forum() 
				|| bbp_is_single_topic()
				|| bbp_is_topic()
				|| bbp_is_topic_edit()
				|| bbp_is_topic_merge()
				|| bbp_is_topic_split()
				|| bbp_is_single_reply()
				|| bbp_is_reply_edit()
				|| bbp_is_reply_edit()
				|| bbp_is_single_view()
				|| bbp_is_single_user_edit()
				|| bbp_is_single_user()
				|| bbp_is_user_home()
				|| bbp_is_subscriptions()
				|| bbp_is_favorites()
				|| bbp_is_topics_created()))
		return true;
	return false;
}

function comicpress_sidebars_disabled() {
	global $wp_query, $post;
	if (!empty($post) && (is_single() || is_page()) && !is_404()) {
		$sidebars_disabled = get_post_meta($post->ID, 'disable-sidebars', true);
		if ($sidebars_disabled) return true;
	}
//		if (comicpress_is_bbpress()) return true;
	return false;
}

global $content_width;
if (!isset($content_width)) {
	$content_width = comicpress_themeinfo('content_width');
	if (!$content_width) $content_width = 500;
}

if (!function_exists('comicpress_display_social_icons')) {
	function comicpress_display_social_icons() {
		$twitter = comicpress_themeinfo('menubar_social_twitter');
		$facebook = comicpress_themeinfo('menubar_social_facebook');
		$googleplus = comicpress_themeinfo('menubar_social_googleplus');
		$linkedin = comicpress_themeinfo('menubar_social_linkedin');
		$pinterest = comicpress_themeinfo('menubar_social_pinterest');
		$youtube = comicpress_themeinfo('menubar_social_youtube');
		$flickr = comicpress_themeinfo('menubar_social_flickr');
		$tumblr = comicpress_themeinfo('menubar_social_tumblr');
		$deviantart = comicpress_themeinfo('menubar_social_deviantart');
		$myspace = comicpress_themeinfo('menubar_social_myspace');
		$email = comicpress_themeinfo('menubar_social_email');
		$output = '<div class="menunav-social-wrapper">';
		if (!empty($deviantart)) $output .= '<a href="'.$deviantart.'" target="_blank" title="'.__( 'my DeviantART', 'comicpress' ).'" class="menunav-social menunav-deviantart">'.__( 'DeviantART', 'comicpress' ).'</a>'."\r\n";
		if (!empty($tumblr)) $output .= '<a href="'.$tumblr.'" target="_blank" title="'.__( 'Examine my Tumblr', 'comicpress' ).'" class="menunav-social menunav-tumblr">'.__( 'Tumblr', 'comicpress' ).'</a>'."\r\n";
		if (!empty($facebook)) $output .= '<a href="'.$facebook.'" target="_blank" title="'.__( 'Friend on Facebook', 'comicpress' ).'" class="menunav-social menunav-facebook">'.__( 'Facebook', 'comicpress' ).'</a>'."\r\n";
		if (!empty($myspace)) $output .= '<a href="'.$myspace.'" target="_blank" title="'.__( 'Make use of MySpace', 'comicpress' ).'" class="menunav-social menunav-myspace">'.__( 'MySpace', 'comicpress' ).'</a>'."\r\n";
		if (!empty($linkedin)) $output .= '<a href="'.$linkedin.'" target="_blank" title="'.__( 'Look at my LinkedIn', 'comicpress' ).'" class="menunav-social menunav-linkedin">'.__( 'LinkedIn', 'comicpress' ).'</a>'."\r\n";
		if (!empty($twitter)) $output .= '<a href="'.$twitter.'" target="_blank" title="'.__( 'Follow me on Twitter', 'comicpress' ).'" class="menunav-social menunav-twitter">'.__( 'Twitter', 'comicpress' ).'</a>'."\r\n";
		if (!empty($flickr)) $output .= '<a href="'.$flickr.'" target="_blank" title="'.__( 'Gaze at my Flickr', 'comicpress' ).'" class="menunav-social menunav-flickr">'.__( 'Flickr', 'comicpress' ).'</a>'."\r\n";		
		if (!empty($email)) $output .= '<a href="'.$email.'" target="_blank" title="'.__( 'Email me', 'comicpress' ).'" class="menunav-social menunav-email">'.__( 'Email', 'comicpress' ).'</a>'."\r\n";
		if (!empty($googleplus)) $output .= '<a href="'.$googleplus.'" target="_blank" title="'.__( 'Circle me on Google+', 'comicpress' ).'" class="menunav-social menunav-googleplus">'.__( 'Google+', 'comicpress' ).'</a>'."\r\n";
		if (!empty($pinterest)) $output .= '<a href="'.$pinterest.'" target="_blank" title="'.__( 'Peruse my Pinterests', 'comicpress' ).'" class="menunav-social menunav-pinterest">'.__( 'pinterest', 'comicpress' ).'</a>'."\r\n";
		if (!empty($youtube)) $output .= '<a href="'.$youtube.'" target="_blank" title="'.__( 'My Channel on YouTube', 'comicpress' ).'" class="menunav-social menunav-youtube">'.__( 'YouTube', 'comicpress' ).'</a>'."\r\n";
		if (comicpress_themeinfo('enable_rss_in_menubar')) $output .= '<a href="'.get_bloginfo('rss2_url').'" target="_blank" title="'.__( 'RSS Feed', 'comicpress' ).'" class="menunav-social menunav-rss2">'.__( 'RSS', 'comicpress' ).'</a>'."\r\n";
		$output .= '<div class="clear"></div>';
		$output .= '</div>'."\r\n";
		echo $output;
	}
}

/**
 * This is function ceo_clean_filename
 *
 * @param string $filename the BASE filename
 * @return string returns the rawurlencoded filename with the %2F put back to /
 */
function comicpress_clean_filename($filename) {
	return str_replace("%2F", "/", rawurlencode($filename));
}

function comicpress_infinite_scroll_loop() {
	while (have_posts()) : the_post();
		comicpress_display_post();
	endwhile;
}

/**
 * function load default settings
 */
function comicpress_load_options() {

	$comicpress_options = get_option('cp-options');
	if (empty($comicpress_options)) {
		
		foreach (array(
				// General
				'home_post_count' => '5',
				'disable_blog_on_homepage' => false,
				'add_pw_async_code_to_head' => false,
				'over-blog-sidebar-all-posts' => false,
				// WordPress Content Width that sets video and image size within posts
				'content_width' => 500,
				'content_width_disabled_sidebars' => 700,
				// Pages
				'disable_page_titles' => false,
				// Posts
				'disable_post_titles' => false,
				'enable_post_calendar' => false,
				'enable_post_author_gravatar' => false,
				'enable_avatar_trick' => true,
				'disable_tags_in_posts' => false,
				'disable_categories_in_posts' => false,
				'disable_author_info_in_posts' => false,
				'disable_date_info_in_posts' => false,
				'disable_posted_at_time_in_posts' => false,
				'enable_last_modified_in_posts' => false,
				'moods_directory' => 'none',
				// Comments
				'disable_comment_note' => true,
				'disable_comment_javascript' => false,
				'enable_comments_on_homepage' => false,
				'avatar_directory' => 'none',
				// Pagination
				'enable_numbered_pagination' => true,
				// Footer
				'disable_footer_text' => false,
				'disable_scroll_to_top' => false,
				'copyright_name' => '',
				'copyright_url' => '',
				// RSS
				'enable_post_thumbnail_rss' => true,
				// Archive & Search
				'display_archive_as_links' => false,
				'excerpt_or_content_in_archive' => 'excerpt',
				'archive_display_order' => 'DESC',
				// Menubar
				'disable_default_menubar' => false,
				'enable_search_in_menubar' => false,
				'enable_rss_in_menubar' => true,
				'disable_jquery_menu_code' => false,
				'enable_breadcrumbs' => false,
				// Menubar - Social Icons
				'menubar_social_icons' => false,
				'menubar_social_twitter' => '',
				'menubar_social_facebook' => '',
				'menubar_social_googleplus' => '',
				'menubar_social_linkedin' => '',
				'menubar_social_pinterest' => '',
				'menubar_social_youtube' => '',
				'menubar_social_flickr' => '',
				'menubar_social_tumblr' => '',
				'menubar_social_deviantart' => '',
				'menubar_social_myspace' => '',
				'menubar_social_email' => '',
				// Debug
				'enable_debug_footer_code' => false,
				'force_active_connection_close' => false,
				// Jetpack
				'enable_jetpack_infinite_scrolling' => false
		) as $field => $value) {
			$comicpress_options[$field] = $value;
		}
//		update_option('cp-options', $comicpress_options);
//		Cannot save to the database unless you click the save button in options
	}
	return $comicpress_options;
}

function comicpress_themeinfo($whichinfo = null) {
	global $comicpress_themeinfo;
	if (empty($comicpress_themeinfo) || $whichinfo == 'reset') {
		$comicpress_themeinfo = array();
		$comicpress_options = comicpress_load_options();
		$comicpress_addinfo = array(
			'version' => '4.4',
			'excerpt_length' => '40'
		);
		$comicpress_themeinfo = array_merge($comicpress_themeinfo, $comicpress_addinfo);
		$comicpress_themeinfo = array_merge($comicpress_themeinfo, $comicpress_options);
	}
	if ($whichinfo && $whichinfo !== 'reset')
		if (isset($comicpress_themeinfo[$whichinfo])) 
			return $comicpress_themeinfo[$whichinfo];
		else
			return false;
	return $comicpress_themeinfo;
}

// Dashboard Menu Options - Only run in the wp-admin area
if (is_admin()) {
	@require_once(get_template_directory().'/options.php');
	/* translators: theme discription for wp-admin */
	$bogus_translation = __( 'Publish a WebComic with the ComicPress theme and the Comic Easel plugin.', 'comicpress' );
}
