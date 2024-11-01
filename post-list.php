<?php
/*
Plugin Name:  Show Posts list – Easy designs, filters and more
Description: Enhance your website with our post list plugin, featuring a carefully crafted template design and a convenient shortcode for effortless integration. Elevate your content presentation and user experience seamlessly.
Version: 1.1.0
Requires at least: 4.7
Tested up to: 6.5.5
Author: Swati Agarwal
Plugin URI: https://swatiagarwal.info/show-posts-list-easy-designs-filters-and-more/
Author URI: https://swatiagarwal.info/
License: GPL2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


function swift_plugin_settings_link($links) {
  $settings_link = '<a href="' . admin_url('options-general.php?page=swiftpost-list-settings') . '">' . __("Settings", "show-posts-shortcodes") . '</a>';
    array_unshift($links, $settings_link);
    return $links;
}

$swift_plugin = plugin_basename(__FILE__);
add_filter("plugin_action_links_$swift_plugin", 'swift_plugin_settings_link');

// Include the form submission check file
require_once(plugin_dir_path(__FILE__) . 'post-list-design.php');