<?php
/*
Widget Name: Transcript Widget
Widget URI: http://comicpress.net/
Description: Show the stylized transcription in a widget area.
Author: Philip M. Hofer (Frumph)
Author URI: http://frumph.net/
Version: 1.03
*/

/**
* Display the comic transcript
* Transcript must be entered into a custom field named "transcript"
* @param string $displaymode, "raw" (straight from the field), "br" (includes html line breaks), "styled" (fully css styled with JavaScript expander)
*/
function comicpress_the_transcript($displaymode = 'raw') {
	global $post;
	$transcript = get_post_meta( get_the_ID(), "transcript", true );
	switch ($displaymode) {
		case "raw":
			echo $transcript;
			break;
		case "br":
			echo nl2br($transcript);
			break;
		case "styled":
			if (!empty($transcript)) { ?>
				<script type='text/javascript'>
				<!--
				function toggle_expander(id) {
					var e = document.getElementById(id);
					if(e.style.height == 'auto')
						e.style.height = '1px';
					else
						e.style.height = 'auto';
				}
				//-->
				</script>
				<div class="transcript-border"><div id="transcript"><a href="javascript:toggle_expander('transcript-content');" class="transcript-title">&darr; Transcript</a><div id="transcript-content"><?php echo nl2br($transcript); ?><br /><br /></div></div></div>
				<script type='text/javascript'>
				<!--
					document.getElementById('transcript-content').style.height = '1px';
				//-->
				</script>
		<?php }
			break;
	}
}

class comicpress_transcript_widget extends WP_Widget {
	
	function comicpress_transcript_widget($skip_widget_init = false) {
		if (!$skip_widget_init) {
			$widget_ops = array('classname' => __CLASS__, 'description' => __('Display the transcription of the current post if there is one. (used in comic sidebars)','comicpress') );
			$this->WP_Widget(__CLASS__, __('Transcript','comicpress'), $widget_ops);
		}
	}
	
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		
		echo $before_widget;
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$transtype = empty($instance['transtype']) ? 'empty' : apply_filters('widget_transtype', $instance['transtype']); 
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
		comicpress_the_transcript($transtype);	
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['transtype'] = strip_tags($new_instance['transtype']);
		return $instance;
	}
	
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'transtype' => '' ) );
		$title = strip_tags($instance['title']);
		$transtype = strip_tags($instance['transtype']);
		if (empty($transtype)) $transtype = 'styled';
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','comicpress'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
		<p>
		<label><input name="<?php echo $this->get_field_name('transtype'); ?>" id="<?php echo $this->get_field_id('transtype'); ?>-styled" type="radio" value="styled"<?php if ( $transtype == "styled") { echo " checked"; } ?> /><?php _e('Styled','comicpress'); ?></label><br />
		<label><input name="<?php echo $this->get_field_name('transtype'); ?>" id="<?php echo $this->get_field_id('transtype'); ?>-br" type="radio" value="br"<?php if ( $transtype == "br") { echo " checked"; } ?> /><?php _e('Add BR','comicpress'); ?></label><br />
		<label><input name="<?php echo $this->get_field_name('transtype'); ?>" id="<?php echo $this->get_field_id('transtype'); ?>-raw" type="radio" value="raw"<?php if ( $transtype == "raw") { echo " checked"; } ?> /><?php _e('Raw Output','comicpress'); ?></label>
		</p>		
		<?php
	}
}
register_widget('comicpress_transcript_widget');

?>