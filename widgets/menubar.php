<?php
/*
Widget Name: Menubar Widget (wordpress 3.0 required)
Widget URI: http://frumph.net/
Description: Display a calendar of this months posts.
Author: Philip M. Hofer (Frumph)
Version: 1.08
Author URI: http://frumph.net/

*/

function easel_menubar() {
	if (file_exists(easel_themeinfo('stylepath') . '/custom-menubar.php')) {
		include(easel_themeinfo('stylepath') . '/custom-menubar.php');
	} else { ?>
		<div id="menubar-wrapper">
			<div class="menu-container">
				<?php do_action('easel-menubar-before'); ?>
				<?php
					// dont mess with the pre_get_posts for the wp_nav_menu()
					wp_nav_menu( array( 'sort_column' => 'menu_order', 'container_class' => 'menu', 'theme_location' => 'Primary' ) );
					do_action('easel-menubar-after');
					do_action('comic-mini-navigation');
				?>
				<div class="menunav">
					<?php if (easel_themeinfo('enable_search_in_menubar')) { ?>
					<div class="menunav-search">
						<?php get_search_form(); ?>
					</div>
					<?php } ?>
					<?php do_action('easel-menubar-menunav'); ?>
					<?php if (easel_themeinfo('enable_rss_in_menubar') && !easel_themeinfo('menubar_social_icons')) { ?>
						<a href="<?php bloginfo('rss2_url') ?>" title="RSS Feed" class="menunav-rss">RSS</a>
					<?php } ?>
					<?php do_action('easel-menubar-mini-navigation'); ?>
				</div>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
		</div>
	<?php } 
}

class easel_menubar_widget extends WP_Widget {
	
	function easel_menubar_widget($skip_widget_init = false) {
		if (!$skip_widget_init) {
			$widget_ops = array('classname' => __CLASS__, 'description' => __('Displays a menubar.','easel') );
			$this->WP_Widget(__CLASS__, __('Easel Menubar','easel'), $widget_ops);
		}
	}
	
	function widget($args, $instance) {
		global $post;
		extract($args, EXTR_SKIP); 
		
		echo $before_widget;
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']); 
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
		easel_menubar();
		echo $after_widget;
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
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','easel'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
		<?php
	}
}

register_widget('easel_menubar_widget');


?>