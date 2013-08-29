<?php 
get_header();

while (have_posts()) : the_post();
	get_template_part('content', 'page');
	comments_template('', true);
endwhile;

get_footer();