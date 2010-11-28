
<div id="comicpress-debug">
	<div class="comicpress-options">
		<table class="widefat" style="width: 100%">
		<tr>
			<td>
			<strong>Site URL</strong>:(siteurl) <?php echo get_option('siteurl'); ?><br />
			<strong>Blog URL</strong>:(home) <?php echo home_url(); ?><br />
			<br />
			<strong>Theme Path</strong>:(themepath) <?php echo get_template_directory(); ?><br />
			<strong>Theme URL</strong>:(themeurl) <?php echo get_template_directory_uri(); ?><br />
			<?php if (is_child_theme()) { ?>
				<strong>Child Theme Path</strong>:(childpath) <?php echo get_stylesheet_directory(); ?><br />
				<strong>Child Theme URL</strong>:(childurl) <?php echo get_stylesheet_directory_uri(); ?><br />
			<?php } ?>
			<strong>Upload Path</strong>:(path) <?php echo comicpress_themeinfo('path'); ?><br />
			<strong>Upload Path Sub Dir</strong>:(subdir) <?php echo comicpress_themeinfo('subdir'); ?><br />
			<strong>Upload Path Base Dir</strong>:(basedir) <?php echo comicpress_themeinfo('basedir'); ?><br />
			<strong>Upload Base URL</strong>:(baseurl) <?php echo comicpress_themeinfo('baseurl'); ?><br />
			<br />
			<strong>Category Tree:</strong><br />
			<?php var_dump(comicpress_themeinfo('category_tree')); ?><br />
			<br />
			<?php var_dump(comicpress_themeinfo()); ?>
			</td>
		</tr>
		</table>
	</div>
</div>
