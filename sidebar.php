<div id="sidebar">
	<div class="sidebar">
	<?php 
		do_action('sidebar');
		if ( !dynamic_sidebar() ) { ?>
		<div class="sidebar-no-widgets">
			<?php _e('There are currently no widgets assigned to the left-sidebar, place some!','comicpress'); ?><br />
			<br />
			<?php _e('Once you add widgets to this sidebar, this default information will go away.','comicpress'); ?><br />
			<br />
			<?php _e('Widgets can be added by going to your dashboard (wp-admin) -> Appearance -> Widgets, drag a widget you want to see into one of the appropriate sidebars.','comicpress'); ?><br />
		</div>
		<?php }
	?>
	</div>
</div>
