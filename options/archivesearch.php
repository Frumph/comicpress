<div id="comicpress-archivesearch">
	<form method="post" id="myForm-general" enctype="multipart/form-data" action="?page=comicpress-options">
		<?php wp_nonce_field('update-options') ?>

		<div class="comicpress-options">
		
			<table class="widefat">
				<thead>
					<tr>
						<th colspan="3">
							<?php _e( 'Archive & Search', 'comicpress' ); ?>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr class="alternate">
						<th scope="row">
							<label for="display_archive_as_links">
								<?php _e( 'Display archive results as a list of links?', 'comicpress' ); ?>
							</label>
						</th>
						<td>
							<input id="display_archive_as_links" name="display_archive_as_links" type="checkbox" value="1" <?php checked(true, $comicpress_options['display_archive_as_links']); ?> />
						</td>
						<td>
							<?php _e('Enabling this will make the archive pages by date/category/term display as a list of links instead of full posts.', 'comicpress' ); ?>
						</td>
					</tr>
					<tr>
						<th scope="row" colspan="2">
							<label for="excerpt_or_content_in_archive">
								<?php _e( 'Excerpt or Full Content in archive and search?', 'comicpress' ); ?>
							</label>
							<select name="excerpt_or_content_in_archive" id="excerpt_or_content_in_archive">
								<option class="level-0" value="excerpt" <?php selected($comicpress_options['excerpt_or_content_in_archive'], 'excerpt'); ?>>
									<?php _e( 'Excerpt', 'comicpress' ); ?>
								</option>
								<option class="level-0" value="content" <?php selected($comicpress_options['excerpt_or_content_in_archive'], 'content'); ?>>
									<?php _e( 'Full Content', 'comicpress' ); ?>
								</option>
							</select>
						</th>
						<td>
							<?php _e( 'If Display archives results as list is disabled, decide how much is seen in the archive display.', 'comicpress' ); ?>
						</td>
					</tr>
					<tr class="alternate">
						<th scope="row" colspan="2">
							<label for="archive_display_order">
								<?php _e( 'Archive Display Order', 'comicpress' ); ?>
							</label>
							<select name="archive_display_order" id="archive_display_order">
								<option class="level-0" value="asc" <?php if ($comicpress_options['archive_display_order'] == "asc") { ?>selected="selected"<?php } ?>>
									<?php _e( 'Oldest to Newest &mdash; Ascending', 'comicpress' ); ?>
								</option>
								<option class="level-0" value="desc" <?php if ($comicpress_options['archive_display_order'] == "desc") { ?>selected="selected"<?php } ?>>
									<?php _e( 'Newest to Oldest &mdash; Descending', 'comicpress' ); ?>
								</option>
							</select>
						</th>
						<td>
							<?php _e( 'Sets the display order of your archives. Newest to Oldest will display your posts starting with the most recent. Oldest to Newest will start with the first entry in the category, tag, or date range (e.g. Selecting May 20XX will start with May 1, not May 31st.)', 'comicpress' ); ?>
						</td>
					</tr>
				</tbody>
			</table>
			<br />
			
			<table class="widefat">
				<thead>
					<tr>
						<th colspan="3">
							<?php _e( 'Navigation', 'comicpress' ); ?>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr class="alternate">
						<th scope="row">
							<label for="enable_numbered_pagination">
								<?php _e( 'Enable numbered pagination?', 'comicpress' ); ?>
							</label>
						</th>
						<td>
							<input id="enable_numbered_pagination" name="enable_numbered_pagination" type="checkbox" value="1" <?php checked(true, $comicpress_options['enable_numbered_pagination']); ?> />
						</td>
						<td>
							<?php _e( 'Previous Entries and Next Entries buttons are replaced by a bar of numbered pages. Numbered pagination appears on the Home page, the author(s) page, the blog template, and comments/single when there are more then the set number of comments per page. Uses the same styling as the Menubar.', 'comicpress' ); ?>
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
					<input type="hidden" name="action" value="comicpress_save_archivesearch" />
				</div>
				<div class="clear"></div>
			</div>
		</div>

	</form>
</div>