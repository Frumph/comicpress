	<?php get_template_part('layout', 'foot'); ?>
	<?php if (!get_theme_mod('comicpress-customize-detach-footer', false)) { ?>
	<footer id="footer">
		<?php do_action('comicpress-footer'); ?>
		<div id="footer-sidebar-wrapper">
		<?php 
			comicpress_get_sidebar('footer-left');
			comicpress_get_sidebar('footer');
			comicpress_get_sidebar('footer-right');
		?>
		</div>
		<div class="clear"></div>
		<div id="footer-menubar-wrapper">
			<?php wp_nav_menu( array( 'sort_column' => 'menu_order', 'depth' => 1, 'fallback_cb' => false, 'container_class' => 'footmenu', 'theme_location' => 'Footer' ) ); ?>
			<div class="clear"></div>
		</div>
		<?php if (!comicpress_themeinfo('disable_footer_text')) comicpress_copyright_text(); ?>
		<?php if (comicpress_themeinfo('enable_debug_footer_code')) { ?>
			<p><?php echo get_num_queries() ?> queries. <?php if (function_exists('memory_get_usage')) { $unit=array('b','kb','mb','gb','tb','pb'); echo @round(memory_get_usage(true)/pow(1024,($i=floor(log(memory_get_usage(true),1024)))),2).' '.$unit[$i]; ?> Memory usage. <?php } timer_stop(1) ?> seconds.</p>
		<?php } ?>
	</footer>	
	<?php } ?>
	</div> <!-- // #page -->
</div> <!-- / #page-wrap -->
<?php if (get_theme_mod('comicpress-customize-detach-footer', false)) { ?>
<footer id="footer">
	<?php do_action('comicpress-footer'); ?>
	<div id="footer-sidebar-wrapper">
	<?php 
		comicpress_get_sidebar('footer-left');
		comicpress_get_sidebar('footer');
		comicpress_get_sidebar('footer-right');
	?>
	</div>
	<div class="clear"></div>
	<div id="footer-menubar-wrapper">
		<?php wp_nav_menu( array( 'sort_column' => 'menu_order', 'depth' => 1, 'fallback_cb' => false, 'container_class' => 'footmenu', 'theme_location' => 'Footer' ) ); ?>
		<div class="clear"></div>
	</div>
	<?php if (!comicpress_themeinfo('disable_footer_text')) comicpress_copyright_text(); ?>
	<?php if (comicpress_themeinfo('enable_debug_footer_code')) { ?>
		<p><?php echo get_num_queries() ?> queries. <?php if (function_exists('memory_get_usage')) { $unit=array('b','kb','mb','gb','tb','pb'); echo @round(memory_get_usage(true)/pow(1024,($i=floor(log(memory_get_usage(true),1024)))),2).' '.$unit[$i]; ?> Memory usage. <?php } timer_stop(1) ?> seconds.</p>
	<?php } ?>
</footer>
<?php } ?>
<?php wp_footer(); ?>
</body>
</html>