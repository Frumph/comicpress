<?php

add_action('admin_menu', 'comicpress_options_setup');

function comicpress_options_setup() {
	$options_title = __('ComicPress Options','comicpress');
	$admin_title = __('ComicPress Options', 'comicpress');
	$pagehook = add_theme_page($admin_title, $admin_title, 'edit_theme_options', 'comicpress-options', 'comicpress_admin_options');
	add_action('admin_head-' . $pagehook, 'comicpress_admin_page_head');
	add_action('admin_print_scripts-' . $pagehook, 'comicpress_admin_print_scripts');
	add_action('admin_print_styles-' . $pagehook, 'comicpress_admin_print_styles');
}

function comicpress_admin_print_scripts() {
	wp_enqueue_script('utils');
	wp_enqueue_script('jquery');
}

function comicpress_admin_print_styles() {
	wp_admin_css('css/global');
	wp_admin_css('css/colors');
	wp_admin_css('css/ie');
	wp_enqueue_style('comicpress-options-style', get_template_directory_uri() . '/options/options.css');
}

function comicpress_admin_page_head() { ?>
	<!--[if lt ie 8]> <style> div.show { position: static; margin-top: 1px; } #cpadmin div.off { height: 22px; } </style> <![endif]-->
<?php }


function comicpress_admin_options() {
	$comicpress_options = get_option('comicpress-options');
?>

<div class="wrap">
	<div id="cpadmin-headericon" style="background: url('<?php echo get_template_directory_uri(); ?>/images/options/comicpress_icon.png') no-repeat;"></div>
	<h2 class="alignleft"><?php _e('ComicPress Options','comicpress'); ?></h2>
	<div class="clear"></div>
	<?php
	$tab = '';
	if (isset($_GET['tab'])) $tab = wp_filter_nohtml_kses($_GET['tab']);
	if ( isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'update-options') ) {

		if ($_REQUEST['action'] == 'comicpress_save_layout') {
			$comicpress_options['cp_theme_layout'] = wp_filter_nohtml_kses($_REQUEST['cp_theme_layout']);
			
			foreach (array(
				'enable_caps'
				) as $key) {
					if (!isset($_REQUEST[$key])) $_REQUEST[$key] = 0;
					$comicpress_options[$key] = (bool)( $_REQUEST[$key] == 1 ? true : false );
			}
			
			$tab = 'themestyle';
			update_option('comicpress-options',$comicpress_options);
		}

		if ($_REQUEST['action'] == 'comicpress_save_general') {

			foreach (array(
				'rascal_says',
				'disable_comment_note',
				'enable_comment_javascript',
				'enable_numbered_pagination',
				'enable_comment_count_in_rss',
				'enable_post_thumbnail_rss',
				'comic_clicks_next',
				'disable_default_comic_nav',
				'enable_widgetarea_use_sidebar_css',
				'disable_lrsidebars',
				'enable_equal_height_sidebars',
				'disable_footer_text',
				'enable_comicpress_debug',
				'enable_full_post_check',
				'enable_scroll_to_top',
				'enable_page_load_info',
				'fix_for_index_paging',
				'enable_multicomic_jquery',
				'enable_comic_lightbox'
				) as $key) {
					if (!isset($_REQUEST[$key])) $_REQUEST[$key] = 0;
					$comicpress_options[$key] = (bool)( $_REQUEST[$key] == 1 ? true : false );
			}

			foreach (array(
				'graphicnav_directory',
				'copyright_name',
				'copyright_url'
						) as $key) {
							if (isset($_REQUEST[$key])) 
								$comicpress_options[$key] = wp_filter_nohtml_kses($_REQUEST[$key]);
			}
			$tab = 'general';
			update_option('comicpress-options',$comicpress_options);
		}

		if ($_REQUEST['action'] == 'comicpress_save_index') {
			foreach (array(
				'disable_comic_frontpage',
				'disable_comic_blog_frontpage',
				'disable_comic_blog_single',
				'enable_comments_when_comic_blog_disabled',
				'disable_blog_frontpage',
				'disable_blogheader',
				'display_first_comic_on_home',
				'display_comments_on_home'
				) as $key) {
					if (!isset($_REQUEST[$key])) $_REQUEST[$key] = 0;
						$comicpress_options[$key] = (bool)( $_REQUEST[$key] == 1 ? true : false );
			}
			foreach (array(
				'blogheader_text'
						) as $key) {
						if (!isset($_REQUEST[$key])) $_REQUEST[$key] = '';
						$comicpress_options[$key] = wp_filter_nohtml_kses($_REQUEST[$key]);
			}
			
			$tab = 'index';
			update_option('comicpress-options',$comicpress_options);
		}

		if ($_REQUEST['action'] == 'comicpress_save_post') {
			foreach (array(
				'transcript_in_posts',
				'remove_wptexturize',
				'enable_comic_post_author_gravatar',
				'enable_post_author_gravatar',
				'split_column_in_two',
				'enable_comic_post_calendar',
				'enable_post_calendar',
				'disable_tags_in_posts',
				'disable_categories_in_posts',
				'blogposts_with_comic',
				'static_blog',
				'disable_page_titles',
				'disable_post_titles',
				'enable_page_options'
						) as $key) {
							if (!isset($_REQUEST[$key])) $_REQUEST[$key] = 0;
							$comicpress_options[$key] = (bool)( $_REQUEST[$key] == 1 ? true : false );
			}
			foreach (array(
				'author_column_one',
				'author_column_two',
				'avatar_directory',
				'moods_directory',
				'calendar_directory'
						) as $key) {
							if (isset($_REQUEST[$key])) 
								$comicpress_options[$key] = wp_filter_nohtml_kses($_REQUEST[$key]);
			}
			$tab = 'post';
			update_option('comicpress-options',$comicpress_options);
		}

		if ($_REQUEST['action'] == 'comicpress_save_archivesearch') {
			foreach (array(
				'archive_display_order',
				'excerpt_or_content_archive',
				'excerpt_or_content_search'
						) as $key) {
							if (isset($_REQUEST[$key])) 
								$comicpress_options[$key] = wp_filter_nohtml_kses($_REQUEST[$key]);
			}
			foreach (array(
				'archive_display_comic_thumbs_in_order',
				'template-comic-year-all-cats',
				'archive_start_latest_year',
				'display_archive_as_text_links'
						) as $key) {
							if (!isset($_REQUEST[$key])) $_REQUEST[$key] = 0;
								$comicpress_options[$key] = (bool)( $_REQUEST[$key] == 1 ? true : false );
			}
			$tab = 'archivesearch';
			update_option('comicpress-options',$comicpress_options);
		}

		if ($_REQUEST['action'] == 'comicpress_save_menubar') {
			foreach (array(
				'enable_search_in_menubar',
				'enable_rss_in_menubar',
				'enable_navigation_in_menubar',
				'disable_jquery_menu_code',
				'disable_default_menubar'
						) as $key) {
						if (!isset($_REQUEST[$key])) $_REQUEST[$key] = 0;
						$comicpress_options[$key] = (bool)( $_REQUEST[$key] == 1 ? true : false );
			}
			$tab = 'menubar';
			update_option('comicpress-options',$comicpress_options);
		}

		if ($_REQUEST['action'] == 'comicpress_save_addons') {
			foreach (array(
				'enable_members_only',
				'enable_custom_image_header',
				'enable_members_only_post_comments',
				'enable_related_comics',
				'enable_related_posts',
				'enable_buy_print',
				'buy_print_sell_original',
				'enable_buystrip_post',
				'disable_showing_members_category',
				'facebook_like_blog_post',
				'facebook_like_comic_post',
				'facebook_meta'
						) as $key) {
				if (!isset($_REQUEST[$key])) $_REQUEST[$key] = 0;
					$comicpress_options[$key] = (bool)( $_REQUEST[$key] == 1 ? true : false );
			}
			foreach (array(
				'custom_image_header_width',
				'custom_image_header_height',
				'members_post_category',
				'buy_print_email',
				'buy_print_url',
				'buy_print_amount',
				'buy_print_orig_amount',
				'buy_print_text',
				'cdn_url'
						) as $key) {
					if (isset($_REQUEST[$key])) {
						$comicpress_options[$key] = wp_filter_nohtml_kses($_REQUEST[$key]);
					}
				}
				$tab = 'addons';
				update_option('comicpress-options',$comicpress_options);
			}

		if ($_REQUEST['action'] == 'comicpress_save_config') {
			$comicpress_config = array();
			foreach (array(
				'comiccat',
				'blogcat',
				'comic_folder',
				'rss_comic_folder',
				'archive_comic_folder',
				'mini_comic_folder',
				'rss_comic_width',
				'archive_comic_width',
				'mini_comic_width'
						) as $key) {
							if (isset($_REQUEST[$key])) 
								$comicpress_config[$key] = wp_filter_nohtml_kses($_REQUEST[$key]);
			}

			$tab = 'config';
			$comicpress_config_check = get_option('comicpress-config');
			if (empty($comicpress_config_check)) {
				add_option('comicpress-config', $comicpress_config, false, true);
			} else {
				update_option('comicpress-config', $comicpress_config);
			}
		}
		if ($tab) { ?>
			<div id="message" class="updated"><p><strong><?php _e('ComicPress Settings MODIFIED.','comicpress'); ?></strong></p></div>
			<script>function hidemessage() { document.getElementById('message').style.display = 'none'; }</script>
		<?php }
		$comicpress_themeinfo = comicpress_themeinfo('reset');
	}
	if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'comicpress_reset') {
		delete_option('comicpress-options');
	?>
		<div id="message" class="updated"><p><strong><?php _e('ComicPress Settings RESET!','comicpress'); ?></strong></p></div>
	<?php
}
	?>
	<div id="poststuff" class="metabox-holder">
		<div id="cpadmin">
		  <?php
		  	$tab_info = array(
		  		'themestyle' => __('Layout', 'comicpress'),
		  		'general' => __('General', 'comicpress'),
  	  			'index' => __('Home Page', 'comicpress'),
  	  			'post' => __('Posts &amp; Pages', 'comicpress'),
  	  			'archivesearch' => __('Archive &amp; Templates', 'comicpress'),
  	  			'menubar' => __('Menubar', 'comicpress'),
  	  			'addons' => __('Add Ons', 'comicpress'),
// 	  			'config' => __('Configuration', 'comicpress'),
				'debug' => __('Debug', 'comicpress') 
		  	);

		  	if (empty($tab)) { $tab = array_shift(array_keys($tab_info)); }

		  	foreach($tab_info as $tab_id => $label) { ?>
		  		<div id="comicpress-tab-<?php echo $tab_id ?>" class="comicpress-tab <?php echo ($tab == $tab_id) ? 'on' : 'off'; ?>"><span><?php echo $label; ?></span></div>
		  	<?php }
		  ?>
		</div>

		<div id="comicpress-options-pages">
		  <?php	foreach (glob(get_template_directory() . '/options/*.php') as $file) { include($file); } ?>
		</div>
	</div>
	<script type="text/javascript">
		(function($) {
			var showPage = function(which) {
				$('#comicpress-options-pages > div').each(function(i) {
					$(this)[(this.id == 'comicpress-' + which) ? 'show' : 'hide']();
				});
			};

			$('.comicpress-tab').click(function() {
				$('#message').animate({height:"0", opacity:0, margin: 0}, 100, 'swing', function() { $(this).remove() });

				showPage(this.id.replace('comicpress-tab-', ''));
				var myThis = this;
				$('.comicpress-tab').each(function() {
					var isSame = (this == myThis);
					$(this).toggleClass('on', isSame).toggleClass('off', !isSame);
				});
				return false;
			});

			showPage('<?php echo esc_js($tab) ?>');
		}(jQuery));
	</script>
</div>

<?php
}
