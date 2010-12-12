<?php
/*
Widget Name: Facebook Like
Widget URI: http://comicpress.net/
Description: Displays a Facebook "Like" button.
Author: Philip M. Hofer (Frumph)
Author URI: http://frumph.net/
Version: 1.03
*/	
	
class comicpress_facebook_like_widget extends WP_Widget {

	function comicpress_facebook_like_widget($skip_widget_init = false) {
		if (!$skip_widget_init) {
			$widget_ops = array('classname' => __CLASS__, 'description' => __('Displays a Facebook "like" Button (For Comic sidebars or single pages only)','comicpress') );
			$this->WP_Widget(__CLASS__, __('Facebook Like','comicpress'), $widget_ops);
		}
	}
	
	function widget($args, $instance) {
		global $post;
		extract($args, EXTR_SKIP); 
		
		echo $before_widget;
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']); 
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
		// This only works in comic sidebar widgets, declare it to pass it as a comic.
		comicpress_display_facebook_like(true, true); // 2nd param is to bypass the check for $is_comic
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}
	
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$title = strip_tags($instance['title']);
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','comicpress'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
		<?php
	}
}
register_widget('comicpress_facebook_like_widget');

?>