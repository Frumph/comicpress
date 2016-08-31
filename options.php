<?php

add_action('admin_menu', 'comicpress_options_setup');

function comicpress_options_setup() {
	$options_title = __( 'Options', 'comicpress' );
	$admin_title = __( 'ComicPress Options', 'comicpress' );
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
	<!--[if lt ie 8]> <style> div.show { position: static; margin-top: 1px; } #eadmin div.off { height: 22px; } </style> <![endif]-->
<?php }

function comicpress_admin_options() { ?>
<div class="wrap">
	<div id="eadmin-headericon" style="background: url('<?php echo get_template_directory_uri() ?>/images/comicpress-rascal.png') no-repeat;"></div>
		<h2><?php _e( 'ComicPress Options', 'comicpress' ); ?></h2>
		<?php _e( 'ComicPress is a modular theme that has an abundance of hooks and actions placed in it for additional usability. Ref: Comic Easel', 'comicpress' ); ?><br />
		<?php _e( 'While ComicPress is an excellent stand-alone theme, it can be enhanced in usability with the associated plugins that have been built to utilize its functionality.', 'comicpress' ); ?><br />
	<div class="clear"></div>
	<?php
	if (isset($_GET['tab'])) { $tab = wp_filter_nohtml_kses($_GET['tab']); } else { $tab = ''; };

	if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'comicpress_reset') {
		delete_option('cp-options');
		global $comicpress_themeinfo; $comicpress_themeinfo = '';
	?>
		<div id="message" class="updated"><p><strong><?php _e( 'ComicPress Settings RESET!', 'comicpress' ); ?></strong></p></div>
	<?php } 
	if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'comicpress_reset_customize') {
		remove_theme_mod('comicpress-customize');
		delete_option('theme_mods_comicpress');
		global $comicpress_themeinfo; $comicpress_themeinfo = '';
	?>
		<div id="message" class="updated"><p><strong><?php _e( 'ComicPress Customizer Colors RESET!', 'comicpress' ); ?></strong></p></div>
	<?php }
	if (empty($comicpress_options)) { 
		comicpress_themeinfo('reset');
	}
	$comicpress_options = comicpress_load_options();
	if ( isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'update-options') ) {
		
		if ($_REQUEST['action'] == 'comicpress_save_general') {

			foreach (array(
			'disable_scroll_to_top',  // general
			'enable_post_thumbnail_rss',  // general
			'disable_footer_text', // general
			'disable_blog_on_homepage', // general
			'add_pw_async_code_to_head',  // general
			'over-blog-sidebar-all-posts'  // general
				) as $key) {
					if (!isset($_REQUEST[$key])) $_REQUEST[$key] = 0;
					$comicpress_options[$key] = (bool)( $_REQUEST[$key] == 1 ? true : false );
			}

			foreach (array(
				'home_post_count',  // general
				'copyright_name',  // general
				'copyright_url'  // general
						) as $key) {
							if (isset($_REQUEST[$key])) 
								$comicpress_options[$key] = wp_filter_nohtml_kses($_REQUEST[$key]);
			}
			$tab = 'general';
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
		
		if ($_REQUEST['action'] == 'comicpress_save_postspages') {

			foreach (array(
			'enable_avatar_trick', // postspages
			'disable_page_titles',  // postspages
			'disable_post_titles',  // postspages
			'enable_post_calendar',  // postspages
			'enable_post_author_gravatar',  // postspages
			'disable_categories_in_posts',  // postspages
			'disable_tags_in_posts',  // postspages
			'disable_author_info_in_posts',  // postspages
			'disable_date_info_in_posts',  // postspages
			'enable_last_modified_in_posts',  // postspages
			'disable_posted_at_time_in_posts', // postspages
				) as $key) {
					if (!isset($_REQUEST[$key])) $_REQUEST[$key] = 0;
					$comicpress_options[$key] = (bool)( $_REQUEST[$key] == 1 ? true : false );
			}

			foreach (array(
				'moods_directory',  // postspages
				'content_width',  // postspages
				'content_width_disabled_sidebars'  // postspages
						) as $key) {
							if (isset($_REQUEST[$key])) 
								$comicpress_options[$key] = wp_filter_nohtml_kses($_REQUEST[$key]);
			}
			$tab = 'postspages';
			update_option('cp-options', $comicpress_options);
		}
		
		if ($_REQUEST['action'] == 'comicpress_save_comments') {

			foreach (array(
			'disable_comment_note',  // comments
			'disable_comment_javascript',  // commments
			'enable_comments_on_homepage', // comments
				) as $key) {
					if (!isset($_REQUEST[$key])) $_REQUEST[$key] = 0;
					$comicpress_options[$key] = (bool)( $_REQUEST[$key] == 1 ? true : false );
			}

			foreach (array(
				'avatar_directory'  // comments 
						) as $key) {
							if (isset($_REQUEST[$key])) 
								$comicpress_options[$key] = wp_filter_nohtml_kses($_REQUEST[$key]);
			}
			$tab = 'comments';
			update_option('cp-options', $comicpress_options);
		}
		
		if ($_REQUEST['action'] == 'comicpress_save_archivesearch') {

			foreach (array(
			'display_archive_as_links',  // archivesearch
			'enable_numbered_pagination'  // postspages
				) as $key) {
					if (!isset($_REQUEST[$key])) $_REQUEST[$key] = 0;
					$comicpress_options[$key] = (bool)( $_REQUEST[$key] == 1 ? true : false );
			}

			foreach (array(
				'archive_display_order',  // archivesearch
				'excerpt_or_content_in_archive'  // archivesearch
						) as $key) {
							if (isset($_REQUEST[$key])) 
								$comicpress_options[$key] = wp_filter_nohtml_kses($_REQUEST[$key]);
			}
			$tab = 'archivesearch';
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
		
		if ($tab) { ?>
			<div id="message" class="updated"><p><strong><?php _e( 'ComicPress Settings SAVED!', 'comicpress' ); ?></strong></p></div>
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
				'splash' => __( 'Introduction', 'comicpress' ),
		  		'general' => __( 'General', 'comicpress' ),
		  		'menubar' => __( 'Menubar', 'comicpress' ),
		  		'postspages' => __( 'Posts & Pages', 'comicpress' ),
				'comments' => __( 'Comments', 'comicpress' ),
				'archivesearch' => __( 'Archive & Search', 'comicpress' ),
				'debug' => __( 'Debug', 'comicpress' )
		  	);

		  	if (empty($tab)) { $tab = 'splash'; }

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

			showPage('<?php echo esc_js($tab); ?>');
		}(jQuery));
	</script>
</div>
	<div class="eadmin-footer">
		<div id="comicpress-version-title"><a href="http://frumph.net/">ComicPress <?php echo comicpress_themeinfo('version'); ?></a></div>
		<br />
		<?php _e( 'Developed and maintained by', 'comicpress' ); ?> <a href="http://frumph.net/">Philip M. Hofer</a> <small>(<a href="http://frumph.net/">Frumph</a>)</small>, <?php _e( 'Originally created by', 'comicpress' ); ?> <a href="http://mindfaucet.com/">Tyler Martin</a><br />
		<?php _e( 'If you like the ComicPress theme, please donate. It will help in developing new features and versions.', 'comicpress' ); ?>
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
						<input name="comicpress_reset" type="submit" class="button" value="<?php _e( 'Reset All Settings', 'comicpress' ); ?>" />
						<input type="hidden" name="action" value="comicpress_reset" />
					</form>
				</td>
				<td style="width:200px;">
					<form method="post" id="myForm" name="template" enctype="multipart/form-data" action="">
						<?php wp_nonce_field('update-options') ?>
						<input name="comicpress_reset_customize" type="submit" class="button" value="<?php _e( 'Reset Customizer Colors', 'comicpress' ); ?>" />
						<input type="hidden" name="action" value="comicpress_reset_customize" />
					</form>
				</td>
			</tr>
		</table>
	</div>

<?php
}
