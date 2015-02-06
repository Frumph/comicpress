<form method="get" class="searchform" action="<?php echo home_url(); ?>">
	<input type="text" value="<?php _e( 'Search...', 'comicpress' ); ?>" name="s" class="s-search" onfocus="this.value=(this.value=='<?php _e( 'Search...', 'comicpress' ); ?>') ? '' : this.value;" onblur="this.value=(this.value=='') ? '<?php _e( 'Search...', 'comicpress' ); ?>' : this.value;" />
	<button type="submit">&raquo;</button>
</form>
<div class="clear"></div>