<?php

/**
* Better display of avatars in comments
* Should only be used in comment sections (may update in future)
* Checks for false empty commenter URLs 'http://' w/registered users
* Adds the class 'photo' to the image
* Adds a call to 'images/trackback.jpg' for trackbacks
* Adds a call to 'images/pingback.jpg' for pingbacks
*
* Filters should only return a string for an image URL for the avatar with class $avatar
* They should not get the avatar as this is done after the filter
*
* @since 0.2
* @filter
*/
function comicpress_avatar() {
	global $comment;

	$url = get_comment_author_url();

	$comment_type = get_comment_type();

	if ($comment_type != 'pingback' && $comment_type != 'trackback') {
		
		echo '<div class="comment-avatar">';
		if($url == true && $url != 'http://') 
			echo '<a href="' . $url . '" rel="external nofollow" title="' . esc_html(get_comment_author()) . '">';
		$id_or_email = get_comment_author_email();
		if (empty($id_or_email)) $id_or_email = get_comment_author();
		
		$current_avatar_directory = comicpress_themeinfo('avatar_directory');
		if (!empty($current_avatar_directory) && ($current_avatar_directory !== 'none')) {
			$avatar_str = get_avatar($id_or_email, 64, comicpress_random_default_avatar($id_or_email), esc_html(get_comment_author()));
		} else
			$avatar_str = get_avatar($id_or_email, 64);
		$return_str = str_replace('photo', 'photo instant nocorner itxtalt', $avatar_str);
		$return_str = str_replace('alt=', 'title="'.esc_html(get_comment_author()).'" alt=', $return_str);
		echo $return_str;
		if($url == true && $url != 'http://')
			echo '</a>';
		echo '</div>';
	}
	
}

/**
* Properly displays comment author name/link
* bbPress and other external systems sometimes don't set a display name for registrations
* WP has problems if no display name is set
* WP gives registered users URL of 'http://' if none is set
*
* @since 0.2.2
*/
function comicpress_comment_author() {
	global $comment;

	$author = get_comment_author();
	$url = get_comment_author_url();

	/*
	* Registered members w/o URL defaults to 'http://'
	*/
	if($url == 'http://')
		$url = false;

	/*
	* Registered through bbPress sometimes leaves no display name
	* Bug with bbPress 0.9 series and WP 2.5 (no later testing)
	* 'Anonymous' should be localized according to WP, not the theme
	*/
	if(is_object($comment) && ($comment->user_id > 0) && !$author) :
		$user = get_userdata($comment->user_id);
		if($user->display_name)
			$author = $user->display_name;
		elseif($user->user_nickname)
			$author = $user->nickname;
		elseif($user->user_nicename)
			$author = $user->user_nicename;
		else
			$author = $user->user_login;
	endif;

	/*
	* Display link and cite if URL is set
	* Also properly cites trackbacks/pingbacks
	*/
	if($url) :
		$output = '<cite title="' . $url . '">';
		$output .= '<a href="' . $url . '" title="' . esc_html($author, 1) . '" class="external nofollow">' . $author . '</a>';
		$output .= '</cite>';
	else :
		$output = '<cite>';
		$output .= $author;
		$output .= '</cite>';
	endif;

	echo $output;
}

/**
* Displays individual comments
* Uses the callback parameter for wp_list_comments
* Overwrites the default display of comments
*
* @since 0.2.3
*
* @param $comment The comment variable
* @param $args Array of arguments passed from wp_list_comments
* @param $depth What level the particular comment is
*/
function comicpress_comments_callback($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	$GLOBALS['comment_depth'] = $depth;
	?>
	<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
	
		<?php comicpress_avatar(); // Avatar filter ?>
		
		<div class="comment-content">
		
			<div class="comment-author vcard">
				<?php comicpress_comment_author(); ?>
			</div>
			
			<div class="comment-meta-data">
						
				<span class="comment-time" title="<?php comment_date('l, F jS Y, g:ia'); ?>">
					<?php
					/* translators: date and time in comments */
					printf(__( '%1$s, %2$s', 'comicpress' ), get_comment_date(), get_comment_time()); ?>
				</span>
				
				<span class="comment-permalink">
					<span class="separator">|</span> <a href="#comment-<?php echo str_replace('&', '&amp;', get_comment_ID()); ?>" title="<?php _e( 'Permalink to comment', 'comicpress' ); ?>"><?php _e( '#', 'comicpress' ); ?></a>
				</span>
				
				<?php if((get_option('thread_comments')) && ($args['type'] == 'all' || get_comment_type() == 'comment')) :
					$max_depth = get_option('thread_comments_depth');
					echo comment_reply_link(array(
						'reply_text' => __( 'Reply', 'comicpress' ), 
						'login_text' => __( 'Login to Reply', 'comicpress' ),
						'depth' => $depth,
						'max_depth' => $max_depth, 
						'before' => '<span class="comment-reply-link"><span class="separator">|</span> ', 
						'after' => '</span>'
					));
				endif; ?>
					
				<?php edit_comment_link('<span class="comment-edit">'.__( 'Edit', 'comicpress' ).'</span>',' <span class="separator">|</span> ',''); ?> 
				
				<?php if ($comment->comment_approved == '0') : ?>
				<div class="comment-moderated"><?php _e( 'Your comment is awaiting moderation.', 'comicpress' ); ?></div>
				<?php endif; ?>
			
			</div>

			<?php if (get_comment_type() == 'comment') { ?>
				<div class="comment-text">
					<?php comment_text(); ?>
				</div>
			<?php } ?>
						
		</div>
		
		<div class="clear"></div>
		
<?php }

/**
* Ends the display of individual comments
* Uses the callback parameter for wp_list_comments
* Needs to be used in conjunction with comicpress_comments_callback
* Not needed but used just in case something is changed
*
* @since 0.2.3
*/
function comicpress_comments_end_callback() {
	echo '</li>';
}

function list_pings($comment, $args, $depth) {       
	$GLOBALS['comment'] = $comment; ?>
		<li id="comment-<?php comment_ID(); ?>"><?php comicpress_comment_author(); ?></li>
<?php } 
