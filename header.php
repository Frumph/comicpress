<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>> 
<head>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type') ?>; charset=<?php bloginfo('charset') ?>" />
	<title><?php 
	bloginfo('name'); 
	if (is_home () ) {
		echo ' - '; bloginfo('description');
	} elseif (is_category() ) {
		echo ' - '; single_cat_title();
	} elseif (is_single() || is_page() ) { 
		echo ' - '; single_post_title();
	} elseif (is_search() ) { 
		echo __(' search results: ','comicpress'); echo esc_html($s);
	} else { 
		echo ' - '; wp_title('',true);
	}
  ?></title>
	<link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" type="text/css" media="screen" />
	<link rel="pingback" href="<?php bloginfo('pingback_url') ?>" />
	<meta name="ComicPress" content="<?php echo comicpress_themeinfo('version'); ?>" />
	<?php if ( is_singular() && comicpress_themeinfo('enable_comment_javascript') && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>
<!-- Last Update: <?php the_time('M jS, Y'); ?> // -->
<!--[if lt IE 7]>
   <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/ie6submenus.js"></script>
<![endif]-->
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php
if (is_active_sidebar('above-header')) get_sidebar('above'); 
?> 
<div id="page-head"></div>
<?php if (!comicpress_themeinfo('disable_page_restraints')) {
	if (is_cp_theme_layout('standard,v')) { ?>
<div id="page-wrap"><!-- Wraps outside the site width -->
	<div id="page"><!-- Defines entire site width - Ends in Footer -->
<?php } else { ?>
<div id="page-wide-wrap"><!-- Wraps outside the site width -->
	<div id="page-wide"><!-- Defines entire site width - Ends in Footer -->
		<?php } 
} ?>

<div id="header">
	<?php do_action('comicpress-header'); ?>
	<h1><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name') ?></a></h1>
	<div class="description"><?php bloginfo('description') ?></div>
	<?php if (is_active_sidebar('header')) get_sidebar('header'); ?>
	<div class="clear"></div>
</div>
		
<?php 
if (!comicpress_themeinfo('disable_default_menubar')) comicpress_menubar();
if (is_active_sidebar('menubar')) get_sidebar('menubar');
get_template_part('layout', 'head');
?>