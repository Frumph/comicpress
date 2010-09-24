<?php

function comicpress_buyprint_edit_post() { 
	global $post;
	if (comicpress_in_comic_category()) {
		$currentbuyprintoption = get_post_meta( $post->ID, 'buyprint-status', true );
		if (empty($currentbuyprintoption)) $currentbuyprintoption = 'Available';
		$currentbuyorigoption = get_post_meta( $post->ID, 'buyorig-status', true );
		if (empty($currentbuyorigoption)) $currentbuyorigoption = 'Available';
		$currentbuyprintamount = get_post_meta($post->ID , 'buy_print_amount', true);
		if (empty($currentbuyprintamount)) $currentbuyprintamount = comicpress_themeinfo('buy_print_amount');
		$currentbuyorigamount = get_post_meta($post->ID , 'buy_print_orig_amount', true);
		if (empty($currentbuyorigamount)) $currentbuyorigamount = comicpress_themeinfo('buy_print_orig_amount');

	?>
		<table>
		<tr>
			<td align="left" valign="top" width="50%">
				The Print Cost <input name="buy_print_amount" id="buy_print_amount" type="text" size="5" value="<?php echo $currentbuyprintamount ?>" />  <br />
				<input name="buyprint-status" id="buyprint-available" type="radio" value="Available" <?php if ($currentbuyprintoption == 'Available' || empty($currentbuyprintoption)) { echo " checked"; } ?> /> Available<br />
				<input name="buyprint-status" id="buyprint-sold" type="radio" value="Sold" <?php if ($currentbuyprintoption == 'Sold') { echo " checked"; } ?> /> Sold<br />
				<input name="buyprint-status" id="buyprint-outofstock" type="radio" value="Out Of Stock" <?php if ($currentbuyprintoption == 'Out Of Stock') { echo " checked"; } ?> /> Out of Stock<br />
				<input name="buyprint-status" id="buyprint-notavail" type="radio" value="Not Available" <?php if ($currentbuyprintoption == 'Not Available') { echo " checked"; } ?> /> Not Available<br />
			</td>
		<?php if (comicpress_themeinfo('buy_print_sell_original')) { ?>
			<td align="left" valign="top">
				Original Cost <input name="buy_print_orig_amount" id="buy_print_orig_amount" size="5" type="text" value="<?php echo $currentbuyorigamount; ?>" /><br />
				<input name="buyorig-status" id="buyorig-available" type="radio" value="Available" <?php if ($currentbuyorigoption == 'Available' || empty($currentbuyorigoption)) { echo " checked"; } ?> /> Available<br />
				<input name="buyorig-status" id="buyorig-sold" type="radio" value="Sold" <?php if ($currentbuyorigoption == 'Sold') { echo " checked"; } ?> /> Sold<br />
				<input name="buyorig-status" id="buyorig-outofstock" type="radio" value="Out Of Stock" <?php if ($currentbuyorigoption == 'Out Of Stock') { echo " checked"; } ?> /> Out of Stock<br />
				<input name="buyorig-status" id="buyorig-notavail" type="radio" value="Not Available" <?php if ($currentbuyorigoption == 'Not Available') { echo " checked"; } ?> /> Not Available<br />
			</td>
		<?php } ?>
		</tr>
		</table>
	<?php 
	} else {
		_e('No prints available for non-comic categories.', 'comicpress');
	}
}


function comicpress_handle_edit_post_buyprint_save($post_id) {
	
	update_post_meta($post_id, 'buyprint-status', $_POST['buyprint-status']);
	update_post_meta($post_id, 'buy_print_amount', wp_filter_nohtml_kses($_POST['buy_print_amount']));
	
	/* delete the old buyprint option if it exists */
	delete_post_meta($post_id, 'buyprint');
	
	/* delete if shipping turned off */
	if (comicpress_themeinfo('buy_print_sell_original')) {
		update_post_meta($post_id, 'buyorig-status', $_POST['buyorig-status']);
		update_post_meta($post_id, 'buy_print_orig_amount', wp_filter_nohtml_kses($_POST['buy_print_orig_amount']));
	} else {
		delete_post_meta($post_id, 'buyorig-status');
		delete_post_meta($post_id, 'buy_print_orig_amount');
	}	
}

function comicpress_buyprint_admin_function() {
	global $post;
	add_meta_box(
			'buyprint-for-this-post',
			__('Buy Print Information', 'comicpress'),
			'comicpress_buyprint_edit_post',
			'post',
			'side',
			'low'
			);
}

if (comicpress_themeinfo('enable_buy_print')) {
	add_action('admin_menu', 'comicpress_buyprint_admin_function');
	add_action('save_post', 'comicpress_handle_edit_post_buyprint_save' , 1, 1);
}

?>