<?php 
remove_action( 'init', 'the_neverending_home_page_init', 10 );
get_header();

	if(get_query_var('author_name') ) {
		$curauth = get_user_by('slug', get_query_var('author_name'));
	} else {
		$curauth = get_userdata(get_query_var('author'));
	}
		if (empty($curauth)) { ?>
			<h2><?php _e('No such author.','comicpress'); ?></h2>
		<?php } else { ?>
		<div <?php post_class(); ?>>
			<div class="post-head"></div>
			<div class="post-content">
				<div class="entry">
					<div class="userpage-avatar">
						<?php echo str_replace('photo', 'photo instant nocorner itxtalt', get_avatar($curauth->user_email, 64, comicpress_random_default_avatar($curauth->user_email), esc_attr($curauth->display_name, 1))); ?>
					</div>
					<div class="userpage-info">
						<div class="userpage-bio">
	<?php
		if($curauth->display_name)
			$authorname = $curauth->display_name;
		elseif($curauth->user_nickname)
			$authorname = $curauth->nickname;
		elseif($curauth->user_nicename)
			$authorname = $curauth->user_nicename;
		else
			$authorname = $curauth->user_login;
	?>
							<h2><?php echo $authorname; ?></h2><br />
							<?php if (current_user_can('manage_options')) { ?>
								<strong><?php _e('Registered on','comicpress'); ?></strong> <?php echo date('F d, Y', strtotime($curauth->user_registered)); ?><br />
								<strong><?php _e('Email:','comicpress'); ?></strong> <a href="mailto://<?php echo $curauth->user_email; ?>" target="_blank"><?php echo $curauth->user_email; ?></a><br />
							<br />
							<?php } ?>
							<?php if (!empty($curauth->user_url)) { ?><strong><?php _e('Website:','comicpress'); ?></strong> <a href="<?php echo $curauth->user_url; ?>" target="_blank"><?php echo $curauth->user_url; ?></a><br /><?php } ?>
							<?php if (!empty($curauth->twitter)) { ?><strong><?php _e('Twitter:','comicpress'); ?></strong> <a href="<?php echo $curauth->twitter; ?>" target="_blank"><?php echo $curauth->twitter; ?></a><br /><?php } ?>
							<?php if (!empty($curauth->facebook)) { ?><strong><?php _e('Facebook :','comicpress'); ?></strong> <a href="<?php echo $curauth->facebook; ?>" target="_blank"><?php echo $curauth->facebook; ?></a><br /><?php } ?>
							<?php if (!empty($curauth->googleplus)) { ?><strong><?php _e('Google+ :','comicpress'); ?></strong> <a href="<?php echo $curauth->googleplus; ?>" target="_blank" rel="me"><?php echo $curauth->googleplus; ?></a><br /><?php } ?>
						</div>
						<?php if (!empty($curauth->description)) { ?>
						<div class="userpage-desc">
							<?php echo $curauth->description; ?>
						</div>
						<?php } ?>
					</div>
					<div class="clear"></div>

<?php
	if (have_posts()) {
?>
					<div class="userpage-posts">
						<h3><?php _e('Posts by','comicpress'); ?> <?php echo $authorname; ?> &not;</h3>
						<ol>
						<table class="author-posts">
						<?php while (have_posts()) : the_post(); ?>
							<tr>
								<td class="author-archive-date" align="right"><?php the_time('M j, Y') ?></td>
								<td class="author-archive-title"><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></td>
							</tr>
						<?php endwhile; ?>
						</table>
						</ol>
					</div>
<?php } ?>
				</div>
			</div>
			<div class="post-foot"></div>
		</div>
<?php 
	}
get_footer();