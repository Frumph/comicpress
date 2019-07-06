<?php
/**
 * Notice for Sidebar left
 * by Philip M. Hofer (Frumph)
 * http://frumph.net/
 *
 * Content for Notice for Sidebar left
 *
 * @package Comicpress
 */

?>

<div id="sidebar-left">

	<div class="sidebar">

		<?php
		do_action( 'comicpress-sidebar-left' );
		if ( ! dynamic_sidebar( 'sidebar-left-sidebar' ) ) {
			?>

		<div class="sidebar-no-widgets">

			<?php esc_html_e( 'There are currently no widgets assigned to the left-sidebar, place some!', 'comicpress' ); ?>
			<br />
			<br />
			<?php esc_html_e( 'Once you add widgets to this sidebar, this default information will go away.', 'comicpress' ); ?>
			<br />
			<br />
			<?php esc_html_e( 'Widgets can be added by going to your dashboard (wp-admin) &#10132; Appearance &#10132; Widgets, drag a widget you want to see into one of the appropriate sidebars.', 'comicpress' ); ?>
			<br />

		</div>

			<?php
		}
		?>

	</div>

</div>
