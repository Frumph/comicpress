<?php
/**
 * Image Page
 * by Philip M. Hofer (Frumph)
 * http://frumph.net/
 *
 * Content for the Image page.
 *
 * @package Comicpress
 */

get_header();
if ( have_posts() ) :
	while ( have_posts() ) :
		the_post()
		?>

	<div <?php post_class(); ?>>

		<?php comicpress_display_post_thumbnail(); ?>

		<div class="post-head"></div>

		<div class="post-content">

			<div class="imagenav-wrap">

				<div class="imagenav-left">

					<div class="imagenav-bg">

						<?php previous_image_link(); ?>

					</div>

					<div class="imagenav-arrow">

						<?php
						/* translators: Symbol for link previous image */
						esc_html_e( '&lsaquo;', 'comicpress' );
						?>

					</div>

					<div class="imagenav-link">

						<?php previous_image_link(); ?>

					</div>

				</div>

				<div class="imagenav-center">

					<a href="<?php echo esc_html( wp_get_attachment_url( $post->ID ) ); ?>" target="_blank" title="<?php esc_html_e( 'Click for full size', 'comicpress' ); ?>" class="imagetitle">
						<?php the_title(); ?>
					</a>
					<br />
					<a href="<?php echo esc_html( get_permalink( $post->post_parent ) ); ?>" rel="attachment">
						<?php esc_html_e( '&larr; Back to Gallery', 'comicpress' ); ?>
					</a>

				</div>

				<div class="imagenav-right">

					<div class="imagenav-bg">

						<?php next_image_link(); ?>

					</div>

					<div class="imagenav-arrow">

						<?php
						/* translators: Symbol for link next image */
						esc_html_e( '&rsaquo;', 'comicpress' );
						?>

					</div>

					<div class="imagenav-link">

						<?php next_image_link(); ?>

					</div>

				</div>

				<div class="clear"></div>

			</div>

			<div class="clear"></div>

			<div class="gallery-image">

				<a href="<?php echo esc_html( wp_get_attachment_url( $post->ID ) ); ?>" target="_blank" title="<?php esc_html_e( 'Click for full size', 'comicpress' ); ?>" >
					<img src="<?php echo esc_html( wp_get_attachment_url( $post->ID ) ); ?>" alt="<?php the_title(); ?>" />
				</a>
			</div>

			<div class="gallery-caption">

				<?php the_excerpt(); ?>

			</div>

			<div class="gallery-content">

				<?php the_content(); ?>

				<div class="clear"></div>

			</div>

			<div class="clear"></div>

		</div>

		<div class="post-foot"></div>

	</div>

		<?php
		edit_post_link( __( 'Edit this attachment.', 'comicpress' ), '', '' );
		if ( 'open' == $post->comment_status ) {
			comments_template( '', true );
		}
		endwhile;
	else :
		?>

	<div <?php post_class(); ?>>

		<div class="post-head"></div>

		<div class="post-content">

			<p>
				<?php esc_html_e( 'Sorry, no image matched your criteria.', 'comicpress' ); ?>
			</p>

			<div class="clear"></div>

		</div>

		<div class="post-foot"></div>

	</div>

		<?php
endif;
	get_footer()
	?>
