<div id="sidebar-left">
	<?php if (comicpress_themeinfo('enable_caps')) { ?><div class="sidebar-head"></div><?php } ?>
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
	<?php if (comicpress_themeinfo('enable_caps')) { ?><div class="sidebar-foot"></div><?php } ?>
</div>