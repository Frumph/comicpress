<script language="javascript" type="text/javascript">
	function showimage(sel,pic) {
	if (!document.images)
	return
	document.getElementById(pic).src = '<?php echo get_template_directory_uri(); ?>/images/options/'+sel.options[sel.selectedIndex].value+'.png'
	}
</script>

<div id="comicpress-themestyle">

	<div class="comicpress-options">
		
	<div class="cpadmin-footer">
		<div class="comicpress-forum">Forums are at <a href="http://comicpress.net/forum/">http://comicpress.net/forum/</a> for Technical Assistance</div>
		<div id="comicpress-version-title"><a href="http://comicpress.net/">ComicPress <?php echo comicpress_themeinfo('version'); ?></a></div>
		<br />
		<?php _e('Developed and maintained by','comicpress'); ?> <a href="http://frumph.net/">Philip M. Hofer</a> <small>(<a href="http://frumph.net/">Frumph</a>)</small>, <?php _e('Originally created by','comicpress'); ?> <a href="http://mindfaucet.com/">Tyler Martin</a><br />
		<?php _e('If you like the ComicPress theme, please donate.  It will help in developing new features and versions.','comicpress'); ?>
		<table style="margin:0 auto;">
			<tr>
				<td style="width:200px;">
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
	<input type="hidden" name="cmd" value="_s-xclick" />
	<input type="hidden" name="hosted_button_id" value="46RNWXBE7467Q" />
	<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" name="submit" alt="PayPal - The safer, easier way to pay online!" />
	<img alt="" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1" />
