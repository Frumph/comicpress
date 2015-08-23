<?php
/*
Widget Name: Random Post
Widget URI: http://comicpress.net/
Description: Display a link to click on to go to a random blog post (not comic).
Author: Philip M. Hofer (Frumph)
Author URI: http://frumph.net/
Version: 1.1

There are some issues with cache' plugins where it's cache'ing the page it randomly goes to,
you can do an exclude in cache plugins like wp-supercache, exclude "randompost" in the area as
necessary.
*/

if ( isset( $_GET['randompost'] ) )
	add_action( 'template_redirect', 'comicpress_random_post' );

//Generate a random post page - to use simply create a URL link to "/?randompost"
function comicpress_random_post() {
	$randomPostQuery = new WP_Query(); $randomPostQuery->query('showposts=1&orderby=rand');
	$random_post_id = '';
	if ($randomPostQuery->have_posts()) {
		$random_comic_id = get_the_ID();
	}
	if ($randomic_post_id)
		wp_redirect( get_permalink( $random_post_id ) );
	exit;
}

/**
 * Adds Random Post widget.
 */
class comicpress_random_post_link_widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			__CLASS__, // Base ID
			__( 'ComicPress - Random Post Link', 'comicpress' ), // Name
			array( 'classname' => __CLASS__, 'description' => __( 'Displays a link to click that triggers going to a random blog post.', 'comicpress' ), ) // Args
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
		extract($args, EXTR_SKIP);
		echo $before_widget;
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; }; ?>
			<h2 class="randompost"><a href="/?randompost"><?php _e( 'Random Post', 'comicpress' ); ?></a></h2>
		<?php
		echo $after_widget;
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

// register Random Post widget
function comicpress_random_post_link_widget_init() {
	register_widget('comicpress_random_post_link_widget');
}

add_action( 'widgets_init', 'comicpress_random_post_link_widget_init');