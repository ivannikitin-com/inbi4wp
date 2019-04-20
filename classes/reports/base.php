<?php
/**
 * Google Data Studio Reports For WordPress
 * Class Plugin
 */
namespace INBI4WP\Reports;
use INBI4WP\Plugin as Plugin;

class Base
{
	/**
	 * @const META_URL Meta Field of Report URL
	 */
	const META_URL = '_inbi4wp_report_url';

	/**
	 * Instance of plugin
	 */
	private $plugin;

	/**
	 * Report ID
	 */
	public $id;

	/**
	 * Report URL
	 */
	public $url;

	/**
	 * Constructor
	 * @param Plugin	$plugin	Plugin instance
	 */
	public function __construct( $plugin )
	{
		$this->plugin = $plugin;		
		$this->id = (int) sanitize_key( $_GET['post'] );
		$this->url = get_post_meta( $this->id, self::META_URL, true );
	}

	/**
	 * Show Metabox of Report
	 */
	public function metaBoxRender()
	{
		// Show Metabox
		include( $this->plugin->dir . 'views/reports/base/metaboxrender.php');
	}

	/**
	 * Save Metabox Data of Report
	 */
	public function metaBoxSave( )
	{
		
	}
}