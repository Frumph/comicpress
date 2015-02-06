<?php 
get_header();

if (is_active_sidebar('blog')) get_sidebar('blog');

if (have_posts()) {

	while (have_posts()) : the_post();
		if (get_post_type() !== 'post') {
			get_template_part('content', get_post_type() );
			comments_template('', true);
		} else {
			get_template_part('content', get_post_format());
			comments_template('', true);
		}
	endwhile;
	
} else { ?>

	<div <?php post_class(); ?>>
		<div class="post-head"></div>
		<div class="post">
			<p><?php _e( 'Sorry, post is not found.', 'comicpress' ); ?></p>
			<div class="clear"></div>
		</div>
		<div class="post-foot"></div>
	</div>
	<?php
}

get_footer();