<?php
/*
Widget Name: comicpress archive dropdown
Widget URI: http://comicpress.net/
Description: 
Author: Philip M. Hofer (Frumph)
Author URI: http://frumph.net/
Version: 1.06

Changelog:
1.06 - Removed the global $post, $wp_query and the saving of the post, not needed.
*/

class comicpress_archive_dropdown_widget extends WP_Widget {
	
	function comicpress_archive_dropdown_widget() {
		$widget_ops = array('classname' => 'comicpress_archive_dropdown_widget', 'description' => __('Display a dropdown list of your archives, styled.','comicpress') );
		$this->WP_Widget('archive_dropdown', __('Comic Archive Dropdown','comicpress'), $widget_ops);
	}
	
	function widget($args, $instance) {
		global $wp_query, $post;
		Protect();
		extract($args, EXTR_SKIP); 
		echo $before_widget;
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']); 
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
		?>
		<div class="archive-dropdown-wrap">
		<select name="archive-dropdown" class="archive-dropdown" onchange='document.location.href=this.options[this.selectedIndex].value;'> 
		<option value=""><?php echo esc_attr(__('Archives...','comicpress')); ?></option> 
		<?php
		switch ($instance['mode']) {
			case "monthly":
				wp_get_archives('type=monthly&format=option&show_post_count=-1');
				break;
			case "yearly":
				wp_get_archives('type=yearly&format=option&show_post_count=-1');
				break;
			case "allposts":
				wp_get_archives('type=postbypost&format=option&show_post_count=-1');
				break;
			case "blogposts":
				$comicArchive = new WP_Query(); $comicArchive->query('showposts=-1&cat=-'.comicpress_exclude_comic_categories());
				while ($comicArchive->have_posts()) : $comicArchive->the_post() ?>
					<option value="<?php echo get_permalink($post->ID) ?>"><?php the_title(); ?></option>
					<?php endwhile;
				break;				
			case "comicposts":
				$comicArchive = new WP_Query(); $comicArchive->query('showposts=-1&cat='.comicpress_all_comic_categories_string());
				while ($comicArchive->have_posts()) : $comicArchive->the_post() ?>
					<option value="<?php echo get_permalink($post->ID) ?>"><?php the_title(); ?></option>
				<?php endwhile;
				break;
			case "currentcat":
				$currentcat = get_the_category($post->ID);
				$currentcat = $currentcat[0]->cat_ID;
				$comicArchive = new WP_Query(); $comicArchive->query('showposts=-1&cat='.$currentcat);
				while ($comicArchive->have_posts()) : $comicArchive->the_post() ?>
					<option value="<?php echo get_permalink($post->ID) ?>"><?php the_title(); ?></option>
				<?php endwhile;
				break;
			case "allcats":
				$args=array('hide_empty' => 1, 'orderby' => 'group');
				$categories=  get_categories($args); 
				foreach ($categories as $cat) {
					if ($cat->category_count > 0) {
						$option = '<option value="'.get_category_link($cat->term_id).'">';
						$option .= $cat->cat_name;
						$option .= ' ('.$cat->category_count.')';
						$option .= '</option>';
						echo $option;
					}
				}
				break;
			case "blogcats":
				$args=array('hide_empty' => 1, 'orderby' => 'group', 'order' => 'ASC', 'exclude' => comicpress_all_comic_categories_string());
				$categories=  get_categories($args); 
				foreach ($categories as $cat) {
					if ($cat->category_count > 0) {
						$option = '<option value="'.get_category_link($cat->term_id).'">';
						$option .= $cat->cat_name;
						$option .= ' ('.$cat->category_count.')';
						$option .= '</option>';
						echo $option;
					}
				}
				break;
			case "storylines":
				if (($result = comicpress_themeinfo('storyline-category-order')) !== false) {
					$comicpress_storyline_dropdown_archive = wp_cache_get( 'comicpress', 'archivedropdown' );
					if (empty($comicpress_storyline_dropdown_archive)) {
						$categories_by_id = comicpress_get_comic_category_objects_by_id();
						$current_depth = 0;
						$comicpress_storyline_dropdown_archive = '';
						foreach (explode(",", $result) as $node) {
							$parts = explode("/", $node);
							$target_depth = count($parts) - 1;
							$category_id = end($parts);
							$category = $categories_by_id[$category_id];
							$description = $category->description;
							$first_comic_in_category = comicpress_get_terminal_post_in_category($category_id);
							$first_comic_permalink = get_permalink($first_comic_in_category->ID);
							$padding = str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", $target_depth-1);
							
							$option = '<option value="'.get_category_link($category_id).'">';
							$option .= $padding.$category->name;
							if ($category->count > 0) $option .= ' ('.$category->count.')';
							$option .= '</option>'."\r\n";
							$comicpress_storyline_dropdown_archive .= $option;		
							
							$current_depth = $target_depth;
						}
						wp_cache_set( 'comicpress', $comicpress_storyline_dropdown_archive, 'archivedropdown', 7200 );
					}
					echo $comicpress_storyline_dropdown_archive;
				}
				break;
			case "comiccats":
			default:
				$args=array('hierarchical ' => 1, 'orderby' => 'group', 'include' => comicpress_all_comic_categories_string());
				$categories=  get_categories($args); 
				foreach ($categories as $cat) {
					if ($cat->category_count > 0) {
						$option = '<option value="'.get_category_link($cat->term_id).'">';
						$option .= $cat->cat_name;
						$option .= ' ('.$cat->category_count.')';
						$option .= '</option>';
						echo $option;
					}
				}
				break;
		}
		?>
		</select>
		</div>
		<?php
		echo $after_widget;
		UnProtect();
	}
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['mode'] = strip_tags($new_instance['mode']);
		$instance['count'] = strip_tags($new_instance['count']);
		return $instance;
	}
	
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'mode' => 'monthly', 'count' => '-1' ) );
		$title = strip_tags($instance['title']);
		$mode = strip_tags($instance['mode']);
		$count = strip_tags($instance['count']);
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','comicpress'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
		<hr>
		<p>
		<label for="<?php echo $this->get_field_id('mode'); ?>-monthly"><input id="<?php echo $this->get_field_id('mode'); ?>-monthly" name="<?php echo $this->get_field_name('mode'); ?>" type="radio" value="monthly" <?php checked('monthly', $mode); ?> /><?php _e('Monthly','comicpress'); ?></label><br />
		<label for="<?php echo $this->get_field_id('mode'); ?>-yearly"><input id="<?php echo $this->get_field_id('mode'); ?>-yearly" name="<?php echo $this->get_field_name('mode'); ?>" type="radio" value="yearly" <?php checked('yearly', $mode); ?> /><?php _e('Yearly','comicpress'); ?></label><br />
		<hr>
		<label for="<?php echo $this->get_field_id('mode'); ?>-allposts"><input id="<?php echo $this->get_field_id('mode'); ?>-allposts" name="<?php echo $this->get_field_name('mode'); ?>" type="radio" value="allposts" <?php checked('allposts', $mode); ?> /><?php _e('All Posts','comicpress'); ?></label><br />
		<label for="<?php echo $this->get_field_id('mode'); ?>-blogposts"><input id="<?php echo $this->get_field_id('mode'); ?>-blogposts" name="<?php echo $this->get_field_name('mode'); ?>" type="radio" value="blogposts" <?php checked('blogposts', $mode); ?> /><?php _e('Blog Posts','comicpress'); ?></label><br />
		<label for="<?php echo $this->get_field_id('mode'); ?>-comicposts"><input id="<?php echo $this->get_field_id('mode'); ?>-comicposts" name="<?php echo $this->get_field_name('mode'); ?>" type="radio" value="comicposts" <?php checked('comicposts', $mode); ?> /><?php _e('Comic Posts','comicpress'); ?></label><br />
		<label for="<?php echo $this->get_field_id('mode'); ?>-currentcat"><input id="<?php echo $this->get_field_id('mode'); ?>-currentcat" name="<?php echo $this->get_field_name('mode'); ?>" type="radio" value="currentcat" <?php checked('currentcat', $mode); ?> /><?php _e('Current Category','currentcat'); ?></label><br />
		<hr>
		<label for="<?php echo $this->get_field_id('mode'); ?>-allcats"><input id="<?php echo $this->get_field_id('mode'); ?>-allcats" name="<?php echo $this->get_field_name('mode'); ?>" type="radio" value="allcats" <?php checked('allcats', $mode); ?> /><?php _e('All Categories','comicpress'); ?></label><br />
		<label for="<?php echo $this->get_field_id('mode'); ?>-blogcats"><input id="<?php echo $this->get_field_id('mode'); ?>-blogcats" name="<?php echo $this->get_field_name('mode'); ?>" type="radio" value="blogcats" <?php checked('blogcats', $mode); ?> /><?php _e('Blog Categories','comicpress'); ?></label><br />
		<label for="<?php echo $this->get_field_id('mode'); ?>-comiccats"><input id="<?php echo $this->get_field_id('mode'); ?>-comiccats" name="<?php echo $this->get_field_name('mode'); ?>" type="radio" value="comiccats" <?php checked('comiccats', $mode); ?> /><?php _e('Comic Categories','comicpress'); ?></label><br />
		<label for="<?php echo $this->get_field_id('mode'); ?>-storylines"><input id="<?php echo $this->get_field_id('mode'); ?>-storylines" name="<?php echo $this->get_field_name('mode'); ?>" type="radio" value="storylines" <?php checked('storylines', $mode); ?> /><?php _e('Storyline Order','comicpress'); ?></label><br />
		</p>
		<hr>
		<?php
	}
}
register_widget('comicpress_archive_dropdown_widget');

?>