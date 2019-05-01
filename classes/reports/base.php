<?php
/**
 * Google Data Studio Reports For WordPress
 * Class Base implements basic capabilities for all reports
 */
namespace INBI4WP\Reports;
use INBI4WP\Plugin as Plugin;
use INBI4WP\ReportManager as ReportManager;
use \WP_Query as WP_Query;

class Base
{
	/**
	 * @const META_URL Meta Field of Report URL
	 */
	const META_URL = '_inbi4wp_report_url';
	
	/**
	 * @const META_WIDTH Meta Field of Report width
	 */
	const META_WIDTH = '_inbi4wp_report_width';
	
	/**
	 * @const META_HEIGHT Meta Field of Report Height
	 */
	const META_HEIGHT = '_inbi4wp_report_height';
	
	/**
	 * @const DEFAULT_WIDTH Default Report width
	 */
	const DEFAULT_WIDTH = '100%';
	
	/**
	 * @const DEFAULT_HEIGHT Default of Report Height
	 */
	const DEFAULT_HEIGHT = '100%';	

	/**
	 * @const FIELD_URL Form Field "Report URL"
	 */
	const FIELD_URL = 'inbi4wp-report-url';
	
	/**
	 * @const FIELD_WIDTH Form Field "Report width"
	 */
	const FIELD_WIDTH = 'inbi4wp-report-width';	

	/**
	 * @const FIELD_HEIGHT Form Field "Report height"
	 */
	const FIELD_HEIGHT = 'inbi4wp-report-height';
	
	/**
	 * @const CACHE_REPORTS	cache reports array
	 */
	const CACHE_REPORTS = 'inbi4wp_cache_report_ids';	
	

	/**
	 * Report ID
	 */
	public $id;

	/**
	 * Report URL
	 */
	public $url;
	
	/**
	 * Report width
	 */
	public $width;

	/**
	 * Report height
	 */
	public $height;
	
	/**
	 * Handle the init WP event
	 * Need for add hooks
	 * @static
	 */
	static public function init()
	{
		add_action( 'admin_enqueue_scripts', __CLASS__ . '::addJSData' );
	}

	/**
	 * Returns ids of all reports by report type
	 * @static
	 * @param string	$reportType		Type of report
	 * @return mixed
	 */
	static public function getAllReport( $reportType )
	{
		// Add \ in the begin of $reportType
		if ( $reportType{0} !== '\\' )
			$reportType = '\\' . $reportType;
		
		// Check the cache
		$reports = wp_cache_get( self::CACHE_REPORTS );
		if ( $reports && isset( $reports[ $reportType ] ) )
			return $reports[ $reportType ];		
		
		// New report types array
		if ( ! is_array( $reports ) )
			$reports = array();
		
		// WP_Query arguments
		$args = array(
			'post_type'		=> array( ReportManager::CPT ),
			'orderby'		=> 'menu_order',
			'meta_query'	=> array(
				array(
					'key'	=> ReportManager::META_TYPE,
					'value'	=> $reportType,
				),
			),
			'nopaging'					=> true,
			'cache_results'				=> true,
			'update_post_meta_cache'	=> true,
		);

		// The Query
		$query = new WP_Query( $args );
		
		// Populate array
		$reportsIds = array();
		if ( $query->posts )
		{
			foreach ($query->posts as $post)
			{
				$reportsIds[] = array(
					'id'	=> $post->ID,
					'title'	=> $post->post_title,
				);
			}			
		}
		
		// Cache results
		$reports[ $reportType ] = $reportsIds;
		wp_cache_set( self::CACHE_REPORTS, $reports );
		
		// Results
		return $reportsIds;
	}

	/**
	 * Add some reports data to JS view
	 * @static
	 */
	static public function addJSData()
	{
		$reportsData = array();
		foreach ( Plugin::get()->reportManager->reportTypes as $reportClass => $reportTitle )
		{
			$reportsData[ $reportClass ] = array(
				'defaultWidth'	=> $reportClass::DEFAULT_WIDTH,
				'defaultHeight'	=> $reportClass::DEFAULT_HEIGHT,
			);
		}
		wp_localize_script( 'jquery', 'inbi4wp_reportsData', $reportsData );
	}

	/**
	 * Constructor
	 * @param int	$id		Report ID 
	 */
	public function __construct( $id = 0 )
	{
		$this->id = $id;
		$this->url 		= ( $this->id > 0 ) ? get_post_meta( $this->id, self::META_URL, true ) : '';
		$this->width 	= ( $this->id > 0 ) ? get_post_meta( $this->id, self::META_WIDTH, true ) : static::DEFAULT_WIDTH;
		$this->height 	= ( $this->id > 0 ) ? get_post_meta( $this->id, self::META_HEIGHT, true ) : static::DEFAULT_HEIGHT;
		
		if ( empty( $this->width ) )
			$this->width = static::DEFAULT_WIDTH;
		
		if ( empty( $this->height ) )
			$this->height = static::DEFAULT_HEIGHT;	
		
	}

	/**
	 * Show Metabox of Report
	 */
	public function metaBoxRender()
	{
		// Show Metabox
		include( Plugin::get()->dir . 'views/reports/base/metaboxrender.php');
	}

	/**
	 * Save Metabox Data of Report
	 * @param int	$post_id	ID of WP Post
	 */
	public function metaBoxSave( $post_id )
	{
		$url = ( isset( $_POST[ self::FIELD_URL ] ) ) ? sanitize_text_field( $_POST[ self::FIELD_URL ] ) : '';
		update_post_meta( $post_id, self::META_URL, $url );
		
		$width = ( isset( $_POST[ self::FIELD_WIDTH ] ) ) ? sanitize_text_field( $_POST[ self::FIELD_WIDTH ] ) : static::DEFAULT_WIDTH;
		update_post_meta( $post_id, self::META_WIDTH, $width );
		
		$height = ( isset( $_POST[ self::FIELD_HEIGHT ] ) ) ? sanitize_text_field( $_POST[ self::FIELD_HEIGHT ] ) : static::DEFAULT_HEIGHT;
		update_post_meta( $post_id, self::META_HEIGHT, $height );

		// Clear report caches
		wp_cache_delete( self::CACHE_REPORTS );		
	}
	
	/**
	 * Show report
	 */
	public function reportRender()
	{
		if ( ! empty( $this->url ) )
		{
			$view = 'views/' . str_replace( '\\', '/', str_replace( 'inbi4wp\\', '', strtolower( get_class( $this ) ) ) ) . '/reportrender.php';
			include( Plugin::get()->dir . $view );
		}
		else
		{
			echo '<h2>'; 
			esc_html_e( 'Warning! Report URL is empty!', Plugin::TEXTDOMAIN );
			echo '</h2>';
		}
	}	
}