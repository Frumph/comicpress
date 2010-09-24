<?php
/*
Template Name: Links
*/
get_header();
?>

<?php 
$bookmarks = wp_list_bookmarks('echo=0&categorize=1'); 
$bookmarks = preg_replace('#<li ([^>]*)>#', '<li>', $bookmarks);
$bookmarks = preg_replace('#<ul ([^>]*)>#', '<ul>', $bookmarks);
?>

<div <?php post_class(); ?>>
	<div class="post-head"></div>
	<div class="post-content">
		<div id="linkspage">
		<ul>
			<?php echo $bookmarks; ?>
		</ul>
		</div>
		<div class="clear"></div>
	</div>
	<div class="post-foot"></div>
</div>
	
<?php get_footer() ?>
