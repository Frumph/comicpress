<div id="sidebar-right">
	<?php if (comicpress_themeinfo('enable_caps')) { ?><div class="sidebar-head"></div><?php } ?>
		<div class="sidebar">
		<?php 
		if ( !dynamic_sidebar('right-sidebar') ) {
			if (is_cp_theme_layout('standard,v')) { 
				the_widget('comicpress_calendar_widget');
			}
			if (comicpress_themeinfo('disable_comic_frontpage')) {
				the_widget('comicpress_latest_thumbnail_widget','title=Latest Comic&thumbcat='.comicpress_themeinfo('comiccat'));
			}
			the_widget('WP_Widget_Pages');
			the_widget('WP_Widget_Categories','hierarchical=1&count=1&dropdown=0');
		}
		?>
		</div>
	<?php if (comicpress_themeinfo('enable_caps')) { ?><div class="sidebar-foot"></div><?php } ?>
</div>