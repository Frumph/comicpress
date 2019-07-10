<?php
/**
 * Search Page
 * by Philip M. Hofer (Frumph)
 * http://frumph.net/
 *
 * Content for the Search page.
 *
 * @package Comicpress
 */

get_header();

$count = 'No';
if ( have_posts() ) :
	$count = $wp_query->found_posts;
	?>

<h2 class="page-title">

	<?php
	esc_html_e( 'Search for &lsquo;', 'comicpress' );
	the_search_query();
	esc_html_e( '&rsquo;', 'comicpress' );
	?>

</h2>

<div class="searchresults">

	<?php
	printf(
		/* translators: %d: Number of found results */
		esc_html( _n( '%d result', '%d results', $count, 'comicpress' ) ),
		esc_html( $count )
	);
	?>

</div>

<div class="clear"></div>

	<?php
	if ( comicpress_themeinfo( 'display_archive_as_links' ) ) {
		?>

<div <?php post_class(); ?>>

	<div class="post-head"></div>

	<div class="entry">

		<table class="archive-table">

		<?php
		while ( have_posts() ) :
			the_post();
			?>

			<tr>
				<td class="archive-date">
					<?php the_time( _x( 'M d, Y', 'search page table date format', 'comicpress' ) ); ?>
				</td>
				<td class="archive-title">
					<a href="<?php echo esc_html( get_permalink( $post->ID ) ); ?>" rel="bookmark" title="<?php esc_html_e( 'Permanent Link:', 'comicpress' ); ?> <?php the_title(); ?>">
						<?php the_title(); ?>
					</a>
				</td>
			</tr>

			<?php
		endwhile;
		?>

		</table>

	</div>

	<div class="post-foot"></div>

</div>

			<?php
	} else {
		while ( have_posts() ) :
			the_post();
			$post_format = ( $post->post_type !== 'post' ) ? $post->post_type : get_post_format();
			get_template_part( 'content', $post_format );
		endwhile;
	}
	?>

<div class="clear"></div>

	<?php
	comicpress_pagination();
	else :
		?>

<div class="post post-search uentry type-page">

	<div class="post-head"></div>

	<div class="post-content">

		<div class="entry">

			<h3>
				<?php esc_html_e( 'No results found.', 'comicpress' ); ?>
			</h3>
			<p>
				<?php esc_html_e( 'Try another search?', 'comicpress' ); ?>
			</p>
			<p>
				<?php get_search_form(); ?>
			</p>

		</div>

	</div>

	<div class="post-foot"></div>

</div>

		<?php
	endif;
	get_footer();
	?>
