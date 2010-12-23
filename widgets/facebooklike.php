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
		switch ($instance['style']) {
			case 1:
				echo '<fb:like layout="box_count" show_faces="false" width="55" href="'.get_permalink().'"></fb:like>';
				break;
			case 2:
				echo '<fb:like layout="button_count" show_faces="false" width="94" href="'.get_permalink().'"></fb:like>';
				break;
			case 3:
				echo '<fb:like show_faces="false" width="260" href="'.get_permalink().'"></fb:like>';
				break;
		}
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['style'] = (int)$new_instance['style'];
		return $instance;
	}
	
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'style' => 1 ) );
		$title = strip_tags($instance['title']);
		$style = (int)$instance['style'];
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','comicpress'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('style'); ?>"><input id="<?php echo $this->get_field_id('style'); ?>" name="<?php echo $this->get_field_name('style'); ?>" type="radio" value="1" <?php checked(1, $style); ?> /> Box Count</label></p>
		<p><label for="<?php echo $this->get_field_id('style'); ?>"><input id="<?php echo $this->get_field_id('style'); ?>" name="<?php echo $this->get_field_name('style'); ?>" type="radio" value="2" <?php checked(2, $style); ?> /> Button Count</label></p>			
		<p><label for="<?php echo $this->get_field_id('style'); ?>"><input id="<?php echo $this->get_field_id('style'); ?>" name="<?php echo $this->get_field_name('style'); ?>" type="radio" value="3" <?php checked(3, $style); ?> /> Standard</label></p>			
		<?php
	}
}
register_widget('comicpress_facebook_like_widget');

?>