<?php
/*
Widget Name: Site List
Description: Display list of sites, which site updated most recently.
Author: Philip M. Hofer (Frumph)
Author URI: http://frumph.net/
Version: 1.04
*/
if (function_exists('is_multisite')) {
	if (is_multisite()) {
		
		class widget_multisite_sitelist extends WP_Widget {
			
			function widget_multisite_sitelist() {
				$widget_ops = array('classname' => 'widget_multisite_sitelist', 'description' => __('Display Site List of all sites that have recently updated on this Multisite.','easel') );
				$this->WP_Widget('multisite_sitelist', 'Site List', $widget_ops);
			}
			
			function widget($args, $instance) {
				global $post;
				Protect();
				extract($args, EXTR_SKIP); 
				
				echo $before_widget;
				$title = empty($instance['title']) ? __('Hosted Site List','easel') : apply_filters('widget_title', $instance['title']); 
				if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
				$blogs = get_last_updated();
				if( is_array( $blogs ) ) { ?>
					<ul>
					<?php foreach( $blogs as $details ) { ?>
						<li><a href="http://<?php echo $details[ 'domain' ] . $details[ 'path' ] ?>"><?php echo get_blog_option( $details[ 'blog_id' ], 'blogname' ) ?></a></li>
					<?php } ?>
					</ul>
				<?php }
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
				<p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
				<?php
			}
		}
		
		register_widget('widget_multisite_sitelist');
	}
}
?>