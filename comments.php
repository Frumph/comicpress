<?php
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
  die (__('Please do not load this page directly. Thanks!','comicpress'));

if ( post_password_required() ) { ?>
	<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.','comicpress'); ?></p>
	<?php
	return;
}
?>

<?php if (comicpress_themeinfo('enable_caps')) { ?><div id="comment-wrapper-head"></div><?php } ?>
<div id="comment-wrapper">

<?php if ( have_comments() ) : ?>

	<?php if ( !empty($comments_by_type['comment']) ) : ?>
		
		<h3 id="comments"><?php comments_number(__('Discussion &not;','comicpress'), __('Discussion &not;','comicpress'), __('Discussion (%) &not;','comicpress') );?></h3>
		<div class="commentsrsslink">[ <?php post_comments_feed_link('Comments RSS'); ?> ]</div>
		<ol class="commentlist">
			<?php if (function_exists('comicpress_comments_callback')) { 
				wp_list_comments(array(
							'type' => 'comment',
							'reply_text' => __('Reply to %s&not;','comicpress'), 
							'callback' => 'comicpress_comments_callback',
							'end-callback' => 'comicpress_comments_end_callback',
							'avatar_size'=>64
							)
						); 
			} else {
				wp_list_comments(array('type' => 'comment', 'avatar_size'=>64));
			}?>	
		</ol>
		
	<?php endif; ?>
		
	<?php if ( !empty($comments_by_type['pings']) ) : ?>
		<div id="pingtrackback-wrap">
			<h3 id="pingtrackback"><?php _e('Pings &amp; Trackbacks &not;','comicpress'); ?></h3>
			<ol class="commentlist">
			<li>
				<ul>
					<?php if (function_exists('comicpress_comments_callback')) { 
						wp_list_comments(array(
									'type' => 'pings',
									'callback' => 'comicpress_comments_callback',
									'end-callback' => 'comicpress_comments_end_callback',
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

	<?php endif; ?>
	
		<?php if (comicpress_themeinfo('enable_numbered_pagination')) { ?>
		<?php 
			$pagelinks = paginate_comments_links(array('echo' => 0)); 
			if (!empty($pagelinks)) {
				$pagelinks = str_replace('<a', '<li><a', $pagelinks);
				$pagelinks = str_replace('</a>', '</a></li>', $pagelinks); 
				$pagelinks = str_replace('<span', '<li', $pagelinks); 
				$pagelinks = str_replace('</span>', '</li>', $pagelinks); ?>
			<div id="wp-paginav">
				<div id="paginav">				
					<?php echo '<ul><li class="paginav-extend">'.__('Comment Pages','comicpress').'</li>'. $pagelinks . '</ul>'; ?>
					</div>
				<div class="clear"></div>
			</div>					
			<?php } ?>

		<?php } else { ?>
			<div class="commentnav">
				<div class="commentnav-right"><?php next_comments_link(__('Next Comments &uarr;','comicpress')) ?></div>
				<div class="commentnav-left"><?php previous_comments_link(__('&darr; Previous Comments','comicpress')) ?></div>
				<div class="clear"></div>
			</div>
		<?php } ?>

	
<?php else : // this is displayed if there are no comments so far ?>
	<?php if ('open' == $post->comment_status) : ?>
  <!-- If comments are open, but there are no comments. -->

	<?php else : // comments are closed ?>
	<!-- If comments are closed. -->
	<?php if (!is_page()) { ?>
		<p class="nocomments"><?php _e('Comments are closed.','comicpress'); ?></p>
	<?php } ?>
	<?php endif; ?>
<?php endif; ?>

<?php if ('open' == $post->comment_status) : 

	if (function_exists('in_members_category')) {
		if (in_members_category() && !comicpress_is_member()) {
			return;
		}
	}
	// comment_form(); not used based on our own required look and functionality.
?>
<div class="comment-wrapper-respond">
	<?php
	
	$fields =  array(
			'author' => '<p class="comment-form-author">' .
			'<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" />'. ' <label for="author"><small>' . __( 'NAME &mdash;','comicpress' ) . ' <a href="http://gravatar.com">'. __('Get a Gravatar','comicpress') . '</a></small></label></p>',
			'email'  => '<p class="comment-form-email">' .
			'<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" /> <label for="email">' . __( 'EMAIL', 'comicpress' ) . '</label></p>',
			'url'    => '<p class="comment-form-url">' .
			'<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /> <label for="url">' . __( 'Website URL', 'comicpress' ) . '</label></p>',
			);
	
	if (comicpress_themeinfo('disable_comment_note')) {
		$args = array(
				'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
				'comment_field'        => '<p class="comment-form-comment"><textarea id="comment" name="comment"></textarea></p>',
				'comment_notes_before' => '',
				'comment_notes_after'  => '',
				'title_reply'          => __( 'Comment &not;<br />', 'comicpress' ),
				'title_reply_to'       => __( 'Reply to %s &not;<br />','comicpress' ), 
				'cancel_reply_link'    => __( '<small>Cancel reply</small>', 'comicpress' ),
				'label_submit'         => __( 'Post Comment', 'comicpress' )
				);
	} else {
		$args = array(
				'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
				'comment_notes_before' => '',
				'comment_field'        => '<p class="comment-form-comment"><textarea id="comment" name="comment"></textarea></p>',
				'comment_notes_after'  => '<p class="comment-note">' . __('NOTE - You can use these ','comicpress') . sprintf(('<abbr title="HyperText Markup Language">HTML</abbr> tags and attributes:<br />%s' ), ' <code>' . allowed_tags() . '</code>' ) . '</p>',
				'title_reply'          => __( 'Comment &not;<br />', 'comicpress'),
				'title_reply_to'       => __('Reply to %s &not;<br />','comicpress'), 
				'cancel_reply_link'    => __( '<small>Cancel reply</small>', 'comicpress' ),
				'label_submit'         => __( 'Post Comment', 'comicpress' )
				);
	}
	comment_form($args); 
	?>
	<div class="clear"></div>
</div>

<?php endif; ?>
</div>
<?php if (comicpress_themeinfo('enable_caps')) { ?><div id="comment-wrapper-foot"></div><?php } ?>