<div id="content-wrapper-head"></div>
	<div id="content-wrapper">
		<?php if (is_cp_theme_layout('2cr,2cl,3c,3c2l,3c2r')) do_action('comic-area'); ?>
		<div id="subcontent-wrapper-head"></div>
		<div id="subcontent-wrapper">
			<?php if (is_cp_theme_layout('2cl,2cvl,3c,3c2l,v3c,v3cl,lgn') && !comicpress_disable_sidebars()) get_sidebar('left'); ?>
			<?php if (is_cp_theme_layout('3c2l,v3cl') && !comicpress_disable_sidebars()) get_sidebar('right'); ?>
			<?php if (is_cp_theme_layout('lgn,rgn')) { ?><div class="gn-wrap"><?php do_action('comic-area'); } ?>
			<?php if (is_cp_theme_layout('rgn') && !comicpress_disable_sidebars()) get_sidebar('left'); ?>
			<div id="content" class="narrowcolumn">
				<?php if (is_cp_theme_layout('2cvr,2cvl,v3c,v3cr,v3cl')) do_action('comic-area'); ?>
				<?php if (is_active_sidebar('over-blog')) get_sidebar('overblog'); ?>