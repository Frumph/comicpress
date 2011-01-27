		</div>
		<?php if (is_cp_theme_layout('lgn,rgn')) { ?>
			<?php if (is_cp_theme_layout('lgn') && !comicpress_disable_sidebars()) get_sidebar('right');  ?>
				<div class="clear"></div>
			</div>
		<?php } ?>
		<?php if (is_cp_theme_layout('3c2r,v3cr') && !comicpress_disable_sidebars()) get_sidebar('left'); ?>
		<?php if (is_cp_theme_layout('2cr,2cvr,3c,3c2r,v3c,v3cr,rgn') && !comicpress_disable_sidebars()) get_sidebar('right');  ?>
			<div class="clear"></div>
		</div>
		<div id="subcontent-wrapper-foot"></div>
	</div>
	<div class="clear"></div>
</div>
<div id="content-wrapper-foot"></div>
