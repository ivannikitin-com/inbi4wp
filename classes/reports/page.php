<?php
/**
 * Google Data Studio Reports For WordPress
 * Class Page
 */
namespace INBI4WP\Reports;
use INBI4WP\Plugin as Plugin;
use INBI4WP\ReportManager as ReportManager;
use \WP_Query as WP_Query;

class Page extends Base
{
	/**
	 * @const SLUG	Admin Page Slug
	 */
	const SLUG = 'inbi4wp_report_';
	
	/**
	 * @const CACHE_REPORTS	cache reports array
	 */
	const CACHE_REPORTS = 'inbi4wp_cache_reports';
	
	
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
	 * Need for add hook to admin_meny
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
		foreach( self::getAllReport() as $report ) 
		{
			add_submenu_page(
				'edit.php?post_type=' . ReportManager::CPT,
				$report['title'],
				$report['title'],
				'manage_options',
				self::SLUG . $report['id'],
				__CLASS__ . '::showReport'
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
	 * Returns ids of all page reports
	 * @static
	 * @return mixed
	 */
	static public function getAllReport()
	{
		$reports = wp_cache_get( self::CACHE_REPORTS );
		if ( $reports )
			return $reports;
		
		$reports = array();
		
		// WP_Query arguments
		$args = array(
			'post_type'		=> array( 'inbi4wp_report' ),
			'orderby'		=> 'menu_order',
			'meta_query'	=> array(
				array(
					'key'	=> '_inbi4wp_report_type',
					'value'	=> '\INBI4WP\Reports\Page',
				),
			),
			'nopaging'					=> true,
			'cache_results'				=> true,
			'update_post_meta_cache'	=> true,
		);

		// The Query
		$query = new WP_Query( $args );
		
		if ( $query->posts )
		{
			foreach ($query->posts as $post)
			{
				$reports[] = array(
					'id'	=> $post->ID,
					'title'	=> $post->post_title,
				);
			}			
		}
		
		wp_cache_set( self::CACHE_REPORTS, $reports );
		return $reports;
	}

	/**
	 * Save Metabox Data of Report
	 * @param int	$post_id	ID of WP Post
	 */
	public function metaBoxSave( $post_id )
	{
		parent::metaBoxSave( $post_id );
		wp_cache_delete( self::CACHE_REPORTS );
	}
	
	/**
	 * Show report
	 */
	public function reportRender()
	{
		if ( ! empty( $this->url ) )
		{
			include( Plugin::get()->dir . 'views/reports/page/reportrender.php' );
		}
		else
		{
			echo '<h2>'; 
			esc_html_e( 'Warning! Report URL is empty!', Plugin::TEXTDOMAIN );
			echo '</h2>';
		}
	}
}