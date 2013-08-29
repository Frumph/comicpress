<div id="sidebar-right">
	<div class="sidebar">
	<?php
		do_action('easel-sidebar-right');
		if ( !dynamic_sidebar('sidebar-right-sidebar') ) { ?>
		<div class="sidebar-no-widgets">
			<?php _e('There are currently no widgets assigned to the right-sidebar, place some!','easel'); ?><br />
			<br />
			<?php _e('Once you add widgets to this sidebar, this default information will go away.','easel'); ?><br />
			<br />
			<?php _e('This theme also uses the WordPress 3.0 Menu system.  You probably see the default stuff you have in the menubar.  Go to Appearance -> Menu in the wp-admin (dashboard) and create a new menu.','easel'); ?><br />
		</div>
			<h2><?php _e('Recommended Plugins','easel'); ?></h2>
			<ol>
				<li><a href="http://wordpress.org/extend/plugins/vipers-video-quicktags/">Viper's Video Quicktags</a></li>
				<li><a href="http://wordpress.org/extend/plugins/audio-player/">Audio Player</a></li>
				<li><a href="http://wordpress.org/extend/plugins/comicpress-companion/">Theme Companion</a></li>
			</ol>						
		<?php }
	?>
	</div>
</div>
