<div id="comicpress-postspages">
	<form method="post" id="myForm-general" enctype="multipart/form-data" action="?page=comicpress-options">
		<?php wp_nonce_field('update-options') ?>

		<div class="comicpress-options">

			<table class="widefat">
				<thead>
					<tr>
						<th colspan="3">
							<?php _e( 'Posts', 'comicpress' ); ?>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr class="alternate">
						<th scope="row">
						<label for="disable_post_titles">
							<?php _e( 'Disable the titles on posts?', 'comicpress' ); ?>
						</label>
						</th>
						<td>
							<input id="disable_post_titles" name="disable_post_titles" type="checkbox" value="1" <?php checked(true, $comicpress_options['disable_post_titles']); ?> />
						</td>
						<td>
							<?php _e( 'Post titles will be turned off. If you disable the titles on posts can still add a post-image in the post editor.', 'comicpress' ); ?>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="enable_post_calendar">
								<?php _e( 'Add graphic calendar to blog posts?', 'comicpress' ); ?>
							</label>
						</th>
						<td>
							<input id="enable_post_calendar" name="enable_post_calendar" type="checkbox" value="1" <?php checked(true, $comicpress_options['enable_post_calendar']); ?> />
						</td>
						<td>
							<?php _e( 'Enabling this option will display a calendar image on your blog posts. The graphic calendar is an image that has the date of the blog post overlayed on top of it.', 'comicpress' ); ?>
						</td>
					</tr>
					<tr class="alternate">
						<th scope="row">
							<label for="enable_post_author_gravatar">
								<?php _e( 'Enable Author Gravatar?', 'comicpress' ); ?>
							</label>
						</th>
						<td>
							<input id="enable_post_author_gravatar" name="enable_post_author_gravatar" type="checkbox" value="1" <?php checked(true, $comicpress_options['enable_post_author_gravatar']); ?> />
						</td>
						<td>
							<?php _e( 'Enabling this option will show a gravatar of the post author based on the author email address. Gravatars are associated by your email address and you can create them at', 'comicpress' ); ?> <a href="https://gravatar.com/" target="_blank">https://gravatar.com</a>.
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="enable_avatar_trick">
								<?php _e( 'Enable Avatar Mod?', 'comicpress' ); ?>
							</label>
						</th>
						<td>
							<input id="enable_avatar_trick" name="enable_avatar_trick" type="checkbox" value="1" <?php checked(true, $comicpress_options['enable_avatar_trick']); ?> />
						</td>
						<td>
							<?php _e( 'With this enabled, the avatar\'s that are displayed will be jquery modified to look like polaroids randomly tilted.', 'comicpress' ); ?>
						</td>
					</tr>
					<tr class="alternate">
						<th scope="row">
							<label for="disable_tags_in_posts">
								<?php _e( 'Disable display of <strong>tags</strong> in posts?', 'comicpress' ); ?>
							</label>
						</th>
						<td>
							<input id="disable_tags_in_posts" name="disable_tags_in_posts" type="checkbox" value="1" <?php checked(true, $comicpress_options['disable_tags_in_posts']); ?> />
						</td>
						<td>
							<?php _e( 'Checkmarking this will make it so that tags will not appear in posts.', 'comicpress' ); ?>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="disable_categories_in_posts">
								<?php _e( 'Disable display of <strong>categories</strong> in posts?', 'comicpress' ); ?>
							</label>
						</th>
						<td>
							<input id="disable_categories_in_posts" name="disable_categories_in_posts" type="checkbox" value="1" <?php checked(true, $comicpress_options['disable_categories_in_posts']); ?> />
						</td>
						<td>
							<?php _e( 'Checkmarking this will make it so that categories will not appear in posts.', 'comicpress' ); ?>
						</td>
					</tr>
					<tr class="alternate">
						<th scope="row">
							<label for="disable_author_info_in_posts">
								<?php _e( 'Disable display of <strong>by Author</strong> in post information?', 'comicpress' ); ?>
							</label>
						</th>
						<td>
							<input id="disable_author_info_in_posts" name="disable_author_info_in_posts" type="checkbox" value="1" <?php checked(true, $comicpress_options['disable_author_info_in_posts']); ?> />
						</td>
						<td>
							<?php _e( 'Checkmarking this will make it so that the by Author information will not appear in posts.', 'comicpress' ); ?>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="disable_date_info_in_posts">
								<?php _e( 'Disable display of the posted on date in posts?', 'comicpress' ); ?>
							</label>
						</th>
						<td>
							<input id="disable_date_info_in_posts" name="disable_date_info_in_posts" type="checkbox" value="1" <?php checked(true, $comicpress_options['disable_date_info_in_posts']); ?> />
						</td>
						<td>
							<?php _e( 'Checkmarking this will make it so that posted on date information will not appear in posts.', 'comicpress' ); ?>
						</td>
					</tr>
					<tr class="alternate">
						<th scope="row">
							<label for="disable_posted_at_time_in_posts">
								<?php _e( 'Disable the display of the posted at time in posts?', 'comicpress' ); ?>
							</label>
						</th>
						<td>
							<input id="disable_posted_at_time_in_posts" name="disable_posted_at_time_in_posts" type="checkbox" value="1" <?php checked(true, $comicpress_options['disable_posted_at_time_in_posts']); ?> />
						</td>
						<td>
							<?php _e( 'Checkmarking this will make it so that the information about what time the post was made will not show.', 'comicpress' ); ?>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="enable_last_modified_in_posts">
								<?php _e( 'Enable the display of last modified information in posts?', 'comicpress' ); ?>
							</label>
						</th>
						<td>
							<input id="enable_last_modified_in_posts" name="enable_last_modified_in_posts" type="checkbox" value="1" <?php checked(true, $comicpress_options['enable_last_modified_in_posts']); ?> />
						</td>
						<td>
							<?php _e( 'Checkmarking this will make it so that it will show when the last time that the post was modified in the post date information.', 'comicpress' ); ?>
						</td>
					</tr>
					
					<?php
					$current_directory = comicpress_themeinfo('moods_directory');
					if (empty($current_directory)) $current_directory = 'default';
					$dirs_to_search = array_unique(array(get_template_directory(), get_stylesheet_directory()));
					$mood_directories = array();
					foreach ($dirs_to_search as $moodir) {
						if (is_dir($moodir . '/images/moods')) {
							$thisdir = null;
							$thisdir = array();
							$thisdir = glob($moodir. '/images/moods/*');
							$mood_directories = array_merge($mood_directories, $thisdir);
						}
					}
					?>
					
					<tr class="alternate">
						<th scope="row" colspan="2">
						<label for="moods_directory">
							<?php _e( 'Moods Directory','comicpress' ); ?>
						</label>
							<select name="moods_directory" id="moods_directory">
								<option class="level-0" value="none" <?php if ($current_directory == "none") { ?>selected="selected"<?php } ?>><?php _e( 'none', 'comicpress' ); ?></option>
								<?php
								foreach ($mood_directories as $mood_dirs) {
									if (is_dir($mood_dirs)) {
										$mood_dir_name = basename($mood_dirs); ?>
										<option class="level-0" value="<?php echo $mood_dir_name; ?>" <?php if ($current_directory == $mood_dir_name) { ?>selected="selected"<?php } ?>><?php echo $mood_dir_name; ?></option>
									<?php }
								}
								?>
							</select>
						</th>
						<td>
							<?php _e('Choose a directory to get the post moods from. Set this to <strong>none</strong> to turn off use. Mood directories are found in your theme directory/images/moods/* . To create your own custom moods just create a directory under images/moods/ and place ONLY image files inside of it. The name of the image file represents what the mood is.','comicpress'); ?>
						</td>
					</tr>
				</tbody>
			</table>
			<br />
			
			<table class="widefat">
				<thead>
					<tr>
						<th colspan="3"><?php _e( 'Pages', 'comicpress' ); ?></th>
					</tr>
				</thead>
				<tr class="alternate">
					<th scope="row">
						<label for="disable_page_titles">
							<?php _e( 'Disable the titles on pages?', 'comicpress' ); ?>
						</label>
					</th>
					<td>
						<input id="disable_page_titles" name="disable_page_titles" type="checkbox" value="1" <?php checked(true, $comicpress_options['disable_page_titles']); ?> />
					</td>
					<td>
						<?php _e( 'Page titles will be turned off. If you disable the titles no pages you can still add a post-image in the page editor.', 'comicpress' ); ?>
					</td>
				</tr>
			</table>
			<br />
			
			<table class="widefat">
				<thead>
					<tr>
						<th colspan="3">
							<?php _e( 'Content Width', 'comicpress' ); ?>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>				
						<?php
						if (!isset($comicpress_options['content_width']))
							$comicpress_options['content_width'] = 500;
						?>				
						<th scope="row">
							<label for="content_width">
								<?php _e( 'Media and images width on posts and pages?', 'comicpress' ); ?>
							</label>
						</th>
						<td>
							<input type="text" size="4" name="content_width" id="content_width" value="<?php echo $comicpress_options['content_width']; ?>" /> px
						</td>
						<td>
							<?php _e( 'This sets a specific width for WordPress to use for media content within your posts and pages. Default = 500', 'comicpress' ); ?>
						</td>
					</tr>
					<tr class="alternate">
						<?php
						if (!isset($comicpress_options['content_width_disabled_sidebars']))
							$comicpress_options['content_width_disabled_sidebars'] = 700;
						?>
						<th scope="row">
							<label for="content_width_disabled_sidebars">
								<?php _e( 'Media and images width when sidebars are disabled on pages?', 'comicpress' ); ?>
							</label>
						</th>
						<td>
							<input type="text" size="4" name="content_width_disabled_sidebars" id="content_width" value="<?php echo $comicpress_options['content_width_disabled_sidebars']; ?>" /> px
						</td>
						<td>
							<?php _e( 'When the sidebars are disabled on pages? Default = 700', 'comicpress' ); ?>
						</td>
					</tr>
				</tbody>	
			</table>
			<br />
			
		</div>

		<div class="comicpress-options-save">
			<div class="comicpress-major-publishing-actions">
				<div class="comicpress-publishing-action">
					<input name="comicpress_save_general" type="submit" class="button-primary" value="<?php _e( 'Save Settings', 'comicpress' ); ?>" />
					<input type="hidden" name="action" value="comicpress_save_postspages" />
				</div>
				<div class="clear"></div>
			</div>
		</div>
		
	</form>
</div>