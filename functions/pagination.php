<?php

function easel_pagination() {
	global $post, $wp_query;
	if(function_exists('easel_wp_pagenavi')) {
		easel_wp_pagenavi('<div id="wp-paginav">', '<div class="clear"></div></div>');
	} else { ?>
		<div id="pagenav">
		<div class="pagenav-right"><?php previous_posts_link(__('Newer Entries &uarr;','easel')) ?></div>
		<div class="pagenav-left"><?php next_posts_link(__('&darr; Previous Entries','easel')) ?></div>
		<div class="clear"></div>
		</div>
	<?php }
} 

?>
