<?php
/*
Widget Name: Comic Donations Widget
Widget URI: http://comicpress.org/
Description: Display a comments link to put inside the comic area.
Author: Philip M. Hofer (Frumph)
Author URI: http://frumph.net/
Version: 1.0
*/	
	
class comicpress_donations_widget extends WP_Widget {

	function comicpress_donations_widget($skip_widget_init = false) {
		if (!$skip_widget_init) {
			$widget_ops = array('classname' => __CLASS__, 'description' => __('Displays a donations box and shows how much has been donated.','comicpress') );
			$this->WP_Widget(__CLASS__, __('Donations','comicpress'), $widget_ops);
		}
	}
	
	function widget($args, $instance) {
		global $post;
		extract($args, EXTR_SKIP); 
		
		echo $before_widget;
		$title = empty($instance['title']) ? __('Donate!','comicpress') : apply_filters('widget_title', $instance['title']); 
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
		$total = $instance['total'];
		$current = $instance['current'];
		if (empty($total)) $total = '100';
		if (empty($current)) $current = '70';
		$donateboximage = get_template_directory_uri().'/images/donatebox.png';
		if (is_child_theme()) {
			if (file_exists(get_stylesheet_directory().'/images/donatebox.png')) {
				$donateboximage = get_stylesheet_directory_uri().'/images/donatebox.png';
			}
		}
		$percent = 100-number_format(($current * 100) / $total);
		// $percent = 100-$percent;
		?>
		<div class="donatebox-wrap">
			<div class="donateunderbox" style="background-position: 0 <?php echo $percent; ?>px;">
				<div class="donatebox" style="background: url('<?php echo $donateboximage; ?>') top center no-repeat;"></div>
			</div>
		</div>
		<?php if (!empty($instance['message'])) { ?>
			<span class="donate-message"><?php echo $instance['message']; ?></span>
			<?php
		}
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['total'] = strip_tags($new_instance['total']);
		$instance['current'] = strip_tags($new_instance['current']);
		$instance['message'] = strip_tags($new_instance['message']);
		$instance['url'] = esc_attr($new_instance['url']);
		$instance['height'] = strip_tags($new_instance['height']);
		return $instance;
	}
	
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'total' => '0', 'current' => '0', 'message' => 'Donate to the cause!', 'url' => 'http://yourdomain.com/pathtodonationpage', 'height' => '100') );
		$title = strip_tags($instance['title']);
		$total = strip_tags($instance['total']);
		$current = strip_tags($instance['current']);
		$message = strip_tags($instance['message']);
		$url = esc_attr($instance['url']);
		$height = strip_tags($instance['height']);
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','comicpress'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('total'); ?>"><?php _e('Total $ Looking For::','comicpress'); ?> <input class="widefat" id="<?php echo $this->get_field_id('total'); ?>" name="<?php echo $this->get_field_name('total'); ?>" type="text" value="<?php echo esc_attr($total); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('current'); ?>"><?php _e('Current $ Received:','comicpress'); ?> <input class="widefat" id="<?php echo $this->get_field_id('current'); ?>" name="<?php echo $this->get_field_name('current'); ?>" type="text" value="<?php echo esc_attr($current); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('message'); ?>"><?php _e('Reason Message:','comicpress'); ?> <input class="widefat" id="<?php echo $this->get_field_id('message'); ?>" name="<?php echo $this->get_field_name('message'); ?>" type="text" value="<?php echo esc_attr($message); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('url'); ?>"><?php _e('URL To Donation Page:','comicpress'); ?> <input class="widefat" id="<?php echo $this->get_field_id('url'); ?>" name="<?php echo $this->get_field_name('url'); ?>" type="text" value="<?php echo esc_attr($url); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('height'); ?>"><?php _e('Height of the image area to use in the math for percent total:','comicpress'); ?> <input class="widefat" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo esc_attr($height); ?>" /></label></p>		
		<?php
	}
}
register_widget('comicpress_donations_widget');

?>