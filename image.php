<?php get_header();  ?>

	<?php if (have_posts()) : while (have_posts()) : the_post() ?>
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
						&lsaquo;
					</div>
					<div class="imagenav-link">
						<?php previous_image_link() ?>
					</div>
				</div>
				<div class="imagenav-center">
					<a href="<?php echo wp_get_attachment_url($post->ID) ?>" target="_blank" title="Click for full size." class="imagetitle"><?php the_title() ?></a><br />
					<a href="<?php echo get_permalink($post->post_parent) ?>" rel="attachment"><?php _e( '&larr; Back to Gallery', 'comicpress' ); ?></a>
				</div>
				<div class="imagenav-right">
					<div class="imagenav-bg">
						<?php next_image_link() ?>
					</div>
					<div class="imagenav-arrow">
						&rsaquo;
					</div>
					<div class="imagenav-link">
						<?php next_image_link() ?>
					</div>
				</div>					
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
			<div class="gallery-image">
				<a href="<?php echo wp_get_attachment_url($post->ID) ?>" target="_blank" title="<?php _e( 'Click for full size.', 'comicpress' ); ?>" ><img src="<?php echo wp_get_attachment_url($post->ID) ?>" alt="<?php the_title() ?>" /></a>
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
	<?php edit_post_link(__( 'Edit this attachment.', 'comicpress' ), '', ''); ?>
	<?php if ('open' == $post->comment_status) { comments_template('', true); } ?>
	<?php endwhile; else: ?>
	<div <?php post_class(); ?>>
		<div class="post-head"></div>
		<div class="post-content">
			<p><?php _e( 'Sorry, no image matched your criteria.', 'comicpress' ); ?></p>
			<div class="clear"></div>
		</div>
		<div class="post-foot"></div>
	</div>
	<?php endif; ?>
	
<?php get_footer() ?>