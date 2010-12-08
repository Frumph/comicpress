<?php
/*
Widget Name: Comic Date
Widget URI: http://comicpress.net/
Description: Display's the date of post of the comic.
Author: Philip M. Hofer (Frumph)
Author URI: http://frumph.net/
Version: 1.03
*/
class comicpress_comic_date_widget extends WP_Widget {

	function comicpress_comic_date_widget($skip_widget_init = false) {
		if (!$skip_widget_init) {
			$widget_ops = array('classname' => __CLASS__, 'description' => __('Displays the date of the post of the comic.','comicpress') );
			$this->WP_Widget(__CLASS__, __('Comic Date','comicpress'), $widget_ops);
		}
	}
	
	function widget($args, $instance) {
		global $post;
		extract($args, EXTR_SKIP); 
		
		echo $before_widget;
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		if ( !empty( $title ) ) { echo $title; } ?>	
		<?php the_time($instance['format']); ?>
		<?php echo $after_widget;
	}
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['format'] = strip_tags($new_instance['format']);
		if (empty($instance['format'])) $instance['format'] = 'F jS, Y';
		return $instance;
	}
	
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'format' => '' ) );
		$title = strip_tags($instance['title']);
		$format = strip_tags($instance['format']);
		if (empty($format)) $format = 'F jS, Y';
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Words to use before date:','comicpress'); ?><br /><input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('format'); ?>"><?php _e('Format of the Time/Date:','comicpress'); ?><br /><input class="widefat" id="<?php echo $this->get_field_id('format'); ?>" name="<?php echo $this->get_field_name('format'); ?>" type="text" value="<?php echo esc_attr($format); ?>" /></label></p>
		<p><a href="http://us.php.net/manual/en/function.date.php" target="_blank"><?php _e('Date String Examples','comicpress'); ?></a></p>
		
		<?php
	}
}
register_widget('comicpress_comic_date_widget');

?>