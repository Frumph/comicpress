<div id="comicpress-menubar">
	<form method="post" id="myForm-menubar" enctype="multipart/form-data" action="?page=comicpress-options">
		<?php wp_nonce_field('update-options') ?>

		<div class="comicpress-options">

			<table class="widefat">
				<thead>
					<tr>
						<th colspan="3">
							<?php _e( 'Menubar', 'comicpress' ); ?>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr class="alternate">
						<th scope="row">
							<label for="disable_default_menubar">
								<?php _e( 'Disable default Menubar?', 'comicpress' ); ?>
							</label>
						</th>
						<td>
							<input id="disable_default_menubar" name="disable_default_menubar" type="checkbox" value="1" <?php checked(true, $comicpress_options['disable_default_menubar']); ?> />
						</td>
						<td>
							<?php _e( 'Allows you to customize the location of the Menubar via Widgets or, just not have it.', 'comicpress' ); ?>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="enable_search_in_menubar">
								<?php _e( 'Enable Search Form?', 'comicpress' ); ?>
							</label>
						</th>
						<td>
							<input id="enable_search_in_menubar" name="enable_search_in_menubar" type="checkbox" value="1" <?php checked(true, $comicpress_options['enable_search_in_menubar']); ?> />
						</td>
						<td>
							<?php _e( 'Searchforms can be fun when you have something to search for.', 'comicpress' ); ?>
						</td>
					</tr>
					<tr class="alternate">
						<th scope="row">
							<label for="enable_rss_in_menubar">
								<?php _e( 'Enable RSS Link?', 'comicpress' ); ?>
							</label>
						</th>
						<td>
							<input id="enable_rss_in_menubar" name="enable_rss_in_menubar" type="checkbox" value="1" <?php checked(true, $comicpress_options['enable_rss_in_menubar']); ?> />
						</td>
						<td>
							<?php _e( 'Adds an RSS link icon to your menubar on the right side.', 'comicpress' ); ?>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="disable_jquery_menu_code">
								<?php _e( 'Disable the menubar jQuery?', 'comicpress' ); ?>
							</label>
						</th>
						<td>
							<input id="disable_jquery_menu_code" name="disable_jquery_menu_code" type="checkbox" value="1" <?php checked(true, $comicpress_options['disable_jquery_menu_code']); ?> />
						</td>
						<td>
							<?php _e( 'Disable the loading of the menubar jQuery. If you do not want the ddsmoother menu code to load. (Will not do drop downs without it.)', 'comicpress' ); ?>
						</td>
					</tr>
					<tr class="alternate">
						<th scope="row">
							<label for="enable_breadcrumbs">
								<?php _e( 'Enable Breadcrumbs?', 'comicpress' ); ?>
							</label>
						</th>
						<td>
							<input id="enable_breadcrumbs" name="enable_breadcrumbs" type="checkbox" value="1" <?php checked(true, $comicpress_options['enable_breadcrumbs']); ?> />
						</td>
						<td>
							<?php _e( 'This will create a pathable breathcrumbs beneith the menubar underneith the default menubar location.', 'comicpress' ); ?>
						</td>
					</tr>
				</tbody>
			</table>
			<br />
			
			<table class="widefat">
				<thead>
					<tr>
						<th colspan="3">
							<?php _e( 'Menubar &mdash; Social Icons', 'comicpress' ); ?>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr class="alternate">
						<th scope="row">
							<label for="menubar_social_icons">
								<?php _e( 'Enable Social Icons in Menubar?', 'comicpress' ); ?>
							</label>
						</th>
						<td>
							<input id="menubar_social_icons" name="menubar_social_icons" type="checkbox" value="1" <?php checked(true, $comicpress_options['menubar_social_icons']); ?> />
						</td>
						<td>
							<?php _e( 'Adds additional social icons in the menubar on in the menunav area. Put the entire http:// url in the input box that leads to your account on those sites. Leave field empty if you do not have one and it will not show.', 'comicpress' ); ?>
						</td>
					</tr>
				</tbody>
			</table>
			
			<table class="widefat">
				<tr>
					<td>
						<strong><?php _e( 'Twitter', 'comicpress' ); ?></strong>
					</td>
					<td>
						<input type="text" size="60" name="menubar_social_twitter" id="menubar_social_twitter" value="<?php echo $comicpress_options['menubar_social_twitter']; ?>" />
					</td>
				</tr>
				<tr>
					<td>
						<strong><?php _e( 'Facebook', 'comicpress' ); ?></strong>
					</td>
					<td>
						<input type="text" size="60" name="menubar_social_facebook" id="menubar_social_facebook" value="<?php echo $comicpress_options['menubar_social_facebook']; ?>" />
					</td>
				</tr>
				<tr>
					<td>
						<strong><?php _e( 'Google+', 'comicpress' ); ?></strong>
					</td>
					<?php
					if (!isset($comicpress_options['menubar_social_googleplus']))
						$comicpress_options['menubar_social_googleplus'] = '';
 					?>
					<td>
						<input type="text" size="60" name="menubar_social_googleplus" id="menubar_social_googleplus" value="<?php echo $comicpress_options['menubar_social_googleplus']; ?>" />
					</td>
				</tr>
				<tr>
					<td>
						<strong><?php _e( 'LinkedIn', 'comicpress' ); ?></strong>
					</td>
					<?php
					if (!isset($comicpress_options['menubar_social_linkedin']))
						$comicpress_options['menubar_social_linkedin'] = '';
					?>
					<td>
						<input type="text" size="60" name="menubar_social_linkedin" id="menubar_social_linkedin" value="<?php echo $comicpress_options['menubar_social_linkedin']; ?>" />
					</td>
				</tr>
				<tr>
					 <td>
					 	<strong><?php _e( 'pinterest', 'comicpress' ); ?></strong>
					 </td>
					<?php
					if (!isset($comicpress_options['menubar_social_pinterest']))
						$comicpress_options['menubar_social_pinterest'] = '';
 					?>
					<td>
						<input type="text" size="60" name="menubar_social_pinterest" id="menubar_social_pinterest" value="<?php echo $comicpress_options['menubar_social_pinterest']; ?>" />
					</td>
				</tr>
				<tr>
					<td>
						<strong><?php _e( 'YouTube', 'comicpress' ); ?></strong>
					</td>
					<?php
					if (!isset($comicpress_options['menubar_social_youtube']))
						$comicpress_options['menubar_social_youtube'] = '';
					?>
					<td>
						<input type="text" size="60" name="menubar_social_youtube" id="menubar_social_youtube" value="<?php echo $comicpress_options['menubar_social_youtube']; ?>" />
					</td>
				</tr>
				<tr>
					<td>
						<strong><?php _e( 'Flickr', 'comicpress' ); ?></strong>
					</td>
					<?php
					if (!isset($comicpress_options['menubar_social_flickr']))
						$comicpress_options['menubar_social_flickr'] = '';
					?>
					<td>
						<input type="text" size="60" name="menubar_social_flickr" id="menubar_social_flickr" value="<?php echo $comicpress_options['menubar_social_flickr']; ?>" />
					</td>
				</tr>
				<tr>
					<td>
						<strong><?php _e( 'Tumblr', 'comicpress' ); ?></strong>
					</td>
					<?php
					if (!isset($comicpress_options['menubar_social_tumblr']))
						$comicpress_options['menubar_social_tumblr'] = '';
					?>
					<td>
						<input type="text" size="60" name="menubar_social_tumblr" id="menubar_social_tumblr" value="<?php echo $comicpress_options['menubar_social_tumblr']; ?>" />
					</td>
				</tr>
				<tr>
					<td>
						<strong><?php _e( 'DeviantART', 'comicpress' ); ?></strong>
					</td>
					<?php
					if (!isset($comicpress_options['menubar_social_deviantart']))
						$comicpress_options['menubar_social_deviantart'] = '';
					?>
					<td>
						<input type="text" size="60" name="menubar_social_deviantart" id="menubar_social_deviantart" value="<?php echo $comicpress_options['menubar_social_deviantart']; ?>" />
					</td>
				</tr>
				<tr>
					<td>
						<strong><?php _e( 'MySpace', 'comicpress' ); ?></strong>
					</td>
					<?php
					if (!isset($comicpress_options['menubar_social_myspace']))
						$comicpress_options['menubar_social_myspace'] = '';
					?>
					<td>
						<input type="text" size="60" name="menubar_social_myspace" id="menubar_social_myspace" value="<?php echo $comicpress_options['menubar_social_myspace']; ?>" />
					</td>
				</tr>
				<tr>
					<td>
						<strong><?php _e( 'Email', 'comicpress' ); ?></strong>
					</td>
					<?php
					if (!isset($comicpress_options['menubar_social_email']))
						$comicpress_options['menubar_social_email'] = '';
					?>
					<td>
						<input type="text" size="60" name="menubar_social_email" id="menubar_social_email" value="<?php echo $comicpress_options['menubar_social_email']; ?>" />
						<br />
						<?php _e( 'use mailto://your@email.com', 'comicpress' ); ?>
					</td>
				</tr>
			</table>
			<br />
			
		</div>

		<div class="comicpress-options-save">
			<div class="comicpress-major-publishing-actions">
				<div class="comicpress-publishing-action">
					<input name="comicpress_save_menubar" type="submit" class="button-primary" value="<?php _e( 'Save Settings', 'comicpress' ); ?>" />
					<input type="hidden" name="action" value="comicpress_save_menubar" />
				</div>
				<div class="clear"></div>
			</div>
		</div>
		
	</form>
</div>