<?php 

// Custom Image Header Defaults
// define('HEADER_TEXTCOLOR', '000');
// define('HEADER_IMAGE', ''); // %s is theme dir
define('HEADER_IMAGE_WIDTH', comicpress_themeinfo('custom_image_header_width'));
define('HEADER_IMAGE_HEIGHT', comicpress_themeinfo('custom_image_header_height'));
define( 'NO_HEADER_TEXT', true );

function theme_admin_header_style() { ?>
<style type="text/css">
#headimg {
	width: <?php echo HEADER_IMAGE_WIDTH; ?>px;
	height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
	background: url(<?php header_image(); ?>) no-repeat center;	
}
	
#headimg h1, #headimg .description {
	text-decoration: none;
<?php if (get_header_textcolor() == 'blank') { ?>
	display: none;
<?php } else { ?>
	color: #<?php header_textcolor();?>;
<?php } ?>	
}
</style>
	<?php
}
	
function theme_header_style() { 
	if (get_header_image()) { ?>
<style type="text/css">
#header {
	width: <?php echo HEADER_IMAGE_WIDTH; ?>px; 
	height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
	background: url(<?php header_image(); ?>) center center no-repeat;
}
		<?php if ( 'blank' == get_header_textcolor() ) { ?>
#header h1, #header .description { display: none; }
		<?php } else { ?>
#header * { color: #<?php header_textcolor();?>; }
		<?php } ?>
		</style>
		
	<?php }
}

add_custom_image_header('theme_header_style', 'theme_admin_header_style');

?>