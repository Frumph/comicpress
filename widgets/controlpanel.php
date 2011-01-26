<?php
/*
Widget Name: Control Panel
Widget URI: http://comicpress.net/
Description: Display an area for login and logout, forgot password and register.
Author: Philip M. Hofer (Frumph)
Author URI: http://frumph.net/
Version: 1.03
*/
class comicpress_control_panel_widget extends WP_Widget {

	function comicpress_control_panel_widget($skip_widget_init = false) {
		if (!$skip_widget_init) {
			$widget_ops = array('classname' => __CLASS__, 'description' => __('Login/Logoff menu with register/lost password links if not logged on. (use only if registrations are enabled.','comicpress') );
			$this->WP_Widget(__CLASS__, __('Control Panel','comicpress'), $widget_ops);
		}
	}
	
	function comicpress_show_control_panel() { 
		global $user_login;
		if (!is_user_logged_in()) {
			$args = array(
					'label_username' => __('Username', 'comicpress'),
					'label_password' => __('Password', 'comicpress')
					);
				wp_login_form($args); 
			?>
			<ul>
			<?php if (is_multisite()) { ?>
				<li><a href="<?php echo home_url(); ?>/wp-signup.php"><?php _e('Register','comicpress'); ?></a></li>
			<?php } else { ?>
				<li><a href="<?php echo home_url(); ?>/wp-register.php"><?php _e('Register','comicpress'); ?></a></li>
			<?php } ?>
			<li><a href="<?php echo home_url(); ?>/wp-login.php?action=lostpassword"><?php _e('Recover password','comicpress'); ?></a></li>
			</ul>
		<?php } else { ?>
			<ul>
			<?php $redirect = '&amp;redirect_to='.urlencode(wp_make_link_relative(site_url()));
			$uri = wp_nonce_url( site_url("wp-login.php?action=logout$redirect", 'login'), 'log-out' ); ?>
			<li><a href="<?php echo $uri; ?>"><?php _e('Logout','comicpress'); ?></a></li>
			<?php wp_register(); ?>
			<li><a href="<?php echo home_url(); ?>/wp-admin/profile.php"><?php _e('Profile','comicpress'); ?></a></li>
			</ul>
		<?php } ?>
		<?php
	} 	
		

	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		Protect();
		echo $before_widget;
		$title = empty($instance['title']) ? __('Control Panel','comicpress') : apply_filters('widget_title', $instance['title']); 
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
		$this->comicpress_show_control_panel();
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
register_widget('comicpress_control_panel_widget');

?>