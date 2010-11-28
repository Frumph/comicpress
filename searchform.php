<form method="get" id="searchform" action="<?php echo home_url(); ?>">
	<div>
		<input type="text" value="<?php _e('Search...','comicpress'); ?>" name="s" id="s-search" onfocus="this.value=(this.value=='<?php _e('Search...','comicpress'); ?>') ? '' : this.value;" onblur="this.value=(this.value=='') ? '<?php _e('Search...','comicpress'); ?>' : this.value;" />
		<button type="submit">&raquo;</button>
	</div>
	<div class="clear"></div>
</form>
