<?php
/*
Template Name: Blog
*/
get_header(); 

$temp_query = $wp_query;

if (!comicpress_themeinfo('split_column_in_two')) {
	$paged = get_query_var('paged');
	$blog_query = 'cat='.comicpress_exclude_comic_categories().'&paged='.$paged;
	$posts = &query_posts($blog_query);
	if (have_posts()) { ?>
		<div class="blogindex-head"></div>
		<div class="blogindex">
		<?php while (have_posts()) : the_post();
			comicpress_display_post();
		endwhile; ?>
		</div>
		<div class="blogindex-foot"></div>
<?php }
	comicpress_pagination();
} else {
	comicpress_dual_columns();
}

$wp_query = $temp_query; $temp_query = null;

if (is_active_sidebar('under-blog')) get_sidebar('underblog');
get_footer();
 ?>