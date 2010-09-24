</div>
<?php if (is_cp_theme_layout('v3cr')) { ?>
		</div>
		<div class="clear"></div>
		<div id="subcontent-wrapper-foot"></div>
	</div>
<?php }

if (is_cp_theme_layout('3c2r,v3cr') && !comicpress_is_signup()) get_sidebar('left');

if (is_cp_theme_layout('3c,v3c,gn,standard,v,3c2r,v3cr') && !comicpress_is_signup()) get_sidebar('right');

if (is_cp_theme_layout('3c,standard,3c2r')) {  ?>
			<div class="clear"></div>
		<?php if (!comicpress_is_signup()) { ?></div><?php } ?>
		<div id="subcontent-wrapper-foot"></div>
<?php }

if (is_cp_theme_layout('gn,rgn')) { ?>
		</div>
<?php }
if (is_cp_theme_layout('rgn') && !comicpress_is_signup()) get_sidebar('right'); ?>
	<div class="clear"></div>
</div>
<div id="content-wrapper-foot"></div>
