<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="post-content">
		<div class="entry">
			<?php easel_display_the_content(); ?>
			<div class="clear"></div>
			<?php edit_post_link(__('Edit this post.','easel'), '', ''); ?>
		</div>
	</div>
	<div class="clear"></div>
</div>
