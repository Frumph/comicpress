<?php

add_action('admin_menu', 'comicpress_options_setup');

function comicpress_options_setup() {
	$options_title = __('Options','comicpress');
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
	wp_enqueue_style('comicpress-options-style', comicpress_themeinfo('themeurl') . '/options/options.css');
}

function comicpress_admin_page_head() { ?>
	<!--[if lt ie 8]> <style> div.show { position: static; margin-top: 1px; } #eadmin div.off { height: 22px; } </style> <![endif]-->
<?php }

function comicpress_admin_options() { ?>
<div class="wrap">
	<div id="eadmin-headericon" style="background: url('<?php echo comicpress_themeinfo('themeurl') ?>/images/comicpress-rascal.png') no-repeat;"></div>
	<p class="alignleft">
		<h2><?php _e('ComicPress Options','comicpress'); ?></h2>
		<?php _e('ComicPress is a modular theme that has an abundance of hooks and actions placed in it for additional usability. Ref: Comic Easel', 'comicpress'); ?><br />
		<?php _e('While ComicPress is an excellent stand-alone theme, it can be enhanced in usability with the associated plugins that have been built to utilize its functionality.','comicpress'); ?><br />
	</p>
	<div class="clear"></div>
	<?php
	if (isset($_GET['tab'])) { $tab = wp_filter_nohtml_kses($_GET['tab']); } else { $tab = ''; };

	if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'comicpress_reset') {
		delete_option('cp-options');
		global $comicpress_themeinfo; $comicpress_themeinfo = '';
	?>
		<div id="message" class="updated"><p><strong><?php _e('ComicPress Settings RESET!','comicpress'); ?></strong></p></div>
	<?php } 
	if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'comicpress_reset_customize') {
		remove_theme_mod('comicpress-customize');
		global $comicpress_themeinfo; $comicpress_themeinfo = '';
	?>
		<div id="message" class="updated"><p><strong><?php _e('ComicPress Customizer Colors RESET!','comicpress'); ?></strong></p></div>
	<?php }
	if (empty($comicpress_options)) { 
		comicpress_themeinfo('reset');
	}
	$comicpress_options = comicpress_load_options();
	if ( isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'update-options') ) {
		
		if ($_REQUEST['action'] == 'comicpress_save_help') {
			$tab = 'layout';
			update_option('cp-options', $comicpress_options);
		}
		
		if ($_REQUEST['action'] == 'comicpress_save_layout') {
			foreach (array(
				'layout',
				'scheme'
					) as $key) {
							if (isset($_REQUEST[$key])) 
								$comicpress_options[$key] = wp_filter_nohtml_kses($_REQUEST[$key]);
			}
			
			foreach (array(
				'disable_default_design'
			) as $key) {
				if (!isset($_REQUEST[$key])) $_REQUEST[$key] = 0;
				$comicpress_options[$key] = (bool)( $_REQUEST[$key] == 1 ? true : false );
			}
			
			$tab = 'layout';
			update_option('cp-options', $comicpress_options);
		}
		
		if ($_REQUEST['action'] == 'comicpress_save_debug') {
			foreach (array(
				'enable_debug_footer_code',
				'force_active_connection_close'
			) as $key) {
				if (!isset($_REQUEST[$key])) $_REQUEST[$key] = 0;
				$comicpress_options[$key] = (bool)( $_REQUEST[$key] == 1 ? true : false );
			}
			$tab = 'debug';
			update_option('cp-options', $comicpress_options);
		}
		
		if ($_REQUEST['action'] == 'comicpress_save_menubar') {

			foreach (array(
			'disable_jquery_menu_code',
			'disable_default_menubar',
			'enable_search_in_menubar',
			'enable_rss_in_menubar',
			'menubar_social_icons',
			'enable_breadcrumbs'			
				) as $key) {
					if (!isset($_REQUEST[$key])) $_REQUEST[$key] = 0;
					$comicpress_options[$key] = (bool)( $_REQUEST[$key] == 1 ? true : false );
			}

			foreach (array(
				'menubar_social_twitter',
				'menubar_social_facebook',
				'menubar_social_googleplus',
				'menubar_social_linkedin',
				'menubar_social_pinterest',
				'menubar_social_youtube',
				'menubar_social_flickr',
				'menubar_social_tumblr',
				'menubar_social_deviantart',
				'menubar_social_myspace',
				'menubar_social_email'
						) as $key) {
							if (isset($_REQUEST[$key]) && !empty($_REQUEST[$key])) {
								$comicpress_options[$key] = esc_url($_REQUEST[$key]);
							} else {
								// set to empty if it's not set
								$comicpress_options[$key] = '';
							}
			}
			$tab = 'menubar';
			update_option('cp-options', $comicpress_options);
		}
		
		if ($_REQUEST['action'] == 'comicpress_save_general') {

			foreach (array(
			'disable_scroll_to_top',
			'enable_sidebar_css',
			'enable_avatar_trick',
			'disable_comment_note',
			'disable_comment_javascript',
			'enable_numbered_pagination',
			'enable_post_thumbnail_rss',
			'disable_footer_text',
			'disable_page_titles',
			'disable_post_titles',
			'enable_post_calendar',
			'enable_post_author_gravatar',
			'disable_categories_in_posts',
			'disable_tags_in_posts',
			'disable_author_info_in_posts',
			'disable_date_info_in_posts',
			'disable_blog_on_homepage',
			'enable_comments_on_homepage',
			'facebook_like_blog_post',
			'facebook_meta',
			'display_archive_as_links',
			'enable_last_modified_in_posts',
			'disable_posted_at_time_in_posts',
			'add_pw_async_code_to_head',
			'over-blog-sidebar-all-posts'
				) as $key) {
					if (!isset($_REQUEST[$key])) $_REQUEST[$key] = 0;
					$comicpress_options[$key] = (bool)( $_REQUEST[$key] == 1 ? true : false );
			}

			foreach (array(
				'avatar_directory',
				'home_post_count',
				'copyright_name',
				'copyright_url',
				'custom_image_header_width',
				'custom_image_header_height',
				'archive_display_order',
				'excerpt_or_content_in_archive',
				'content_width',
				'content_width_disabled_sidebars'
						) as $key) {
							if (isset($_REQUEST[$key])) 
								$comicpress_options[$key] = wp_filter_nohtml_kses($_REQUEST[$key]);
			}
			$tab = 'general';
			update_option('cp-options', $comicpress_options);
		}
		if ($tab) { ?>
			<div id="message" class="updated"><p><strong><?php _e('ComicPress Settings SAVED!','comicpress'); ?></strong></p></div>
			<script>function hidemessage() { document.getElementById('message').style.display = 'none'; }</script>
		<?php }
	} 
	$version = comicpress_themeinfo('version');
	$comicpress_options = comicpress_load_options();
	?>
	<div id="poststuff" class="metabox-holder">
		<div id="eadmin">
		  <?php
		  	$tab_info = array(
				'layout' => __('Layout', 'comicpress'),
		  		'general' => __('General', 'comicpress'),
				'menubar' => __('Menubar', 'comicpress'),
				'debug' => __('Debug', 'comicpress')
		  	);

		  	if (empty($tab)) { $tab = array_shift(array_keys($tab_info)); }

		  	foreach($tab_info as $tab_id => $label) { ?>
		  		<div id="comicpress-tab-<?php echo $tab_id ?>" class="comicpress-tab <?php echo ($tab == $tab_id) ? 'on' : 'off'; ?>"><span><?php echo $label; ?></span></div>
		  	<?php }
		  ?>
		</div>

		<div id="comicpress-options-pages">
		  <?php	foreach (glob(comicpress_themeinfo('themepath') . '/options/*.php') as $file) { include($file); } ?>
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

			showPage('<?php echo esc_js($tab); ?>');
		}(jQuery));
	</script>
