<?php
// page options - extra page options for easel, shown in a meta box in the page editor

function easel_page_editor_options($post) { 
?>
<div class="inside" style="overflow: hidden">
	<?php 
		wp_nonce_field( 'easel_post_options-'.$post->ID, 'easel-update-page-options' ); 
		$disable_sidebars = get_post_meta($post->ID, 'disable-sidebars', true);
	?>
	<table>
		<td valign="top">
			<input id="easel_sidebar_remove" name="easel_sidebar_remove" type="checkbox" value="1"<?php echo $disable_sidebars ? ' checked="checked"' : ''; ?> /> Disable Sidebars
		</td>
	</tr>
	</table>
</div>
<?php
}
add_action('add_meta_boxes', 'easel_add_page_editor_meta_box');

function easel_add_page_editor_meta_box() {
	add_meta_box('easel-page-options', __('Easel Page Options', 'easel'), 'easel_page_editor_options', 'page', 'side', 'high');
}

function easel_save_page_editor_options($post_id) {
	if (isset($_POST['easel-update-page-options']) && !wp_verify_nonce( $_POST['easel-update-page-options'], 'easel_post_options-'.$post_id )) {
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
	
	if (isset($_POST['easel_sidebar_remove'])) {
		update_post_meta($post_id, 'disable-sidebars', '1');
	} else {
		delete_post_meta($post_id, 'disable-sidebars');
	}
	return $post_id;
}
add_action('save_post', 'easel_save_page_editor_options');

?>