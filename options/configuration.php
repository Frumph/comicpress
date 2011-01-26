<div id="comicpress-config">
	<form method="post" id="myForm-config" enctype="multipart/form-data" action="">
	<?php wp_nonce_field('update-options') ?>

		<div class="comicpress-options">

			<table class="widefat">

				<thead>
					<tr>
						<th colspan="5"><?php _e('Configuration','comicpress'); ?></th>
					</tr>
				</thead>

				<tr class="alternate">
					<th scope="row">
						<label for="comiccat"><?php _e('Comic Category','comicpress'); ?></label>
						<?php
							$select = wp_dropdown_categories('show_option_all=Select category&hide_empty=0&show_count=0&orderby=name&echo=0&selected='.comicpress_themeinfo('comiccat'));
							$select = preg_replace('#<select([^>]*)>#', '<select name="comiccat" id="comicccat">', $select);
							echo $select;
						?>
					</th>
					<td>
						<?php _e('The category that is designated for the primary comic category.','comicpress'); ?>
					</td>
				</tr>

				<tr>
					<th scope="row">
						<label for="comiccat"><?php _e('Blog Category','comicpress'); ?></label>
						<?php
							$blogcat = comicpress_themeinfo('blogcat');
							$select = wp_dropdown_categories('show_option_all=Select category&hide_empty=0&show_count=0&orderby=name&echo=0&selected='.$blogcat);
							$select = preg_replace('#<select([^>]*)>#', '<select name="blogcat" id="blogcat">', $select);
							echo $select;
						?>
					</th>
					<td>
						<?php _e('The primary blog category.','comicpress'); ?>
					</td>
				</tr>
				<?php
					$directories = glob(comicpress_themeinfo('basedir').'/*');
					$current_directory = comicpress_themeinfo('comic_folder');
				?>
				<tr class="alternate">
					<th scope="row"><label for="comic_folder"><?php _e('Comic Folder','comicpress'); ?></label>

							<select name="comic_folder" id="comic_folder">
								<?php
									foreach ($directories as $dirs) {
										if (is_dir($dirs)) {
											$dir_name = basename($dirs); ?>
											<option class="level-0" value="<?php echo $dir_name; ?>" <?php if ($current_directory == $dir_name) { ?>selected="selected"<?php } ?>><?php echo $dir_name; ?></option>
									<?php }
									}
								?>
							</select>

					</th>
					<td>
						<?php _e('Choose a directory to get the original sized comics from.','comicpress'); ?>
					</td>
				</tr>
				<tr>
					<th scope="row" colspan="3">
						<?php _e('If you set the directory for the rss, mini and archive to the base comic folder, it will utilize the original as images and not look for a thumbnail.  Alternatively if it does not find a thumbnail it will fallback to the original as well.','comicpress'); ?>
					</th>
				</tr>
				<?php
					$current_directory = comicpress_themeinfo('rss_comic_folder');
				?>
				<tr>
					<th scope="row"><label for="rss_comic_folder"><?php _e('RSS Thumbnail Folder','comicpress'); ?></label>

							<select name="rss_comic_folder" id="rss_comic_folder">
								<?php
									foreach ($directories as $dirs) {
										if (is_dir($dirs)) {
											$dir_name = basename($dirs); ?>
											<option class="level-0" value="<?php echo $dir_name; ?>" <?php if ($current_directory == $dir_name) { ?>selected="selected"<?php } ?>><?php echo $dir_name; ?></option>
									<?php }
									}
								?>
							</select>

					</th>
					<td>
						<?php _e('Choose a directory to get the RSS thumbnails from.','comicpress'); ?>
					</td>
				</tr>

				<?php
					$current_directory = comicpress_themeinfo('archive_comic_folder');
				?>
				<tr class="alternate">
					<th scope="row"><label for="archive_comic_folder"><?php _e('Archive Thumbnail Folder','comicpress'); ?></label>

							<select name="archive_comic_folder" id="archive_comic_folder">
								<?php
									foreach ($directories as $dirs) {
										if (is_dir($dirs)) {
											$dir_name = basename($dirs); ?>
											<option class="level-0" value="<?php echo $dir_name; ?>" <?php if ($current_directory == $dir_name) { ?>selected="selected"<?php } ?>><?php echo $dir_name; ?></option>
									<?php }
									}
								?>
							</select>

					</th>
					<td>
						<?php _e('Choose a directory to get the Archive/Search thumbnails from.','comicpress'); ?>
					</td>
				</tr>

				<?php
					$current_directory = comicpress_themeinfo('mini_comic_folder');
				?>
				<tr>
					<th scope="row"><label for="mini_comic_folder"><?php _e('Mini Thumbnail Folder','comicpress'); ?></label>

							<select name="mini_comic_folder" id="mini_comic_folder">
								<?php
									foreach ($directories as $dirs) {
										if (is_dir($dirs)) {
											$dir_name = basename($dirs); ?>
											<option class="level-0" value="<?php echo $dir_name; ?>" <?php if ($current_directory == $dir_name) { ?>selected="selected"<?php } ?>><?php echo $dir_name; ?></option>
									<?php }
									}
								?>
							</select>

					</th>
					<td>
						<?php _e('Choose a directory to get the Mini thumbnails from. (for archive-comic-list, etc.)','comicpress'); ?>
					</td>
				</tr>

				<tr class="alternate">
					<th scope="row"><label for="rss_comic_width"><?php _e('RSS Thumbnail Width','comicpress'); ?></label></th>
					<td colspan="2">
						<input type="text" size="7" name="rss_comic_width" id="rss_comic_width" value="<?php echo comicpress_themeinfo('rss_comic_width'); ?>" />
					</td>
				</tr>

				<tr>
					<th scope="row"><label for="archive_comic_width"><?php _e('Archive Thumbnail Width','comicpress'); ?></label></th>
					<td colspan="2">
						<input type="text" size="7" name="archive_comic_width" id="archive_comic_width" value="<?php echo comicpress_themeinfo('archive_comic_width'); ?>" />
					</td>
				</tr>

				<tr class="alternate">
					<th scope="row"><label for="mini_comic_width"><?php _e('Mini Thumbnail Width','comicpress'); ?></label></th>
					<td colspan="2">
						<input type="text" size="7" name="mini_comic_width" id="mini_comic_width" value="<?php echo comicpress_themeinfo('mini_comic_width'); ?>" />
					</td>
				</tr>
		
			</table>

		</div>

		<div class="comicpress-options-save">
			<div class="comicpress-major-publishing-actions">
				<div class="comicpress-publishing-action">
					<input name="comicpress_save_config" type="submit" class="button-primary" value="Save Settings" />
					<input type="hidden" name="action" value="comicpress_save_config" />
				</div>
				<div class="clear"></div>
			</div>
		</div>

	</form>

</div>
