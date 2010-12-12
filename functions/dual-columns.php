<?php 

function comicpress_dual_filter_where($where = '') {
	global $cur_date, $next_date, $prev_date;
	if (!empty($next_date)) {
		if (!empty($prev_date)) {
			$where .= " AND post_date > '".$cur_date."' AND post_date < '".$next_date."'";
		} else {
			$where .= " AND post_date < '".$next_date."'";
		}
	} else {
		$where .= " AND post_date >= '".$cur_date."'";
	}
	return $where;
}

if (!function_exists('comicpress_dual_columns')) {
	function comicpress_dual_columns($whereclause = false) { 
		global $wp_query;
?>
		<div id="dualcolumns">
			<div class="column_one">
				<div class="column_one_header"></div>
<?php
				Protect();
				$wp_query->in_the_loop = true;
				$blog_query = new WP_Query();
				if ($whereclause) add_filter('posts_where', 'comicpress_dual_filter_where');
				$blog_query->query('showposts='.comicpress_themeinfo('blog_postcount').'&cat='.comicpress_exclude_comic_categories().'&author='.comicpress_themeinfo('author_column_one').'&paged='.$paged);
		if (have_posts()) {
			while ($blog_query->have_posts()) : $blog_query->the_post();
				comicpress_display_post();
			endwhile;
		}
				UnProtect();
?>
			</div>
			<div class="column_two">
				<div class="column_two_header"></div>
<?php
				Protect();
				$wp_query->in_the_loop = true;
				$blog_query = new WP_Query();
				if ($whereclause) add_filter('posts_where', 'comicpress_dual_filter_where');
				$blog_query->query('showposts='.comicpress_themeinfo('blog_postcount').'&cat='.comicpress_exclude_comic_categories().'&author='.comicpress_themeinfo('author_column_two'));
		if (have_posts()) {
			while ($blog_query->have_posts()) : $blog_query->the_post();
				comicpress_display_post();
			endwhile;
		}
				UnProtect();
?>
			</div>
			<div class="clear"></div>
		</div>
	<?php }
}
?>