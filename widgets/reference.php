<?php
/*
Widget Name: References
Widget URI: http://comicpress.net/
Description: If .png image found in images/ref/ 
Author: Philip M. Hofer (Frumph)
Version: 1.00

Installation Instructions:

This widget goes into your child-theme's wp-content/themes/comicpress-<childthemename>/widgets/  directory, 
copy this reference.php into there.

This is the CSS I use, copy it into your style.css of your child-theme.

.refimage {
	height: 64px;
	width: 64px;
	display: inline-block;
	float: left;
	margin-right: 3px;
}

.reftext {
	font-size: 11px;
}

.refname {
	text-transform: capitalize;
	font-weight: 700;
	font-size: 14px;
}

When you add tags to your post, go to the wp-admin -> post -> post tags area, edit the tag and add a description, 
thats what is used to find the reference, if it's empty it wont be used as a reference

In your child themes images directory, create a directory called "ref" and add an image for the reference into it, its
based on the slug of your tag you created.   So the tag "Rascal" with slug "rascal" will use rascal as the image name, 
and I decided to use .png, so it would be rascal.png which is used to find the image.

*/
class comicpress_reference_widget extends WP_Widget {
	
	function comicpress_reference_widget($skip_widget_init = false) {
		if (!$skip_widget_init) {
			$widget_ops = array('classname' => __CLASS__, 'description' => __('Display a reference on tags (if image found in dir. based on tag name)','comicpress') );
			$this->WP_Widget(__CLASS__, __('Reference','comicpress'), $widget_ops);
		}
	}
/*	
function ceo_display_comic_locations() {
	global $post;
	if ($post->post_type == 'comic') {
		$before = '<div class="comic-locations">Location: ';
		$sep = ', '; 
		$after = '</div>';
		$output = get_the_term_list( $post->ID, 'locations', $before, $sep, $after );
		echo apply_filters('ceo_display_comic_locations', $output);
	}
}
*/
	
	function widget($args, $instance) {
		global $post, $wp_query;
		Protect();
		extract($args, EXTR_SKIP); 
		echo $before_widget;
		$title = empty($instance['title']) ? __('Reference','comicpress') : apply_filters('widget_title', $instance['title']); 
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; }; 
		$tags_list = get_the_terms($post->ID, 'post_tag');
		if (!empty($tags_list)) {
			foreach ($tags_list as $tagname) {
				if (!empty($tagname->description)) { ?>
						<div class="refwrap">
					<?php if (file_exists(get_stylesheet_directory().'/images/ref/'.$tagname->slug.'.png')) { 
							$image_file = trailingslashit(get_stylesheet_directory_uri()).'images/ref/'.$tagname->slug.'.png'; ?>
							<div class="refimage refimage-<?php echo $tagname->slug; ?>">
								<img src="<?php echo $image_file; ?>" alt="<?php echo $tagname->slug; ?>" />
							</div>
						<?php } ?>
							<div class="reftext reftext-<?php echo $tagname->slug; ?>">
								<div class="refname refname-<?php echo $tagname-slug; ?>"><?php echo $tagname->name; ?></div>
								<?php if (!empty($tagname->description)) echo $tagname->description; ?>
								<div class="clear"></div>
							</div>
							<div class="clear"></div>
						</div>
				<?php }
			}
			if (!empty($instance['info'])) { ?>
				<div class="refinfo"><?php echo $instance['info']; ?></div>
			<?php }
		}
		echo $after_widget;
		UnProtect();
	}
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['info'] = strip_tags($new_instance['info']);
		return $instance;
	}
	
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'info' => '' ) );
		$title = strip_tags($instance['title']);
		$info = strip_tags($instance['info']);
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','comicpress'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('info'); ?>"><?php _e('Bottom Information:','comicpress'); ?><br /><input class="widefat" id="<?php echo $this->get_field_id('info'); ?>" name="<?php echo $this->get_field_name('info'); ?>" type="text" value="<?php echo esc_attr($info); ?>" /></label></p>
		<?php
	}
}

register_widget('comicpress_reference_widget');

?>