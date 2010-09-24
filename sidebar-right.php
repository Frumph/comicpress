<?php if (!comicpress_themeinfo('disable_lrsidebars') && !is_page('chat') && !is_page('forum')) { ?>
<div id="sidebar-right">
	<div class="sidebar-head"></div>
		<div class="sidebar">
		<?php 
		if ( !dynamic_sidebar('right-sidebar') ) : 
			if (is_cp_theme_layout('standard,v')) { 
				the_widget('comicpress_calendar_widget');
			}
			if (comicpress_themeinfo('disable_comic_frontpage')) {
				the_widget('comicpress_latest_thumbnail_widget','title=Latest Comic&thumbcat='.comicpress_themeinfo('comiccat'));
			}
			the_widget('WP_Widget_Pages');
			the_widget('WP_Widget_Categories','hierarchical=1&count=1&dropdown=0');
		endif; 
		?>
		</div>
	<div class="sidebar-foot"></div>
</div>
<?php } ?>
