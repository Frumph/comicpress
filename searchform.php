<?php
/**
 * Search Form
 * by Philip M. Hofer (Frumph)
 * http://frumph.net/
 *
 * Method for the Search form.
 *
 * @package Comicpress
 */

?>

<form method="get" class="searchform" action="<?php echo esc_html( home_url() ); ?>">
	<input type="text" value="<?php esc_html_e( 'Search...', 'comicpress' ); ?>" name="s" class="s-search" onfocus="this.value=(this.value=='<?php esc_html_e( 'Search...', 'comicpress' ); ?>') ? '' : this.value;" onblur="this.value=(this.value=='') ? '<?php esc_html_e( 'Search...', 'comicpress' ); ?>' : this.value;" />
	<button type="submit">

		<?php
		/* translators: Content for search button */
		esc_html_e( '&raquo;', 'comicpress' );
		?>

	</button>
</form>

<div class="clear"></div>
