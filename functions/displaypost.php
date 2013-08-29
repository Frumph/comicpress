<?php

if ( isset( $_GET['latestblogpost'] ) ) 
	add_action( 'template_redirect', 'easel_latest_blog_post_jump' );

function easel_latest_blog_post_jump() {
	$catnum = 0;
	if (isset($_GET['latestblogpost'])) $catnum = (int)esc_attr($_GET['latestblogpost']);
	if (!empty($catnum)) {
		$args = array( 
				'numberposts' => 1, 
				'post_type' => 'post',
				'orderby' => 'post_date', 
				'order' => 'DESC', 
				'post_status' => 'publish', 
				'category__in' => array($catnum)
				);
		$qposts = get_posts( $args );
	} else {
		$args = array( 
				'numberposts' => 1, 
				'post_type' => 'post', 
				'orderby' => 'post_date', 
				'order' => 'DESC', 
				'post_status' => 'publish'
				);
		$qposts = get_posts( $args );
	}
	if (is_array($qposts)) {
		$qposts = reset($qposts);
		wp_redirect( get_permalink( $qposts->ID ) );
	} else {
		wp_redirect( home_url() );
	}
	wp_reset_query();
	exit;
}

if (!function_exists('easel_display_post_title')) {
	function easel_display_post_title() {
		global $post, $wp_query;
		$get_post_title = '';
		if ((easel_themeinfo('disable_page_titles') && is_page()) || (easel_themeinfo('disable_post_titles') && !is_page()) || (is_page('chat') || is_page('forum'))) return;
		if (is_page()) {
			$post_title = "<h2 class=\"page-title\">";
		} else {
			$post_title = "<h2 class=\"post-title\">";
		}
		if (!is_page() && !is_single() || (is_front_page() && is_page_template())) $post_title .= "<a href=\"".get_permalink()."\">";
		$get_post_title .= get_the_title();
		if (!$get_post_title) $get_post_title = '( No Title )';
		$post_title .= $get_post_title;
		if (!is_page() && !is_single() || (is_front_page() && is_page_template())) $post_title .= "</a>";
		$post_title .= "</h2>\r\n";
		echo apply_filters('easel_display_post_title',$post_title);
	}
}

if (!function_exists('easel_display_post_thumbnail')) {
	function easel_display_post_thumbnail($size = 'thumbnail') {
		global $post, $wp_query;
		if ($post->post_type == 'post') {
			$post_thumbnail = '';
			$link = get_post_meta( $post->ID, 'link', true );
			if (empty($link)) $link = get_permalink();
			if ( has_post_thumbnail() ) {
				if (is_home()) {
					$post_thumbnail = '<div class="post-image"><center><a href="'.$link.'" rel="featured-image" title="Link to '.get_the_title().'">'.get_the_post_thumbnail($post->ID, $size).'</a></center></div>'."\r\n";
				} else
					$post_thumbnail = '<div class="post-image"><center>'.get_the_post_thumbnail($post->ID, $size).'</center></div>'."\r\n";
			} else {
				$url_image = get_post_meta($post->ID, 'featured-image', true);
				if (!empty($url_image)) $post_thumbnail = '<div class="post-image"><center><a href="'.$link.'" rel="featured-image" title="Link to "'.get_the_title().'"><img src="'.$url_image.'" title="'.get_the_title().'" alt="'.get_the_title().'"></a></center></div>'."\r\n";
			}
			echo apply_filters('easel_display_post_thumbnail', $post_thumbnail);
		}
	}
}

if (!function_exists('easel_display_author_gravatar')) {
	function easel_display_author_gravatar() {
		global $post, $wp_query, $is_IE;
		if (is_page()) return;
		if (easel_themeinfo('enable_post_author_gravatar')) {
			$author_get_gravatar = get_avatar(get_the_author_meta('email'), 82, easel_random_default_avatar(get_the_author_meta('email'),get_the_author_meta('display_name')));
			if (!$is_IE) $author_get_gravatar = str_replace('photo', 'photo instant nocorner itxtalt', $author_get_gravatar);
			$author_gravatar = "<div class=\"post-author-gravatar\">".$author_get_gravatar."</div>\r\n";
			echo apply_filters('easel_display_author_gravatar', $author_gravatar);
		}
	}
}

