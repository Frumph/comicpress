<?php
/*
Widget Name: Tip Jar Widget
Widget URI: http://comicpress.net/
Description: Display a Tip Jar that has gauge to goal.
Author: Philip M. Hofer (Frumph)
Author URI: http://frumph.net/
Version: 1.0
*/	
	
class comicpress_tipjar_widget extends WP_Widget {

	function comicpress_tipjar_widget($skip_widget_init = false) {
		if (!$skip_widget_init) {
			$widget_ops = array('classname' => __CLASS__, 'description' => __('Displays a Tip Jar box and shows how much has been donated with goal.','comicpress') );
			$this->WP_Widget(__CLASS__, __('Tip Jar','comicpress'), $widget_ops);
		}
	}
	
	function widget($args, $instance) {
		global $post;
		extract($args, EXTR_SKIP); 
		
		echo $before_widget;
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']); 
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
		$total = $instance['total'];
		$current = $instance['current'];
		$height = $instance['height'];
		if (empty($height)) $height = '200';
		if (empty($total)) $total = '100';
		if (empty($current)) $current = '0';
		$gauge = get_template_directory_uri().'/images/gauge.png';		
		$tipjarimage = get_template_directory_uri().'/images/tip-jar.png';
		if (is_child_theme()) {
			if (file_exists(get_stylesheet_directory().'/images/tip-jar.png')) {
				$tipjarimage = get_stylesheet_directory_uri().'/images/tip-jar.png';
			}
			if (file_exists(get_stylesheet_directory().'/images/gauge.png')) {
				$gauge = get_stylesheet_directory_uri().'/images/gauge.png';
			}
		}
		$percent = $height-(2*(number_format(($current * 100) / $total)));
		// $percent = 100-$percent;
		?>
		<div class="tipjarbox-wrap">
			<div class="tipjarunderbox" style="background: url('<?php echo $gauge; ?>') no-repeat; background-position: 0 <?php echo $percent; ?>px;">
				<div class="tipjarbox" style="background: url('<?php echo $tipjarimage; ?>') top center no-repeat;"></div>
			</div>
		</div>
		<div class="clear"></div>
		<?php
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['total'] = strip_tags($new_instance['total']);
		$instance['current'] = strip_tags($new_instance['current']);
		$instance['url'] = esc_attr($new_instance['url']);
		$instance['height'] = strip_tags($new_instance['height']);
		return $instance;
	}
	
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'total' => '100', 'current' => '0', 'url' => 'http://yourdomain.com/pathtodonationpage', 'height' => '200') );
		$title = strip_tags($instance['title']);
		$total = strip_tags($instance['total']);
		$current = strip_tags($instance['current']);
		$url = esc_attr($instance['url']);
		$height = strip_tags($instance['height']);
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','comicpress'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
		<?php _e('Just input an integer number like 200 or 300, not a dollar amount.','comicpress'); ?><br />
		<p><label for="<?php echo $this->get_field_id('total'); ?>"><?php _e('Total $ Looking For::','comicpress'); ?> <input class="widefat" id="<?php echo $this->get_field_id('total'); ?>" name="<?php echo $this->get_field_name('total'); ?>" type="text" value="<?php echo esc_attr($total); ?>" /></label></p>
		<?php _e('Make sure the number in the current is LESS then the number of the total.','comicpress'); ?><br />
		<p><label for="<?php echo $this->get_field_id('current'); ?>"><?php _e('Current $ Received:','comicpress'); ?> <input class="widefat" id="<?php echo $this->get_field_id('current'); ?>" name="<?php echo $this->get_field_name('current'); ?>" type="text" value="<?php echo esc_attr($current); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('url'); ?>"><?php _e('URL To Donation Page:','comicpress'); ?> <input class="widefat" id="<?php echo $this->get_field_id('url'); ?>" name="<?php echo $this->get_field_name('url'); ?>" type="text" value="<?php echo esc_attr($url); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('height'); ?>"><?php _e('Height of the image area to use in the math for percent total (if you did not make custom graphics, this should not change).','comicpress'); ?> <input class="widefat" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo esc_attr($height); ?>" /></label></p>		
		<?php
	}
}
register_widget('comicpress_tipjar_widget');

?>