<?php 
if (!comicpress_themeinfo('disable_lrsidebars') && !is_page('chat') && !is_page('forum')) { ?>
<div id="sidebar-left">
	<div class="sidebar-head"></div>
		<div class="sidebar">
		<?php 
			if ( !dynamic_sidebar('left-sidebar') ) :
				if (!is_cp_theme_layout('standard,v')) { 
					the_widget('comicpress_calendar_widget');
				}
				the_widget('comicpress_latest_comics_widget');
			endif; 
		?>
		</div>
	<div class="sidebar-foot"></div>
</div>
<?php } ?>
