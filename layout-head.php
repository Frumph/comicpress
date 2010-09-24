<div id="content-wrapper-head"></div>
	<div id="content-wrapper">

	<?php 
if (is_cp_theme_layout('gn,v3c') && !comicpress_is_signup()) get_sidebar('left'); 

	if (is_cp_theme_layout('gn,rgn')) { ?>
		<div id="pagewrap-right">
	<?php }
	
	if (is_cp_theme_layout('v3cr')) { ?>
		<div id="pagewrap-left">
	<?php }

if (is_cp_theme_layout('v,v3c')) { 
	if (is_page('chat') || is_page('forum') && !comicpress_is_signup()) { ?>
			<div id="content" class="widecolumn">
	<?php } elseif (!comicpress_is_signup()) { ?>
			<div id="content" class="narrowcolumn">
	<?php } 
	if (is_active_sidebar('over-blog')) get_sidebar('overblog');
}

if (!is_paged()) {
	if (is_home()) {
		if (!comicpress_themeinfo('disable_comic_frontpage')) {
			$wp_query->in_the_loop = true; $comicFrontpage = new WP_Query(); $comicFrontpage->query('showposts=1&cat='.comicpress_all_comic_categories_string());
			while ($comicFrontpage->have_posts()) : $comicFrontpage->the_post();
				comicpress_display_comic_area();
			endwhile;
		}
	} else {
		if (is_single() && comicpress_in_comic_category()) {
			comicpress_display_comic_area();
		}
	}
}

if (is_cp_theme_layout('3c,standard,3c2r')) {  ?>
<div id="subcontent-wrapper-head"></div>
	<div id="subcontent-wrapper">
<?php }

if (is_cp_theme_layout('3c,rgn') && !comicpress_is_signup()) get_sidebar('left');

if (is_cp_theme_layout('v3cr')) { ?>
<div id="subcontent-wrapper-head"></div>
	<div id="subcontent-wrapper">
<?php }

if (!is_cp_theme_layout('v3c,v')) {
	if (is_page('chat') || is_page('forum') && !comicpress_is_signup()) { ?>
			<div id="content" class="widecolumn">
	<?php } elseif (!comicpress_is_signup()) { ?>
			<div id="content" class="narrowcolumn">
	<?php }
	if (is_active_sidebar('over-blog')) get_sidebar('overblog');
} 
?>