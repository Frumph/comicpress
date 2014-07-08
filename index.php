<?php 
get_header();

if (!comicpress_themeinfo('disable_blog_on_homepage')) {
	
	if (have_posts()) {
		while (have_posts()) : the_post();
			get_template_part('content', get_post_format());
		endwhile;
		if (comicpress_themeinfo('enable_comments_on_homepage') && (comicpress_themeinfo('home_post_count') == '1')) {
			$withcomments = true;
			comments_template('', true);
		} else 
			comicpress_pagination();
	}

}

get_footer();