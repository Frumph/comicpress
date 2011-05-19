<?php 
get_header();
remove_filter('pre_get_posts','comicpress_members_filter');

$count = $wp_query->found_posts;
if (!$count) $count = "no";
?>
	<h2 class="pagetitle"><?php _e('Search for &lsquo;','comicpress'); the_search_query(); _e('&rsquo;','comicpress'); ?></h2>
	<div class="searchresults"><?php printf(_n("%d item.", "%d items.", $count,'comicpress'),$count); ?></div>

<?php
if (have_posts()) :
	while (have_posts()) : the_post();

		if (is_category() && comicpress_in_comic_category()) { ?>

				<div class="comicthumbwrap">
					<div class="comicarchiveframe" style="width: <?php echo $mini_comic_width; ?>px">
						<a href="<?php the_permalink() ?>"><img src="<?php echo comicpress_display_comic_thumbnail('archive', $post, true); ?>" alt="<?php the_title() ?>" title="<?php the_title() ?>"  /></a>
					</div>
				</div>
				
		<?php } else {
			comicpress_display_post();
		}
	endwhile;
    
	else : ?>
		<div <?php post_class(); ?>>
			<?php if (comicpress_themeinfo('enable_caps')) { ?><div class="post-head"></div><?php } ?>
			<div class="post-content">
				<h3><?php _e('No entries found.','comicpress'); ?></h3>
				<p><?php _e('Try another search?','comicpress'); ?></p>
				<p><?php get_search_form(); ?></p>
			</div>
			<?php if (comicpress_themeinfo('enable_caps')) { ?><div class="post-foot"></div><?php } ?>
		</div>
<?php
	endif;
	
comicpress_pagination();

get_footer();
?>