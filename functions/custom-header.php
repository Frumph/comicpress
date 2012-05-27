<?php

$custom_header_args = array();

add_theme_support( 'custom-header', array(
			// Header image default
			'default-image'			=> false,
			// Header text display default
			'header-text'			=> false,
			// Header text color default
			'default-text-color'		=> '000',
			// Header image width (in pixels)
			'width'				=> comicpress_themeinfo('custom_image_header_width'),
			// Header image height (in pixels)
			'height'			=> comicpress_themeinfo('custom_image_header_height'),
			// Header image random rotation default
			'random-default'		=> false,
			// Template header style callback
			'wp-head-callback'		=> 'comicpress_header_style',
			// Admin header style callback
			'admin-head-callback'		=> 'comicpress_admin_header_style',
			// Admin preview style callback
			'admin-preview-callback'	=> 'comicpress_admin_header_style'
			) );

function comicpress_admin_header_style() { ?>
<style type="text/css">
#headimg {
	width: <?php echo get_custom_header()->width; ?>px;
	height: <?php echo get_custom_header()->height; ?>px;
	background: url(<?php header_image(); ?>) no-repeat center;	
}

#headimg h1, #headimg .description {
	display: none;
}
</style>
	<?php
}

function comicpress_header_style() { 
	if (get_header_image()) { ?>
<style type="text/css">
	#header {
		width: <?php echo HEADER_IMAGE_WIDTH; ?>px; 
		/* height: <?php echo HEADER_IMAGE_HEIGHT; ?>px; */
		background: url(<?php header_image(); ?>) top center no-repeat;
		overflow: hidden;
	}
	#header h1 { padding: 0; }
	#header h1 a { 
		display: block;
		width: <?php echo HEADER_IMAGE_WIDTH; ?>px;
		height: <?php echo HEADER_IMAGE_HEIGHT-1; ?>px;
		text-indent: -9999px;
	}
	#header .description { display: none; }
</style>
	<?php }
}

?>