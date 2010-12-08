<?php
/*
Widget Name: Non-Member text widget
Widget URI: http://comicpress.net/
Description: Displays whatever inside to non-members.
Author: Philip M. Hofer (Frumph)
Author URI: http://frumph.net/
Version: 1.03
*/	
class comicpress_non_member_text_widget extends WP_Widget {
	
	function comicpress_non_member_text_widget($skip_widget_init = false) {
		if (!$skip_widget_init) {
			$widget_ops = array('classname' => __CLASS__, 'description' => __('Displays Whatever is in the text box to non-members only.','comicpress') );
			$this->WP_Widget(__CLASS__, __('Text - Non Member','comicpress'), $widget_ops);
		}
	}
	
	function widget($args, $instance) {
		global $post, $wp_query;
		if (!comicpress_is_member()) {
			extract($args, EXTR_SKIP); 
			echo $before_widget;
			$title = empty($instance['title']) ? '': apply_filters('widget_title', $instance['title']);
			echo stripslashes($instance['textinfo']);
			echo $after_widget;
		}
	}
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['textinfo'] = addslashes($new_instance['textinfo']);
		return $instance;
	}
	
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' , 'textinfo' => '') );
		$title = strip_tags($instance['title']);
		$textinfo = stripslashes($instance['textinfo']);
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','comicpress'); ?><input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
		<p><label><textarea style="width: 400px; height: 280px;" name="<?php echo $this->get_field_name('textinfo'); ?>" name="<?php echo $this->get_field_name('textinfo'); ?>"><?php echo $textinfo; ?></textarea></label></p>
		<?php
	}
}
register_widget('comicpress_non_member_text_widget');

?>