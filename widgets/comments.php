<?php
/*
Widget Name: Comic Comments Widget
Widget URI: http://comicpress.net/
Description: Display a comments link to put inside the comic area.
Author: Philip M. Hofer (Frumph)
Author URI: http://frumph.net/
Version: 1.03
*/	
	
class comicpress_comments_widget extends WP_Widget {

	function comicpress_comments_widget($skip_widget_init = false) {
		if (!$skip_widget_init) {
			$widget_ops = array('classname' => __CLASS__, 'description' => __('Displays a comments link. (used in comic sidebars)','comicpress') );
			$this->WP_Widget(__CLASS__, __('Comic Comments Link','comicpress'), $widget_ops);
		}
	}
	
	function widget($args, $instance) {
		global $post;
		setup_postdata($post);
		extract($args, EXTR_SKIP); 
		
		echo $before_widget;
		$title = empty($instance['title']) ? __('Permalink','comicpress') : apply_filters('widget_title', $instance['title']); ?>
		<?php if ('open' == $post->comment_status) { ?><div class="comment-link"><?php comments_popup_link('<span class="comment-balloon comment-balloon-empty"> </span> Comment ', '<span class="comment-balloon">1</span> Comment ', '<span class="comment-balloon">%</span> Comments '); ?></div><?php } ?>
		<?php
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}
	
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
		$title = strip_tags($instance['title']);
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('New Link name:','comicpress'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>		
		<?php
	}
}
register_widget('comicpress_comments_widget');

?>