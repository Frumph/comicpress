<div id="comicpress-debug">

	<div class="comicpress-options">
	
		<form method="post" id="myForm-debug" enctype="multipart/form-data" action="?page=comicpress-options">
		<?php wp_nonce_field('update-options') ?>
		<table class="widefat">
			<thead>
				<tr>
					<th colspan="3"><?php _e('Debug','comicpress'); ?></th>
				</tr>
			</thead>			
			<tr class="alternate">
				<th scope="row"><label for="enable_debug_footer_code"><?php _e('Enable the debug page load/memory usage at the bottom of each page?','comicpress'); ?></label></th>
				<td>
					<input id="enable_debug_footer_code" name="enable_debug_footer_code" type="checkbox" value="1" <?php checked(true, $comicpress_options['enable_debug_footer_code']); ?> />
				</td>
				<td>
					<?php _e('If enabled will show information on how many queries, memory is used as well as how fast the page loads.','comicpress'); ?>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="force_active_connection_close"><?php _e('Force MySQL to close the current active connection after page load?','comicpress'); ?></label></th>
				<td>
					<input id="force_active_connection_close" name="force_active_connection_close" type="checkbox" value="1" <?php checked(true, $comicpress_options['force_active_connection_close']); ?> />		
				</td>
				<td>
					<?php _e('This option forces mysql to close the connection after each page load - not recommended unless you are requested to enable it.','comicpress'); ?>
				</td>
			</tr>
		</table>

		<div class="comicpress-options-save">
			<div class="comicpress-major-publishing-actions">
				<div class="comicpress-publishing-action">
					<input name="comicpress_save_debug" type="submit" class="button-primary" value="Save Settings" />
					<input type="hidden" name="action" value="comicpress_save_debug" />
				</div>
				<div class="clear"></div>
			</div>
		</div>
		
		</form>
		
		<table class="widefat" style="width: 100%">
		<tr>
			<td colspan="5">
				Technical Support is available on the <a href="https://github.com/Frumph/comicpress/issues">github repository</a> or use the Contact form on <a href="http://frumph.net" target="_blank">Frumph.NET</a>
			</td>
		<tr>
			<td>
			<strong>Site URL</strong>:(siteurl) <?php echo comicpress_themeinfo('siteurl'); ?><br />
			<strong>Blog URL</strong>:(home) <?php echo comicpress_themeinfo('home'); ?><br />
			<br />
<table class="widefat">
<?php 
$variable_dump = comicpress_themeinfo(); 
if (is_array($variable_dump)) {
	while (list($key, $value) = each($variable_dump)) { ?>
	<tr>
		<td> <?php var_dump($key); ?></td>
		<td> <?php var_dump($value); ?></td>
	</tr>
	<?php }
}
?>
</table>
			</td>
		</tr>
		</table>
	</div>
</div>

