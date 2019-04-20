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
	 * Returns report type title
	 * @static
	 * @return string
	 */
	static public function getTitle()
	{
		return __( 'Admin Page Report', Plugin::TEXTDOMAIN );
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