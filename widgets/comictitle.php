<?php
/*
Widget Name: Comic Title Widget
Widget URI: http://comicpress.net/
Description: Display a Title of the Comic that can be used in any area around the comic.
Author: Philip M. Hofer (Frumph)
Author URI: http://frumph.net/
Version: 1.03
*/
class comicpress_comic_title_widget extends WP_Widget {
	
	function comicpress_comic_title_widget($skip_widget_init = false) {
		if (!$skip_widget_init) {
			$widget_ops = array('classname' => __CLASS__, 'description' => __('Displays the title of the comic. (used in comic sidebars)','comicpress') );
			$this->WP_Widget(__CLASS__, __('Comic Title','comicpress'), $widget_ops);
		}
	}
	
	function widget($args, $instance) {
		global $post;
		extract($args, EXTR_SKIP); 
		
		echo $before_widget;?>
		<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		<?php echo $after_widget;
	}
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		return $instance;
	}
	
	function form($instance) {
	}
}
register_widget('comicpress_comic_title_widget');

?>