if (!function_exists('easel_display_post_calendar')) {
	function easel_display_post_calendar() {
		global $post, $wp_query;
		if (is_page()) return;
		if (easel_themeinfo('enable_post_calendar')) { 
			$post_calendar = "<div class=\"post-calendar-date\"><div class=\"calendar-date\"><span>".get_the_time('M')."</span>".get_the_time('d')."</div></div>\r\n";
			echo apply_filters('easel_display_post_calendar', $post_calendar);
		}
	}
}

if (!function_exists('easel_display_post_author')) {
	function easel_display_post_author() {
		global $post, $authordata;
		if (!easel_themeinfo('disable_author_info_in_posts')) {
			$post_author = "<span class=\"post-author\">".__('by','easel')." <a href=\"".get_author_posts_url( $authordata->ID, $authordata->user_nicename )."\">".get_the_author()."</a></span>\r\n";
			echo apply_filters('easel_display_post_author',$post_author);
		}
	}
}

if (!function_exists('easel_display_post_date')) {
	function easel_display_post_date() {
		global $post;
		if (!easel_themeinfo('disable_date_info_in_posts')) {
			$post_date = "<span class=\"posted-on\">".__('on&nbsp;','easel')."</span><span class=\"post-date\">".get_the_date(get_option('date_format'))."</span>\r\n";
			echo apply_filters('easel_display_post_date',$post_date);
		}
	}
}

if (!function_exists('easel_display_post_time')) {
	function easel_display_post_time() {
		global $post;
		if (!easel_themeinfo('disable_date_info_in_posts') && !easel_themeinfo('disable_posted_at_time_in_posts')) {
			$post_time = "<span class=\"posted-at\">".__('at&nbsp;','easel')."</span><span class=\"post-time\">".get_the_time(get_option('time_format'))."</span>\r\n";
			echo apply_filters('easel_display_post_time',$post_time);
		}
	}
}

if (!function_exists('easel_display_modified_date_time')) {
	function easel_display_modified_date_time() {
		global $post;
		if (!easel_themeinfo('disable_date_info_in_posts') && easel_themeinfo('enable_last_modified_in_posts')) {
			$u_time = get_the_time('U');
			$u_modified_time = get_the_modified_time('U');
			if ($u_modified_time != $u_time) {
				$post_date_time = '<span class="posted-last-modified"> '.__('and modified on','easel').' '.get_the_modified_date(get_option('date_format')).'. '; 
				if (!easel_themeinfo('disable_posted_at_time_in_posts')) $post_date_time .= '<span class="posted-last-modified-time"> '.__('at','easel').' '.get_the_modified_time(get_option('time_format')).'</span>'."\r\n";
				echo apply_filters('easel_display_modified_date_time', $post_date_time);
			}
		}
	}
}

if (!function_exists('easel_display_post_category')) {
	function easel_display_post_category() {
		global $post;
		$post_category = '';
		if (!easel_is_bbpress() && !easel_themeinfo('disable_categories_in_posts') && !is_attachment() && ($post->post_type == 'post')) {
			$post_category = "<div class=\"post-cat\">". __('Posted In: ','easel') .get_the_category_list(', ')."</div>\r\n";
		}
		echo apply_filters('easel_display_post_category', $post_category);
	}
}

if (!function_exists('easel_display_post_tags')) {
	function easel_display_post_tags() {
		global $post;
		if (!easel_themeinfo('disable_tags_in_posts')) {
			$post_tags = "<div class=\"post-tags\">".get_the_tag_list(__('&#9492; Tags: ','easel'), ', ', '<br />')."</div>\r\n";
			echo apply_filters('easel_display_post_tags', $post_tags);
		}
	}
}

if (!function_exists('easel_display_comment_link')) {
	function easel_display_comment_link() {
		global $post;
		if ($post->comment_status == 'open' && !is_singular()) { ?>
			<div class="comment-link">
				<?php comments_popup_link('<span class="comment-balloon comment-balloon-empty">&nbsp;</span>'.__('Comment&nbsp;','easel'), '<span class="comment-balloon">1</span> '.__('Comment ','easel'), '<span class="comment-balloon">%</span> '.__('Comments ','easel')); ?>
			</div>
			<?php
		}
	}
}

