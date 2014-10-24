<script language="javascript" type="text/javascript">
	function lshowimage(sel,pic) {
	if (!document.images) return
	document.getElementById(pic).src = '<?php echo get_template_directory_uri(); ?>/images/options/'+sel.options[sel.selectedIndex].value+'.png'
	}
</script>
<script language="javascript" type="text/javascript">
	function sshowimage(sel,pic) {
	if (!document.images) return
	document.getElementById(pic).src = '<?php echo get_template_directory_uri(); ?>/images/schemes/'+sel.options[sel.selectedIndex].value+'.jpg'
	}
</script>
<div id="comicpress-layout">
	<form method="post" id="myForm-layout" enctype="multipart/form-data" action="?page=comicpress-options">
	<?php wp_nonce_field('update-options') ?>

		<div class="comicpress-options">

			<table class="widefat" cellspacing="0">
				<thead>
					<tr>
						<th colspan="4"><?php _e('Layout','comicpress'); ?></th>
					</tr>
				</thead>
				<?php if (!isset($comicpress_options['layout']) || empty($comicpress_options['layout'])) $comicpress_options['layout'] = '3c'; ?>
				<tr class="alternate">
					<th scope="row" style="width:250px"><label for="layout" style="text-align:left"><?php _e('Choose Your Website Layout','comicpress'); ?></label>
						<select name="layout" id="layout" onchange="lshowimage(this,'thelayout')">
							<option class="level-0" value="3c" <?php if ($comicpress_options['layout'] == '3c') { ?>selected="selected" <?php } ?>><?php _e('3 Column - Standard','comicpress'); ?></option>
							<option class="level-0" value="3cl" <?php if ($comicpress_options['layout'] == '3cl') { ?>selected="selected" <?php } ?>><?php _e('3 Column - Sidebar\'s on Left','comicpress'); ?></option>
							<option class="level-0" value="3cr" <?php if ($comicpress_options['layout'] == '3cr') { ?>selected="selected" <?php } ?>><?php _e('3 Column - Sidebar\'s on Right','comicpress'); ?></option>
							<option class="level-0" value="2cl" <?php if ($comicpress_options['layout'] == '2cl') { ?>selected="selected" <?php } ?>><?php _e('2 Column - Sidebar on Left (780px)','comicpress'); ?></option>
							<option class="level-0" value="2cr" <?php if ($comicpress_options['layout'] == '2cr') { ?>selected="selected" <?php } ?>><?php _e('2 Column - Sidebar on Right (780px)','comicpress'); ?></option>
							<option class="level-0" value="2clw" <?php if ($comicpress_options['layout'] == '2clw') { ?>selected="selected" <?php } ?>><?php _e('2 Column Wide - Sidebar on Left (980px)', 'comicpress'); ?></option>
							<option class="level-0" value="2crw" <?php if ($comicpress_options['layout'] == '2crw') { ?>selected="selected" <?php } ?>><?php _e('2 Column Wide - Sidebar on Right (980px)','comicpress'); ?></option>
							<option class="level-0" value="3clgn" <?php if ($comicpress_options['layout'] == '3clgn') { ?>selected="selected" <?php } ?>><?php _e('3 Column - Sidebar on Left, Sidebar on right under comic. ','comicpress'); ?></option>
							<option class="level-0" value="3crgn" <?php if ($comicpress_options['layout'] == '3crgn') { ?>selected="selected" <?php } ?>><?php _e('3 Column - Sidebar on Right, Sidebar on left under comic.','comicpress'); ?></option>							
						</select>
						<br />
					</th>
					<td>
						<img id="thelayout" src="<?php echo get_template_directory_uri(); ?>/images/options/<?php echo $comicpress_options['layout']; ?>.png" alt="Layout" />
					</td>
					<td style="vertical-align:middle">
					</td>
				</tr>
			</table>
			<br />
			<strong><?php _e('Schemes and customization can be modified in the appearance - customize section of the wp-admin','comicpress'); ?></strong>
			<br />
		</div>
		<div class="comicpress-options-save">
			<div class="comicpress-major-publishing-actions">
				<div class="comicpress-publishing-action">
					<input name="comicpress_save_layout" type="submit" class="button-primary" value="<?php _e('Save Settings','comicpress'); ?>" />
					<input type="hidden" name="action" value="comicpress_save_layout" />
				</div>
				<div class="clear"></div>
			</div>
		</div>

	</form>

</div>
