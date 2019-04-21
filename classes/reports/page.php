<?php
/**
 * Google Data Studio Reports For WordPress
 * Class Plugin
 */
namespace INBI4WP\Reports;
use INBI4WP\Plugin as Plugin;

class Page extends Base
{
	/**
	 * @const SLUG	Admin Page Slug
	 */
	const SLUG = 'inbi4wp_report_';	
	
	/**
	 * Returns Report Type Title
	 * @static
	 * @return string
	 */
	static public function getTitle()
	{
		return __( 'Admin Page Report', Plugin::TEXTDOMAIN );
	}
	
	/**
	 * Returns Report URL by ID
	 * @static
	 * @param int	$id	Report ID
	 * @return string
	 */
	static public function getURL( $id )
	{
		return '';
	}
	
	

	/**
	 * Constructor
	 * @param Plugin	$plugin	Plugin instance
	 */
	public function __construct( $plugin )
	{
		parent::__construct( $plugin );

	}

	/**
	 * Show Metabox of Report
	 */
	public function metaBoxRender()
	{
		parent::metaBoxRender();
		// Show Metabox
		//include( $this->plugin->dir . 'views/reports/base/metaboxrender.php');
	}

	/**
	 * Save Metabox Data of Report
	 * @param int	$post_id	ID of WP Post
	 */
	public function metaBoxSave( $post_id )
	{
		parent::metaBoxSave( $post_id );
	}	
}