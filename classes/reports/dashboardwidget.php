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
	 * Returns Report Type Title
	 * @static
	 * @return string
	 */
	static public function getTitle()
	{
		return __( 'Dashboard Widget Report', Plugin::TEXTDOMAIN );
	}
	
	/**
	 * Handle the init WP event
	 * Need for add hook
	 * @static
	 */
	static public function init()
	{

	}

	/**
	 * Returns Report URL by ID
	 * @static
	 * @param int	$id	Report ID
	 * @return string
	 */
	static public function getURL( $id )
	{
		return '/wp-admin/index.php';
	}	
}