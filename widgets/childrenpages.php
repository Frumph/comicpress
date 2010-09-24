<?php
/*
Widget Name: Display Children Pages (In Testing)
Widget URI: http://frumph.net/
Description: Displays a list of all children pages of the current page.
Author: Philip M. Hofer (Frumph)
Author URI: http://frumph.net/
Version: 1.03
*/
class comicpress_children_pages_widget extends WP_Widget {
	
	function comicpress_children_pages_widget($skip_widget_init = false) {
		if (!$skip_widget_init) {
			$widget_ops = array('classname' => __CLASS__, 'description' => __('Displays a list of all children pages of the current page.','comicpress') );
			$this->WP_Widget(__CLASS__, __('Children Pages','comicpress'), $widget_ops);
		}
	}
	
	function widget($args, $instance) {
		global $post, $wp_query;
		extract($args, EXTR_SKIP); 
		if (!is_home()) {
			$my_wp_query = new WP_Query();
			$all_wp_pages = $my_wp_query->query(array('post_type' => 'page'));
			$page_children = get_page_children($post->ID, $all_wp_pages);
			if (!empty($page_children)) {
				echo $before_widget;
				$title = empty($instance['title']) ? __('Children Pages','comicpress') : apply_filters('widget_title', $instance['title']); 
				if ( !empty( $title ) ) { echo $before_title . $title . $after_title; }; 
				
				//			var_dump($page_children);
				?><ul>
				<?php foreach ($page_children as $child) { ?>
					<li><a href="<?php echo get_permalink($child->ID); ?>"><?php echo get_the_title($child->ID); ?></a></li>
				<?php } ?>
				</ul> <?php
				echo $after_widget;
			}
		}
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
// register_widget('comicpress_children_pages_widget');

?>