</form>
				</td>
				<td style="width:200px;">
					<a href="http://comicpress.net/"><img src="<?php echo get_template_directory_uri(); ?>/images/cal/default.png" /></a>
				</td>
				<td style="width:200px;">
					<form method="post" id="myForm" name="template" enctype="multipart/form-data" action="">
						<?php wp_nonce_field('update-options') ?>
						<input name="comicpress_reset" type="submit" class="button" value="Reset All Settings" />
						<input type="hidden" name="action" value="comicpress_reset" />
					</form>
				</td>
			</tr>
		</table>
	</div>

	<form method="post" id="myForm-themestyle" enctype="multipart/form-data" action="?page=comicpress-options">

	<?php wp_nonce_field('update-options') ?>
	
			<table class="widefat nolowermargin" cellspacing="0">
				<thead>
					<tr>
						<th colspan="4"><?php _e('Layout','comicpress'); ?></th>
					</tr>
				</thead>
				<?php global $avail_layouts; ?>
				<tr class="alternate">
					<th scope="row" style="width:250px"><label for="cp_theme_layout" style="text-align:left"><?php _e('Choose Your Website Layout','comicpress'); ?></label>
						<select name="cp_theme_layout" id="cp_theme_layout" onchange="showimage(this,'cpthemestyle')">
						<?php if (is_cp_layout_avail('2cr',$avail_layouts)) { ?>
							<option class="level-0" value="2cr" <?php if (comicpress_themeinfo('cp_theme_layout') == '2cr') { ?>selected="selected" <?php } ?>><?php _e('2 Column - Sidebar on Right','comicpress'); ?></option>
						<?php } ?>
						<?php if (is_cp_layout_avail('2cl',$avail_layouts)) { ?>
							<option class="level-0" value="2cl" <?php if (comicpress_themeinfo('cp_theme_layout') == '2cl') { ?>selected="selected" <?php } ?>><?php _e('2 Column - Sidebar on Left','comicpress'); ?></option>
						<?php } ?>
						<?php if (is_cp_layout_avail('2cvr',$avail_layouts)) { ?>
							<option class="level-0" value="2cvr" <?php if (comicpress_themeinfo('cp_theme_layout') =='2cvr') { ?>selected="selected" <?php } ?>><?php _e('2 Column - Vertical, Sidebar on Right','comicpress'); ?></option>
						<?php } ?>
						<?php if (is_cp_layout_avail('2cvl',$avail_layouts)) { ?>
							<option class="level-0" value="2cvl" <?php if (comicpress_themeinfo('cp_theme_layout') =='2cvl') { ?>selected="selected" <?php } ?>><?php _e('2 Column - Vertical, Sidebar on Left','comicpress'); ?></option>
						<?php } ?>
						<?php if (is_cp_layout_avail('3c',$avail_layouts)) { ?>
							<option class="level-0" value="3c" <?php if (comicpress_themeinfo('cp_theme_layout') =='3c') { ?>selected="selected" <?php } ?>><?php _e('3 Column','comicpress'); ?></option>
						<?php } ?>
						<?php if (is_cp_layout_avail('3c2r',$avail_layouts)) { ?>
							<option class="level-0" value="3c2r" <?php if (comicpress_themeinfo('cp_theme_layout') =='3c2r') { ?>selected="selected" <?php } ?>><?php _e('3 Column - Double Right Sidebar','comicpress'); ?></option>
						<?php } ?>
						<?php if (is_cp_layout_avail('3c2l',$avail_layouts)) { ?>
							<option class="level-0" value="3c2l" <?php if (comicpress_themeinfo('cp_theme_layout') =='3c2l') { ?>selected="selected" <?php } ?>><?php _e('3 Column - Double Left Sidebar','comicpress'); ?></option>
						<?php } ?>
						<?php if (is_cp_layout_avail('v3c',$avail_layouts)) { ?>
							<option class="level-0" value="v3c" <?php if (comicpress_themeinfo('cp_theme_layout') =='v3c') { ?>selected="selected" <?php } ?>><?php _e('3 Column - Vertical','comicpress'); ?></option>
						<?php } ?>
						<?php if (is_cp_layout_avail('v3cr',$avail_layouts)) { ?>
							<option class="level-0" value="v3cr" <?php if (comicpress_themeinfo('cp_theme_layout') =='v3cr') { ?>selected="selected" <?php } ?>><?php _e('3 Column - Vertical Double Right Sidebar','comicpress'); ?></option>
						<?php } ?>
						<?php if (is_cp_layout_avail('v3cl',$avail_layouts)) { ?>
							<option class="level-0" value="v3cl" <?php if (comicpress_themeinfo('cp_theme_layout') =='v3cl') { ?>selected="selected" <?php } ?>><?php _e('3 Column - Vertical Double left Sidebar','comicpress'); ?></option>
						<?php } ?>
						<?php if (is_cp_layout_avail('lgn',$avail_layouts)) { ?>
							<option class="level-0" value="lgn" <?php if (comicpress_themeinfo('cp_theme_layout') =='lgn') { ?>selected="selected" <?php } ?>><?php _e('Graphic Novel - Left Sidebar','comicpress'); ?></option>
						<?php } ?>
						<?php if (is_cp_layout_avail('rgn',$avail_layouts)) { ?>
							<option class="level-0" value="rgn" <?php if (comicpress_themeinfo('cp_theme_layout') =='rgn') { ?>selected="selected" <?php } ?>><?php _e('Graphic Novel - Right Sidebar','comicpress'); ?></option>
						<?php } ?>
						</select>
						<br />
						<?php if (!empty($avail_layouts)) { ?>
						<em><strong>Some layouts might not be available with this child theme.</strong></em>
						<?php } ?>
					</th>
					<td>
						<img id="cpthemestyle" src="<?php echo get_template_directory_uri(); ?>/images/options/<?php echo comicpress_themeinfo('cp_theme_layout'); ?>.png" alt="ComicPress Theme Style" />
					</td>
					<td style="vertical-align:middle">
						<?php _e('2 column layout default width: <strong>780px</strong>.','comicpress'); ?>
						<br/><br/>
						<?php _e('3 column layout (<em>includes Graphic Novel</em>) default width: <b>980px</b>.','comicpress'); ?>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="enable_caps"><?php _e('Enable -head and -foot caps?','comicpress'); ?></label></th>
					<td>
						<input id="enable_caps" name="enable_caps" type="checkbox" value="1" <?php checked(true, comicpress_themeinfo('enable_caps')); ?> />
					</td>
					<td>
						<?php _e('Enabling this option will create post-head widget-head and various other div alignments increasing the amount of dom elements available to use in designing your site, however will reduce the speed in which the page is shown on the end users browser.','comicpress'); ?>
					</td>
				</tr>
			</table>
		<div class="comicpress-options-save">
			<div class="comicpress-major-publishing-actions">
				<div class="comicpress-publishing-action">
					<input name="comicpress_save_layout" type="submit" class="button-primary" value="Save Layout" />
					<input type="hidden" name="action" value="comicpress_save_layout" />
				</div>
				<div class="clear"></div>
			</div>
		</div>
		
			<table class="widefat" cellspacing="0">
				<thead>
					<tr>
						<th colspan="4"><?php _e('Child Themes','comicpress'); ?></th>
					</tr>
				</thead>
				<tr>
					<td colspan="5">
					These child themes can be downloaded at <a href="http://comicpress.net/downloads/comicpress-child-themes/" target="_blank">ComicPress.net</a>, child themes are like regular themes but they only contain the "look" of your site.  It is best if you use a child theme so that when you upgrade ComicPress you do not lose any of your site's design.  Child themes are also 'base' designs, where you can modify them to look as you wish; they're created to give you a place to start with your own site design.
					You install child themes just like the regular ComicPress theme, into the wp-content/themes/ directory, then activate it and it will use the design from the chlid theme and the code from the main ComicPress theme.   Most people use the child-theme as a central location for their site design images since it does not disappear or change if you upgrade the main ComicPress theme.
					</td>
				</tr>
				<tr>
				<td>
				<table>
				<tr>
					<td><img src="<?php echo get_template_directory_uri(); ?>/images/screenshots/comicpress-silverii.jpg" alt="ComicPress Silver II" /></td>
					<td><img src="<?php echo get_template_directory_uri(); ?>/images/screenshots/comicpress-boxed.jpg" alt="ComicPress Silver" /></td>
					<td><img src="<?php echo get_template_directory_uri(); ?>/images/screenshots/comicpress-foreboding.jpg" alt="ComicPress Silver" /></td>
				</tr>
				<tr>
					<td><img src="<?php echo get_template_directory_uri(); ?>/images/screenshots/comicpress-red.jpg" alt="ComicPress Silver" /></td>
					<td><img src="<?php echo get_template_directory_uri(); ?>/images/screenshots/comicpress-sandy.jpg" alt="ComicPress Silver" /></td>
					<td><img src="<?php echo get_template_directory_uri(); ?>/images/screenshots/comicpress-greymatter.jpg" alt="ComicPress Silver" /></td>
				</tr>
				</table>
				</td>
				</tr>
			</table>		
			<div class="clear"></div>

		</div>
	</form>

	<div class="clear"></div>

</div>
