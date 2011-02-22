<?php 
get_header();
if (!comicpress_themeinfo('disable_comic_frontpage') && !comicpress_themeinfo('disable_comic_blog_frontpage') && !is_paged() )  {
	$wp_query->in_the_loop = true; $comicFrontpage = new WP_Query(); 
	$order = 'DESC';
	if (comicpress_themeinfo('display_first_comic_on_home')) $order = 'ASC';
	$comicFrontpage->query('showposts=1&order='.$order.'&cat='.comicpress_all_comic_categories_string());
	while ($comicFrontpage->have_posts()) : $comicFrontpage->the_post();
		comicpress_display_post();
		if (comicpress_themeinfo('disable_blog_frontpage') && comicpress_themeinfo('display_comments_on_home')) {
			$withcomments = 1;
			comments_template('', true);
		}
	endwhile;
}

if (is_active_sidebar('blog')) get_sidebar('blog');

if (!comicpress_themeinfo('disable_blogheader')) { ?>
	<div id="blogheader"><?php echo comicpress_themeinfo('blogheader_text'); ?></div>
<?php 
}

if (!comicpress_themeinfo('disable_blog_frontpage')) {
	Protect();
	if (!comicpress_themeinfo('split_column_in_two')) {
		$paged = get_query_var('paged');
		$blog_query = 'showposts='.comicpress_themeinfo('blog_postcount') .'&cat='.comicpress_exclude_comic_categories().'&paged='.$paged;
		$posts = &query_posts($blog_query);
		if (have_posts()) { ?>
			<?php if (comicpress_themeinfo('enable_caps')) { ?><div class="blogindex-head"></div><?php } ?>
			<div class="blogindex">
			<?php while (have_posts()) : the_post();
				comicpress_display_post();
			endwhile; ?>
			</div>
			<?php if (comicpress_themeinfo('enable_caps')) { ?><div class="blogindex-foot"></div><?php } ?>
		<?php }
		comicpress_pagination();
	} else {
		comicpress_dual_columns();
	}
	UnProtect();
}

if (is_active_sidebar('under-blog')) get_sidebar('underblog');

get_footer();
?>
