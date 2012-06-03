<?php
/*
Template Name: Members Only Blog
*/
get_header(); 
remove_filter('pre_get_posts','comicpress_members_filter');

if (comicpress_themeinfo('enable_members_only')) {
	if (comicpress_themeinfo('members_post_category') && comicpress_is_member()) {
		$blog_query = 'showposts='.comicpress_themeinfo('blog_postcount').'&cat='.comicpress_themeinfo('members_post_category').'&paged='.$paged; 
		
		$posts = &query_posts($blog_query);
		if (have_posts()) {
			
			while (have_posts()) : the_post();
				
				comicpress_display_post();	
			
			endwhile;
			
		}
		comicpress_pagination();
	} else {
		_e("This page is restricted to members only.",'comicpress');
	}
} else {
	_e('Member\'s Only content is not enabled on this installation.');
}

if (is_active_sidebar('under-blog')) get_sidebar('underblog');

get_footer();
?>