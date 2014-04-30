<?php
/**
 * Plugin Name: Thesis Importer
 * Plugin URI: http://github.com/ITPNYU/thesis-importer
 * Description: Wordpress plugin for importing ITP theses as posts
 * Version: 1.0
 * Author: NYU ITP
 * Author URI: http://itp.nyu.edu
 * License: GPLv3
 */

require 'ti-util.php';

register_activation_hook( __FILE__, 'ti_setup');
add_action('admin_init', 'ti_settings');
add_action('admin_menu', 'ti_menu');

function ti_menu() {
  $page_hook = add_management_page( 'Thesis Importer', 'Thesis Importer', 'manage_options', 'thesis-importer', 'ti_page');
}

function ti_page() {
  include plugin_dir_path(__FILE__) . '/html/tiPage.php';
}

function ti_setup() {
  add_option('ti_export_url');
}

function ti_setting_callback($arg) {
  $option_name = $arg[0];
  $option_data = get_option($option_name);
  echo "<input type=\"text\" name=\"$option_name\" value=\"$option_data\" />";
}

function ti_settings() {
  add_settings_section('ti_section',
    'Thesis Importer Settings',
    'ti_section',
    'general'
  );

  add_settings_field('ti_export_url',
    'Thesis Export URL',
    'ti_setting_callback',
    'general',
    'ti_section',
    array('ti_export_url')
  );

  register_setting('general', 'ti_export_url');
}
