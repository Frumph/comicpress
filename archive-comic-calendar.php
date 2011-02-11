<?php
/*
Template Name: Comic Calendar Archive
*/
get_header(); 
remove_filter('pre_get_posts','comicpress_members_filter');

$cpdayWidth = 22; //set to .cpcal-day total width in pixels including: width, left & right border, left & right margin, left & right padding

if (isset($_GET['archive_year'])) { 
	$archive_year = (int)$_GET['archive_year']; 
} else { 
	if (comicpress_themeinfo('archive_start_latest_year')) {
		$latest_comic = comicpress_get_terminal_post_in_category(comicpress_all_comic_categories_string(),false); 
	} else {
		$latest_comic = comicpress_get_terminal_post_in_category(comicpress_all_comic_categories_string(),true); 
	}
	$archive_year = get_post_time('Y', false, $latest_comic, true); 
}
if (empty($archive_year)) $archive_year = date('Y');

$firstDayMargins = array();
for ($i = 1; $i <= 12; ++$i) {
	$dateInfo = getdate(mktime(0,0,0,$i,1,$archive_year));
	$firstDayMargins[$i] = $dateInfo['wday'] * $cpdayWidth;
}

$tempPost = $post;
$comicArchive = new WP_Query(); 
if (comicpress_themeinfo('template-comic-year-all-cats')) {
	$comicArchive->query('showposts=-1&posts_per_page=-1&year='.$archive_year);
} else {
	$comicArchive->query('showposts=-1&posts_per_page=-1&cat='.comicpress_all_comic_categories_string().'&year='.$archive_year);
}
while ($comicArchive->have_posts()) : $comicArchive->the_post();
	$calTitle = get_the_title();
	$calLink = get_permalink();
	$calDay = get_the_time('j');
	$calMonth = get_the_time('F');
	$calComic[$calMonth.$calDay] = array('link' => $calLink, 'title' => $calTitle);
endwhile;
$post = $tempPost;

function leapYear($yr) {
	if ($yr % 4 != 0) {
		return 28;
	} else {
		if ($yr % 100 != 0) {
			return 29;
		} else {
			if ($yr % 400 != 0) {
				return 28;
            } else {
				return 29;
			}
		}
	}
}
$leapYear = leapYear($archive_year);

$cpmonth['1'] = array('month' => __('January','comicpress'), 'days' => '31');
$cpmonth['2'] = array('month' => __('February','comicpress'), 'days' => $leapYear);
$cpmonth['3'] = array('month' => __('March','comicpress'), 'days' => '31');
$cpmonth['4'] = array('month' => __('April','comicpress'), 'days' => '30');
$cpmonth['5'] = array('month' => __('May','comicpress'), 'days' => '31');
$cpmonth['6'] = array('month' => __('June','comicpress'), 'days' => '30');
$cpmonth['7'] = array('month' => __('July','comicpress'), 'days' => '31');
$cpmonth['8'] = array('month' => __('August','comicpress'), 'days' => '31');
$cpmonth['9'] = array('month' => __('September','comicpress'), 'days' => '30');
$cpmonth['10'] = array('month' => __('October','comicpress'), 'days' => '31');
$cpmonth['11'] = array('month' => __('November','comicpress'), 'days' => '30');
$cpmonth['12'] = array('month' => __('December','comicpress'), 'days' => '31');

?>
<div <?php post_class(); ?>>
<?php if (comicpress_themeinfo('enable_caps')) { ?><div class="post-head"></div><?php } ?>
	<div class="post-content">
		<div class="post-info">
			<div class="post-text">
				<h2 class="page-title"><?php the_title(); ?> <?php echo $archive_year; ?></h2>
			</div>
		</div>
		<div class="archive-yearlist">| 
