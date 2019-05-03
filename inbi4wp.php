<?php
/**
 * Plugin Name: INBI4WP
 * Plugin URI:  https://ivannikitin-com.github.io/inbi4wp/
 * Description: Adds any Google Data Studio Reports to the WordPress admin
 * Version:     1.0
 * Author:      Ivan Nikitin & Co.
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
require( 'classes/installer.php' );
require( 'classes/reports/base.php' );
require( 'classes/reports/page.php' );
require( 'classes/reports/dashboardwidget.php' );
require( 'classes/reports/welcome.php' );

/* Run plugin */
\INBI4WP\Plugin::get(  __FILE__ );
