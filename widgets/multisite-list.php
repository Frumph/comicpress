<?php
/*
Widget Name: Site List
Widget URI: http://comicpress.net/
Description: Display list of sites, which site updated most recently.
Author: Philip M. Hofer (Frumph)
Author URI: http://frumph.net/
Version: 1.1
*/
if (function_exists('is_multisite') && is_multisite()) {
		
		/**
		 * Adds Site List widget.
		 */
		class comicpress_multisite_sitelist_widget extends WP_Widget {
			
			/**
			 * Register widget with WordPress.
			 */
			function __construct() {
				parent::__construct(
					__CLASS__, // Base ID
					__( 'ComicPress - Site List', 'comicpress' ), // Name
					array( 'classname' => __CLASS__, 'description' => __( 'Display Site List of all sites that have recently updated on this Multisite.', 'comicpress' ), ) // Args
				);
			}
			
			/**
			 * Front-end display of widget.
			 *
			 * @see WP_Widget::widget()
			 *
			 * @param array $args     Widget arguments.
			 * @param array $instance Saved values from database.
			 */
			public function widget($args, $instance) {
				global $post;
				Protect();
				extract($args, EXTR_SKIP);
				echo $before_widget;
				$title = empty($instance['title']) ? __( 'Hosted Site List', 'comicpress' ) : apply_filters('widget_title', $instance['title']);
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
			
			/**
			 * Sanitize widget form values as they are saved.
			 *
			 * @see WP_Widget::update()
			 *
		     * @param array $new_instance Values just sent to be saved.
			 * @param array $old_instance Previously saved values from database.
			 *
			 * @return array Updated safe values to be saved.
			 */
			 public function update($new_instance, $old_instance) {
				 $instance = $old_instance;
				 $instance['title'] = strip_tags($new_instance['title']);
				 return $instance;
			 }
			
			 /**
			  * Back-end widget form.
			  *
	 		  * @see WP_Widget::form()
	 		  *
	 		  * @param array $instance Previously saved values from database.
	 		  */
			 public function form($instance) {
				 $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
				 $title = strip_tags($instance['title']);
				 ?>
				 <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
				 <?php
			  }
		}
		
	// register Site List widget
	function comicpress_multisite_sitelist_widget_init() {
		register_widget('comicpress_multisite_sitelist_widget');
	}
	
	add_action( 'widgets_init', 'comicpress_multisite_sitelist_widget_init');
}