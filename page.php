<?php 
get_header();
$is_comic = false;

while (have_posts()) : the_post();

?>
		<div <?php post_class(); ?>>
			<?php comicpress_display_post_thumbnail($is_comic); ?>
			<div class="post-head"></div>
			<div class="post-content">
				<div class="post-info">
					<div class="post-text">
						<?php comicpress_display_post_title($is_comic); ?>
					</div>
				</div>
				<div class="clear"></div>
				<div class="entry">
					<?php comicpress_display_the_content($is_comic); ?>
					<div class="clear"></div>
				</div>
				<?php wp_link_pages(array('before' => '<div class="linkpages"><span class="linkpages-pagetext">'.__('Pages:','comicpress').'</span> ', 'after' => '</div>', 'next_or_number' => 'number'));  ?>
				<?php edit_post_link(__('Edit this page.','comicpress'), '', ''); ?>
			</div>
			<div class="post-foot"></div>
		</div>
<?php 
	if ('open' == $post->comment_status) {
		comments_template('', true);
	}
endwhile;
	
get_footer();
?>