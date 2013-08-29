<?php get_header();

if (!easel_themeinfo('disable_blog_on_homepage')) {
	
	if (have_posts()) {
		while (have_posts()) : the_post();
			get_template_part('content', get_post_format());
		endwhile;
		if (easel_themeinfo('enable_comments_on_homepage') && (easel_themeinfo('home_post_count') == '1')) {
			$withcomments = true;
			comments_template('', true);
		} else 
			easel_pagination();
	}

}

get_footer();