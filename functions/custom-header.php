<?php

$custom_header_args = array();

add_theme_support( 'custom-header', array(
			'flex-height' => true,
			'flex-width' => true,
			// Header image default
			'default-image'			=> false,
			// Header text display default
			'header-text'			=> false,
			// Header text color default
			'default-text-color'		=> '000',
			// Default Header image width (in pixels)
			'width'				=> easel_themeinfo('custom_image_header_width'),
			// Default Header image height (in pixels)
			'height'			=> easel_themeinfo('custom_image_header_height'),
			// Header image random rotation default
			'random-default'		=> false,
			// Template header style callback
			'wp-head-callback'		=> 'easel_header_style',
			// Admin header style callback
			'admin-head-callback'		=> 'easel_admin_header_style',
			// Admin preview style callback
			'admin-preview-callback'	=> 'easel_admin_header_style'
			) );

function easel_admin_header_style() { ?>
<style type="text/css">
	#headimg { width: <?php echo get_custom_header()->width; ?>px; height: <?php echo get_custom_header()->height; ?>px; background: url(<?php header_image(); ?>) top center no-repeat; }
	#headimg h1, #headimg .description { display: none; }
</style>
	<?php
}

function easel_header_style() { 
	if (get_header_image()) { ?>
<style type="text/css">
	#header { width: <?php echo get_custom_header()->width; ?>px; height: <?php echo get_custom_header()->height; ?>px; background: url('<?php header_image(); ?>') top center no-repeat; overflow: hidden; }
	#header h1 { padding: 0; }
	#header h1 a { display: block; width: <?php echo get_custom_header()->width; ?>px; height: <?php echo get_custom_header()->height; ?>px; text-indent: -9999px; }
	#header .description { display: none; }
</style>
	<?php }
}
