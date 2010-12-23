<?php 
add_filter('comicpress_header_image_width', 'comicpress_change_header_width');

function comicpress_change_header_width($width) {
	$new_width = comicpress_themeinfo('custom_image_header_width');
	if (!empty($new_width) && ((int)$new_width > 0)) 
		$width = $new_width;
	return $width;
}

add_filter('comicpress_header_image_height', 'comicpress_change_header_height');

function comicpress_change_header_height($height) {
	$new_height = comicpress_themeinfo('custom_image_header_height');
	if (!empty($new_height) && ((int)$new_height > 0)) 
		$height = $new_height;
	return $height;
}

// Custom Image Header Defaults
define('HEADER_TEXTCOLOR', '');
define('HEADER_IMAGE', ''); // %s is theme dir
define('NO_HEADER_TEXT', true);

define( 'HEADER_IMAGE_WIDTH', apply_filters( 'comicpress_header_image_width', '980') );
define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'comicpress_header_image_height', '100') );
set_post_thumbnail_size( HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, true );

add_custom_image_header('comicpress_header_style', 'comicpress_admin_header_style');

function comicpress_admin_header_style() { ?>
<style type="text/css">
#headimg {
	width: <?php echo HEADER_IMAGE_WIDTH; ?>px;
	height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
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
		height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
		background: url(<?php header_image(); ?>) top center no-repeat;
		overflow: hidden;
	}

	#header h1 { padding: 0; }
	#header h1 a { 
		display: block;
		width: <?php echo HEADER_IMAGE_WIDTH; ?>px;
		height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
		text-indent: -9999px;
	}
	#header .description { display: none; }
</style>

	<?php }
}

?>