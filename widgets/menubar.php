<?php
/*
Widget Name: Menubar Widget (wordpress 3.0 required)
Widget URI: http://frumph.net/
Description: Display a calendar of this months posts.
Author: Philip M. Hofer (Frumph)
Version: 1.09
Author URI: http://frumph.net/

*/

function comicpress_menubar() {
	if (file_exists(comicpress_themeinfo('stylepath') . '/custom-menubar.php')) {
		get_template_part('custom-menubar');
	} else { ?>
		<div id="menubar-wrapper">
			<div class="menu-container">
				<?php do_action('comicpress-menubar-before'); ?>
				<?php
					// dont mess with the pre_get_posts for the wp_nav_menu()
					wp_nav_menu( array( 'sort_column' => 'menu_order', 'container_class' => 'menu', 'theme_location' => 'Primary' ) );
					do_action('comicpress-menubar-after');
					do_action('comic-mini-navigation');
				?>
				<div class="menunav">
					<?php if (comicpress_themeinfo('enable_search_in_menubar')) { ?>
					<div class="menunav-search">
						<?php get_search_form(); ?>
					</div>
					<?php } ?>
					<?php do_action('comicpress-menubar-menunav'); ?>
					<?php if (comicpress_themeinfo('enable_rss_in_menubar') && !comicpress_themeinfo('menubar_social_icons')) { ?>
						<a href="<?php bloginfo('rss2_url') ?>" title="RSS Feed" class="menunav-rss">RSS</a>
					<?php } ?>
					<?php do_action('comicpress-menubar-mini-navigation'); ?>
				</div>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
		</div>
	<?php } 
}

class comicpress_menubar_widget extends WP_Widget {
	
	function comicpress_menubar_widget($skip_widget_init = false) {
		if (!$skip_widget_init) {
			$widget_ops = array('classname' => __CLASS__, 'description' => __('Displays a menubar.','comicpress') );
			$this->WP_Widget(__CLASS__, __('ComicPress Menubar','comicpress'), $widget_ops);
		}
	}
	
	function widget($args, $instance) {
		global $post;
		extract($args, EXTR_SKIP); 
		
		echo $before_widget;
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']); 
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
		comicpress_menubar();
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
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','comicpress'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
		<?php
	}
}

register_widget('comicpress_menubar_widget');


?>