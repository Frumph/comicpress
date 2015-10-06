<?php
/**
 * Theme Function: Moods
 * Author: Philip M. Hofer (Frumph)
 * Created: 08/22/2009
 * Author Email: philip@frumph.net
 * You may use this and adapt this code to anything you like however keep the author information retained in 
 * the appropriate files.
 * 
 * Lets you set and make moods for your blog posts.
 * 
 * Usage:  if (function_exists('comicpress_show_mood_in_post')) comicpress_show_mood_in_post();
 * 
 * Edit a post and it you will see the possible moods you can use, select one.
 * 
 */

add_action('save_post', 'comicpress_handle_edit_post_mood_save' ,5, 1);
add_action('add_meta_boxes', 'comicpress_add_moods_into_posts');

function comicpress_add_moods_into_posts() {
	global $post;
	if (!empty($post) && ($post->post_type == 'comic' || $post->post_type == 'post')) {
		add_meta_box('comicpress_showmood_edit_post', __( 'Moods', 'comicpress' ), 'comicpress_showmood_edit_post', 'post', 'normal', 'low');
	}
}

 
function comicpress_show_mood_in_post() {
	global $post;
	$moods_directory = comicpress_themeinfo('moods_directory');
	if (!empty($moods_directory) && $moods_directory != 'none') {
		$mood_file = get_post_meta( get_the_ID(), "mood", true );
		if (!empty($mood_file) && $mood_file != '') {
			$mood = explode(".", $mood_file);
			$mood = reset($mood);
			if ( !empty($mood_file) && file_exists(get_stylesheet_directory() . '/images/moods/'.$moods_directory.'/'.$mood_file) ) { ?>
				<div class="post-mood post-<?php echo $mood; ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/moods/<?php echo $moods_directory; ?>/<?php echo $mood_file; ?>" alt="<?php echo $mood; ?>" title="<?php echo $mood; ?>" /></div>
			<?php } elseif (!empty($mood_file) && file_exists(get_template_directory() . '/images/moods/' .$moods_directory . '/' . $mood_file) ) { ?>
				<div class="post-mood post-<?php echo $mood; ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/moods/<?php echo $moods_directory; ?>/<?php echo $mood_file; ?>" alt="<?php echo $mood; ?>" title="<?php echo $mood; ?>" /></div>
			<?php }
		}
	}
}

function comicpress_showmood_edit_post() { 
	global $post;
	$moods_directory = comicpress_themeinfo('moods_directory');
	if (!empty($moods_directory) && $moods_directory != 'none') { ?>
		<div class="inside" style="overflow: hidden">
		<?php _e( 'Available Moods, you can set which mood images to use in the comicpress Options.', 'comicpress' ); ?><br />
		<br />
		<?php 
		
		$currentmood = get_post_meta( $post->ID, "mood", true );
		
		if (empty($currentmood) || $currentmood == '' || $currentmood == null) { 
			$mood = __( 'none', 'comicpress' );
		} else {
			$mood = explode(".", $currentmood);
			$mood = reset($mood);
		}
		
		$count = 0;
		$count = count($results = glob(get_stylesheet_directory() . '/images/moods/'.$moods_directory.'/*'));
		if (!$count) {
			$count = count($results = glob(get_template_directory() . '/images/moods/'.$moods_directory.'/*'));
			$moods_uri = get_template_directory_uri();
		} else {
			$moods_uri = get_stylesheet_directory_uri();
		}
		echo $count .__( ' moods are available.', 'comicpress' ).'<br />
				'.__( 'Using Moods from directory:', 'comicpress' ).' '.$moods_directory.'<br />
				'.__( 'Current Mood:', 'comicpress' ).' '.$mood.'<br /><br />';
		if (!empty($results)) { ?>
			<div style="float:left; margin-top: 70px; text-align: center; width: 68px; overflow: hidden;"> 
			<label for="postmood-none" style="cursor:pointer;">		
			none
			</label>
			<br />
			<input name="postmood" style="margin-top: 3px;" id="postmood-anger" type="radio" value="none" <?php if ( $mood == 'none' ) { echo " checked"; } ?> />
			</div>
			<?php foreach ($results as $file) {
				$newmood_file = basename($file);
				$newmood = explode(".", $newmood_file); 
				$newmood = $newmood[0]; ?>
				<div style="float:left; margin-top: 10px; text-align: center; width: 68px; overflow: hidden;"> 
				<label for="postmood-<?php echo $newmood; ?>" style="cursor:pointer;">
				<img src="<?php echo $moods_uri; ?>/images/moods/<?php echo $moods_directory; ?>/<?php echo basename($file); ?>" /><br />
				<?php echo $newmood; ?>
				</label>
				<br />
				<input  name="postmood" style="margin-top: 3px;" id="postmood-<?php echo $newmood; ?>" type="radio" value="<?php echo $newmood_file; ?>"<?php if ( $mood == $newmood ) { echo " checked"; } ?> />
				</div>
			<?php }
		} ?>
		</div>
	<?php }
}


function comicpress_handle_edit_post_mood_save($post_id) {
	$moods_directory = comicpress_themeinfo('moods_directory');
	if (!empty($moods_directory) && $moods_directory != 'none') {
		$currentmood = get_post_meta( $post_id, "mood", true );
		if (isset($_POST['postmood']) && $_POST['postmood'] !== $currentmood) {
			$postmood = $_POST['postmood'];
			update_post_meta($post_id, 'mood', $postmood);
		}
	}
}
