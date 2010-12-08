<?php
/*
Widget Name: Latest Comics Widget
Widget URI: http://comicpress.net/
Description: Display a list of links of the latest comics.
Author: Philip M. Hofer (Frumph)
Version: 1.02
*/
class comicpress_latest_comics_widget extends WP_Widget {
	
	function comicpress_latest_comics_widget($skip_widget_init = false) {
		if (!$skip_widget_init) {
			$widget_ops = array('classname' => __CLASS__, 'description' => __('Display a list of the latest comics available.','comicpress') );
			$this->WP_Widget(__CLASS__, __('Latest Comics','comicpress'), $widget_ops);
		}
	}
	
	function widget($args, $instance) {
		global $post, $wp_query;
		Protect();
		extract($args, EXTR_SKIP); 
		echo $before_widget;
		$title = empty($instance['title']) ? __('Latest Comics','comicpress') : apply_filters('widget_title', $instance['title']); 
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; }; 
		$latestcomics = &get_posts('numberposts=5&category='.comicpress_all_comic_categories_string()); ?>
		<ul>
		<?php foreach($latestcomics as $post) : ?>
			<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
			<?php endforeach; ?>
		</ul>
		<?php
		echo $after_widget;
		UnProtect();
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
register_widget('comicpress_latest_comics_widget');

?>