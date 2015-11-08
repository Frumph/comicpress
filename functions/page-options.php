<?php
// page options - extra page options, shown in a meta box in the page editor

function comicpress_page_editor_options($post) { 
?>
<div class="inside" style="overflow: hidden">
	<?php 
		wp_nonce_field( 'comicpress_post_options-'.$post->ID, 'comicpress-update-page-options' ); 
		$disable_sidebars = get_post_meta($post->ID, 'disable-sidebars', true);
	?>
	<table>
		<tr>
			<td valign="top">
			<input id="comicpress_sidebar_remove" name="comicpress_sidebar_remove" type="checkbox" value="1"<?php echo $disable_sidebars ? ' checked="checked"' : ''; ?> /> Disable Sidebars
			</td>
		</tr>
	</table>
</div>
<?php
}
add_action('add_meta_boxes', 'comicpress_add_page_editor_meta_box');

function comicpress_add_page_editor_meta_box() {
	add_meta_box('comicpress-page-options', __( 'Page Options', 'comicpress' ), 'comicpress_page_editor_options', 'page', 'side', 'high');
}

function comicpress_save_page_editor_options($post_id) {
	if (isset($_POST['comicpress-update-page-options']) && !wp_verify_nonce( $_POST['comicpress-update-page-options'], 'comicpress_post_options-'.$post_id )) {
		return $post_id;
	} 
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
		return $post_id;
	if ( isset($_POST['post_type']) && ($_POST['post_type'] == 'page') ) {
		if ( !current_user_can( 'edit_page', $post_id ) )
			return $post_id;
	} else {
		if ( !current_user_can( 'edit_post', $post_id ) )
			return $post_id;
	}
	
	if (isset($_POST['comicpress_sidebar_remove'])) {
		update_post_meta($post_id, 'disable-sidebars', '1');
	} else {
		delete_post_meta($post_id, 'disable-sidebars');
	}
	return $post_id;
}
add_action('save_post', 'comicpress_save_page_editor_options');

?>