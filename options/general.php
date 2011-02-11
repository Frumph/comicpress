<div id="comicpress-general">

	<form method="post" id="myForm-general" enctype="multipart/form-data" action="?page=comicpress-options">
	<?php wp_nonce_field('update-options') ?>

		<div class="comicpress-options">

			<table class="widefat">
				<thead>
					<tr>
						<th colspan="3"><?php _e('Design','comicpress'); ?></th>
					</tr>
				</thead>
				<tr class="alternate">
					<th scope="row"><label for="enable_caps"><?php _e('Enable -head and -foot caps?','comicpress'); ?></label></th>
					<td>
						<input id="enable_caps" name="enable_caps" type="checkbox" value="1" <?php checked(true, comicpress_themeinfo('enable_caps')); ?> />
					</td>
					<td>
						<?php _e('Enabling this option will create post-head widget-head and various other div alignments increasing the amount of dom elements available to use in designing your site, however will reduce the speed in which the page is shown on the end users browser.','comicpress'); ?>
					</td>
				</tr>
			</table>
			
			<table class="widefat">
				<thead>
					<tr>
						<th colspan="3"><?php _e('Comic','comicpress'); ?></th>
					</tr>
				</thead>
				<tr class="alternate">
					<th scope="row"><label for="rascal_says"><?php _e('Enable Rascal the ComicPress Mascot','comicpress'); ?></label></th>
					<td>
						<input id="rascal_says" name="rascal_says" type="checkbox" value="1" <?php checked(true, comicpress_themeinfo('rascal_says')); ?> />
					</td>
					<td>
						<?php _e('Enable this option to make a comic bubble appear over the comic and write out what you put in the hovertext, along with a friendly face. You can add the hovertext when uploading your comic with ComicPress Manager. To change the graphics for this will need to be well-versed in CSS.','comicpress'); ?>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="enable_multicomic_jquery"><?php _e('Enable Multi-Comic Jquery navigation?','comicpress'); ?></label></th>
					<td>
						<input id="enable_multicomic_jquery" name="enable_multicomic_jquery" type="checkbox" value="1" <?php checked(true, comicpress_themeinfo('enable_multicomic_jquery')); ?> />
					</td>
					<td>
						<?php _e('This is if you have uploaded multiple comics on the same date, it puts button navigation under the comic so you can navigate the comics that are on the same date.','comicpress'); ?>
					</td>
				</tr>
				<tr class="alternate">
					<th scope="row"><label for="enable_comic_lightbox"><?php _e('Enable lightbox support for the comic image.','comicpress'); ?></label></th>
					<td>
						<input id="enable_comic_lightbox" name="enable_comic_lightbox" type="checkbox" value="1" <?php checked(true, comicpress_themeinfo('enable_comic_lightbox')); ?> />
					</td>
					<td>
						<?php _e('This will allow you to use lightbox with the comic so the comic expands when clicked.  Will *not* work with rascal or comic clicks next options.','comicpress'); ?>
					</td>
				</tr>				
			</table>
			
			<table class="widefat">
				<thead>
					<tr>
						<th colspan="3"><?php _e('Comments','comicpress'); ?></th>
					</tr>
				</thead>
				<tr class="alternate">
					<th scope="row"><label for="disable_comment_note"><?php _e('Disable the comment notes','comicpress'); ?></label></th>
					<td>
						<input id="disable_comment_note" name="disable_comment_note" type="checkbox" value="1" <?php checked(true, comicpress_themeinfo('disable_comment_note')); ?> />
					</td>
					<td>
						<?php _e('Disabling this will remove the note text that displays with more options for adding to comments (html).','comicpress'); ?>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="enable_comment_javascript"><?php _e('Enable Comment Javascript','comicpress'); ?></label></th>
					<td>
						<input id="enable_comment_javascript" name="enable_comment_javascript" type="checkbox" value="1" <?php checked(true, comicpress_themeinfo('enable_comment_javascript')); ?> />
					</td>
					<td>
						<?php _e('Enable this option if you want the comment form to appear directly under who is being replied to. (reduces pageview/hit)','comicpress'); ?>
					</td>
				</tr>
			</table>
			
			<table class="widefat">
				<thead>
					<tr>
						<th colspan="3"><?php _e('RSS','comicpress'); ?></th>
					</tr>
				</thead>			
				<tr class="alternate">
					<th scope="row"><label for="enable_comment_count_in_rss"><?php _e('Enable the comment count to show in feed title.','comicpress'); ?></label></th>
					<td>
						<input id="enable_comment_count_in_rss" name="enable_comment_count_in_rss" type="checkbox" value="1" <?php checked(true, comicpress_themeinfo('enable_comment_count_in_rss')); ?> />
					</td>
					<td>
						<?php _e('Will show how many comments there are in the title of the post in the feed.','comicpress'); ?>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="enable_post_thumbnail_rss"><?php _e('Enable the post thumbnails in the RSS feed?','comicpress'); ?></label></th>
					<td>
						<input id="enable_post_thumbnail_rss" name="enable_post_thumbnail_rss" type="checkbox" value="1" <?php checked(true, comicpress_themeinfo('enable_post_thumbnail_rss')); ?> />		
					</td>
					<td>
						<?php _e('If enabled will show the post thumbnail of the post in the RSS feed.','comicpress'); ?>
					</td>
				</tr>
			</table>

			<table class="widefat">
				<thead>
					<tr>
						<th colspan="3"><?php _e('Navigation','comicpress'); ?></th>
					</tr>
				</thead>
				<tr class="alternate">
					<th scope="row"><label for="enable_numbered_pagination"><?php _e('Enable numbered pagination','comicpress'); ?></label></th>
					<td>
						<input id="enable_numbered_pagination" name="enable_numbered_pagination" type="checkbox" value="1" <?php checked(true, comicpress_themeinfo('enable_numbered_pagination')); ?> />
					</td>
					<td>
						<?php _e('Previous Entries and Next Entries buttons are replaced by a bar of numbered pages. Numbered pagination appears on the Home page, the author(s) page, the blog template, and comments/single when there are more then the set number of comments per page. Uses the same styling as the Menubar.','comicpress'); ?>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="comic_clicks_next"><?php _e('Click comic to go next','comicpress'); ?></label></th>
					<td>
						<input id="comic_clicks_next" name="comic_clicks_next" type="checkbox" value="1" <?php checked(true, comicpress_themeinfo('comic_clicks_next')); ?> />
					</td>
					<td>
						<?php _e('Allows users to click the comic itself to go to the next comic (unless on the latest comic). This allows you to offer a more convenient option for your archive readers to proceed to the next comic, and the next, etc. Any enabled hover options will continue to function even with this enabled.','comicpress'); ?>
					</td>
				</tr>
				<tr class="alternate">
					<th scope="row"><label for="disable_default_comic_nav"><?php _e('Disable the default comic post navigation','comicpress'); ?></label></th>
					<td>
						<input id="disable_default_comic_nav" name="disable_default_comic_nav" type="checkbox" value="1" <?php checked(true, comicpress_themeinfo('disable_default_comic_nav')); ?> />
					</td>
					<td>
						<?php _e('The default comic post navigation is above each comic blog post.','comicpress'); ?>
					</td>
				</tr>
				<?php
					$current_gnav_directory = comicpress_themeinfo('graphicnav_directory');
					if (empty($current_gnav_directory)) $current_gnav_directory = 'default';
					$dirs_to_search = array_unique(array(get_template_directory(),get_stylesheet_directory()));
					$gnav_directories = array();
					foreach ($dirs_to_search as $gnav_dir) {
						if (is_dir($gnav_dir . '/images/nav')) {
							$thisdir = null;
							$thisdir = array();
							$thisdir = glob($gnav_dir. '/images/nav/*');
							$gnav_directories = array_merge($gnav_directories, $thisdir); 		
						}
					}
				?>
				<tr>
					<th scope="row" colspan="2"><label for="graphicnav_directory"><?php _e('Graphic Navigation Directory','comicpress'); ?></label>

							<select name="graphicnav_directory" id="graphicnav_directory">
								<?php
									foreach ($gnav_directories as $gnav_dirs) {
										if (is_dir($gnav_dirs)) {
											$gnav_dir_name = basename($gnav_dirs); ?>
											<option class="level-0" value="<?php echo $gnav_dir_name; ?>" <?php if ($current_gnav_directory == $gnav_dir_name) { ?>selected="selected"<?php } ?>><?php echo $gnav_dir_name; ?></option>
									<?php }
									}
								?>
							</select>

					</th>
					<td>
						<?php _e('Choose a directory to get the graphic navigation styling from. To create your own custom graphic navigation menu buttons just create a directory under <i>images/nav/</i> and place your image files inside of it and create a navstyle.css file to determine the style of your navigation display.','comicpress'); ?>
					</td>
				</tr>
			</table>

			<table class="widefat">
				<thead>
					<tr>
						<th colspan="3"><?php _e('Sidebars','comicpress'); ?></th>
					</tr>
				</thead>
				<tr class="alternate">
					<th scope="row"><label for="enable_widgetarea_use_sidebar_css"><?php _e('Enable main Sidebar CSS for all sidebars','comicpress'); ?></label></th>
					<td>
						<input id="enable_widgetarea_use_sidebar_css" name="enable_widgetarea_use_sidebar_css" type="checkbox" value="1" <?php checked(true, comicpress_themeinfo('enable_widgetarea_use_sidebar_css')); ?> />
					</td>
					<td>
						<?php _e('Uses default CSS styling of the sidebars for all sidebar areas. If disabled it will use the .customwidgetarea user-made styling and only Sidebar-left and Sidebar-right will use sidebar styling.','comicpress'); ?><br />
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="disable_lrsidebars"><?php _e('Disable left and right sidebars','comicpress'); ?></label></th>
					<td>
						<input id="disable_lrsidebars" name="disable_lrsidebars" type="checkbox" value="1" <?php checked(true, comicpress_themeinfo('disable_lrsidebars')); ?> />
					</td>
					<td>
						<?php _e('Your site will not display the default left/right sidebars. Minimalists dream. WARNING: Not recommended for use with Graphic Novel layouts.','comicpress'); ?>
					</td>
				</tr>
