<?php
add_action('after_setup_theme', 'comicpress_setup');
add_action('wp_enqueue_scripts', 'comicpress_enqueue_theme_scripts');
add_action('widgets_init', 'comicpress_register_sidebars');
add_filter('wp_title', 'comicpress_filter_wp_title');
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
foreach (glob(comicpress_themeinfo('themepath') . '/functions/*.php') as $funcfile) {
	@require_once($funcfile);
}

// Load all the widgets.
foreach (glob(comicpress_themeinfo('themepath')  . '/widgets/*.php') as $widgefile) {
	@require_once($widgefile);
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
		'Primary' => __('Primary', 'comicpress'),
		'Footer' => __('Footer', 'comicpress')
	));
	$args = array(
			'default-color' => '1C2C5B',
			'default-image' => get_template_directory_uri() . '/images/background.jpg'
		);
	add_theme_support('custom-background', $args);
	add_theme_support('post-thumbnails');
	add_theme_support( 'woocommerce' ); // PMH
}

function comicpress_enqueue_theme_scripts() {
	global $is_IE, $wp_styles;
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) && !comicpress_themeinfo('disable_comment_javascript')) wp_enqueue_script('comment-reply');
	if (!is_admin()) {
		wp_enqueue_script('jquery');
		if (!comicpress_themeinfo('disable_jquery_menu_code')) {
			wp_enqueue_script('ddsmoothmenu_js', comicpress_themeinfo('themeurl').'/js/ddsmoothmenu.js'); 
			wp_enqueue_script('menubar_js', comicpress_themeinfo('themeurl').'/js/menubar.js');
		}
		if (!comicpress_themeinfo('disable_scroll_to_top')) {
			wp_enqueue_script('comicpress_scroll', comicpress_themeinfo('themeurl').'/js/scroll.js', null, null, true);
		}
		if (is_active_widget('comicpress_google_translate_widget', false, 'comicpress_google_translate_widget', true)) {
			wp_enqueue_script('google-translate', 'http://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit', null, null, true);
			wp_enqueue_script('google-translate-settings', get_template_directory_uri() . '/js/googletranslate.js');
		}
		if (comicpress_themeinfo('enable_avatar_trick') && !$is_IE) {
			wp_enqueue_script('themetricks_historic1', comicpress_themeinfo('themeurl').'/js/cvi_text_lib.js', null, null, true);
			wp_enqueue_script('themetricks_historic2', comicpress_themeinfo('themeurl').'/js/instant.js', null, null, true);
		}
		if (comicpress_themeinfo('facebook_like_blog_post'))
			wp_enqueue_script('comicpress-facebook', 'http://connect.facebook.net/en_US/all.js#xfbml=1'); // force to the header instead of footer
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
			array('id' => 'left-sidebar', 'name' => __('Left Sidebar', 'comicpress'), 'description' => __('The sidebar that appears to the left of the content.','comicpress')),
			array('id' => 'right-sidebar', 'name' => __('Right Sidebar', 'comicpress'), 'description' => __('The sidebar that appears to the right of the content.','comicpress')),
			array('id' => 'above-header', 'name' => __('Above Header', 'comicpress'), 'description' => __('This sidebar appears to above all of the site information.  This sidebar is not encased in CSS, you will need to create CSS for it.','comicpress')),
			array('id' => 'header', 'name' => __('Header', 'comicpress'), 'description' => __('This sidebar appears inside the #header block.','comicpress')),
			array('id' => 'menubar', 'name' => __('Menubar', 'comicpress'), 'description' => __('This sidebar is under the header and above the content-wrapper block','comicpress')),
			array('id' => 'over-blog', 'name' => __('Over Blog', 'comicpress'), 'description' => __('This sidebar appears over the blog within the #column .narrowcolumn','comicpress')),
			array('id' => 'under-blog', 'name' => __('Under Blog', 'comicpress'), 'description' => __('This sidebar appears under the blog within the #column .narrowocolumn','comicpress')),
			array('id' => 'footer', 'name' => __('Footer', 'comicpress'), 'description' => __('This sidebar is at the bottom of the page and is the center of the 3 footer sidebars.','comicpress')),
			array('id' => 'footer-left', 'name' => __('Footer Left', 'comicpress'), 'description' => __('This sidebar is at the bottom of the page, the left one.','comicpress')),
			array('id' => 'footer-right', 'name' => __('Footer Right', 'comicpress'), 'description' => __('This sidebar is at the bottom of the page, the right one.','comicpress')),
		);
		if (class_exists('Jetpack') && Jetpack::init()->is_module_active('minileven')) { 
			$widgets_list[] = array('id' => '1', 'name' => __('Jetpack Mobile Sidebar', 'comicpress'), 'description' => __('Jetpack Mobile Sidebar','comicpress'));
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
		return __(' [&hellip;]','comicpress') . ' <a class="more-link" href="'. get_permalink() . '">' . __('&darr; Read the rest of this entry...','comicpress') . '</a>';
	}
}

