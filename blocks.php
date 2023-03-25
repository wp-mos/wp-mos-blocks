<?php

/**
 * Plugin Name:       Mos Blocks
 * Theme URI: https: //github.com/wp-mos/wp-mos-blocks
 * Author: Harpoon Team
 * Author URI: https://harpoon.ro/
 * Description:       A plugin for adding custom blocks to Mos Theme.
 * Version:           1.0.0
 * Requires at least: 5.9
 * Requires PHP:      7.2
 * Text Domain:       /mos
 * Domain Path:       /languages
 */

if (!function_exists('add_action')) {
	echo 'Seems like you stumbled here by accident. 😛';
	exit;
}

// Setup
define('MOS_PLUGIN_DIR', plugin_dir_path(__FILE__));

// Includes
$rootFiles         = glob(MOS_PLUGIN_DIR . 'includes/*.php');
$subdirectoryFiles = glob(MOS_PLUGIN_DIR . 'includes/**/*.php');
$allFiles          = array_merge($rootFiles, $subdirectoryFiles);

foreach ($allFiles as $filename) {
	include_once($filename);
}

// Filters
  add_filter('block_categories_all', 'mos_register_blocks_category');

// Hooks
  add_action('init', 'mos_register_blocks');