<?php /*
				<tr class="alternate">
					<th scope="row"><label for="enable_equal_height_sidebars"><?php _e('Enable jQuery that will make the sidebars equal length?','comicpress'); ?></label></th>
					<td>
						<input id="enable_equal_height_sidebars" name="enable_equal_height_sidebars" type="checkbox" value="1" <?php checked(true, comicpress_themeinfo('enable_equal_height_sidebars')); ?> />
					</td>
					<td>
						<?php _e('Enabling this will enable jQuery code to make the sidebars equal length.','comicpress'); ?><br />
					</td>
				</tr>
*/ ?>
			</table>
			
			<table class="widefat">
				<thead>
					<tr>
						<th colspan="3"><?php _e('Footer','comicpress'); ?></th>
					</tr>
				</thead>
				<tr class="alternate">
					<th scope="row"><label for="disable_footer_text"><?php _e('Disable the default text in the footer','comicpress'); ?></label></th>
					<td>
						<input id="disable_footer_text" name="disable_footer_text" type="checkbox" value="1" <?php checked(true, comicpress_themeinfo('disable_footer_text')); ?> />
					</td>
					<td>
						<?php _e('Default text in the footer will not display. Enable this if you do not want any text in the footer. If you wish to add you own custom content, you may do so via Appearance -> Widgets-> Footer.', 'comicpress'); ?>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="enable_scroll_to_top"><?php _e('Enable the scroll to top link in the footer?','comicpress'); ?></label></th>
					<td>
						<input id="enable_scroll_to_top" name="enable_scroll_to_top" type="checkbox" value="1" <?php checked(true, comicpress_themeinfo('enable_scroll_to_top')); ?> />
					</td>
					<td>
						<?php _e('When this link is clicked on long pages it will scroll back to the top.','comicpress'); ?>
					</td>
				</tr>
				<tr class="alternate">
					<th scope="row"><label for="copyright_name"><?php _e('&copy; Copyright Name','comicpress'); ?></label>
						<input type="text" size="20" name="copyright_name" id="copyright_name" value="<?php echo comicpress_themeinfo('copyright_name'); ?>" /><br />
					</th>
					<td colspan="2">
						<?php _e('Set the name to which this site is &copy; Copyright to, leave blank to have the site name.','comicpress'); ?>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="copyright_url"><?php _e('Copyright Holder URL','comicpress'); ?></label>
						<input type="text" size="30" name="copyright_url" id="copyright_url" value="<?php echo comicpress_themeinfo('copyright_url'); ?>" /><br />
					</th>
					<td colspan="2">
						<?php _e('Set the URL to the owner of the &copy; Copyright if different then this website, leave blank for sites link.','comicpress'); ?>
					</td>
				</tr>
			</table>
			
			<table class="widefat">
				<thead>
					<tr>
						<th colspan="3"><?php _e('Debug','comicpress'); ?></th>
					</tr>
				</thead>
				<tr class="alternate">
					<th scope="row"><label for="enable_page_load_info"><?php _e('Enable the page load info in the footer?','comicpress'); ?></label></th>
					<td>
						<input id="enable_page_load_info" name="enable_page_load_info" type="checkbox" value="1" <?php checked(true, comicpress_themeinfo('enable_page_load_info')); ?> />
					</td>
					<td>
						<?php _e('Will display information on how many queries and how fast it took to load the page in the footer.', 'comicpress'); ?>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="fix_for_index_paging"><?php _e('Enable fix for index paging file not found with permalinks?','comicpress'); ?></label></th>
					<td>
						<input id="fix_for_index_paging" name="fix_for_index_paging" type="checkbox" value="1" <?php checked(true, comicpress_themeinfo('fix_for_index_paging')); ?> />
					</td>
					<td>
						<?php _e('Enabling this will add a filter to the index page query that will set the number of posts displayed appropriately for paging if it does not work for you.', 'comicpress'); ?>
					</td>
				</tr>
			</table>

		</div>

		<div class="comicpress-options-save">
			<div class="comicpress-major-publishing-actions">
				<div class="comicpress-publishing-action">
					<input name="comicpress_save_general" type="submit" class="button-primary" value="Save Settings" />
					<input type="hidden" name="action" value="comicpress_save_general" />
				</div>
				<div class="clear"></div>
			</div>
		</div>

	</form>

</div>
