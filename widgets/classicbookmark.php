<?php
/*
Widget Name: (classic) Bookmark
Description: Adds a bookmark set of icons to save the page your own.
Author: Tyler Martin, Philip M. Hofer (Frumph)
Author URI: http://frumph.net
Version: 1.1
*/

function comicpress_classic_bookmark() {
global $post, $wp_query; ?>
	<div class="classic-bookmark">
		<script type="text/javascript">
			<!--

				/* Bookmark Config Settings */

				var cl = 31;
				var imgTag = '<?php echo get_template_directory_uri(); ?>/images/1.gif';		//add tag comic
				var imgClearOff = '<?php echo get_template_directory_uri(); ?>/images/3a.gif';	//no comic tagged, clear not possible
				var imgGotoOff = '<?php echo get_template_directory_uri(); ?>/images/2a.gif';	//no comic tagged, goto not possible
				var imgClearOn = '<?php echo get_template_directory_uri(); ?>/images/3.gif';	//clear a tag, shows when comic previously tagged
				var imgGotoOn = '<?php echo get_template_directory_uri(); ?>/images/2.gif';		//shows when a comic is tagged  
				var imgInfo = '<?php echo get_template_directory_uri(); ?>/images/4.gif';  		//img that displays the help
				var comicDir = '/'; 		//alter this if you run multiple comics in different directories on your site.

				/* Now write out the applicable links */

				createCookie('t', 1);
				var c = readCookie('t');
				if(c && document.getElementById) {
					var l = readCookie('bm');
					var gt = imgGotoOff;
					var ct = imgClearOff;
					if(l) {
						gt = imgGotoOn;
						ct = imgClearOn;
					}
					document.write('<div id="bmh"><strong><?php _e( 'BOOKMARK', 'comicpress' ); ?><\/strong><br /><?php _e( 'Click "Tag Page" to bookmark a page. When you return to the site, click "Goto Tag" to continue where you left off.', 'comicpress' ); ?><\/div>');
					document.write('<a href="#" onClick="bmhome();return false;"><img src="'+imgTag+'" alt="Tag This Page" border="0"><\/a>');
					document.write('<a href="#" onClick="gto();return false;"><img src="'+gt+'" alt="Goto Tag" border="0" id="gtc"><\/a>');
					document.write('<a href="#" onClick="bmc();return false;"><img src="'+ct+'" alt="Clear Tag" border="0" id="rmc"><\/a>');
					document.write('<a href="#" onMouseOver="document.getElementById(\'bmh\').style.visibility=\'visible\';" onMouseOut="document.getElementById(\'bmh\').style.visibility=\'hidden\';" onClick="return false;"><img src="'+imgInfo+'" alt="Info" border="0" \/><\/a>');
				}

				/* Below are our functions for this little script */

					function bmhome() {
						if(document.getElementById) {
							document.getElementById('gtc').src = imgGotoOn;
							document.getElementById('rmc').src = imgClearOn;
						}
						<?php if (is_home()) { ?>
							createCookie("bm", "<?php echo site_url(); ?>", cl);
						<?php } else { ?>
							createCookie("bm", "<?php the_permalink(); ?>", cl);
						<?php } ?>
					}

				function bm() {
					if(document.getElementById) {
						document.getElementById('gtc').src = imgGotoOn;
						document.getElementById('rmc').src = imgClearOn;
					}
					createCookie("bm", window.location, cl);
				}

				function bmc() {
					if(document.getElementById) {
						document.getElementById('gtc').src = imgGotoOff;
						document.getElementById('rmc').src = imgClearOff;
					}
					createCookie("bm","",-1);
				}
		      
				function gto() {
					var g = readCookie('bm');
					if(g) {
						window.location = g;
					}	
				}

				/* The follow functions have been borrowed from Peter-Paul Koch. Please find them here: http://www.quirksmode.org */

				function createCookie(name,value,days) {
					if (days) {
						var date = new Date();
						date.setTime(date.getTime()+(days*24*60*60*1000));
						var expires = "; expires="+date.toGMTString();
					} else var expires = "";
					document.cookie = name+"="+value+expires+"; path="+comicDir;
				}
				function readCookie(name) {
					var nameEQ = name + "=";
					var ca = document.cookie.split(';');
					for(var i=0;i < ca.length;i++) {
						var c = ca[i];
						while (c.charAt(0)==' ') c = c.substring(1,c.length);
						if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
					}
					return null;
				}
			//-->
		</script>
	</div>
<?php
}	

class widget_comicpress_classic_bookmark extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			__CLASS__, // Base ID
			__( 'ComicPress - Classic Bookmark', 'comicpress' ), // Name
			array( 'description' => __( 'Creates a set of buttons that let the user return to the page they tagged.', 'comicpress' ), ) // Args
		);
	}
	
	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget($args, $instance) {
		global $post, $wp_query;
		extract($args, EXTR_SKIP);
		echo $before_widget;
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']); // Args
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
		comicpress_classic_bookmark();
		echo $after_widget;
	}
	
	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}
	
	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$title = strip_tags($instance['title']);
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', 'comicpress' ); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
		<?php
	}
}

function widget_comicpress_classic_bookmark_init() {
	register_widget('widget_comicpress_classic_bookmark');
}

add_action( 'widgets_init', 'widget_comicpress_classic_bookmark_init');