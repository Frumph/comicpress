<div id="comicpress-comments">
	<form method="post" id="myForm-general" enctype="multipart/form-data" action="?page=comicpress-options">
		<?php wp_nonce_field('update-options') ?>

		<div class="comicpress-options">

			<table class="widefat">
				<thead>
					<tr>
						<th colspan="3">
							<?php _e( 'Comments', 'comicpress' ); ?>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr class="alternate">
						<th scope="row">
							<label for="disable_comment_note">
								<?php _e( 'Disable the comment notes?', 'comicpress' ); ?>
							</label>
						</th>
						<td>
							<input id="disable_comment_note" name="disable_comment_note" type="checkbox" value="1" <?php checked(true, $comicpress_options['disable_comment_note']); ?> />
						</td>
						<td>
							<?php _e( 'Disabling this will remove the note text that displays with more options for adding to comments (html).', 'comicpress' ); ?>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="disable_comment_javascript">
								<?php _e( 'Disable Comment Javascript?', 'comicpress' ); ?>
							</label>
						</th>
						<td>
							<input id="disable_comment_javascript" name="disable_comment_javascript" type="checkbox" value="1" <?php checked(true, $comicpress_options['disable_comment_javascript']); ?> />
						</td>
						<td>
							<?php _e( 'Checkmark this if you want the comment form to not use javascript to appear directly under who is being replied to. (increases pageviews/hits)', 'comicpress' ); ?>
						</td>
					</tr>
					<tr class="alternate">
						<th scope="row">
							<label for="enable_comments_on_homepage">
								<?php _e( 'Enable Comments on Home Page?', 'comicpress' ); ?>
							</label>
						</th>
						<td>
							<input id="enable_comments_on_homepage" name="enable_comments_on_homepage" type="checkbox" value="1" <?php checked(true, $comicpress_options['enable_comments_on_homepage']); ?> />
						</td>
						<td>
							<?php _e( 'Checkmarking this option will make it so that the post(s) on the home page will also display the comments under them. This will ONLY work if you have it set to only display 1 post on the home page. The post count and this must be set to work.', 'comicpress' ); ?>
						</td>
					</tr>
					
					<?php
					$current_avatar_directory = $comicpress_options['avatar_directory'];
					if (empty($current_avatar_directory))
    					$current_avatar_directory = 'default';
					$avatar_directories = array();
					$dirs_to_search = array_unique(array(get_template_directory(), get_stylesheet_directory()));
					foreach ($dirs_to_search as $avdir) {
    					if (is_dir($avdir . '/images/avatars')) {
							$thisdir = null;
							$thisdir = array();
							$thisdir = glob($avdir . '/images/avatars/*');
							$avatar_directories = array_merge($avatar_directories, $thisdir);
						}
					}
					?>
					
					<tr>
						<th scope="row" colspan="2">
							<label for="avatar_directory">
								<?php _e( 'Avatar Directory', 'comicpress' ); ?>
							</label>
							<select name="avatar_directory" id="avatar_directory">
								<option class="level-0" value="none" <?php if ($current_avatar_directory == "none") { ?>selected="selected"<?php } ?>>
									<?php _e( 'none', 'comicpress' ); ?>
								</option>
								<?php
								foreach ($avatar_directories as $avatar_dirs) {
									if (is_dir($avatar_dirs)) {
										$avatar_dir_name = basename($avatar_dirs); ?>
								<option class="level-0" value="<?php echo $avatar_dir_name; ?>" <?php if ($current_avatar_directory == $avatar_dir_name) { ?>selected="selected"<?php } ?>>
									<?php echo $avatar_dir_name; ?>
								</option>
								<?php }
								}
								?>
							</select>
						</th>
						<td>
							<?php _e( 'Choose a directory to get the avatars for default gravatars if someone does not have one. You will have to make these images yourself, or download them from avatar providers. Then make a new directory on your site server to upload them to and select that directory here. Setting this to <strong>none</strong> will disable it from using any special avatar sets.', 'comicpress' ); ?>
							<br />
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
					<input type="hidden" name="action" value="comicpress_save_comments" />
				</div>
				<div class="clear"></div>
			</div>
		</div>

	</form>
</div>