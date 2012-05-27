<?php
/*
Template Name: Buy Print
Template Author: Philip M. Hofer (Frumph)
Template URL: http://frumph.net
Template Author Email: philip@frumph.net
Template Version: 2.35
*/
get_header();
if (isset($_REQUEST['comic'])) $comicnum = intval($_REQUEST['comic']);

if (isset($_REQUEST['action'])) { 
	$action = esc_attr($_REQUEST['action']);
	switch ($action) {
		case 'thankyou': ?>
		<div class="buyprint-thankyou">
			Thanks for the purchase!
		</div>
		<?php
			break;
		case 'cancelled': ?>
		<div class="buyprint-cancelled">
			You have cancelled your transaction.
		</div>
		<?php
			break;
	}
}

if (isset($comicnum)) {
	 
	$buy_print_orig_amount = get_post_meta($comicnum , 'buy_print_orig_amount', true);
	if (empty($buy_print_orig_amount)) $buy_print_orig_amount = comicpress_themeinfo('buy_print_orig_amount');

	$buy_print_amount = get_post_meta($comicnum , 'buy_print_amount', true);
	if (empty($buy_print_amount)) $buy_print_amount = comicpress_themeinfo('buy_print_amount');

	$buyprint_status = get_post_meta($comicnum , 'buyprint-status', true);
	if (empty($buyprint_status)) $buyprint_status = 'Available';

	$buyorig_status = get_post_meta($comicnum , 'buyorig-status', true);
	if (empty($buyorig_status)) $buyorig_status = 'Available';



	$post = & get_post( $comicnum ); 
	if (!empty($post))
		setup_postdata($post);
?>
	<div <?php post_class(); ?>>
		<?php comicpress_display_post_thumbnail(); ?>
		<?php if (comicpress_themeinfo('enable_caps')) { ?><div class="post-head"></div><?php } ?>
		<div class="post-content">
			<div class="post-url-back">
				<a href="<?php echo $post->guid; ?>">&lt;-- Return to Comic</a>
			</div>
			<div class="clear"></div>
			<?php _e('Comic ID','comicpress'); ?> #<?php echo $comicnum; ?><br />
			<?php _e('Title: ','comicpress'); ?><?php echo get_the_title($post); ?><br />
			<?php _e('Print Status: ','comicpress'); ?><?php echo $buyprint_status; ?><br />
	<?php if (comicpress_themeinfo('buy_print_sell_original')) {
		_e('Original Status: ','comicpress'); echo $buyorig_status."<br />\r\n";
	} ?>
			<br />
			<div class="print-thumbnail">
			<?php 
				echo comicpress_display_comic_thumbnail('archive', $post);
			?>
			</div>
			<table class="buystriptable">
			<tr>
				<td align="left" valign="top">
					<div class="buyprint-us-form">
					<h4 class="buyprint-title">Print</h4>
						$<?php echo $buy_print_amount; ?><br />
					<?php if ($buyprint_status == 'Available') { ?>
					
						<form target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post">
							<input type="hidden" name="add" value="1" />
							<input type="hidden" name="cmd" value="_cart" />
							<input type="hidden" name="item_name" value="<?php _e('Print','comicpress'); ?> - <?php echo get_the_title($post); ?> - <?php echo $this_post->guid; ?>" />
							<input type="hidden" name="return" value="<?php echo comicpress_themeinfo('buy_print_url'); ?>?action=thankyou&comic=<?php echo $comicnum; ?>" /> <!-- send to buyprint template, trigger thank you -->
							<input type="hidden" name="amount" value="<?php echo $buy_print_amount;?>" />
							<input type="hidden" name="item_number" value="<?php echo $comicnum; ?>" />
							<input type="hidden" name="business" value="<?php echo comicpress_themeinfo('buy_print_email'); ?>" />
							<input type="image" src="<?php echo get_template_directory_uri(); ?>/images/buynow_paypal.png" name="submit32" alt="<?php _e('Make payments with PayPal - it is fast, free and secure!','comicpress'); ?>" /> 
						</form>
						
					<?php } ?>
					<?php if ($buyprint_status == 'Sold') { ?>
							<img src="<?php echo get_template_directory_uri().'/images/sold.png'; ?>" alt="Sold" />
					<?php } ?>
					<?php if ($buyprint_status == 'Out Of Stock') { ?>
							<img src="<?php echo get_template_directory_uri().'/images/outofstock.png'; ?>" alt="Out Of Stock" />
					<?php } ?>
					<?php if ($buyprint_status == 'Not Available') { ?>
							<img src="<?php echo get_template_directory_uri().'/images/notavailable.png'; ?>" alt="Not Available" />
					<?php } ?>
					</div>
				</td>
			<?php if (comicpress_themeinfo('buy_print_sell_original')) { ?>
				<td width="40">
				</td>
				<td align="left" valign="top">
					<div class="buyprint-us-form">
					<h4 class="buyprint-orig-title">Original</h4>
						$<?php echo $buy_print_orig_amount; ?><br />
					<?php if ($buyorig_status == 'Available') { ?>
					
						<form target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post">
							<input type="hidden" name="add" value="1" />
							<input type="hidden" name="cmd" value="_cart" />
							<input type="hidden" name="quantity" value="1" />
							<input type="hidden" name="notify_url" value="<?php echo get_template_directory_uri().'/addons/ipn.php'; ?>" /> <!-- send to the ipn.php file -->
							<input type="hidden" name="return" value="<?php echo comicpress_themeinfo('buy_print_url'); ?>?action=thankyou&comic=<?php echo $comicnum; ?>" /> <!-- send to buyprint template, trigger thank you -->
							<input type="hidden" name="cancel_return" value="<?php echo comicpress_themeinfo('buy_print_url'); ?>?action=cancel&comic=<?php echo $comicnum; ?>" /> <!-- send to the buyprint template, trigger cancel info -->
							<input type="hidden" name="item_name" value="<?php _e('Original','comicpress'); ?> - <?php echo get_the_title($post); ?> - <?php echo $this_post->guid; ?>" />
							<input type="hidden" name="amount" value="<?php echo $buy_print_orig_amount;?>" />
							<input type="hidden" name="item_number" value="<?php echo $comicnum; ?>" />
							<input type="hidden" name="business" value="<?php echo comicpress_themeinfo('buy_print_email'); ?>" />				
							<input type="image" src="<?php echo get_template_directory_uri(); ?>/images/buynow_paypal.png" name="submit32" alt="<?php _e('Make payments with PayPal - it is fast, free and secure!','comicpress'); ?>" /> 
						</form>
						
					<?php } ?>
					<?php if ($buyorig_status == 'Sold') { ?>
							<img src="<?php echo get_template_directory_uri().'/images/sold.png'; ?>" alt="Sold" />
					<?php } ?>
					<?php if ($buyorig_status == 'Out Of Stock') { ?>
							<img src="<?php echo get_template_directory_uri().'/images/outofstock.png'; ?>" alt="Out Of Stock" />
					<?php } ?>
					<?php if ($buyorig_status == 'Not Available') { ?>
							<img src="<?php echo get_template_directory_uri().'/images/notavailable.png'; ?>" alt="Not Available" />
					<?php } ?>
					</div>
				</td>
			<?php } ?>
			</tr>
			</table>
			<br />
			<div class="print-text">
			<?php echo comicpress_themeinfo('buy_print_text'); ?>
			</div>
			<div class="clear"></div>
		</div>
		<?php if (comicpress_themeinfo('enable_caps')) { ?><div class="post-foot"></div><?php } ?>
	</div>
	
<?php 
	} 

if (comicpress_themeinfo('enable_buystrip_post') || empty($comicnum)) {
	while (have_posts()) : the_post() 
?>

<div <?php post_class(); ?>>
	<?php comicpress_display_post_thumbnail(); ?>
	<?php if (comicpress_themeinfo('enable_caps')) { ?><div class="post-head"></div><?php } ?>
	<div class="post-content">
		<?php if (!comicpress_themeinfo('disable_page_titles')) { ?>
			<h2 class="pagetitle"><?php the_title() ?></h2>
		<?php } ?>
		<div class="entry">
			<?php the_content(); ?>
		</div>
		<div class="clear"></div>
		<?php edit_post_link(__('Edit this page.','comicpress'), '', '') ?>
	</div>
	<?php if (comicpress_themeinfo('enable_caps')) { ?><div class="post-foot"></div><?php } ?>
</div>

<?php 
		if ('open' == $post->comment_status) { comments_template('', true); }

	endwhile; 
} 

get_footer() 
?>