<?php $years = $wpdb->get_col("SELECT DISTINCT YEAR(post_date) FROM $wpdb->posts WHERE post_status = 'publish' ORDER BY post_date ASC");
foreach ( $years as $year ) {
				if ($year != (0) ) { ?>	
				<a href="<?php echo add_query_arg('archive_year', $year) ?>"><strong><?php echo $year ?></strong></a> |
			<?php } } ?>
		</div>
		<div class="cpcal-cals">
		<?php $i=1; while($i<=12) { 
			$calendar_directory = comicpress_themeinfo('calendar_directory');
			if (!empty($calendar_directory) && $calendar_directory != 'none') { ?>
				<div class="cpcal-month" style="height: 257px;" id="<?php echo $cpmonth[$i]['month'] ?>">
				<?php if (file_exists(get_stylesheet_directory() . '/images/cal') && $calendar_directory != 'default') { ?>

					<?php if (file_exists(get_stylesheet_directory().'/images/cal/'.$calendar_directory.'/'.$archive_year)) { ?>
						<?php if (count($cpmonthfile = glob(get_stylesheet_directory().'/images/cal/'.$calendar_directory.'/'.$archive_year.'/'.strtolower($cpmonth[$i]['month']).'.*')) > 0) { 
							if (is_array($cpmonthfile)) $cpmonthfile = reset($cpmonthfile); ?>
							<img class="cpcal-image" src="<?php echo get_stylesheet_directory_uri(); ?>/images/cal/<?php echo $calendar_directory; ?>/<?php echo $archive_year; ?>/<?php echo basename($cpmonthfile); ?>" alt="<?php echo $cpmonth[$i]['month'] ?>" title="<?php echo $cpmonth[$i]['month'] ?>" />
						<?php } else { ?>
							<img class="cpcal-image" src="<?php echo get_stylesheet_directory_uri(); ?>/images/cal/default.png" alt="<?php echo $cpmonth[$i]['month'] ?>" title="<?php echo $cpmonth[$i]['month'] ?>" />
						<?php } ?>
					<?php } else { ?>
						<?php if (count($cpmonthfile = glob(get_stylesheet_directory().'/images/cal/'.$calendar_directory.'/'.strtolower($cpmonth[$i]['month']).'.*')) > 0) { 
							if (is_array($cpmonthfile)) $cpmonthfile = reset($cpmonthfile); ?>
							<img class="cpcal-image" src="<?php echo get_stylesheet_directory_uri(); ?>/images/cal/<?php echo $calendar_directory; ?>/<?php echo basename($cpmonthfile); ?>" alt="<?php echo $cpmonth[$i]['month'] ?>" title="<?php echo $cpmonth[$i]['month'] ?>" />				
						<?php } else { ?>
							<img class="cpcal-image" src="<?php echo get_stylesheet_directory_uri(); ?>/images/cal/default.png" alt="<?php echo $cpmonth[$i]['month'] ?>" title="<?php echo $cpmonth[$i]['month'] ?>" />
						<?php } ?>
					<?php } ?>		
				
				<?php } else { ?>
				

					<?php if (file_exists(get_template_directory().'/images/cal/'.$calendar_directory.'/'.$archive_year)) { ?>
						<?php if (count($cpmonthfile = glob(get_template_directory().'/images/cal/'.$calendar_directory.'/'.$archive_year.'/'.strtolower($cpmonth[$i]['month']).'.*')) > 0) { 
							if (is_array($cpmonthfile)) $cpmonthfile = reset($cpmonthfile); ?>
							<img class="cpcal-image" src="<?php echo get_template_directory_uri(); ?>/images/cal/<?php echo $calendar_directory; ?>/<?php echo $archive_year; ?>/<?php echo basename($cpmonthfile); ?>" alt="<?php echo $cpmonth[$i]['month'] ?>" title="<?php echo $cpmonth[$i]['month'] ?>" />
						<?php } else { ?>
							<img class="cpcal-image" src="<?php echo get_template_directory_uri(); ?>/images/cal/default.png" alt="<?php echo $cpmonth[$i]['month'] ?>" title="<?php echo $cpmonth[$i]['month'] ?>" />
						<?php } ?>
					<?php } else { ?>
						<?php if (count($cpmonthfile = glob(get_template_directory().'/images/cal/'.$calendar_directory.'/'.strtolower($cpmonth[$i]['month']).'.*')) > 0) { 
							if (is_array($cpmonthfile)) $cpmonthfile = reset($cpmonthfile); ?>
							<img class="cpcal-image" src="<?php echo get_template_directory_uri(); ?>/images/cal/<?php echo $calendar_directory; ?>/<?php echo basename($cpmonthfile); ?>" alt="<?php echo $cpmonth[$i]['month'] ?>" title="<?php echo $cpmonth[$i]['month'] ?>" />				
						<?php } else { ?>
							<img class="cpcal-image" src="<?php echo get_template_directory_uri(); ?>/images/cal/default.png" alt="<?php echo $cpmonth[$i]['month'] ?>" title="<?php echo $cpmonth[$i]['month'] ?>" />
						<?php } ?>
					<?php } ?>
					
				<?php } ?>
				
			<?php } else { ?>
					<div class="cpcal-month" style="height: 137px;" id="<?php echo $cpmonth[$i]['month'] ?>">
					
			<?php } ?>
						<div class="cpcal-monthtitle"><?php echo $cpmonth[$i]['month']." ".$archive_year ?></div>
				<?php foreach(array("S", "M", "T", "W", "T", "F", "S") as $dow) { ?>
							<div class="cpcal-dayletter"><?php echo $dow ?></div>		
				<?php } ?>
							<div class="clear"></div>
				<?php $cpday=1; while($cpday<=$cpmonth[$i]['days']) {
					if ($cpday == 1) { ?>
						<div style="width:<?php echo $firstDayMargins[$i]; ?>px;height:15px;float:left;"></div>
					<?php } ?>
					<div class="cpcal-day">
						<?php if (isset($calComic[$cpmonth[$i]['month'].$cpday])) { ?>
							<a href="<?php echo $calComic[$cpmonth[$i]['month'].$cpday]['link'] ?>" title="<?php echo $calComic[$cpmonth[$i]['month'].$cpday]['title'] ?>"><?php echo $cpday ?></a>
						<?php } else {
								echo $cpday." ";
						} ?>
					</div>
		<?php ++$cpday;
	}
				++$i ?>
			</div>
		<?php } ?>
		</div>
		<div class="clear"></div>
	</div>
<?php if (comicpress_themeinfo('enable_caps')) { ?><div class="post-foot"></div><?php } ?>
</div>

<?php get_footer() ?>