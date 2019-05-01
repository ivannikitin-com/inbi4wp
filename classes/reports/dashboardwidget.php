<?php
/**
 * Google Data Studio Reports For WordPress
 * Class DashboardWidget implements reports as dashboard widgets
 */
namespace INBI4WP\Reports;
use INBI4WP\Plugin as Plugin;
use INBI4WP\ReportManager as ReportManager;

class DashboardWidget extends Base
{
	/**
	 * @const SLUG	Widdet Slug
	 */
	const SLUG = 'inbi4wp_widget_';
	
	/**
	 * @const DEFAULT_HEIGHT Default of Report Height
	 */
	const DEFAULT_HEIGHT = '400px';	
	
	/**
	 * Returns Report Type Title
	 * @static
	 * @return string
	 */
	static public function getTitle()
	{
		return __( 'Dashboard Widget Report', Plugin::TEXTDOMAIN );
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
		// Add a widget to the dashboard.
		add_action( 'wp_dashboard_setup', __CLASS__ . '::addWidgets' );
	}

	/**
	 * Add widgets to dashboard
	 * @static
	 */
	static public function addWidgets()
	{
		foreach( Base::getAllReport( __CLASS__ ) as $report ) 
		{
			wp_add_dashboard_widget(
				self::SLUG . $report['id'],	// Widget slug
				$report['title'],			// Title.
				__CLASS__ . '::showReport',	// Display function
				null,						// Control callback function
				$report['id']				// Callback args
			);
		}		
	}

	/**
	 * Show Report Widdet
	 * @param string	$var	The args are stored in the 2nd variable passed to callback function
	 * @param mixed		$args	Callback args
	 * @static
	 */
	static public function showReport( $var, $args )
	{
		$report = new static( $args[ 'args' ] );
		$report->reportRender();
	}
}