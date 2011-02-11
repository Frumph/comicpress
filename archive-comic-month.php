<?php
/*
Template Name: This Month of Comics
*/
get_header();

//based on Austin Matzko's code from wp-hackers email list
function filter_where($where = '') {
	//posts in the last 30 days
	$where .= " AND post_date > '" . date('Y-m-d', strtotime('-30 days')) . "'";
	//    $where .= " AND post_date >= '2009-03-01' AND post_date < '2009-03-16'";
	return $where;
}
add_filter('posts_where', 'filter_where');


$wp_query->in_the_loop = true; 
$archiveQuery = new WP_Query(); 
$archiveQuery->query('show_posts=-1&posts_per_page=-1&cat='.comicpress_all_comic_categories_string());

?>
<div <?php post_class(); ?>>
<?php if (comicpress_themeinfo('enable_caps')) { ?><div class="post-head"></div><?php } ?>
	<div class="post-content">
		<div class="post-info">
			<div class="post-text">
				<h2 class="page-title"><?php the_title(); ?></h2>
			</div>
		</div>
<?php if ($archiveQuery->have_posts()) : while ($archiveQuery->have_posts()) : $archiveQuery->the_post() ?>

				<div class="comicthumbwrap">
					<div class="comicarchiveframe">
						<a href="<?php the_permalink() ?>"><img src="<?php the_comic_mini() ?>" alt="<?php the_title() ?>" title="<?php the_title() ?>" style="width: <?php echo $mini_comic_width; ?>px" /></a><br />
					</div>
				</div>
				
<?php endwhile; endif; ?>
		<div class="clear"></div>
	</div>
<?php if (comicpress_themeinfo('enable_caps')) { ?><div class="post-foot"></div><?php } ?>
</div>

<?php get_footer() ?>