<?php 
get_header();
if (comicpress_themeinfo('blogposts_with_comic')) {
	Protect();
	global $cur_date, $next_date, $prev_date;
	$cur_date = $next_date = $prev_date = null;
	
	$cur_date = mysql2date('Y-m-j', $post->post_date);
	$next_comic = comicpress_get_next_comic();
	$prev_comic = comicpress_get_previous_comic();
	if (!empty($next_comic)) {
		$next_comic = (array)$next_comic;
		$next_date = mysql2date('Y-m-j', $next_comic['post_date']);
	}
	if (!empty($prev_comic)) {
		$prev_comic = (array)$prev_comic;
		$prev_date = mysql2date('Y-m-j', $prev_comic['post_date']);
	}
	UnProtect();
}

if (have_posts()) {
	while (have_posts()) : the_post();
		$blog_query = 'showposts='.comicpress_themeinfo('blog_postcount').'&order=asc&cat='.comicpress_exclude_comic_categories();
		if (!comicpress_in_comic_category() || (comicpress_in_comic_category() && !comicpress_themeinfo('disable_comic_blog_single'))) {
			comicpress_display_post();
			comments_template('', true);
			$blog_query = 'showposts='.comicpress_themeinfo('blog_postcount').'&order=asc&cat='.comicpress_exclude_comic_categories();
		}
	endwhile; 
	
	if (is_active_sidebar('blog')) get_sidebar('blog');
	
	if (comicpress_themeinfo('static_blog') && comicpress_in_comic_category()) {
		if (!comicpress_themeinfo('split_column_in_two')) {
			$blog_query = 'showposts='.comicpress_themeinfo('blog_postcount').'&cat='.comicpress_exclude_comic_categories().'&paged='.$paged; 
			
			$posts = &query_posts($blog_query);
		if (have_posts()) { ?>
		
			<?php if (!comicpress_themeinfo('disable_blogheader')) { ?>
				<div id="blogheader"><!-- This area can be used for a heading above your main page blog posts --></div>
			<?php } ?>
			
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
	} else {
		if (comicpress_themeinfo('blogposts_with_comic')) {
			if (!comicpress_themeinfo('split_column_in_two')) {
				
				Protect();		
				
				if (comicpress_in_comic_category()) {
					function filter_where($where = '') {
						global $cur_date, $next_date;
						if (!empty($next_date)) {
							$where .= " AND post_date >= '".$cur_date."' AND post_date <= '".$next_date."'";
						} else {
							$where .= " AND post_date >= '".$cur_date."'";
						}
						return $where;
					}
					add_filter('posts_where', 'filter_where');
					$posts = &query_posts($blog_query);
					if (have_posts()) { while (have_posts()) : the_post();
							comicpress_display_post();
							comments_template('', true);
					endwhile; }
				} 
				UnProtect();
			} else {
				comicpress_dual_columns(true);
			}
		}
	}
	if (comicpress_in_comic_category() && comicpress_themeinfo('enable_comments_when_comic_blog_disabled') && comicpress_themeinfo('disable_comic_blog_single')) comments_template('', true);
} else {
?>
	<div <?php post_class(); ?>>
		<?php if (comicpress_themeinfo('enable_caps')) { ?><div class="post-head"></div><?php } ?>
		<div class="post">
			<p><?php _e('Sorry, no posts matched your criteria.','comicpress'); ?></p>
			<div class="clear"></div>
		</div>
		<?php if (comicpress_themeinfo('enable_caps')) { ?><div class="post-foot"></div><?php } ?>
	</div>
	<?php
}
	
if (is_active_sidebar('under-blog')) get_sidebar('underblog');

get_footer();
?>