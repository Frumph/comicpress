<div id="easel-menubar">
	<form method="post" id="myForm-menubar" enctype="multipart/form-data" action="?page=easel-options">
	<?php wp_nonce_field('update-options') ?>

		<div class="easel-options">

			<table class="widefat">
				<thead>
					<tr>
						<th colspan="3"><?php _e('Menubar','easel'); ?></th>
					</tr>
				</thead>
				<tr class="alternate">
					<th scope="row"><label for="disable_default_menubar"><?php _e('Disable default Menubar','easel'); ?></label></th>
					<td>
						<input id="disable_default_menubar" name="disable_default_menubar" type="checkbox" value="1" <?php checked(true, $easel_options['disable_default_menubar']); ?> />
					</td>
					<td>
						<?php _e('Allows you to customize the location of the Menubar via Widgets or, just not have it.','easel'); ?>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="enable_search_in_menubar"><?php _e('Enable Search Form','easel'); ?></label></th>
					<td>
						<input id="enable_search_in_menubar" name="enable_search_in_menubar" type="checkbox" value="1" <?php checked(true, $easel_options['enable_search_in_menubar']); ?> />
					</td>
					<td>
						<?php _e('Searchforms can be fun when you have something to search for.','easel'); ?>
					</td>
				</tr>
				<tr class="alternate">
					<th scope="row"><label for="enable_rss_in_menubar"><?php _e('Enable RSS Link','easel'); ?></label></th>
					<td>
						<input id="enable_rss_in_menubar" name="enable_rss_in_menubar" type="checkbox" value="1" <?php checked(true, $easel_options['enable_rss_in_menubar']); ?> />
					</td>
					<td>
					<?php _e('Adds an RSS link icon to your menubar on the right side.','easel'); ?>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="disable_jquery_menu_code"><?php _e('Disable the menubar jQuery?','easel'); ?></label></th>
					<td>
						<input id="disable_jquery_menu_code" name="disable_jquery_menu_code" type="checkbox" value="1" <?php checked(true, $easel_options['disable_jquery_menu_code']); ?> />
					</td>
					<td>
						<?php _e('Disable the loading of the menubar jQuery.  If you do not want the ddsmoother menu code to load. (will not do drop downs without it)','easel'); ?>
					</td>
				</tr>

				<tr>
					<th scope="row"><label for="enable_breadcrumbs"><?php _e('Enable Breadcrumbs?','easel'); ?></label></th>
					<td>
						<input id="enable_breadcrumbs" name="enable_breadcrumbs" type="checkbox" value="1" <?php checked(true, $easel_options['enable_breadcrumbs']); ?> />
					</td>
					<td>
						<?php _e('This will create a pathable breathcrumbs beneith the menubar underneith the default menubar location.','easel'); ?>
					</td>
				</tr>
			</table>
			<br />
			<table class="widefat">
				<thead>
					<tr>
						<th colspan="3"><?php _e('Menubar - Social Icons','easel'); ?></th>
					</tr>
				</thead>
				<tr class="alternate">
					<th scope="row" align="top" valign="top"><label for="menubar_social_icons"><?php _e('Enable Social Icons in Menubar?','easel'); ?></label></th>
					<td align="top" valign="top">
						<input id="menubar_social_icons" name="menubar_social_icons" type="checkbox" value="1" <?php checked(true, $easel_options['menubar_social_icons']); ?> />
					</td>
					<td>
					<?php _e('Adds additional social icons in the menubar on in the menunav area.  Put the entire http:// url in the input box that leads to your account on those sites.  Leave field empty if you do not have one and it will not show.','easel'); ?><br />
					<br />
					<strong><?php _e('Twitter','easel'); ?></strong><br />
					<input type="text" size="60" name="menubar_social_twitter" id="menubar_social_twitter" value="<?php echo $easel_options['menubar_social_twitter']; ?>" /><br />
					<strong><?php _e('Facebook','easel'); ?></strong><br />
					<input type="text" size="60" name="menubar_social_facebook" id="menubar_social_facebook" value="<?php echo $easel_options['menubar_social_facebook']; ?>" /><br />
					<strong><?php _e('Google+','easel'); ?></strong><br />
					<?php if (!isset($easel_options['menubar_social_googleplus'])) $easel_options['menubar_social_googleplus'] = ''; ?>					
					<input type="text" size="60" name="menubar_social_googleplus" id="menubar_social_googleplus" value="<?php echo $easel_options['menubar_social_googleplus']; ?>" /><br />
					<strong><?php _e('LinkedIn','easel'); ?></strong><br />
					<?php if (!isset($easel_options['menubar_social_linkedin'])) $easel_options['menubar_social_linkedin'] = ''; ?>					
					<input type="text" size="60" name="menubar_social_linkedin" id="menubar_social_linkedin" value="<?php echo $easel_options['menubar_social_linkedin']; ?>" /><br />					
					<strong><?php _e('pinterest','easel'); ?></strong><br />
					<?php if (!isset($easel_options['menubar_social_pinterest'])) $easel_options['menubar_social_pinterest'] = ''; ?>
					<input type="text" size="60" name="menubar_social_pinterest" id="menubar_social_pinterest" value="<?php echo $easel_options['menubar_social_pinterest']; ?>" /><br />
					<strong><?php _e('YouTube','easel'); ?></strong><br />
					<?php if (!isset($easel_options['menubar_social_youtube'])) $easel_options['menubar_social_youtube'] = ''; ?>
					<input type="text" size="60" name="menubar_social_youtube" id="menubar_social_youtube" value="<?php echo $easel_options['menubar_social_youtube']; ?>" /><br />
					<strong><?php _e('Flickr','easel'); ?></strong><br />
					<?php if (!isset($easel_options['menubar_social_flickr'])) $easel_options['menubar_social_flickr'] = ''; ?>
					<input type="text" size="60" name="menubar_social_flickr" id="menubar_social_flickr" value="<?php echo $easel_options['menubar_social_flickr']; ?>" /><br />
					<strong><?php _e('Tumblr','easel'); ?></strong><br />
					<?php if (!isset($easel_options['menubar_social_tumblr'])) $easel_options['menubar_social_tumblr'] = ''; ?>
					<input type="text" size="60" name="menubar_social_tumblr" id="menubar_social_tumblr" value="<?php echo $easel_options['menubar_social_tumblr']; ?>" /><br />
					<strong><?php _e('DeviantART','easel'); ?></strong><br />
					<?php if (!isset($easel_options['menubar_social_deviantart'])) $easel_options['menubar_social_deviantart'] = ''; ?>
					<input type="text" size="60" name="menubar_social_deviantart" id="menubar_social_deviantart" value="<?php echo $easel_options['menubar_social_deviantart']; ?>" /><br />
					<strong><?php _e('MySpace','easel'); ?></strong><br />
					<?php if (!isset($easel_options['menubar_social_myspace'])) $easel_options['menubar_social_myspace'] = ''; ?>
					<input type="text" size="60" name="menubar_social_myspace" id="menubar_social_myspace" value="<?php echo $easel_options['menubar_social_myspace']; ?>" /><br />
					<strong><?php _e('Email - use mailto://your@email.com','easel'); ?></strong><br />
					<?php if (!isset($easel_options['menubar_social_email'])) $easel_options['menubar_social_email'] = ''; ?>
					<input type="text" size="60" name="menubar_social_email" id="menubar_social_email" value="<?php echo $easel_options['menubar_social_email']; ?>" /><br />
					</td>
				</tr>
			</table>
		</div>

		<div class="easel-options-save">
			<div class="easel-major-publishing-actions">
				<div class="easel-publishing-action">
					<input name="easel_save_menubar" type="submit" class="button-primary" value="Save Settings" />
					<input type="hidden" name="action" value="easel_save_menubar" />
				</div>
				<div class="clear"></div>
			</div>
		</div>

	</form>

</div>
