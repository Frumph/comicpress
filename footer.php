<?php get_template_part('layout', 'foot'); ?>
		<div id="footer">
<?php
if (is_active_sidebar('the-footer')) get_sidebar('footer');

if (!comicpress_themeinfo('disable_footer_text')) { 
	echo comicpress_footer_text();
} ?>
<?php if (comicpress_themeinfo('enable_page_load_info')) { ?>
	<p><?php echo get_num_queries() ?> queries. <?php if (function_exists('memory_get_usage')) { $unit=array('b','kb','mb','gb','tb','pb'); echo @round(memory_get_usage(true)/pow(1024,($i=floor(log(memory_get_usage(true),1024)))),2).' '.$unit[$i]; ?> Memory usage. <?php } timer_stop(1) ?> seconds.</p>
<?php } else { ?>
	<!-- <?php echo get_num_queries() ?> queries. <?php timer_stop(1) ?> seconds. //-->
<?php } ?>
		</div><!-- Ends #footer -->
	</div><!-- Ends "page/page-wide" -->
</div><!-- Ends "page-wrap" -->

<?php if (comicpress_themeinfo('enable_caps')) { ?><div id="page-foot"></div><?php } ?>

<?php wp_footer(); ?>
</body>
</html>