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
	 * @const FIELD_URL Form Field "Report URL"
	 */
	const FIELD_URL = 'inbi4wp-report-url';

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
	 * @param int	$id	ID отчета
	 */
	public function __construct( $id = 0 )
	{
		$this->id = $id;
		$this->url = ( $this->id > 0 ) ? get_post_meta( $this->id, self::META_URL, true ) : '';
		var_dump( $this->id, $this->url );
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
	}
}