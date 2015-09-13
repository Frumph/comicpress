<?php comicpress_display_post_thumbnail(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="post-content">
		<div class="post-info">
			<?php 
				comicpress_display_post_title();
			?>
			<div class="post-text">
			<?php 
				wp_link_pages(array('before' => '<div class="linkpages"><span class="linkpages-pagetext">Pages:</span> ', 'after' => '</div>', 'next_or_number' => 'number'));
			?>
			</div>
			<div class="clear"></div>
		</div>
		<div class="entry">
			<?php comicpress_display_the_content(); ?>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
		<?php edit_post_link(__( 'Edit this page.', 'comicpress' ), '', ''); ?>
	</div>
</article>
