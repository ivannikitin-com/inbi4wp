<?php
/**
 * Plugin Name: Google Data Studio Reports For WordPress
 * Plugin URI:  https://ivannikitin-com.github.io/inbi4wp/
 * Description: Placing any Google Data Studio reports in the admin WordPress
 * Version:     1.0
 * Author:      Ivan Nikitin
 * Author URI:  https://ivannikitin.com/
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: inbi4wp
 * Domain Path: /languages
 */
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/* Pligin files */
require( 'classes/plugin.php' );
require( 'classes/reportmanager.php' );
require( 'classes/reports/base.php' );
require( 'classes/reports/page.php' );

/* Run plugin */
new \INBI4WP\Plugin( plugin_dir_path( __FILE__ ) );
