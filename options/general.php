<div id="comicpress-general">
	<form method="post" id="myForm-general" enctype="multipart/form-data" action="?page=comicpress-options">
	<?php wp_nonce_field('update-options') ?>

		<div class="comicpress-options">

			<table class="widefat">
				<thead>
					<tr>
						<th colspan="3"><?php _e('General','comicpress'); ?></th>
					</tr>
				</thead>

				<tr>
					<th scope="row"><label for="home_post_count"><?php _e('How many blog posts would you like to display on the home page?','comicpress'); ?></label></th>
					<td>
						<input type="text" size="2" name="home_post_count" id="home_post_count" value="<?php echo $comicpress_options['home_post_count']; ?>" />
					</td>
					<td>
						<?php _e('How many blog posts you would like displayed on the index page at one time.  This is different then the one in the wp-admin - settings, the one in the settings will control how many show up on search and archive pages.','comicpress'); ?>
					</td>
				</tr>
				<tr class="alternate">
					<th scope="row"><label for="disable_blog_on_homepage"><?php _e('Disable Blog Loop','comicpress'); ?></label></th>
					<td>
						<input id="disable_blog_on_homepage" name="disable_blog_on_homepage" type="checkbox" value="1" <?php checked(true, $comicpress_options['disable_blog_on_homepage']); ?> />
					</td>
					<td>
						<?php _e('Enabling this option, will DISABLE the blog from appearing on the home page AND any pages set as the blog posts page in the settings - reading.','comicpress'); ?>
					</td>
				</tr>
				<tr>
					<?php if (!isset($comicpress_options['add_pw_async_code_to_head'])) $comicpress_options['add_pw_async_code_to_head'] = false; ?>
					<th scope="row"><label for="add_pw_async_code_to_head"><?php _e('Enable Project Wonderful Asyncronus code?','comicpress'); ?></label></th>
					<td>
						<input id="add_pw_async_code_to_head" name="add_pw_async_code_to_head" type="checkbox" value="1" <?php checked(true, $comicpress_options['add_pw_async_code_to_head']); ?> />
					</td>
					<td>
						<?php _e('This option places the Project Wonderful asyncronus code into the header of the site.','comicpress'); ?>
					</td>
				</tr>
				<tr class="alternate">
					<th scope="row"><label for="over-blog-sidebar-all-posts"><?php _e('Allow the sidebar over-blog to appear on all posts?','comicpress'); ?></label></th>
					<td>
						<input id="over-blog-sidebar-all-posts" name="over-blog-sidebar-all-posts" type="checkbox" value="1" <?php checked(true, $comicpress_options['over-blog-sidebar-all-posts']); ?> />
					</td>
					<td>
						<?php _e('Sidebar Over-Blog appears on all posts not just the front page/blog loop when enabled.','comicpress'); ?>
					</td>
				</tr>
			</table>
			
			
			<table class="widefat">
				<thead>
					<tr>
						<th colspan="5"><?php _e('Custom Header','comicpress'); ?></th>
					</tr>
				</thead>
				<tr class="alternate">
					<th scope="row"><label for="custom_image_header_width"><?php _e('Custom Header Values','comicpress'); ?></label></th>
					<td>
						<?php _e('Width:','comicpress'); ?> <input type="text" size="5" name="custom_image_header_width" id="custom_image_header_width" value="<?php echo $comicpress_options['custom_image_header_width']; ?>" />px &nbsp;
						<?php _e('Height:','comicpress'); ?> <input type="text" size="5" name="custom_image_header_height" id="custom_image_header_height" value="<?php echo $comicpress_options['custom_image_header_height']; ?>" />px<br />
						<?php _e('Modify the height and width of the custom header *if* you use Appearance - Header','comicpress'); ?><br />
						<?php _e('3 Column Layouts are 980px width while 2 Column Layouts are 780px width as default.','comicpress'); ?><br />
						<strong><?php _e('NOTE: This should only be used if the appearance - header section is not displaying your header dimensions correctly.', 'comicpress'); ?></strong>
					</td>
				</tr>
			</table>

			<table class="widefat">
				<thead>
					<tr>
						<th colspan="3"><?php _e('Content Width','comicpress'); ?></th>
					</tr>
				</thead>
				<tr>
					<?php if (!isset($comicpress_options['content_width'])) $comicpress_options['content_width'] = 500; ?>
					<th scope="row"><label for="content_width"><?php _e('Media and images width on posts and pages?','comicpress'); ?></label></th>
					<td>
						<input type="text" size="4" name="content_width" id="content_width" value="<?php echo $comicpress_options['content_width']; ?>" />px
					</td>
					<td>
						<?php _e('This sets a specific width for WordPress to use for media content within your posts and pages.  Default = 500','comicpress'); ?>
					</td>
				</tr>
				<tr class="alternate">
					<?php if (!isset($comicpress_options['content_width_disabled_sidebars'])) $comicpress_options['content_width_disabled_sidebars'] = 700; ?>
					<th scope="row"><label for="content_width_disabled_sidebars"><?php _e('Media and images width when sidebars are disabled on pages?','comicpress'); ?></label></th>
					<td>
						<input type="text" size="4" name="content_width_disabled_sidebars" id="content_width" value="<?php echo $comicpress_options['content_width_disabled_sidebars']; ?>" />px
					</td>
					<td>
						<?php _e('When the sidebars are disabled on pages?  Default = 700','comicpress'); ?>
					</td>
				</tr>
			</table>
			
			<table class="widefat">
				<thead>
					<tr>
						<th colspan="3"><?php _e('Pages','comicpress'); ?></th>
					</tr>
				</thead>
				<tr class="alternate">
					<th scope="row"><label for="disable_page_titles"><?php _e('Disable the titles on pages','comicpress'); ?></label></th>
					<td>
						<input id="disable_page_titles" name="disable_page_titles" type="checkbox" value="1" <?php checked(true, $comicpress_options['disable_page_titles']); ?> />
					</td>
					<td>
						<?php _e('Page titles will be turned off.  If you disable the titles no pages you can still add a post-image in the page editor.','comicpress'); ?>
					</td>
				</tr>			
			</table>
			
			<table class="widefat">
				<thead>
					<tr>
						<th colspan="3"><?php _e('Posts','comicpress'); ?></th>
					</tr>
				</thead>
				<tr class="alternate">
					<th scope="row"><label for="disable_post_titles"><?php _e('Disable the titles on posts','comicpress'); ?></label></th>
					<td>
						<input id="disable_post_titles" name="disable_post_titles" type="checkbox" value="1" <?php checked(true, $comicpress_options['disable_post_titles']); ?> />
					</td>
					<td>
						<?php _e('Post titles will be turned off.  If you disable the titles on posts can still add a post-image in the post editor.','comicpress'); ?>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="enable_post_calendar"><?php _e('Add graphic calendar to blog posts','comicpress'); ?></label></th>
					<td>
						<input id="enable_post_calendar" name="enable_post_calendar" type="checkbox" value="1" <?php checked(true, $comicpress_options['enable_post_calendar']); ?> />
					</td>
					<td>
						<?php _e('Enabling this option will display a calendar image on your blog posts. The graphic calendar is an image that has the date of the blog post overlayed on top of it.','comicpress'); ?>
					</td>
				</tr>
				<tr class="alternate">
					<th scope="row"><label for="enable_post_author_gravatar"><?php _e('Enable Author Gravatar','comicpress'); ?></label></th>
					<td>
						<input id="enable_post_author_gravatar" name="enable_post_author_gravatar" type="checkbox" value="1" <?php checked(true, $comicpress_options['enable_post_author_gravatar']); ?> />
					</td>
					<td>
						<?php _e('Enabling this option will show a gravatar of the post author based on the author email address.  Gravatars are associated by your email address and you can create them at','comicpress'); ?> <a href="http://gravatar.com/">http://gravatar.com</a>.
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="enable_avatar_trick"><?php _e('Enable Avatar Mod','comicpress'); ?></label></th>
					<td>
						<input id="enable_avatar_trick" name="enable_avatar_trick" type="checkbox" value="1" <?php checked(true, $comicpress_options['enable_avatar_trick']); ?> />
					</td>
					<td>
						<?php _e('With this enabled, the avatar\'s that are displayed will be jquery modified to look like polaroids randomly tilted.','comicpress'); ?>
					</td>
				</tr>
				<tr class="alternate">
					<th scope="row"><label for="disable_tags_in_posts"><?php _e('Disable display of <strong>tags</strong> in posts','comicpress'); ?></label></th>
					<td>
						<input id="disable_tags_in_posts" name="disable_tags_in_posts" type="checkbox" value="1" <?php checked(true, $comicpress_options['disable_tags_in_posts']); ?> />
					</td>
					<td>
						<?php _e('Checkmarking this will make it so that tags will not appear in posts.','comicpress'); ?>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="disable_categories_in_posts"><?php _e('Disable display of <strong>categories</strong> in posts','comicpress'); ?></label></th>
					<td>
						<input id="disable_categories_in_posts" name="disable_categories_in_posts" type="checkbox" value="1" <?php checked(true, $comicpress_options['disable_categories_in_posts']); ?> />
					</td>
					<td>
						<?php _e('Checkmarking this will make it so that categories will not appear in posts.','comicpress'); ?>
					</td>
				</tr>
				<tr class="alternate">
					<th scope="row"><label for="disable_author_info_in_posts"><?php _e('Disable display of <strong>by Author</strong> in post information.','comicpress'); ?></label></th>
					<td>
						<input id="disable_author_info_in_posts" name="disable_author_info_in_posts" type="checkbox" value="1" <?php checked(true, $comicpress_options['disable_author_info_in_posts']); ?> />
					</td>
					<td>
						<?php _e('Checkmarking this will make it so that the by Author information will not appear in posts.','comicpress'); ?>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="disable_date_info_in_posts"><?php _e('Disable display of the posted on date in posts','comicpress'); ?></label></th>
					<td>
						<input id="disable_date_info_in_posts" name="disable_date_info_in_posts" type="checkbox" value="1" <?php checked(true, $comicpress_options['disable_date_info_in_posts']); ?> />
					</td>
					<td>
						<?php _e('Checkmarking this will make it so that posted on date information will not appear in posts.','comicpress'); ?>
					</td>
				</tr>
				<tr class="alternate">
					<th scope="row"><label for="disable_posted_at_time_in_posts"><?php _e('Disable the display of the posted at time in posts','comicpress'); ?></label></th>
					<td>
						<input id="disable_posted_at_time_in_posts" name="disable_posted_at_time_in_posts" type="checkbox" value="1" <?php checked(true, $comicpress_options['disable_posted_at_time_in_posts']); ?> />
					</td>
					<td>
						<?php _e('Checkmarking this will make it so that the information about what time the post was made will not show.','comicpress'); ?>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="enable_last_modified_in_posts"><?php _e('Enable the display of last modified information in posts.','comicpress'); ?></label></th>
					<td>
						<input id="enable_last_modified_in_posts" name="enable_last_modified_in_posts" type="checkbox" value="1" <?php checked(true, $comicpress_options['enable_last_modified_in_posts']); ?> />
					</td>
					<td>
						<?php _e('Checkmarking this will make it so that it will show when the last time that the post was modified in the post date information.','comicpress'); ?>
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
						<input id="disable_comment_note" name="disable_comment_note" type="checkbox" value="1" <?php checked(true, $comicpress_options['disable_comment_note']); ?> />
					</td>
					<td>
						<?php _e('Disabling this will remove the note text that displays with more options for adding to comments (html).','comicpress'); ?>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="disable_comment_javascript"><?php _e('Disable Comment Javascript','comicpress'); ?></label></th>
					<td>
						<input id="disable_comment_javascript" name="disable_comment_javascript" type="checkbox" value="1" <?php checked(true, $comicpress_options['disable_comment_javascript']); ?> />
					</td>
					<td>
						<?php _e('Checkmark this if you want the comment form to not use javascript to appear directly under who is being replied to. (increases pageviews/hits)','comicpress'); ?>
					</td>
				</tr>
				<tr class="alternate">
					<th scope="row"><label for="enable_comments_on_homepage"><?php _e('Enable Comments on Home Page','comicpress'); ?></label></th>
					<td>
						<input id="enable_comments_on_homepage" name="enable_comments_on_homepage" type="checkbox" value="1" <?php checked(true, $comicpress_options['enable_comments_on_homepage']); ?> />
					</td>
					<td>
						<?php _e('Checkmarking this option will make it so that the post(s) on the home page will also display the comments under them, This will ONLY work if you have it set to only display 1 post on the home page.  The post count and this must be set to work.','comicpress'); ?>
					</td>
				</tr>
