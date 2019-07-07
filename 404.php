<?php
/**
 * 404 Page
 * by Philip M. Hofer (Frumph)
 * http://frumph.net/
 *
 * Content for the 404 page.
 *
 * @package Comicpress
 */

get_header();
?>

<div class="post uentry type-page">

	<div class="post-content">

		<div class="post-info">

			<h2 class="page-title">
				<?php esc_html_e( 'Page Not Found', 'comicpress' ); ?>
			</h2>

		</div>

		<div class="entry">

			<p>
				<a href="<?php echo esc_url( site_url() ); ?>">
					<?php esc_html_e( 'Click here to return to the home page', 'comicpress' ); ?>
				</a>
				<?php esc_html_e( 'or try a search:', 'comicpress' ); ?>
			</p>
			<p>
				<?php get_search_form(); ?>
			</p>

			<div class="clear"></div>

		</div>

		<div class="clear"></div>

	</div>

</div>

<?php
get_footer();
?>
