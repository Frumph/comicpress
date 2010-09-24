<?php
/*
Widget Name: Latest Excerpt
Widget URI: http://frumph.net
Description: Display the excerpt of the latest post/comic.
Author: Philip M. Hofer (Frumph)
Author URI: http://frumph.net/
Version: 1.0
*/
class comicpress_latest_excerpt_widget extends WP_Widget {

	function comicpress_latest_excerpt_widget($skip_widget_init = false) {
		if (!$skip_widget_init) {
			$widget_ops = array('classname' => __CLASS__, 'description' => __('Display the excerpt of the latest comic or post, clickable to go to the comic post.','comicpress') );
			$this->WP_Widget(__CLASS__, __('Display Latest Excerpt','comicpress'), $widget_ops);
		}
	}
	
	function widget($args, $instance) {
		global $post, $wp_query;
		Protect();
		extract($args, EXTR_SKIP);
		$post_query = 'showposts=1&cat='.$instance['thecat'];
		$posts = &query_posts($post_query);
		if (have_posts()) {
			while (have_posts()) : the_post();
				echo $before_widget;
				$title = empty($instance['title']) ? 'Latest Excerpt' : apply_filters('widget_title', $instance['title']); 
				if ( !empty( $title ) ) { echo $before_title . $title . $after_title; }; ?>
				<ul>
					<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
					<li><?php the_excerpt(); ?></li>
				</ul>
				<?php echo $after_widget;
			endwhile;
		}
		UnProtect();
	}
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['thecat'] = strip_tags($new_instance['thecat']);
		return $instance;
	}
	
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'thecat' => '' ) );
		$title = strip_tags($instance['title']);
		$thecat = $instance['thecat'];
//  This is a comicpress 3.0 function
//		if (empty($thecat)) $thecat = comicpress_themeinfo('comiccat');
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','comicpress'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
		<p><?php _e('Which Category?','comicpress'); ?><br />	
		<?php 
			$select = wp_dropdown_categories('show_option_all=Select category&hide_empty=0&show_count=0&orderby=name&echo=0&selected='.$thecat);
			$select = preg_replace('#<select([^>]*)>#', '<select name="'.$this->get_field_name('thecat').'" id="'.$this->get_field_id('thecat').'">', $select);
			echo $select;
		?>
		</p>
		<br />

	<?php
	}
}
register_widget('comicpress_latest_excerpt_widget');

?>