<?php
/*
Template Name: Blog
*/
get_header();

$blog_query = array(
		'paged' => get_query_var('paged'),
		'post_type' => 'post'
		);
		
$blogpage = new WP_Query(); $blogpage->query($blog_query);
if ($blogpage->have_posts()) {
	while ($blogpage->have_posts()) : $blogpage->the_post();
		$withcomment = 0;
		get_template_part('content', get_post_format());
	endwhile;
	easel_pagination();
}

get_footer();

