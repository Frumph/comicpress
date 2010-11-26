<?php

if ( isset( $_GET['latestcomic'] ) )
	add_action( 'template_redirect', 'comicpress_latest_comic_jump' );

//to use simply create a URL link to "/?latestcomic"
function comicpress_latest_comic_jump() {
	if (isset($_GET['latestcomic'])) $chapter = (int)$_GET['latestcomic'];
	if (!empty($chapter)) {
		wp_redirect( get_permalink( comicpress_get_terminal_post_in_category($chapter, false) ) );
	} else {
		wp_redirect( get_permalink( comicpress_get_terminal_post_in_category(comicpress_all_comic_categories_string(), false) ) );
	}
	exit;
}

//Generate a random comic page - to use simply create a URL link to "/?randomcomic"
function comicpress_random_comic() {
	$randomComicQuery = new WP_Query(); $randomComicQuery->query('showposts=1&orderby=rand&cat='.comicpress_all_comic_categories_string());
	if ($randomComicQuery->have_posts()) {
		$randomComicQuery->the_post();
		$random_comic_id = get_the_ID();
		define('DONOTCACHEPAGE', true);
		wp_redirect( get_permalink( $random_comic_id ) );
	}
	exit;
}

if ( isset( $_GET['randomcomic'] ) )
	add_action( 'template_redirect', 'comicpress_random_comic' );

//Generate a random post page - to use simply create a URL link to "/?randompost"
function comicpress_random_post() {
	$randomComicQuery = new WP_Query(); $randomComicQuery->query('showposts=1&orderby=rand&cat='.comicpress_exclude_comic_categories());
	while ($randomComicQuery->have_posts()) : $randomComicQuery->the_post();
		$random_comic_id = get_the_ID();
	endwhile;
	define('DONOTCACHEPAGE', true);
	wp_redirect( get_permalink( $random_comic_id ) );
	exit;
}

if ( isset( $_GET['randompost'] ) )
	add_action( 'template_redirect', 'comicpress_random_post' );


?>