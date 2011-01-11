<div id="comicpress-menubar">

	<form method="post" id="myForm-menubar" enctype="multipart/form-data" action="?page=comicpress-options">
	<?php wp_nonce_field('update-options') ?>

		<div class="comicpress-options">

			<table class="widefat">
				<thead>
					<tr>
						<th colspan="3"><?php _e('Menubar','comicpress'); ?></th>
					</tr>
				</thead>
				<tr class="alternate">
					<th scope="row"><label for="disable_default_menubar"><?php _e('Disable default Menubar','comicpress'); ?></label></th>
					<td>
						<input id="disable_default_menubar" name="disable_default_menubar" type="checkbox" value="1" <?php checked(true, comicpress_themeinfo('disable_default_menubar')); ?> />
					</td>
					<td>
						<?php _e('Allows you to customize the location of the Menubar via Widgets.','comicpress'); ?>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="enable_search_in_menubar"><?php _e('Enable Search Form','comicpress'); ?></label></th>
					<td>
						<input id="enable_search_in_menubar" name="enable_search_in_menubar" type="checkbox" value="1" <?php checked(true, comicpress_themeinfo('enable_search_in_menubar')); ?> />
					</td>
					<td>
						<?php _e('Searchforms can be fun when you have something to search for.','comicpress'); ?>
					</td>
				</tr>
				<tr class="alternate">
					<th scope="row"><label for="enable_rss_in_menubar"><?php _e('Enable RSS Link','comicpress'); ?></label></th>
					<td>
						<input id="enable_rss_in_menubar" name="enable_rss_in_menubar" type="checkbox" value="1" <?php checked(true, comicpress_themeinfo('enable_rss_in_menubar')); ?> />
					</td>
					<td>
					<?php _e('Adds an RSS link icon to your menubar on the right side.','comicpress'); ?>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="enable_navigation_in_menubar"><?php _e('Enable mini navigation','comicpress'); ?></label></th>
					<td>
						<input id="enable_navigation_in_menubar" name="enable_navigation_in_menubar" type="checkbox" value="1" <?php checked(true, comicpress_themeinfo('enable_navigation_in_menubar')); ?> />
					</td>
					<td>
						<?php _e('Mini Navigation adds small previous and next arrows arrow to the right side of your Menubar.','comicpress'); ?>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="disable_jquery_menu_code"><?php _e('Disable the menubar jQuery?','comicpress'); ?></label></th>
					<td>
						<input id="disable_jquery_menu_code" name="disable_jquery_menu_code" type="checkbox" value="1" <?php checked(true, comicpress_themeinfo('disable_jquery_menu_code')); ?> />
					</td>
					<td>
						<?php _e('Disable the loading of the menubar jQuery, useful if you use a custom menubar.','comicpress'); ?>
					</td>
				</tr>
			</table>

		</div>

		<div class="comicpress-options-save">
			<div class="comicpress-major-publishing-actions">
				<div class="comicpress-publishing-action">
					<input name="comicpress_save_menubar" type="submit" class="button-primary" value="Save Settings" />
					<input type="hidden" name="action" value="comicpress_save_menubar" />
				</div>
				<div class="clear"></div>
			</div>
		</div>

	</form>

</div>
