<div id="comicpress-help">
	<div class="comicpress-options">
		<?php if (comicpress_themeinfo('first_run')) { ?>
		<h1 class="options-about-title"><?php _e('Welcome to ComicPress 4.0!','comicpress'); ?></h1>
		<div class="options-about-welcome">
			<strong><?php _e('Thank you for using ComicPress!','comicpress'); ?></strong><br />
			<?php _e('ComicPress 4.0 has more features, uses the Comic Easel plugin now and is more stable than ever to help you build an incredible WebComic website.','comicpress'); ?>
		<form method="post" id="myForm-general" enctype="multipart/form-data" action="?page=comicpress-options">
			<?php wp_nonce_field('update-options') ?>
			<input name="comicpress_save_help" type="submit" class="button-primary" value="Dismiss Help Page From Continually Showing Up" />
			<input type="hidden" name="action" value="comicpress_save_help" />
		</form>			
		</div>
		<?php } ?>
		<div class="options-about-table">
			<div class="options-about-migrate">
				<h3><?php _e('Fresh installation of Comic Easel and ComicPress','comicpress'); ?></h3>
				<br />
				<strong><?php _e('There is a video at the bottom of this page to help guide you with installation and usage.','comicpress'); ?></strong><br />
				<br />
				<h3><?php _e('Migration Instructions','comicpress'); ?></h3>
				<br />
				<strong><?php _e('There are videos available at','comicpress'); ?> <a href="http://comiceasel.com/category/tutorials/video/" target="_blank">comiceasel.com</a> <?php _e('that show a migration.','comicpress'); ?></strong><br />
				<ul>
					<ol>
						<li><?php _e('Deactivate ComicPress manager if you are using it.','comicpress'); ?></li>
						<li><?php _e('If you are using a child theme, activate the main ComicPress theme while migrating.','comicpress'); ?></li>
						<li><?php _e('Install and activate both the Comic Easel and CP2CE (ComicPress to Comic Easel) plugins.','comicpress'); ?></li>
						<li><?php _e('Make sure your comics folder is named comics and is directly off the root of your WordPress installation, that is where the CP2CE plugin is looking for the comics.','comicpress'); ?></li>
						<li><strong><?php _e('Go through all of your comics in wp-admin - posts - all posts.  Make sure all of your comics are set into only one category.   They can be different categories for each group of comics, but only one category set.','comicpress'); ?></strong></li>
						<li><?php _e('Go to wp-admin - tools - export and make a backup of your current sites data.  (best if you use phpmyadmin from your hostings cpanel and do an .sql export of your database)','comicpress'); ?></li>
						<li><?php _e('Make sure Comic Easel is activated and go to wp-admin - Tools - CP2CE Migrator','comicpress'); ?></li>
						<li><?php _e('Select one category at a time in the drop down.','comicpress'); ?></li>
						<li><?php _e('Choose how many comics to migrate at once. The first time you use it, select 1 comic to migrate. Click the [Migrate!] button and it will refresh the page and give you information on the migration.','comicpress'); ?></li>
						<li><?php _e('If it looks like it could not find the comic to attach to the post, follow the Reverting a Migration steps and fix your comics location to the path the CP2CE plugin is looking for the comics in, then start over in the CP2CE.','comicpress'); ?></li>
						<li><?php _e('If it looks successful and found the comic to attach to the post, start increasing the amount of comics to migrate at one time. 1-25 at a time for shared hostings.  25-50 for VPS hosting, 50-100 for dedicated servers with high memory availability.','comicpress'); ?></li>
						<li><?php _e('Once you are done with the migration, go to wp-admin - Comics -> Comics and check all of your comic posts, note if they have comics attached to them.','comicpress'); ?></li>
						<li><?php _e('Go to wp-admin - posts - categories and delete the OLD comic categories that you used to have.  Check the column to see if there are any comics you still need to migrate.','comicpress'); ?></li>
						<li><?php _e('If all looks good, you have successfully migrated to using Comic Easel, congratulations!','comicpress'); ?></li>
					</ol>
				</ul>
				<h3><?php _e('Converting Child Theme Instructions','comicpress'); ?></h3>
				<br />
				<?php _e('Now that you have successfully migrated to Comic Easel, it is time to fix your child theme.','comicpress'); ?><br />
				<br />
				<strong><?php _e('Important things to note:','comicpress'); ?></strong>
				<ul>
					<li><?php _e('Any theme files, child-functions.php and functions.php all of those .php files will no longer be able to be used.  While this ComicPress is similar it is not the same. Remove them from your child theme - make backups of them to your local drive via FTP so you can reference them later.  The only file you should have left is the style.css in the child theme directory.','comicpress'); ?></li>
					<li><?php _e('Some elements have changed (only a select few).  For example, .narrowcolumn width is now controlled by #content-column,  .uentry is used in place of .type-post, .type-comic, .type-page and handles all of those.','comicpress'); ?></li>
					<li><?php _e('Use a browser based developement tool like firebug for Firefox or Chromes developement tools to point and click and find the CSS element you need.','comicpress'); ?></li>
					<li><?php _e('If in doubt, contact me - Frumph and I will help you.','comicpress'); ?></li>
				</ul>
			</div>
			<div class="options-about-directions">
				<h3><?php _e('Yada Yada Notes','comicpress'); ?></h3>
				<ul>
					<li><strong><?php _e('Do NOT migrate unless you are confident on its success, read EVERYTHING.','comicpress'); ?></strong></li>
					<li><?php _e('ComicPress no longer supports ComicPress Manager, you can deactivate the plugin and delete it.','comicpress'); ?></li>
					<li><?php _e('Frumph can help you migrate your ComicPress old version to this new version if you are stuck.','comicpress'); ?></li>
					<li><?php _e('Your widgets are NOT lost, they are in the [inactive] section of the appearance - widgets area, just put them back into the sidebars you want them in.','comicpress'); ?></li>
					<li><?php _e('It is still a good idea to use a child theme if you do customizations beyond what the customizer has.','comicpress'); ?></li>
					<li><?php _e('You can download a blank child theme on frumph.net.','comicpress'); ?></li>
					<li><?php _e('Each comic when added needs to be in a chapter, each chapter is considered an individual story. If you do not need chapters then create a chapter that is named something that encompasses all of of your comics.','comicpress'); ?></li>
					<li><?php _e('You cannot use comic as a slug for anything','comicpress'); ?></li>
					<li><?php _e('Slugs can not be strictly numerical, has to have some sort of alpha character in them.','comicpress'); ?></li>
					<li><?php _e('In the wp-admin - Themes section there is an area now for recommended plugins to use with ComicPress.','comicpress'); ?></li>
					<li><?php _e('The configuration for comic options is in the wp-admin - Comics - Config are while the configuration for the theme is in wp-admin - Appearance - ComicPress Options','comicpress'); ?></li>
					<li><?php _e('You do NOT have to install all of the recommended plugins, just dismiss the message so you do not see it again.','comicpress'); ?></li>
					<li><?php _e('In the customizer, if you set a logo you should NOT use the checkbox in the Header Image to make the header title the hotspot.','comicpress'); ?></li>
				</ul>
				<h3><?php _e('Reverting a Migration','comicpress'); ?></h3>
				<br />
				<strong><?php _e('If you accidently migrated blog categories.','comicpress'); ?></strong><br />
				<ul>
					<ol>
						<li><?php _e('Install and activate the Convert Post Types plugin from wp-admin - Themes - Recommended Plugins.','comicpress'); ?></li>
						<li><?php _e('Select the comic post type in the Convert From.. dropdown and set the Convert To.. dropdown to post.','comicpress'); ?></li>
						<li><?php _e('Click the [convert] button and it will set all of the things you migrated back to posts.','comicpress'); ?></li>
						<li><?php _e('NOTE: This WILL make it so that you lose all of your chapter/categories set.  So you will have to remake them.','comicpress'); ?></li>
						<li><?php _e('Go to the media library and delete all of the comic images that it already migrated.','comicpress'); ?></li>
						<li><?php _e('Start over with your migration.','comicpress'); ?></li>
					</ol>
				</ul>
			</div>
		</div>
		<div style="text-align:center; clear: both;margin-top:40px;">
			<iframe width="853" height="480" src="//www.youtube.com/embed/b6feJZJPtD0" frameborder="0" allowfullscreen></iframe>
		</div>

	</div>	
</div>

