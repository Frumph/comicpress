<?php
/**
 * Members Only
 * by Philip M. Hofer (Frumph)
 * http://frumph.net/
 * 
 * Displays content that only registered users that are marked members can see.
 * 
 * example:  [members]Only members can read this.[/members]
 * 
 * 
 */

add_shortcode( 'members', 'shortcode_for_comicpress_members_only' );
add_shortcode( 'member', 'shortcode_for_comicpress_members_only' );
add_action('show_user_profile', 'comicpress_profile_members_only');
add_action('edit_user_profile', 'comicpress_profile_members_only');
add_action('profile_update', 'comicpress_profile_members_only_save');

if (comicpress_themeinfo('members_post_category') && comicpress_themeinfo('disable_showing_members_category'))
	add_filter('pre_get_posts','comicpress_members_filter');

function comicpress_members_filter($query) {
	global $current_user;
	$members_post_category = comicpress_themeinfo('members_post_category');
	if ($members_post_category != 'none' && !empty($members_post_category) && !$query->is_search && !$query->is_page && !$query->is_archive) {
		$oldset = $query->get('cat');
		$is_member = '';
		
		if (!empty($oldset)) {
			$excludeset = $oldset.',-'.$members_post_category;
		} else {
			$excludeset = '-'.$members_post_category;
		}
		
		if ( !empty($current_user->ID) ) {
			$is_member = get_user_meta($current_user->ID,'comicpress-is-member', true);
		}
		if (!$is_member || empty($is_member)) {
			$query->set('cat',$excludeset);
		}
	}
	return $query;
}

function shortcode_for_comicpress_members_only( $atts, $content = null ) {
	global $post, $userdata, $profileuser, $current_user, $errormsg;
	$returninfo = '<div class="non-member"><p>'.__('There is Members Only content here.<br />To view this content you need to be a member of this site.','comicpress').'</p></div>';
	if ( !empty($current_user->ID) && !empty($content) ) {
		$is_member = get_user_meta($current_user->ID,'comicpress-is-member', true);
		if ($is_member || current_user_can('manage_options')) {
			$content = str_replace('<p>', '', $content);
			$content = str_replace('</p>', '', $content);
			$returninfo = "<div class=\"members-only\">$content</div>\r\n";
		}
	}
	return $returninfo;
}

function comicpress_profile_members_only() { 
	global $profileuser, $current_user, $errormsg; 
	$comicpress_is_member = get_user_meta($profileuser->ID,'comicpress-is-member', true);
	if (empty($comicpress_is_member)) $comicpress_is_member = 0;
	?>
	<h3><?php _e('Member of','comicpress'); ?> <?php bloginfo('name'); ?></h3>
	<table class="form-table">
	<tr>
	<th><label for="Memberflag"><?php _e('Member?','comicpress'); ?></label></th>
	<td> 
	<?php 
	if (current_user_can('manage_options')) { ?>
		<input id="comicpress-is-member" name="comicpress-is-member" type="checkbox" value="1" <?php checked(true, get_user_meta($profileuser->ID,'comicpress-is-member', true)); ?> />		
	<?php } else {
		if ($comicpress_is_member) { 
			echo 'Is Member';
		} else {
			echo 'Not a Member';
		}
	}
	?>
	</td>
	</tr>
	</table>
<?php }


function comicpress_profile_members_only_save() { 
	$id = (int)$_POST['user_id'];
	$is_member = (int)$_POST['comicpress-is-member'];
	$comicpress_is_member = (bool)( $is_member == 1 ? 1 : 0 );
	update_usermeta($id, 'comicpress-is-member', $comicpress_is_member);
}

/**
 * Return true if the current post is in the members category.
 */
function in_members_category() {
	global $post;
	$members_post_category = comicpress_themeinfo('members_post_category');
	$members_post_category_array = array();
	$members_post_category_array = explode(',',$members_post_category);
	$thecats = array();
	$category = get_the_category($post->ID);
	$thecats[] = $category[0]->cat_ID;
	return (count(array_intersect($members_post_category_array, $thecats)) > 0);
}

function comicpress_is_member() {
	global $user_ID;
	if (!empty($user_ID)) {
		$is_member = get_user_meta($user_ID,'comicpress-is-member', true);
		if ($is_member || current_user_can('manage_options')) {
			return true;
		}
	}
	return false;	
}

function comicpress_members_comment_filter($content) {
	global $post;
	if (comicpress_themeinfo('enable_members_only_post_comments') && in_members_category()) {
		if ( is_user_logged_in() && comicpress_is_member() ) {
			return $content;
		} else {
			return '<div class="non-member"><p>'.__('There is Members Only content here.<br />To view this content you need to be a member of this site.','comicpress').'</p></div>';
		}
	} 
	return $content;
}

add_filter('comment_text', 'comicpress_members_comment_filter');
	

?>