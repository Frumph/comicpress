<?php

add_shortcode( 'version', 'comicpress_ver_shortcode' );

function comicpress_ver_shortcode( $atts, $content = null ) {
	return '<div class="comicpress_ver">'.comicpress_themeinfo('version').'</div>';
}

add_shortcode( 'note', 'comicpress_admin_note' );

function comicpress_admin_note( $atts, $content = null ) {
	if ( current_user_can( 'manage_options' ) )
		return '<div class="admin_note">'.$content.'</div>';
	return '';
}

?>