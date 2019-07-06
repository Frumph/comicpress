<?php
/**
 * Notice for Sidebar rights
 * by Philip M. Hofer (Frumph)
 * http://frumph.net/
 *
 * Content for Notice for Sidebar rights
 *
 * @package Comicpress
 */

?>

<div id="sidebar-right">

	<div class="sidebar">

		<?php
		do_action( 'comicpress-sidebar-right' );
		if ( ! dynamic_sidebar( 'sidebar-right-sidebar' ) ) {
			?>

		<div class="sidebar-no-widgets">

			<?php esc_html_e( 'There are currently no widgets assigned to the right-sidebar, place some!', 'comicpress' ); ?>
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
