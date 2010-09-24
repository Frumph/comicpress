<?php
/*
Plugin Name: ComicPress WPMU Functionality
Plugin URI: http://webcomicplanet.com/
Description: Provide the functionality to use ComicPress and ComicPress Manager on a WordPress MU site.
Version: 1.0
Author: John Bintz
Author URI: http://www.coswellproductions.org/wordpress/

Copyright 2008 John Bintz  (email : jcoswell@coswellproductions.org), All Rights Reserved.
*/

/* Functions for ComicPress Themes */

if (get_option('upload_path') !== false) {
	$variables_to_extract = array();
	
	foreach (array(
		'comiccat'            => 'comiccat',
		'blogcat'             => 'blogcat',
		'comics_path'         => 'comic_folder',
		'comicsrss_path'      => 'rss_comic_folder',
		'comicsarchive_path'  => 'archive_comic_folder',
		'comicsmini_path'     => 'mini_comic_folder',
		'archive_comic_width' => 'archive_comic_width',
		'rss_comic_width'     => 'rss_comic_width',
		'mini_comic_width'    => 'mini_comic_width',
		'blog_postcount'      => 'blog_postcount') as $options => $variable_name) {
		$variables_to_extract[$variable_name] = cp_option($option);
	}
	
	extract($variables_to_extract);
}

/**
 * Fix the search path for comics.
 */
function cpm_wpmu_fix_folder_to_use($folder) {
	$wpmu_path = get_option('upload_path');
	if (!empty($wpmu_path)) {
		$folder = get_option('siteurl') . '/files';
	}
  return $folder;
}

/**
 * Fix the search path for comics.
 */
function cpm_wpmu_fix_comic_path($comic) {
	if (($wpmu_path = get_option('upload_path')) !== false) {
		$comic = str_replace($wpmu_path, "files", $comic); 
	}
  return $comic;
}

/* Functions for ComicPress Manager */

function cp_option($name) { return get_option("comicpress-${name}"); }

/**
 * Add additional parameters to every ComicPress Manager object created.
 */
function cpm_wpmu_config_setup($cpm_config) {
  $cpm_config->wpmu_disk_space_message = __("<strong>You've exceeded your disk space quota!</strong> Either delete files you don't need, or find out how to get more disk space for your account.", 'comicpress-manager');
}

/**
 * Add WPMU path information to the document root.
 */
function cpm_wpmu_modify_path($document_root) {
	$result = get_option('upload_path');
	$root_path = str_replace('\wp-admin','',getcwd());
	$root_path = str_replace('/wp-admin','',$root_path); 
	if (!empty($result)) { $document_root = $root_path . '/' . $result; }
	return $document_root;
}

/**
 * Load ComicPress options from the options table.
 */
function cpm_wpmu_load_options() {
  global $cpm_config;

  include(ABSPATH . 'wp-content/plugins/comicpress-manager/cp_configuration_options.php');

  foreach ($comicpress_configuration_options as $field_info) {
    $config_id = (isset($field_info['variable_name'])) ? $field_info['variable_name'] : $field_info['id'];

    $result = cp_option($field_info['id']);

    if ($result === false) {
      update_option("comicpress-" . $field_info['id'], $field_info['default']);
      $result = $field_info['default'];
    }

    $cpm_config->properties[$config_id] = $result;
  }
}

/**
 * Save ComicPress options to the options table.
 */
function cpm_wpmu_save_options() {
  global $cpm_config;

  include(ABSPATH . 'wp-content/plugins/comicpress-manager/cp_configuration_options.php');

  foreach ($comicpress_configuration_options as $field_info) {
    $config_id = (isset($field_info['variable_name'])) ? $field_info['variable_name'] : $field_info['id'];

    update_option("comicpress-" . $field_info['id'], $cpm_config->properties[$config_id]);
  }
}

/**
 * Return the first run directory.
 */
function cpm_wpmu_first_run_root_dir() {
  global $blog_id;

  return "wp-content/blogs.dir/${blog_id}";
}

/**
 * Get the list of directories to create.
 */
function cpm_wpmu_first_run_dir_list() {
  $root_dir = ABSPATH . cpm_wpmu_first_run_root_dir();

  return array("$root_dir",
               "$root_dir/files",
               "$root_dir/files/comics",
               "$root_dir/files/comics-rss",
               "$root_dir/files/comics-archive",
				"$root_dir/files/comics-mini");
}

/**
 * Action to perform on the end of the first run.
 */
function cpm_wpmu_complete_first_run() {
  update_option("upload_path", cpm_wpmu_first_run_root_dir() . "/files");
}

/**
 * Get the available disk space for this account.
 */
function cpm_wpmu_get_available_disk_space() {
  $space_allowed = 1048576 * get_space_allowed();
  $space_used = get_dirsize( constant( "ABSPATH" ) . constant( "UPLOADS" ) );
  return $space_allowed - $space_used;
}

/**
 * Returns true if current blog is over storage limit.
 */
function cpm_wpmu_is_over_storage_limit() {
  return cpm_wpmu_get_available_disk_space() < 0;
}

?>