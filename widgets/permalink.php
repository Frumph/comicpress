<?php
/*
Widget Name: Permalink
Widget URI: http://comicpress.net/
Description: Display a permalink link that can be used in any area around the comic.
Author: Philip M. Hofer (Frumph)
Author URI: http://frumph.net/
Version: 1.03
*/
class comicpress_permalink_widget extends WP_Widget {

	function comicpress_permalink_widget($skip_widget_init = false) {
		if (!$skip_widget_init) {
			$widget_ops = array('classname' => __CLASS__, 'description' => __('Displays a permalink. (used in comic sidebars)','comicpress') );
			$this->WP_Widget(__CLASS__, __('Permalink','comicpress'), $widget_ops);
		}
	}
	
	function widget($args, $instance) {
		global $post;
		extract($args, EXTR_SKIP); 
		
		echo $before_widget;
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']); ?>
		<a href="<?php the_permalink(); ?><?php if ($instance['comment'] == 'yes') { ?>#comment<?php } ?>" class="widget_permalink_href"><?php echo $title; ?></a>
		<?php
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['comment'] = strip_tags($new_instance['comment']);
		return $instance;
	}
	
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' , 'comment' => '') );
		$title = strip_tags($instance['title']);
		$comment = strip_tags($instance['comment']);
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('New Link name:','comicpress'); ?><input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
		<p><label><input name="<?php echo $this->get_field_name('comment'); ?>" id="<?php echo $this->get_field_id('comment'); ?>-comment" type="radio" value="yes"<?php if ( $comment == "yes") { echo " checked"; } ?> />Yes <input name="<?php echo $this->get_field_name('comment'); ?>" id="<?php echo $this->get_field_id('comment'); ?>-comment" type="radio" value="no"<?php if ( $comment == "no") { echo " checked"; } ?> />No<br />Add #comment to href?</label></p>
		
		<?php
	}
}
register_widget('comicpress_permalink_widget');

?>