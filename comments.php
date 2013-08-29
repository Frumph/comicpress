<?php
if ( post_password_required() ) { ?>
	<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.','easel'); ?></p>
	<?php
	return;
}

if (!comments_open() && !get_comments_number()) {
	return;
}
?>
<div id="comment-wrapper">
<?php if (comments_open() && (get_comments_number() > 0)) { ?> 
	<div class="commentsrsslink"><?php post_comments_feed_link(__('Comments RSS', 'easel')); ?></div>
	<h3 id="comments"><?php comments_number(__('Discussion &not;','easel'), __('Discussion &not;','easel'), __('Discussion (%) &not;','easel') );?></h3>
<?php } 
if ( isset($comments_by_type['pings']) && (!isset($wp_query->query_vars['cpage']) || ((int)$wp_query->query_vars['cpage'] < 2))&& (count($comments_by_type['pings']) > 0)) { ?>
		<div id="pingtrackback-wrap">
			<ol class="commentlist">
			<li>
				<ul>
					<?php if (function_exists('easel_comments_callback')) { 
						wp_list_comments(array(
									'type' => 'pings',
									'callback' => 'easel_comments_callback',
									'end-callback' => 'easel_comments_end_callback',
									'avatar_size'=>32
									)
								); 
					} else {
						wp_list_comments(array('type' => 'pings', 'avatar_size'=>64));
					}?>	
				</ul>
			</li>
			</ol>
		</div>
	<?php 
}
	if ( !empty($comments_by_type['comment']) ) { ?>
		<ol class="commentlist">
		<?php if (function_exists('easel_comments_callback')) { 
			wp_list_comments(array(
						'type' => 'comment',
						'reply_text' => __('Reply &not;','easel'),
						'callback' => 'easel_comments_callback',
						'end-callback' => 'easel_comments_end_callback',
						'avatar_size'=>64
						)
					); 
		} else {
			wp_list_comments(array('type' => 'comment', 'avatar_size'=>64));
			}?>	
		</ol>
	<?php 
	if (get_comment_pages_count() > 1 && get_option( 'page_comments' )) {
		if (easel_themeinfo('enable_numbered_pagination')) {
			$pagelinks = paginate_comments_links(array('echo' => 0)); 
			if (!empty($pagelinks)) {
				$pagelinks = str_replace('<a', '<li><a', $pagelinks);
				$pagelinks = str_replace('</a>', '</a></li>', $pagelinks); 
				$pagelinks = str_replace('<span', '<li', $pagelinks); 
				$pagelinks = str_replace('</span>', '</li>', $pagelinks); ?>
			<div id="wp-paginav">
				<div id="paginav">				
					<?php echo '<ul><li class="paginav-extend">'.__('Comment Pages','easel').'</li>'. $pagelinks . '</ul>'; ?>
					</div>
				<div class="clear"></div>
			</div>					
			<?php } ?>

		<?php } else { ?>
			<div class="commentnav">
				<div class="commentnav-right"><?php next_comments_link(__('Next Comments &uarr;','easel')) ?></div>
				<div class="commentnav-left"><?php previous_comments_link(__('&darr; Previous Comments','easel')) ?></div>
				<div class="clear"></div>
			</div>
		<?php }
	}
}

if (comments_open()) { ?>
<div class="comment-wrapper-respond">
	<?php
	$fields =  array(
			'author' => '<p class="comment-form-author">' .
			'<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" />'. ' <label for="author"><small>' . __( '*NAME','easel' ) .'</small></label></p>',
			'email'  => '<p class="comment-form-email">' .
			'<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" /> <label for="email">' . __( '*EMAIL', 'easel' ) . '<small> &mdash; <a href="http://gravatar.com">'. __('Get a Gravatar','easel') . '</a></small></label></p>',
			'url'    => '<p class="comment-form-url">' .
			'<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /> <label for="url">' . __( 'Website URL', 'easel' ) . '</label></p>',
			);
	$args = array(
			'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
			'comment_field'        => '<p class="comment-form-comment"><textarea id="comment" name="comment" class="comment-textarea"></textarea></p>', 
			'comment_notes_after'  => easel_themeinfo('disable_comment_note') ? '' : '<p class="comment-note"><strong><small>' . __('NOTE - You can use these HTML tags and attributes: ', 'easel') . '</small></strong><br /><small><code>' . allowed_tags() . '</code></small></p>',
			'title_reply'          => __( 'Comment &not;', 'easel' ),
			'title_reply_to'       => __( 'Reply to %s &not;','easel' ), 
			'cancel_reply_link'    => __( 'Cancel reply', 'easel' ),
			'label_submit'         => __( 'Post Comment', 'easel' )
			);
	comment_form($args); 
	?>
	</div>
<?php } elseif (!comments_open() && (get_comments_number() > 0)) { ?>
	<p class="closed-comments"><?php _e('Comments are closed.','easel'); ?></p>
<?php } ?>
</div>
