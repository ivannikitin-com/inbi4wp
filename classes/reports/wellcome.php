<?php
/**
 * Google Data Studio Reports For WordPress
 * Class Wellcome implements reports as dashboard Wellcome widget
 * https://www.wpexplorer.com/custom-wordpress-welcome-message/
 */
namespace INBI4WP\Reports;
use INBI4WP\Plugin as Plugin;
use INBI4WP\ReportManager as ReportManager;

class Wellcome extends Base
{
	/**
	 * @const DEFAULT_HEIGHT Default of Report Height
	 */
	const DEFAULT_HEIGHT = '200px';	
	
	/**
	 * Returns Report Type Title
	 * @static
	 * @return string
	 */
	static public function getTitle()
	{
		return __( 'Dashboard Wellcome Report', Plugin::TEXTDOMAIN );
	}
	
	/**
	 * Returns Report URL by ID -- all reports have one URL
	 * @static
	 * @param int	$id	Report ID
	 * @return string
	 */
	static public function getURL( $id )
	{
		return '/wp-admin/index.php';
	}	
	
	/**
	 * Handle the init WP event
	 * Need for add hook
	 * @static
	 */
	static public function init()
	{
		// Have we Dashboard Wellcome reports?
		$reports = Base::getAllReport( __CLASS__ );
		if ( ! empty( $reports ) ) 
		{
			// Remove standart welcome panel
			remove_action( 'welcome_panel', 'wp_welcome_panel' );
			// Add new welcome panel
			add_action( 'welcome_panel', __CLASS__ . '::showReport' );
		}
	}
	
	/**
	 * Show Report Widget
	 * @static
	 */
	static public function showReport()
	{
		$reports = Base::getAllReport( __CLASS__ );
		// Get the 1st report
		$report = new static( $reports[0]['id'] );
		$report->reportRender();
	}	
}