function comicpress_close_up_shop() {
	@mysql_close();
}

if (!function_exists('comicpress_is_layout')) {
	function comicpress_is_layout($choices) {
		$choices = explode(",", $choices);
		if (in_array(comicpress_themeinfo('layout'), $choices)) return true;
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
		if (!empty($deviantart)) $output .= '<a href="'.$deviantart.'" target="_blank" title="'.__(' my DeviantART','comicpress').'" class="menunav-social menunav-deviantart">'.__('DeviantART','comicpress').'</a>'."\r\n";
		if (!empty($tumblr)) $output .= '<a href="'.$tumblr.'" target="_blank" title="'.__('Examine my Tumblr','comicpress').'" class="menunav-social menunav-tumblr">'.__('Tumblr','comicpress').'</a>'."\r\n";
		if (!empty($facebook)) $output .= '<a href="'.$facebook.'" target="_blank" title="'.__('Friend on Facebook','comicpress').'" class="menunav-social menunav-facebook">'.__('Facebook','comicpress').'</a>'."\r\n";
		if (!empty($myspace)) $output .= '<a href="'.$myspace.'" target="_blank" title="'.__('Make use of MySpace','comicpress').'" class="menunav-social menunav-myspace">'.__('MySpace','comicpress').'</a>'."\r\n";		
		if (!empty($linkedin)) $output .= '<a href="'.$linkedin.'" target="_blank" title="'.__('Look at my LinkedIn','comicpress').'" class="menunav-social menunav-linkedin">'.__('LinkedIn','comicpress').'</a>'."\r\n";
		if (!empty($twitter)) $output .= '<a href="'.$twitter.'" target="_blank" title="'.__('Follow me on Twitter','comicpress').'" class="menunav-social menunav-twitter">'.__('Twitter','comicpress').'</a>'."\r\n";
		if (!empty($flickr)) $output .= '<a href="'.$flickr.'" target="_blank" title="'.__('Gaze at my Flickr','comicpress').'" class="menunav-social menunav-flickr">'.__('Flickr','comicpress').'</a>'."\r\n";		
		if (!empty($email)) $output .= '<a href="'.$email.'" target="_blank" title="'.__('Email me','comicpress').'" class="menunav-social menunav-email">'.__('Email','comicpress').'</a>'."\r\n";
		if (!empty($googleplus)) $output .= '<a href="'.$googleplus.'" target="_blank" title="'.__('Circle me on Google+','comicpress').'" class="menunav-social menunav-googleplus">'.__('Google+','comicpress').'</a>'."\r\n";
		if (!empty($pinterest)) $output .= '<a href="'.$pinterest.'" target="_blank" title="'.__('Peruse my Pinterests','comicpress').'" class="menunav-social menunav-pinterest">'.__('pinterest','comicpress').'</a>'."\r\n";
		if (!empty($youtube)) $output .= '<a href="'.$youtube.'" target="_blank" title="'.__('My Channel on YouTube','comicpress').'" class="menunav-social menunav-youtube">'.__('YouTube','comicpress').'</a>'."\r\n";
		if (comicpress_themeinfo('enable_rss_in_menubar')) $output .= '<a href="'.get_bloginfo('rss2_url').'" target="_blank" title="'.__('RSS Feed','comicpress').'" class="menunav-social menunav-rss2">'.__('RSS','comicpress').'</a>'."\r\n";
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
 *
 */
function comicpress_clean_filename($filename) {
	return str_replace("%2F", "/", rawurlencode($filename));
}

function comicpress_filter_wp_title( $title ) {
	global $wp_query, $s, $paged, $page;
	if (!is_feed()) {
		$sep = __('&raquo;','comicpress');
		$new_title = get_bloginfo('name').' ';
		$bloginfo_description = get_bloginfo('description');	
		if ((is_home () || is_front_page()) && !empty($bloginfo_description) && !$paged && !$page) {
			$new_title .= $sep.' '.$bloginfo_description;
		} elseif (is_single() || is_page()) { 
			$new_title .= $sep.' '.single_post_title('', false);		
		} elseif (is_search() ) { 
			$new_title .= $sep.' '.sprintf(__('Search Results: %s','comicpress'), esc_html($s));
		} else
			$new_title .= $title;
		if ( $paged || $page ) {
			$new_title .= ' '.$sep.' '.sprintf(__('Page: %s','comicpress'),max( $paged, $page ));
		}
		$title = $new_title;
	}
    return $title;
}

function comicpress_infinite_scroll_loop() {
	while (have_posts()) : the_post();
		comicpress_display_post();
	endwhile;
}

function comicpress_load_options() {

	$comicpress_options = get_option('cp-options');
	if (empty($comicpress_options)) {
		
		foreach (array(
			'disable_jquery_menu_code' => false,
			'disable_scroll_to_top' => false,
			'enable_avatar_trick' => true,
			'disable_default_design' => false,
			'disable_comment_note' => true,
			'enable_numbered_pagination' => true,
			'disable_comment_javascript' => false,
			'enable_post_thumbnail_rss' => true,
			'disable_page_titles' => false,
			'disable_post_titles' => false,			
			'enable_post_calendar' => true,
			'enable_post_author_gravatar' => false,
			'disable_categories_in_posts' => false,
			'disable_tags_in_posts' => false,
			'disable_author_info_in_posts' => false,
			'disable_date_info_in_posts' => false,
			'home_post_count' => '5',
			'disable_footer_text' => false,
			'disable_default_menubar' => false,
			'enable_search_in_menubar' => false,
			'enable_rss_in_menubar' => true,
			'avatar_directory' => 'none',
			'enable_debug_footer_code' => false,
			'disable_blog_on_homepage' => false,
			'enable_comments_on_homepage' => false,
			'custom_image_header_width' => '980',
			'custom_image_header_height' => '100',
			'copyright_name' => '',
			'copyright_url' => '',
			'facebook_like_blog_post' => false,
			'facebook_meta' => false,
			'display_archive_as_links' => false,
			'archive_display_order' => 'DESC',
			'layout' => '3c',
			'first_run' => true, /* no longer used */
			'force_active_connection_close' => false,
			'removed_option' => true,
			'menubar_social_icons' => false,
			'menubar_social_twitter' => '',
			'menubar_social_facebook' => '',
			'enable_breadcrumbs' => false,
			'excerpt_or_content_in_archive' => 'excerpt',
			'enable_last_modified_in_posts' => false,
			'disable_posted_at_time_in_posts' => false,
			'menubar_social_googleplus' => '',
			'menubar_social_linkedin' => '',
			'menubar_social_pinterest' => '',
			'menubar_social_youtube' => '',
			'menubar_social_flickr' => '',
			'menubar_social_tumblr' => '',
			'menubar_social_deviantart' => '',
			'menubar_social_myspace' => '',
			'menubar_social_email' => '',
			'enable_jetpack_infinite_scrolling' => false,
			'content_width' => 500,
			'content_width_disabled_sidebars' => 700,
			'add_pw_async_code_to_head' => false,
			'over-blog-sidebar-all-posts' => false
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
		$comicpress_coreinfo = wp_upload_dir();
		$comicpress_addinfo = array(
			'upload_path' => get_option('upload_path'),
			'version' => '4.2.1',
			'themepath' => get_template_directory(),
			'themeurl' => get_template_directory_uri(), 
			'stylepath' => get_stylesheet_directory(), 
			'styleurl' => get_stylesheet_directory_uri(),
			'uploadpath' => $comicpress_coreinfo['basedir'],
			'uploadurl' => $comicpress_coreinfo['baseurl'],
			'home' => untrailingslashit(home_url()),  
			'siteurl' => untrailingslashit(site_url()),
			'excerpt_length' => '40'
		);
		$comicpress_themeinfo = array_merge($comicpress_coreinfo, $comicpress_addinfo);
		$comicpress_themeinfo = array_merge($comicpress_themeinfo, $comicpress_options);
		if (!isset($comicpress_themeinfo['layout']) || empty($comicpress_themeinfo['layout']) || ($comicpress_themeinfo['layout'] == 'standard')) $comicpress_themeinfo['layout'] = '3c';
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
	@require_once(comicpress_themeinfo('themepath').'/options.php');
	// This line is here so the description in the style.css get's translated
	$bogus_translation = __('Publish a WebComic with the ComicPress theme and the Comic Easel plugin.','comicpress');
}
