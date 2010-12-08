<?php
/*
Widget Name: ComicPress Social
Widget URI: http://comicpress.net/
Description: Translates a user's URL line into a social widget, associating it to images.
Author: Philip M. Hofer (Frumph)
Author URI: http://frumph.net/
Version: 1.03
*/
class comicpress_social_widget extends WP_Widget {
	
	function comicpress_social_widget($skip_widget_init = false) {
		if (!$skip_widget_init) {
			$widget_ops = array('classname' => __CLASS__, 'description' => __('Display a user defined social button, with translated URL.','comicpress') );
			$this->WP_Widget(__CLASS__, __('Social Button','comicpress'), $widget_ops);
		}
	}
	
	function widget($args, $instance) {
		global $post;
		extract($args, EXTR_SKIP); 
		
		/* Get the info necessary */		
		$permalink = get_permalink($post->ID);
		$posttitle = $post->post_title;
		$posttitle = str_replace(' ', '%20', $posttitle);
		$title = $instance['title'];
		if (empty($title)) $title = $posttitle;

		$rss = get_bloginfo('rss2_url');
		$blogname = urlencode(get_bloginfo('name')." ".get_bloginfo('description'));
		// Grab the excerpt, if there is no excerpt, create one
		$excerpt = urlencode(strip_tags(strip_shortcodes($post->post_excerpt)));
		if ($excerpt == "") {
			$excerpt = urlencode(substr(strip_tags(strip_shortcodes($post->post_content)),0,250));
		}
		// Clean the excerpt for use with links
		$excerpt	= str_replace('+','%20',$excerpt);
		
		echo $before_widget; 
		$url = $instance['urlstr'];
		$url = str_replace('[URL]', $permalink, $url);
		$url = str_replace('[TITLE]', $posttitle, $url);
		$url = str_replace('[RSS]', $rss, $url);
		$url = str_replace('[BLOGNAME]', $blogname, $url);
		$url = str_replace('[EXCERPT]', $excerpt, $url); ?>
		
		<div class="social-<?php echo sanitize_title($title); ?>">
		<?php if (!empty($instance['image'])) { ?>
			<a href="<?php echo $url; ?>" target="_blank" class="social-<?php echo sanitize_title($title); ?>"><img src="<?php echo $instance['image']; ?>" alt="<?php echo $title; ?>" /></a>
		<?php } else { ?>
			<a href="<?php echo $url; ?>" target="_blank" class="social-<?php echo sanitize_title($title); ?>"><?php echo $title; ?></a>		
		<?php } ?>
		</div>
		<?php echo $after_widget;
	}
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['urlstr'] = strip_tags($new_instance['urlstr']);
		$instance['image'] = strip_tags($new_instance['image']);
		return $instance;
	}
	
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => 'Share This!', 'urlstr' => '', 'image' => '') );
		$title = strip_tags($instance['title']);
		if (empty($title)) $title = 'Share This!';
		$urlstr = strip_tags($instance['urlstr']);
		$image = strip_tags($instance['image']);
		?>
		<small>
		<strong>Translated Strings:</strong> [URL] [TITLE] [RSS] [BLOGNAME] [EXCERPT]<br />
		<strong>Examples:</strong><br />
		http://twitter.com/home?status=[TITLE]%20-%20[URL]<br />
		http://www.stumbleupon.com/submit?url=[URL]&amp;title=[TITLE]<br />
		</small>
		<br />
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title (used as CSS marker too):','comicpress'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('urlstr'); ?>"><?php _e('URL','comicpress'); ?> <input class="widefat" id="<?php echo $this->get_field_id('urlstr'); ?>" name="<?php echo $this->get_field_name('urlstr'); ?>" type="text" value="<?php echo esc_attr($urlstr); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('image'); ?>"><?php _e('Image','comicpress'); ?> <input class="widefat" id="<?php echo $this->get_field_id('image'); ?>" name="<?php echo $this->get_field_name('image'); ?>" type="text" value="<?php echo esc_attr($image); ?>" /></label></p>
		<?php
	}
}
register_widget('comicpress_social_widget');

?>