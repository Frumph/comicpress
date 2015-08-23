<?php
/*
Widget Name: Scheduled Posts
Widget URI: http://comicpress.net/
Description: Display a list of posts that are due to be scheduled.
Author: Philip M. Hofer (Frumph)
Author URI: http://frumph.net/
Version: 1.2
*/

/**
 * Adds Scheduled Posts widget.
 */
class comicpress_scheduled_posts_widget extends WP_Widget {
	
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			__CLASS__, // Base ID
			__( 'ComicPress - Scheduled Posts', 'comicpress' ), // Name
			array( 'classname' => __CLASS__, 'description' => __( 'Display a list of posts that are scheduled to be published.', 'comicpress' ), ) //Args
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
		extract($args, EXTR_SKIP);
		Protect();
		echo $before_widget;
		$title = empty($instance['title']) ? __( 'Scheduled Posts', 'comicpress' ) : apply_filters('widget_title', $instance['title']); 
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
		$scheduled_posts = &get_posts('post_status=future&showposts=5');
		if (empty($scheduled_posts)) {
			echo '<ul><li>None.</li></ul>';
		} else { ?>
			<ul>
			<?php foreach($scheduled_posts as $post) : ?>
				<li><span class="scheduled-post-date"><?php echo date('m/d/Y',strtotime($post->post_date)); ?></span> <span class="scheduled-post-title"><?php echo $post->post_title; ?></span></li>
			<?php endforeach; ?>
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
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', 'comicpress' ); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
		<?php
	}
}

// register Scheduled Posts widget
function comicpress_scheduled_posts_widget_init() {
	register_widget('comicpress_scheduled_posts_widget');
}

add_action( 'widgets_init', 'comicpress_scheduled_posts_widget_init');