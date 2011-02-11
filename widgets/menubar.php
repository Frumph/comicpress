<?php
/*
Widget Name: Menubar Widget (wordpress 3.0 required)
Widget URI: http://comicpress.net/
Description: Display a calendar of this months posts.
Author: Philip M. Hofer (Frumph)
Version: 1.07
Author URI: http://frumph.net/

*/

function comicpress_menubar() {
	if (file_exists(get_stylesheet_directory() . '/custom-menubar.php')) {
		include(get_stylesheet_directory() . '/custom-menubar.php');
	} else { ?>
		<div id="menubar-wrapper">
			<?php do_action('comicpress-menubar-before'); ?>
			<div class="menunav">
				<?php if (comicpress_themeinfo('enable_search_in_menubar')) { ?>
				<div class="menunav-search">
					<?php get_search_form(); ?>
				</div>
				<?php } ?>
				<?php do_action('comicpress-menubar-menunav'); ?>
				<?php if (comicpress_themeinfo('enable_rss_in_menubar')) { ?>
					<a href="<?php bloginfo('rss2_url') ?>" title="RSS Feed" class="menunav-rss">RSS</a>
				<?php } ?>
			<?php if (comicpress_themeinfo('enable_navigation_in_menubar')) { ?>
			<?php if (is_home() && !comicpress_themeinfo('disable_comic_frontpage')) {
				$comicMenubar = new WP_Query(); 
				$order = 'DESC';
				if (comicpress_themeinfo('display_first_comic_on_home')) $order = 'ASC';
				$comicMenubar->query('showposts=1&order='.$order.'&cat='.comicpress_all_comic_categories_string());
				while ($comicMenubar->have_posts()) : $comicMenubar->the_post();
					global $wp_query; 
					$temp_query = $wp_query->is_single;
					$wp_query->is_single = true; ?>
					<div class="menunav-prev">
					<?php comicpress_previous_comic_link('%link', '&lsaquo;'); ?>
					</div>
					<?php 
					$wp_query->is_single = $temp_query;
					$temp_query = null;
				endwhile;
			} elseif (is_single() && comicpress_in_comic_category()) { ?>
				<div class="menunav-prev">
				<?php comicpress_previous_comic_link('%link', '&lsaquo;'); ?>
				</div>
				<div class="menunav-next">
				<?php comicpress_next_comic_link('%link', '&rsaquo;'); ?>
				</div>
			<?php } ?>
		<?php } ?>
			</div>
			<?php wp_nav_menu( array( 'sort_column' => 'menu_order', 'container_class' => 'menu', 'theme_location' => 'menubar' ) ); ?>
			<?php do_action('comicpress-menubar-after'); ?>
			<div class="clear"></div>
		</div>
	<?php } 
}

class comicpress_menubar_widget extends WP_Widget {
	
	function comicpress_menubar_widget($skip_widget_init = false) {
		if (!$skip_widget_init) {
			$widget_ops = array('classname' => __CLASS__, 'description' => __('Displays a menubar.','comicpress') );
			$this->WP_Widget(__CLASS__, __('Menubar','comicpress'), $widget_ops);
		}
	}
	
	function widget($args, $instance) {
		global $post;
		Protect();
		extract($args, EXTR_SKIP); 
		
		echo $before_widget;
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']); 
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
		comicpress_menubar();
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

register_widget('comicpress_menubar_widget');


?>