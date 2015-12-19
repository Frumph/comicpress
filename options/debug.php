<div id="comicpress-debug">
	<form method="post" id="myForm-debug" enctype="multipart/form-data" action="?page=comicpress-options">
		<?php wp_nonce_field('update-options') ?>

		<div class="comicpress-options">
	
			<table class="widefat">
				<thead>
					<tr>
						<th colspan="3">
							<?php _e( 'Debug', 'comicpress' ); ?>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr class="alternate">
						<th scope="row">
							<label for="enable_debug_footer_code">
								<?php _e( 'Enable the debug page load/memory usage at the bottom of each page?', 'comicpress' ); ?>
							</label>
						</th>
						<td>
							<input id="enable_debug_footer_code" name="enable_debug_footer_code" type="checkbox" value="1" <?php checked(true, $comicpress_options['enable_debug_footer_code']); ?> />
						</td>
						<td>
							<?php _e( 'If enabled will show information on how many queries, memory is used as well as how fast the page loads.', 'comicpress' ); ?>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="force_active_connection_close">
								<?php _e( 'Force MySQL to close the current active connection after page load?', 'comicpress' ); ?>
							</label>
						</th>
						<td>
							<input id="force_active_connection_close" name="force_active_connection_close" type="checkbox" value="1" <?php checked(true, $comicpress_options['force_active_connection_close']); ?> />
						</td>
						<td>
							<?php _e( 'This option forces mysql to close the connection after each page load &mdash; not recommended unless you are requested to enable it.', 'comicpress' ); ?>
						</td>
					</tr>
				</tbody>
			</table>
			<br />
			
		</div>

		<div class="comicpress-options-save">
			<div class="comicpress-major-publishing-actions">
				<div class="comicpress-publishing-action">
					<input name="comicpress_save_debug" type="submit" class="button-primary" value="<?php _e( 'Save Settings', 'comicpress' ); ?>" />
					<input type="hidden" name="action" value="comicpress_save_debug" />
				</div>
				<div class="clear"></div>
			</div>
		</div>
		
		<table class="widefat">
		<!--
			<?php 
			// hidden with <!-- from displaying, but not hidden from view-source
			$variable_dump = comicpress_themeinfo(); 
			if (is_array($variable_dump)) {
			while (list($key, $value) = each($variable_dump)) { ?>
			<tr>
				<td style= "width: 330px;">
					<?php var_dump($key); ?>
				</td>
				<td>
					<?php var_dump($value); ?>
				</td>
			</tr>
			<?php }
			}
			?>
		// -->
		</table>
		
	</form>
</div>