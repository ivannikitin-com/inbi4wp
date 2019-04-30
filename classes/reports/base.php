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
	 * Constructor
	 * @param int	$id	ID отчета
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
	}
}