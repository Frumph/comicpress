<div id="sidebar-left">
	<div class="sidebar-head"></div>
		<div class="sidebar">
		<?php 
			if ( !dynamic_sidebar('left-sidebar') ) {
				if (!is_cp_theme_layout('standard,v')) { 
					the_widget('comicpress_calendar_widget');
				}
				the_widget('comicpress_latest_comics_widget');
			}
		?>
		</div>
	<div class="sidebar-foot"></div>
</div>