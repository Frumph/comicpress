<?php
/*
Taxonomy - Chapters
TODO: Make it display the first comic in the category.
*/
get_header();

if (have_posts()) {
	while (have_posts()) : the_post();
		get_template_part( 'content', 'comic' );
	endwhile;
	if ($post->comment_status == 'open') {
		comments_template('', true);
	}
}

get_footer();
