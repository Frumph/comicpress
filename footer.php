		<?php get_template_part('layout', 'foot'); ?>
		<div id="footer">
			<?php do_action('easel-footer'); ?>
			<div id="footer-sidebar-wrapper">
			<?php 
				easel_get_sidebar('footer-left');
				easel_get_sidebar('footer');
				easel_get_sidebar('footer-right');
			?>
			</div>
			<div class="clear"></div>
		</div>	
	</div> <!-- // #page -->
	<div id="footer-menubar-wrapper">
		<?php wp_nav_menu( array( 'sort_column' => 'menu_order', 'depth' => 1, 'fallback_cb' => false, 'container_class' => 'footmenu', 'theme_location' => 'Footer' ) ); ?>
		<div class="clear"></div>
	</div>			
	<?php if (!easel_themeinfo('disable_footer_text')) easel_copyright_text(); ?>		
</div> <!-- / #page-wrap -->
<?php wp_footer(); ?>
</body>
</html>