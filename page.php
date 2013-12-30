<?php 
get_header();

if (comicpress_sidebars_disabled()) $content_width = comicpress_themeinfo('content_width_disabled_sidebars');

while (have_posts()) : the_post();
	get_template_part('content', 'page');
	comments_template('', true);
endwhile;

get_footer();