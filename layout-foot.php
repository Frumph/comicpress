				<?php if (!comicpress_sidebars_disabled()) comicpress_get_sidebar('under-blog'); ?>
			</div>
<?php
if (!comicpress_is_signup() && !comicpress_sidebars_disabled()) {
	if (comicpress_is_layout('3clgn')) comicpress_get_sidebar('right');
}
?>
		</div>
<?php
if (!comicpress_is_signup() && !comicpress_sidebars_disabled()) {
	if (comicpress_is_layout('3cl,3cr')) comicpress_get_sidebar('left');
	if (comicpress_is_layout('2cr,3c,3cr,3crgn')) comicpress_get_sidebar('right');
}
?>
		<div class="clear"></div>
	</div>
</div>
