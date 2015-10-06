<?php
if ( post_password_required() ) { ?>
	<p class="nocomments"><?php _e( 'This post is password protected. Enter the password to view comments.', 'comicpress' ); ?></p>
	<?php
    return;
    }

    if (!comments_open() && !get_comments_number()) {
    return;
    }
?>
<div id="comment-wrapper">
<?php if (comments_open()) { ?>
	<div class="commentsrsslink"><?php post_comments_feed_link(__( 'Comments RSS', 'comicpress' )); ?></div>
	<h4 id="comments"><?php comments_number(__( 'Discussion &not;', 'comicpress' ), __( 'Discussion &not;', 'comicpress' ), __( 'Discussion (%) &not;', 'comicpress' )); ?></h4>
<?php }
        if ( isset($comments_by_type['pings']) && (!isset($wp_query->query_vars['cpage']) || ((int)$wp_query->query_vars['cpage'] < 2))&& (count($comments_by_type['pings']) > 0)) {
 ?>
		<div id="pingtrackback-wrap">
			<ol class="commentlist">
			<li>
				<ul>
					<?php
						$comment_args = array(
							'type' => 'pings',
							'avatar_size' => 32,
							'callback' => 'comicpress_comments_callback',
							'end-callback' => 'comicpress_comments_end_callback',
						);
                        wp_list_comments($comment_args);
					?>
				</ul>
			</li>
			</ol>
		</div>
	<?php
            }
            if ( !empty($comments_by_type['comment']) ) {
 ?>
		<ol class="commentlist">
		<?php
            $comment_args = array(
				'type' => 'comment',
				'reply_text' => __( 'Reply &not;', 'comicpress' ),
				'callback' => 'comicpress_comments_callback',
				'end-callback' => 'comicpress_comments_end_callback',
				'avatar_size' => 64
			);
			wp_list_comments($comment_args);
        ?>
		</ol>
	<?php
	if (get_comment_pages_count() > 1 && get_option( 'page_comments' )) {
		if (comicpress_themeinfo('enable_numbered_pagination')) {
			$pagelinks = paginate_comments_links(array('echo' => 0));
			if (!empty($pagelinks)) {
				$pagelinks = str_replace('<a', '<li><a', $pagelinks);
				$pagelinks = str_replace('</a>', '</a></li>', $pagelinks);
				$pagelinks = str_replace('<span', '<li', $pagelinks);
				$pagelinks = str_replace('</span>', '</li>', $pagelinks); ?>
			<div id="wp-paginav">
				<div id="paginav">
					<?php echo '<ul><li class="paginav-extend">' . __( 'Comment Pages', 'comicpress' ) . '</li>' . $pagelinks . '</ul>'; ?>
					</div>
				<div class="clear"></div>
			</div>
			<?php } ?>

		<?php } else { ?>
			<div class="commentnav">
				<div class="commentnav-right"><?php next_comments_link(__( 'Next Comments &uarr;', 'comicpress' )) ?></div>
				<div class="commentnav-left"><?php previous_comments_link(__( '&darr; Previous Comments', 'comicpress' )) ?></div>
				<div class="clear"></div>
			</div>
		<?php }
                }
                }

                if (comments_open()) {
 ?>
<div class="comment-wrapper-respond">
	<?php
    $fields = array('author' => '<p class="comment-form-author">' . '<input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30" />' . ' <label for="author"><small>' . __( '*NAME', 'comicpress' ) . '</small></label></p>', 'email' => '<p class="comment-form-email">' . '<input id="email" name="email" type="text" value="' . esc_attr($commenter['comment_author_email']) . '" size="30" /> <label for="email">' . __( '*EMAIL', 'comicpress' ) . '<small> &mdash; <a href="https://gravatar.com">' . __( 'Get a Gravatar', 'comicpress' ) . '</a></small></label></p>', 'url' => '<p class="comment-form-url">' . '<input id="url" name="url" type="text" value="' . esc_attr($commenter['comment_author_url']) . '" size="30" /> <label for="url">' . __( 'Website URL', 'comicpress' ) . '</label></p>', );
    $args = array('fields' => apply_filters('comment_form_default_fields', $fields), 'comment_field' => '<p class="comment-form-comment"><textarea id="comment" name="comment" class="comment-textarea"></textarea></p>', 'comment_notes_after' => comicpress_themeinfo('disable_comment_note') ? '' : '<p class="comment-note"><strong><small>' . __( 'NOTE &mdash; You can use these HTML tags and attributes:', 'comicpress' ).'</small></strong><br /><small><code>'.allowed_tags().'</code></small></p>', 'title_reply' => __( 'Comment &not;', 'comicpress' ), 'title_reply_to' => __( 'Reply to %s &not;', 'comicpress' ), 'cancel_reply_link' => __( 'Cancel reply', 'comicpress' ), 'label_submit' => __( 'Post Comment', 'comicpress' ));
    comment_form($args);
	?>
	</div>
<?php } elseif (!comments_open() && (get_comments_number() > 0)) { ?>
	<p class="closed-comments"><?php _e( 'Comments are closed.', 'comicpress' ); ?></p>
<?php } ?>
</div>
