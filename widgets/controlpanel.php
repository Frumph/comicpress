<?php
/*
Widget Name: Control Panel
Description: Display an area for login and logout, forgot password and register.
Author: Philip M. Hofer (Frumph)
Author URI: http://frumph.net/
Version: 1.1
*/

/**
 * Adds Control Panel widget.
 */
class comicpress_control_panel_widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			__CLASS__, // Base ID
			__( 'ComicPress - Control Panel', 'comicpress' ), // Name
			array( 'classname' => __CLASS__, 'description' => __( 'Login/Logoff menu with register/lost password links if not logged on. (use only if registrations are enabled).', 'comicpress' ), ) // Args
		);
	}
	
	function comicpress_show_control_panel() {
		global $user_login;
		if (!is_user_logged_in()) { ?>
			<?php
			$args = array(
					'label_username' => __( 'Username', 'comicpress' ),
					'label_password' => __( 'Password', 'comicpress' )
					);
				wp_login_form($args);
			?>
			<ul>
			<?php if (is_multisite()) { ?>
				<li><a href="<?php echo site_url(); ?>/wp-signup.php"><?php _e( 'Register', 'comicpress' ); ?></a></li>
			<?php } else { ?>
				<li><a href="<?php echo site_url(); ?>/wp-register.php"><?php _e('Register', 'comicpress' ); ?></a></li>
			<?php } ?>
			<li><a href="<?php echo site_url(); ?>/wp-login.php?action=lostpassword"><?php _e( 'Recover password', 'comicpress' ); ?></a></li>
			</ul>
		<?php } else { ?>
			<ul>
				<li><a href="<?php echo wp_logout_url(get_permalink()); ?>"><?php _e( 'Logout', 'comicpress' ); ?></a></li>
				<?php wp_register(); ?>
				<li><a href="<?php echo site_url(); ?>/wp-admin/profile.php"><?php _e( 'Profile', 'comicpress' ); ?></a></li>
			</ul>
		<?php } ?>
		<?php
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
		$title = empty($instance['title']) ? __( 'Control Panel', 'comicpress' ) : apply_filters('widget_title', $instance['title']); 
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
		$this->comicpress_show_control_panel();
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

// register Control Panel widget
function comicpress_control_panel_widget_init() {
	register_widget('comicpress_control_panel_widget');
}

add_action( 'widgets_init', 'comicpress_control_panel_widget_init');