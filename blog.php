<?php
/*
Template Name: Blog
*/
get_header();

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$blog_query = array(
		'paged' => $paged,
		'post_type' => 'post',
		'in_the_loop' => true,
		'posts_per_page' => comicpress_themeinfo('home_post_count')
		);
		
$wp_query = new WP_Query(); $wp_query->query($blog_query);
if (have_posts()) {
	while (have_posts()) : the_post();
		$withcomment = 0;
		get_template_part('content', get_post_format());
	endwhile;
	comicpress_pagination();
}

wp_reset_query();

get_footer();

