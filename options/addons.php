<div id="comicpress-addons">

	<form method="post" id="myForm-addons" enctype="multipart/form-data" action="?page=comicpress-options">
	<?php wp_nonce_field('update-options') ?>

		<div class="comicpress-options">
		
		<table class="widefat">
			<thead>
				<tr>
					<th colspan="5"><?php _e('Custom Header','comicpress'); ?></th>
				</tr>
			</thead>
			<tr class="alternate">
				<th scope="row"><label for="custom_image_header_width"><?php _e('Custom Header Values','comicpress'); ?></label></th>
				<td>
					<?php _e('Width:','comicpress'); ?> <input type="text" size="5" name="custom_image_header_width" id="custom_image_header_width" value="<?php echo comicpress_themeinfo('custom_image_header_width'); ?>" />px &nbsp;
					<?php _e('Height:','comicpress'); ?> <input type="text" size="5" name="custom_image_header_height" id="custom_image_header_height" value="<?php echo comicpress_themeinfo('custom_image_header_height'); ?>" />px<br />
					<?php _e('Modify the height and width of the custom header *if* you use Appearance - Header - 780px is for standard and v layouts, the rest are wide at 980px.','comicpress'); ?>
				</td>
			</tr>
		</table>

		<table class="widefat">
			<thead>
				<tr>
					<th colspan="3"><?php _e('Related Posts','comicpress'); ?></th>
				</tr>
			</thead>
			<tr class="alternate">
				<th scope="row"><label for="enable_related_comics"><?php _e('Put Related Comics in comic posts','comicpress'); ?></label></th>
				<td>
					<input id="enable_related_comics" name="enable_related_comics" type="checkbox" value="1" <?php checked(true, comicpress_themeinfo('enable_related_comics')); ?> />
				</td>
				<td>
					<?php _e('Comics will be related by "tags" that you create for each comic post.  When creating tags for your comics, include *only* the subject material and possibly cast. Do not use tags that can relate to the entire archive or storyline the post is in.','comicpress'); ?>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="enable_related_posts"><?php _e('Put Related Posts in blog posts','comicpress'); ?></label></th>
				<td>
					<input id="enable_related_posts" name="enable_related_posts" type="checkbox" value="1" <?php checked(true, comicpress_themeinfo('enable_related_posts')); ?> />
				</td>
				<td>
					<?php _e('Blog posts will be related by "tags" that you create for each blog post.  Like the related posts for comics, the related posts for blog post checks with other blog posts comparing the tags. Try to only use 1-5 tags total; the less the better.','comicpress'); ?>
				</td>
			</tr>
		</table>
		
			<table class="widefat">
				<thead>
					<tr>
						<th colspan="3"><?php _e('Members Only Content','comicpress'); ?></th>
					</tr>
				</thead>
				<tr class="alternate">
					<th scope="row"><label for="enable_members_only"><?php _e('Enable Members Only options?','comicpress'); ?></label></th>
					<td>
						<input id="enable_members_only" name="enable_members_only" type="checkbox" value="1" <?php checked(true, comicpress_themeinfo('enable_members_only')); ?> />
					</td>
					<td>
						<?php _e('When enabled this will allow all of the members only code to be active and working.','comicpress'); ?>
					</td>
				</tr>
				<?php if (comicpress_themeinfo('enable_members_only')) { ?>
				<tr>
					<th scope="row"><label for="disable_showing_members_category"><?php _e('Disable the homepage/search for finding the members only posts?','comicpress'); ?></label></th>
					<td>
						<input id="disable_showing_members_category" name="disable_showing_members_category" type="checkbox" value="1" <?php checked(true, comicpress_themeinfo('disable_showing_members_category')); ?> />
					</td>
					<td>
						<?php _e('When enabled the member\' only category will not be displayed in the homepage posts loop.','comicpress'); ?>
					</td>
				</tr>
				<tr class="alternate">
					<th scope="row"><label for="enable_members_only_post_comments"><?php _e('Enable Members only comment content?','comicpress'); ?></label></th>
					<td>
						<input id="enable_members_only_post_comments" name="enable_members_only_post_comments" type="checkbox" value="1" <?php checked(true, comicpress_themeinfo('enable_members_only_post_comments')); ?> />
					</td>
					<td>
						<?php _e('When enabled this will make all the content of each of the comments available to be seen only by users registered and set as members.','comicpress'); ?>
					</td>
				</tr>
				<tr>
					<th scope="row" colspan="2">
						<label for="members_post_category"><?php _e('Members category','comicpress'); ?></label>
					<?php
							$select = wp_dropdown_categories('show_option_none=Select category&show_count=0&orderby=name&echo=0&selected='.comicpress_themeinfo('members_post_category'));
							$select = preg_replace('#<select([^>]*)>#', '<select name="members_post_category" id="members_post_category">', $select);
							echo $select;
						?>
					</th>
					<td>
						<?php _e('The category that is designated to show members only content.','comicpress'); ?>
					</td>
				</tr>
				<tr class="alternate">
					<td colspan="3">
						<p><?php _e('USAGE: Edit the user with <em>Dashboard -> Users -> Authors &amp; Users</em> and flag the user you want to be a member with the option at the bottom.','comicpress'); ?></p>
						<p><?php _e('Inside posts, add [members] content you only want members to see [/members]','comicpress'); ?></p>
						<p><?php _e('When setting a \'members\' category, you *cannot* use an existing comic category, uncategorized, or blog category!','comicpress'); ?></p>
						<p><?php _e('You MUST create a whole new category and called it "members", then you select that category here and create a page called "Members" or something equivelant and associate the Member\'s Only template to it.','comicpress'); ?></p>
						<p><?php _e('This will make it so that that category is only seen as blogposts inside that area and not anywhere else on the site unless the user has the members flag.','comicpress'); ?></p>
					</td>
				</tr>
				<?php } ?>
			</table>

		<table class="widefat">
			<thead>
				<tr>
					<th colspan="3"><?php _e('Buy Print','comicpress'); ?></th>
				</tr>
			</thead>
			<tr class="alternate">
				<th scope="row"><label for="enable_buy_print"><?php _e('Use Buy Print?','comicpress'); ?></label></th>
				<td>
					<input id="enable_buy_print" name="enable_buy_print" type="checkbox" value="1" <?php checked(true, comicpress_themeinfo('enable_buy_print')); ?> />
				</td>
				<td>
					<?php _e('Enables the Buy Print widgets, navigation, functions and template.','comicpress'); ?>
				</td>
			</tr>
			<?php if (comicpress_themeinfo('enable_buy_print')) { ?>
			<tr>
				<th scope="row"><label for="enable_buystrip_post"><?php _e('Enable the by print post to stay with the comic purchase page?','comicpress'); ?></label></th>
				<td>
					<input id="enable_buystrip_post" name="enable_buystrip_post" type="checkbox" value="1" <?php checked(true, comicpress_themeinfo('enable_buystrip_post')); ?> />
				</td>
				<td>
					<?php _e('Enables the Post that is on the store page to stay with the comic purchase page.','comicpress'); ?>
				</td>
			</tr>
			<tr>
				<th scope="row" colspan="2">
					<label for="buy_print_email"><?php _e('Paypal email address','comicpress'); ?></label>
					<input type="text" size="25" name="buy_print_email" id="buy_print_email" value="<?php echo comicpress_themeinfo('buy_print_email'); ?>" />
				</th>
				<td>
					<span style="color: #d54e21;"><?php _e('* This must be correct, you do not want other people getting your money.','comicpress'); ?></span><br />
					<?php _e('The Email address you registered with Paypal and that your store is associated with.','comicpress'); ?>
				</td>
			</tr>
			<tr class="alternate">
				<th scope="row"colspan="2">
					<label for="buy_print_url"><?php _e('URL of the template page','comicpress'); ?></label>
					<input type="text" size="25" name="buy_print_url" id="buy_print_url" value="<?php echo comicpress_themeinfo('buy_print_url'); ?>" />
				</th>
				<td>
					<span style="color: #d54e21;"><?php _e('* This must be correct, the form needs some place to go.','comicpress'); ?></span><br />
					<?php _e('The FULL URL address to which you associated the buy print template.','comicpress'); ?><br />
					<em>
						<?php _e('Examples:','comicpress'); ?>
						"http://yourdomain.com/?p=233",
						"http://yourdomain.com/shop/",
					</em>
				</td>
			</tr>

			<tr class="alternate">
				<th scope="row"><label for="buy_print_amount"><?php _e('Print Cost','comicpress'); ?></label></th>
				<td>
					<input type="text" size="7" name="buy_print_amount" id="buy_print_amount" value="<?php echo comicpress_themeinfo('buy_print_amount'); ?>" />
				</td>
				<td>
					<?php _e('How much does a print cost?','comicpress'); ?>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="buy_print_sell_original"><?php _e('Are you selling the original?','comicpress'); ?></label></th>
				<td>
					<input id="buy_print_sell_original" name="buy_print_sell_original" type="checkbox" value="1" <?php checked(true, comicpress_themeinfo('buy_print_sell_original')); ?> />
				</td>
				<td>
					<?php _e('<strong>NOTE: If you want to add shipping you will have to do that from your profile on paypal.</strong>','comicpress'); ?>
				</td>
			</tr>
			<tr class="alternate">
				<th scope="row"><label for="buy_print_orig_amount"><?php _e('Original Cost','comicpress'); ?></label></th>
				<td>
					<input type="text" size="7" name="buy_print_orig_amount" id="buy_print_orig_amount" value="<?php echo comicpress_themeinfo('buy_print_orig_amount'); ?>" />
				</td>
				<td>
					<?php _e('How much are you selling the Original for ?','comicpress'); ?>
				</td>
			</tr>
			<tr class="alternate">
				<th scope="row"><label for="buy_print_text"><?php _e('Buy Print Text on Template Page','comicpress'); ?></label></th>
				<td>
					<input type="text" size="20" name="buy_print_text" id="buy_print_text" value="<?php echo comicpress_stripslashes(comicpress_themeinfo('buy_print_text')); ?>" />
				</td>
				<td>
					<?php _e('What text to display to the user on the buyprint template page.','comicpress'); ?>
				</td>
			</tr>
			<?php } ?>
		</table>
		
		<table class="widefat">
			<thead>
				<tr>
					<th colspan="3"><?php _e('Facebook','comicpress'); ?></th>
				</tr>
			</thead>
			<tr>
				<td colspan="5">
					*Note: There is a Facebook Like Widget that you can place in any of the comic sidebars.
				</td>
			</tr>
			<tr class="alternate">
				<th scope="row"><label for="facebook_like_blog_post"><?php _e('Enable the Facebook Like button in Blog Posts?','comicpress'); ?></label></th>
				<td>
					<input id="facebook_like_blog_post" name="facebook_like_blog_post" type="checkbox" value="1" <?php checked(true, comicpress_themeinfo('facebook_like_blog_post')); ?> />
				</td>
				<td>
					<?php _e('When enabled this option will allow the Facebook like button to appear at the bottom of regular blog posts.','comicpress'); ?>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="facebook_like_comic_post"><?php _e('Enable the Facebook Like button in Comic Posts?','comicpress'); ?></label></th>
				<td>
					<input id="facebook_like_comic_post" name="facebook_like_comic_post" type="checkbox" value="1" <?php checked(true, comicpress_themeinfo('facebook_like_comic_post')); ?> />
				</td>
				<td>
					<?php _e('Enabling this option will allow the Facebook like button to appear at the bottom of comic posts.','comicpress'); ?>
				</td>
			</tr>
			<tr class="alternate">
				<th scope="row"><label for="facebook_meta"><?php _e('Enable the Facebook Meta?','comicpress'); ?></label></th>
				<td>
					<input id="facebook_meta" name="facebook_meta" type="checkbox" value="1" <?php checked(true, comicpress_themeinfo('facebook_meta')); ?> />
				</td>
				<td>
					<?php _e('When setting this option ComicPress will add meta information to the head area of each page so that facebook will recognize the content within.','comicpress'); ?>
				</td>
			</tr>
		</table>
		
		<table class="widefat">
			<thead>
				<tr>
					<th colspan="5"><?php _e('CDN (Content Delivery Network)','comicpress'); ?></th>
				</tr>
			</thead>
			<tr class="alternate">
				<th scope="row"><label for="cdn_url"><?php _e('CDN URL','comicpress'); ?></label></th>
				<td>
					<?php _e('URL:','comicpress'); ?> <input type="text" size="40" name="cdn_url" id="cdn_url" value="<?php echo comicpress_themeinfo('cdn_url'); ?>" /><br />
					<?php _e('If you are using a content delivery network, put the URL to where the comics are stored here.  This will replace the url used in the img tag when outputting the comic.','comicpress'); ?>
				</td>
			</tr>
		</table>

	</div>

	<div class="comicpress-options-save">
			<div class="comicpress-major-publishing-actions">
				<div class="comicpress-publishing-action">
					<input name="comicpress_save_addons" type="submit" class="button-primary" value="Save Settings" />
					<input type="hidden" name="action" value="comicpress_save_addons" />
				</div>
				<div class="clear"></div>
			</div>
		</div>

	</form>

</div>
