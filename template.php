<?php
/*
Template Name: Blank Template
*/
get_header();

if (have_posts()) {
	while (have_posts()) : the_post();
		get_template_part( 'content', get_post_format() );
	endwhile;
	if ($post->comment_status == 'open') {
		comments_template('', true);
	}
}

get_footer();
?>