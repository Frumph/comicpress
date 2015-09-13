<?php
if (!comicpress_is_bbpress()) comicpress_display_blog_navigation();
if (!is_home() && !is_archive() && !is_search()) { comicpress_display_post_thumbnail('large'); ?><div class="clear"></div><?php } 
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="post-content">
		<?php if (is_home() || is_archive() || is_search()) comicpress_display_post_thumbnail('thumbnail'); ?>
		<?php if (!comicpress_is_bbpress()) comicpress_display_author_gravatar(); ?>
		<div class="post-info">
			<?php
				comicpress_display_post_title();
				if (!comicpress_is_bbpress()) comicpress_display_post_calendar();
				if (is_sticky()) { ?><div class="sticky-image">Featured Post</div><?php }
				if (function_exists('comicpress_show_mood_in_post')) comicpress_show_mood_in_post(); 
			?>
			<div class="post-text">
				<?php 
				comicpress_display_post_author();
				comicpress_display_post_date();
				comicpress_display_post_time();
				comicpress_display_modified_date_time();
				comicpress_display_post_category();
				/* Integrate the WP-Plugin: WP-PostRatings */
				if (function_exists('the_ratings') && $post->post_type == 'post') { the_ratings(); }
				do_action('comicpress-post-info');
				wp_link_pages(array('before' => '<div class="linkpages"><span class="linkpages-pagetext">Pages:</span> ', 'after' => '</div>', 'next_or_number' => 'number'));
				?>
			</div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
		<div class="entry">
			<?php comicpress_display_the_content(); ?>
			<div class="clear"></div>
		</div>
		<div class="post-extras">
			<?php
				comicpress_display_post_tags();
				do_action('comicpress-post-extras');
				comicpress_display_comment_link(); 
			?>
			<div class="clear"></div>
		</div>
		<?php edit_post_link(__( 'Edit this post.', 'comicpress' ), '', ''); ?>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
</article>