<?php
$current_avatar_directory = $comicpress_options['avatar_directory'];
if (empty($current_avatar_directory)) $current_avatar_directory = 'default';
$avatar_directories = array();
$dirs_to_search = array_unique(array(comicpress_themeinfo('themepath'), comicpress_themeinfo('stylepath')));
foreach ($dirs_to_search as $avdir) { 
	if (is_dir($avdir . '/images/avatars')) {
		$thisdir = null;
		$thisdir = array();
		$thisdir = glob($avdir. '/images/avatars/*');
		$avatar_directories = array_merge($avatar_directories, $thisdir); 		
	}
}
				?>
				<tr>
					<th scope="row" colspan="2">
						<label for="avatar_directory"><?php _e('Avatar Directory','comicpress'); ?></label>
						<select name="avatar_directory" id="avatar_directory">
							<option class="level-0" value="none" <?php if ($current_avatar_directory == "none") { ?>selected="selected"<?php } ?>>none</option>
<?php
foreach ($avatar_directories as $avatar_dirs) {
	if (is_dir($avatar_dirs)) {
										$avatar_dir_name = basename($avatar_dirs); ?>
										<option class="level-0" value="<?php echo $avatar_dir_name; ?>" <?php if ($current_avatar_directory == $avatar_dir_name) { ?>selected="selected"<?php } ?>><?php echo $avatar_dir_name; ?></option>
	<?php }
}
							?>
						</select>
					</th>
					<td>
						<?php _e('Choose a directory to get the avatars for default gravatars if someone does not have one.  You will have to make these images yourself, or download them from avatar providers. Then make a new directory on your site server to upload them to and select that directory here. <strong>Setting this to \'none\' will disable it from using any special avatar sets.</strong>','comicpress'); ?><br />
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
						<input id="enable_numbered_pagination" name="enable_numbered_pagination" type="checkbox" value="1" <?php checked(true, $comicpress_options['enable_numbered_pagination']); ?> />
					</td>
					<td>
						<?php _e('Previous Entries and Next Entries buttons are replaced by a bar of numbered pages. Numbered pagination appears on the Home page, the author(s) page, the blog template, and comments/single when there are more then the set number of comments per page. Uses the same styling as the Menubar.','comicpress'); ?>
					</td>
				</tr>
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
						<input id="disable_footer_text" name="disable_footer_text" type="checkbox" value="1" <?php checked(true, $comicpress_options['disable_footer_text']); ?> />
					</td>
					<td>
						<?php _e('Default text in the footer will not display. Enable this if you do not want any text in the footer. If you wish to add you own custom content, you may do so via Appearance -> Widgets-> Footer.', 'comicpress'); ?>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="disable_scroll_to_top"><?php _e('Disable the scroll to top link in the footer?','comicpress'); ?></label></th>
					<td>
						<input id="disable_scroll_to_top" name="disable_scroll_to_top" type="checkbox" value="1" <?php checked(true, $comicpress_options['disable_scroll_to_top']); ?> />
					</td>
					<td>
						<?php _e('When this link is clicked on long pages it will scroll back to the top.','comicpress'); ?>
					</td>
				</tr>
				<tr class="alternate">
					<th scope="row"><label for="copyright_name"><?php _e('&copy; Copyright Name','comicpress'); ?></label>
						<input type="text" size="20" name="copyright_name" id="copyright_name" value="<?php echo  stripcslashes($comicpress_options['copyright_name']); ?>" /><br />
					</th>
					<td colspan="2">
						<?php _e('Set the name to which this site is &copy; Copyright to, leave blank to have the site name.','comicpress'); ?>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="copyright_url"><?php _e('Copyright Holder URL','comicpress'); ?></label>
						<input type="text" size="30" name="copyright_url" id="copyright_url" value="<?php echo  stripcslashes($comicpress_options['copyright_url']); ?>" /><br />
					</th>
					<td colspan="2">
						<?php _e('Set the URL to the owner of the &copy; Copyright if different then this website, leave blank for sites link.','comicpress'); ?>
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
					<th scope="row"><label for="enable_post_thumbnail_rss"><?php _e('Enable the post thumbnails in the RSS feed?','comicpress'); ?></label></th>
					<td>
						<input id="enable_post_thumbnail_rss" name="enable_post_thumbnail_rss" type="checkbox" value="1" <?php checked(true, $comicpress_options['enable_post_thumbnail_rss']); ?> />		
					</td>
					<td>
						<?php _e('If enabled will show the post thumbnail of the post in the RSS feed.','comicpress'); ?>
					</td>
				</tr>
			</table>		
			<table class="widefat">
				<thead>
					<tr>
						<th colspan="3"><?php _e('Archive & Search','comicpress'); ?></th>
					</tr>
				</thead>
				<tr class="alternate">
					<th scope="row"><label for="display_archive_as_links"><?php _e('Display archive results as a list of links?','comicpress'); ?></label></th>
					<td>
						<input id="display_archive_as_links" name="display_archive_as_links" type="checkbox" value="1" <?php checked(true, $comicpress_options['display_archive_as_links']); ?> />
					</td>
					<td>
						<?php _e('Enabling this will make the archive pages by date/category/term display as a list of links instead of full posts.','comicpress'); ?>
					</td>
				</tr>
				<tr>
					<th scope="row" colspan="2">
						<label for="excerpt_or_content_in_archive"><?php _e('Excerpt or Full Content in archive and search.','comicpress'); ?></label>
						<select name="excerpt_or_content_in_archive" id="excerpt_or_content_in_archive">
							<option class="level-0" value="excerpt" <?php selected($comicpress_options['excerpt_or_content_in_archive'], 'excerpt'); ?>>Excerpt</option>
							<option class="level-0" value="content" <?php selected($comicpress_options['excerpt_or_content_in_archive'], 'content'); ?>>Full Content</option>
						</select>
					</th>
					<td>
						<?php _e('If Display archives results as list is disabled, decide how much is seen in the archive display. ','comicpress'); ?>
					</td>
				</tr>				
				<tr class="alternate">
					<th scope="row" colspan="2">
						<label for="archive_display_order"><?php _e('Archive Display Order','comicpress'); ?></label>
						<select name="archive_display_order" id="archive_display_order">
							<option class="level-0" value="asc" <?php if ($comicpress_options['archive_display_order'] == "asc") { ?>selected="selected"<?php } ?>>Oldest to Newest - Ascending</option>
							<option class="level-0" value="desc" <?php if ($comicpress_options['archive_display_order'] == "desc") { ?>selected="selected"<?php } ?>>Newest to Oldest - Descending</option>
						</select>
					</th>
					<td>
						<?php _e('Sets the display order of your archives. Newest to Oldest will display your posts starting with the most recent. Oldest to Newest will start with the first entry in the category, tag, or date range (e.g., Selecting May 20XX will start with May 1, not May 31st.)','comicpress'); ?>
					</td>
				</tr>
			</table>
				
		</div>

		<div class="comicpress-options-save">
			<div class="comicpress-major-publishing-actions">
				<div class="comicpress-publishing-action">
					<input name="comicpress_save_general" type="submit" class="button-primary" value="<?php _e('Save Settings','comicpress'); ?>" />
					<input type="hidden" name="action" value="comicpress_save_general" />
				</div>
				<div class="clear"></div>
			</div>
		</div>

	</form>

</div>