if (!function_exists('easel_display_blog_navigation')) {
	function easel_display_blog_navigation() {
		global $post, $wp_query;
		if (easel_themeinfo('enable_comments_on_homepage') && (easel_themeinfo('home_post_count') == '1')) {
			$temp_single = $wp_query -> is_single;
			$wp_query -> is_single = true;
		}
		if (is_single() && !is_page() && !is_archive() && !is_search() && ($post->post_type == 'post')) { ?>
			<div class="blognav">
				<?php previous_post_link('<span class="blognav-prev">%link</span>',__('&lsaquo; Prev','easel'), false); ?>
				<?php next_post_link('<span class="blognav-next">%link</span>',__('Next &rsaquo;','easel'), false); ?>
				<div class="clear"></div>
			</div>
		<?php }
		if (easel_themeinfo('enable_comments_on_homepage') && (easel_themeinfo('home_post_count') == '1')) {
			$wp_query -> is_single = $temp_single;
		}
	}
}

if (!function_exists('easel_display_the_content')) {
	function easel_display_the_content() {
		global $post, $wp_query;
		if ((is_archive() || is_search()) && (easel_themeinfo('excerpt_or_content_in_archive') == 'excerpt') && !easel_is_bbpress()) {
			do_action('easel-display-the-content-before');
			the_excerpt();
			do_action('easel-display-the-content-after');
		} else {
			if (!is_single()) { global $more; $more = 0; } 
			do_action('easel-display-the-content-before');
			the_content(__('&darr; Read the rest of this entry...','easel'));
			do_action('easel-display-the-content-after');
		}
	}
}

if (!function_exists('easel_display_post')) {
	function easel_display_post() {
		global $post, $wp_query;
		if (!easel_is_bbpress()) easel_display_blog_navigation(); ?>
		<div <?php post_class(); ?>>
			<?php easel_display_post_thumbnail(); ?>
			<div class="post-head"><?php do_action('easel-post-head'); ?></div>
			<div class="post-content">
				<div class="post-info">
					<?php 
						if (!easel_is_bbpress()) easel_display_author_gravatar();
						if (!easel_is_bbpress()) easel_display_post_calendar();
						if (is_sticky()) { ?><div class="sticky-image">Featured Post</div><?php }
						if (function_exists('easel_show_mood_in_post')) easel_show_mood_in_post(); 
					?>
					<div class="post-text">
						<?php 
						easel_display_post_title();
						if (!is_page()) {
							easel_display_post_author();
							easel_display_post_date();	easel_display_post_time(); easel_display_modified_date_time();
							if ($post->post_type == 'post') { edit_post_link(__('Edit','easel'), ' <span class="post-edit">', '</span>'); }
							easel_display_post_category();
							if (function_exists('the_ratings') && $post->post_type == 'post') { the_ratings(); }
							do_action('easel-post-info');
							do_action('comic-post-info');
						} ?>
					</div>
				</div>
				<div class="clear"></div>
				<div class="entry">
					<?php easel_display_the_content(); ?>
					<div class="clear"></div>
					<?php do_action('comic-transcript'); ?>
				</div>
				<?php wp_link_pages(array('before' => '<div class="linkpages"><span class="linkpages-pagetext">Pages:</span> ', 'after' => '</div>', 'next_or_number' => 'number')); ?>
				<div class="clear"></div>
				<?php if (!is_page()) { ?>
				<div class="post-extras">
					<?php 
						easel_display_post_tags();
						do_action('easel-post-extras');
						easel_display_comment_link(); 
					?>
					<div class="clear"></div>
				</div>
				<?php } else
					edit_post_link(__('Edit this page.','easel'), '', ''); ?>
			</div>
			<div class="post-foot"><?php do_action('comic-post-foot'); ?><?php do_action('easel-post-foot'); ?></div>
		</div>
		<?php 
			do_action('comic-post-extras');
			comments_template('', true);
	}
}

?>