</div>
	<div class="eadmin-footer">
		<div id="comicpress-version-title"><a href="http://frumph.net/">ComicPress <?php echo comicpress_themeinfo('version'); ?></a></div>
		<br />
		<?php _e('Developed and maintained by','comicpress'); ?> <a href="http://frumph.net/">Philip M. Hofer</a> <small>(<a href="http://frumph.net/">Frumph</a>)</small>, <?php _e('Originally created by','comicpress'); ?> <a href="http://mindfaucet.com/">Tyler Martin</a><br />
		<?php _e('If you like the ComicPress theme, please donate.  It will help in developing new features and versions.','comicpress'); ?>
		<table style="margin:0 auto;">
			<tr>
				<td style="width:200px;">
					<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
						<input type="hidden" name="cmd" value="_s-xclick" />
						<input type="hidden" name="hosted_button_id" value="46RNWXBE7467Q" />
						<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" name="submit" alt="PayPal - The safer, easier way to pay online!" />
						<img alt="" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1" />
					</form>
				</td>
				<td style="width:200px;">
					<form method="post" id="myForm" name="template" enctype="multipart/form-data" action="">
						<?php wp_nonce_field('update-options') ?>
						<input name="comicpress_reset" type="submit" class="button" value="<?php _e('Reset All Settings','comicpress'); ?>" />
						<input type="hidden" name="action" value="comicpress_reset" />
					</form>
				</td>
				<td style="width:200px;">
					<form method="post" id="myForm" name="template" enctype="multipart/form-data" action="">
						<?php wp_nonce_field('update-options') ?>
						<input name="comicpress_reset_customize" type="submit" class="button" value="<?php _e('Reset Customizer Colors','comicpress'); ?>" />
						<input type="hidden" name="action" value="comicpress_reset_customize" />
					</form>
				</td>
			</tr>
		</table>
	</div>

<?php
}
