				<?php if (!easel_sidebars_disabled()) easel_get_sidebar('under-blog'); ?>
			</div>
		</div>			
<?php 
if (!easel_is_signup() && !easel_sidebars_disabled()) {
	if (easel_is_layout('3cl,3cr')) easel_get_sidebar('left');
	if (easel_is_layout('2cr,2crw,3c,3cr')) easel_get_sidebar('right');
}
?>
		<div class="clear"></div>
	</div>
</div>
