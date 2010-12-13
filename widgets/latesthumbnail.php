<?php
/*
Widget Name: Latest Thumbnail
Widget URI: http://comicpress.net/
Description: Display a thumbnail of the latest comic.
Author: Philip M. Hofer (Frumph)
Author URI: http://frumph.net/
Version: 1.03
*/
class comicpress_latest_thumbnail_widget extends WP_Widget {

	function comicpress_latest_thumbnail_widget($skip_widget_init = false) {
		if (!$skip_widget_init) {
			$widget_ops = array('classname' => __CLASS__, 'description' => __('Display a thumbnail of the latest (or first) comic or post in a category, clickable to go to the comic or post.','comicpress') );
			$this->WP_Widget(__CLASS__, __('Thumbnail','comicpress'), $widget_ops);
		}
	}
	
	function widget($args, $instance) {
		global $wp_query, $post;
		Protect();
		extract($args, EXTR_SKIP);
		$this_post_id = $post->ID;
		// Check if the category is a comic category.
		$in_comic_cat = false;
		if (comicpress_in_comic_category(array($instance['thumbcat'])) > 0) $in_comic_cat = true;
		
		if ($instance['first']) { $order = 'ASC'; } else { $order = 'DESC'; }
		$comic_query = 'showposts=1&order='.$order.'&cat='.$instance['thumbcat'];
		if ($instance['random']) $comic_query .= '&orderby=rand';
		if (!empty($post) && $instance['random']) $comic_query .= '&exclude='.$post->ID;
		
		$found_posts = &get_posts($comic_query);
		$archive_image = null;
		foreach($found_posts as $post) {
			setup_postdata($post);
			$temp_query = $wp_query->is_single;
			$wp_query->is_single = true;
			if ($in_comic_cat) {
				echo $before_widget;
				$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']); 
				if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
				echo "<a href=\"".get_permalink($post->ID)."\" title=\"".$post->post_title."\">".comicpress_display_comic_thumbnail('mini',$post, true, 0, false)."</a>\r\n";
				echo $after_widget;
			} else {
				if (function_exists('has_post_thumbnail')) {
					if ( has_post_thumbnail($post->ID) ) {
						echo $before_widget;
						$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']); 
						if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
						echo "<a href=\"".get_permalink($post->ID)."\" rel=\"bookmark\" title=\"Permanent Link to ".get_the_title()."\">".get_the_post_thumbnail($post->ID,'medium')."</a>\r\n";
						echo $after_widget;
					}
				}
			}
			$wp_query->is_single = $temp_query;
			$temp_query = null;
		}
		UnProtect();
	}
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['thumbcat'] = strip_tags($new_instance['thumbcat']);
		$instance['first'] =  (bool)( $new_instance['first'] == 1 ? true : false );
		$instance['random'] =  (bool)( $new_instance['random'] == 1 ? true : false );
		return $instance;
	}
	
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'thumbcat' => '', 'first' => false, 'random' => false ) );
		$title = strip_tags($instance['title']);
		$thumbcat = $instance['thumbcat'];
		if (empty($thumbcat)) $thumbcat = comicpress_themeinfo('comiccat');
		$first = $instance['first'];
		$random = $instance['random'];
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','comicpress'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
		<p><?php _e('Which Category?','comicpress'); ?><br />	
		<?php 
			$select = wp_dropdown_categories('show_option_all=Select category&hide_empty=0&show_count=0&orderby=name&echo=0&selected='.$thumbcat);
			$select = preg_replace('#<select([^>]*)>#', '<select name="'.$this->get_field_name('thumbcat').'" id="'.$this->get_field_id('thumbcat').'">', $select);
			echo $select;
		?>
		</p>
		<p><em><?php _e('*note: If it is a blog category it will search for the latest thumbnail attached to the image.  If it is a comic it will search for the thumbnail attached to the post first, then check do the thumbnail for the comic.','comicpress'); ?></em></p>
		<p><label for="<?php echo $this->get_field_id('first'); ?>"><?php _e('Get first in Category instead?','comicpress'); ?> <input id="<?php echo $this->get_field_id('first'); ?>" name="<?php echo $this->get_field_name('first'); ?>" type="checkbox" value="1" <?php checked(true, $first); ?> /></label></p>		
		<p><label for="<?php echo $this->get_field_id('random'); ?>"><?php _e('Display a random Thumbnail?','comicpress'); ?> <input id="<?php echo $this->get_field_id('random'); ?>" name="<?php echo $this->get_field_name('random'); ?>" type="checkbox" value="1" <?php checked(true, $random); ?> /></label></p>
		<p><em><?php _e('*note: Random comic thumbnail overrides the get first in category option.','comicpress'); ?></em></p>		
		<br />

	<?php
	}
}
register_widget('comicpress_latest_thumbnail_widget');

?>