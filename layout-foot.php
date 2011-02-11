		</div>
		<?php if (is_cp_theme_layout('2cvr,2cvl,v3c,v3cr,v3cl,lgn,rgn')) { ?>
			<?php if (is_cp_theme_layout('lgn') && !comicpress_disable_sidebars()) get_sidebar('right');  ?>
				<div class="clear"></div>
			</div>
			<?php } ?>
		<?php if (is_cp_theme_layout('3c2r,v3cr') && !comicpress_disable_sidebars()) get_sidebar('left'); ?>
		<?php if (is_cp_theme_layout('2cr,2cvr,3c,3c2r,v3c,v3cr,rgn') && !comicpress_disable_sidebars()) get_sidebar('right');  ?>
		<?php if (comicpress_themeinfo('enable_caps')) { ?><div id="subcontent-wrapper-foot"></div><?php } ?>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
</div>
<?php if (comicpress_themeinfo('enable_caps')) { ?><div id="content-wrapper-foot"></div><?php } ?>