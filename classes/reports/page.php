<?php
/**
 * Google Data Studio Reports For WordPress
 * Class Page implements reports as admin pages
 */
namespace INBI4WP\Reports;
use INBI4WP\Plugin as Plugin;
use INBI4WP\ReportManager as ReportManager;

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
		return '/wp-admin/edit.php?post_type=' . ReportManager::CPT . '&page=' . self::SLUG . $id;
	}
	
	/**
	 * Handle the init WP event
	 * Need for add hook to admin_menu
	 * @static
	 */
	static public function init()
	{
		add_action('admin_menu', __CLASS__ . '::showReports');
	}	
	
	/**
	 * Handle the init WP event
	 * Need for add hook to admin_meny
	 * @static
	 */
	static public function showReports()
	{
		$menuOrder = 0;
		foreach( Base::getAllReport( __CLASS__ ) as $report ) 
		{
			add_submenu_page(
				'edit.php?post_type=' . ReportManager::CPT,
				$report['title'],
				$report['title'],
				'read',
				self::SLUG . $report['id'],
				__CLASS__ . '::showReport',
				$menuOrder++
			);
		}
	}
	
	/**
	 * Show Report Page
	 * @static
	 */
	static public function showReport()
	{
		if ( ! isset( $_GET[ 'page' ] ) )
			return;
		
		$page = sanitize_key( $_GET[ 'page' ] );
		$id = (int) str_replace( self::SLUG, '', $page );
		$report = new static( $id );
		$report->reportRender();
	}
	
	/**
	 * Add new report
	 * @param sgtring	$url		Report URL 	 
	 * @param sgtring	$title		Report title
	 * @return int post_id
	 */	
	static public function add( $url, $title )
	{
		return Base::addReport( $url, $title, '\\' . __CLASS__, Base::DEFAULT_WIDTH, Base::DEFAULT_HEIGHT );
	}
}