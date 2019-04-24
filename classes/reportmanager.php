<?php
/**
 * Google Data Studio Reports For WordPress
 * Class ReportManager
 */
namespace INBI4WP;

class ReportManager
{
	/**
	 * @const CPT Custom Post Type for Report
	 */
	const CPT = 'inbi4wp_report';

	/**
	 * @const META_TYPE Meta Field "Type of Report"
	 */
	const META_TYPE = '_inbi4wp_report_type';

	/**
	 * @const Nonce field
	 */
	const NONCE = 'inbi4wp_nonce';

	/**
	 * @const FIELD_TYPE Form Field "Type of Report"
	 */
	const FIELD_TYPE = 'inbi4wp-report-type';
	
	/**
	 * @const COLUMN_TYPE Table column "Type of Report"
	 */
	const COLUMN_TYPE = 'type';	
	
	/**
	 * Array of avaliable report types and classes
	 */
	private $reportTypes;

	/**
	 * Current Report
	 */
	private $currentReport;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		// Avaliable report types and classes
		$this->reportTypes = array(
			'\INBI4WP\Reports\Page'	=>	Reports\Page::getTitle(),
		);

		// Register CPT
		$this->registerCPT();

		// Row actions https://wp-kama.ru/hook/post_row_actions
		add_filter( 'post_row_actions', array( $this, 'modifyRowActions' ), 10, 2 );


		// Add and handle meta_box
		add_action( 'add_meta_boxes', array( $this, 'metaBoxAdd' ) );
		add_action( 'save_post', array( $this, 'metaBoxSave' ) );
		
		// Add and handle table column
		add_filter( 'manage_' . self::CPT . '_posts_columns',  array( $this, 'tableColumnAdd' ) );
		add_action( 'manage_' . self::CPT . '_posts_custom_column', array( $this, 'tableColumnRender' ), 10, 2 );

		// Current Report
		$this->currentReport = $this->getReport();
		
		// Init reports classes
		foreach ( array_keys( $this->reportTypes ) as $class )
		{
			$class::init();
		}
	}
	
	/**
	 * Registration of CPT
	 */
	private function registerCPT()
	{
		$labels = array(
			'name'                  => _x( 'Reports', 'Post Type General Name', Plugin::TEXTDOMAIN ),
			'singular_name'         => _x( 'Report', 'Post Type Singular Name', Plugin::TEXTDOMAIN ),
			'menu_name'             => __( 'BI Reports', Plugin::TEXTDOMAIN ),
			'name_admin_bar'        => __( 'BI Reports', Plugin::TEXTDOMAIN ),
			'archives'              => __( 'Reports Archives', Plugin::TEXTDOMAIN ),
			'attributes'            => __( 'Report Attributes', Plugin::TEXTDOMAIN ),
			'parent_item_colon'     => __( 'Parent Report:', Plugin::TEXTDOMAIN ),
			'all_items'             => __( 'All Reports', Plugin::TEXTDOMAIN ),
			'add_new_item'          => __( 'Add New Report', Plugin::TEXTDOMAIN ),
			'add_new'               => __( 'Add New', Plugin::TEXTDOMAIN ),
			'new_item'              => __( 'New Report', Plugin::TEXTDOMAIN ),
			'edit_item'             => __( 'Edit Report', Plugin::TEXTDOMAIN ),
			'update_item'           => __( 'Update Report', Plugin::TEXTDOMAIN ),
			'view_item'             => __( 'View Report', Plugin::TEXTDOMAIN ),
			'view_items'            => __( 'View Reports', Plugin::TEXTDOMAIN ),
			'search_items'          => __( 'Search Reports', Plugin::TEXTDOMAIN ),
			'not_found'             => __( 'Not found', Plugin::TEXTDOMAIN ),
			'not_found_in_trash'    => __( 'Not found in Trash', Plugin::TEXTDOMAIN ),
			'featured_image'        => __( 'Featured Image', Plugin::TEXTDOMAIN ),
			'set_featured_image'    => __( 'Set featured image', Plugin::TEXTDOMAIN ),
			'remove_featured_image' => __( 'Remove featured image', Plugin::TEXTDOMAIN ),
			'use_featured_image'    => __( 'Use as featured image', Plugin::TEXTDOMAIN ),
			'insert_into_item'      => __( 'Insert into report', Plugin::TEXTDOMAIN ),
			'uploaded_to_this_item' => __( 'Uploaded to this reports', Plugin::TEXTDOMAIN ),
			'items_list'            => __( 'Reports list', Plugin::TEXTDOMAIN ),
			'items_list_navigation' => __( 'Reports list navigation', Plugin::TEXTDOMAIN ),
			'filter_items_list'     => __( 'Filter reports list', Plugin::TEXTDOMAIN ),
		);
		$args = array(
			'label'                 => __( 'Report', Plugin::TEXTDOMAIN ),
			'description'           => __( 'Google Data Studio Reports', Plugin::TEXTDOMAIN ),
			'labels'                => $labels,
			'supports'              => array( 'title' ),
			'hierarchical'          => false,
			'public'                => false,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 3,
			'menu_icon'             => 'dashicons-chart-area',
			'show_in_admin_bar'     => false,
			'show_in_nav_menus'     => false,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'page',
		);
		register_post_type( self::CPT, $args );
	}

	/**
	 * Returns the instance of Report Object
	 * return Reports\Base
	 */
	public function getReport()
	{
		// Read Existing Report
		if ( $_GET['action'] == 'edit' && isset( $_GET['post'] ) )
		{
			$id = (int) sanitize_key( $_GET['post'] );
			$class = get_post_meta( $id, self::META_TYPE, true );
			if ( !empty( $class ) && array_key_exists( $class, $this->reportTypes ) )
			{
				return new $class( $id );
			}
		}
		
		// Create New Report
		$class = array_keys( $this->reportTypes )[0];
		return new $class();
	}

	/**
	 * Returns Modified row_actions array
	 * return @mixed
	 */
	public function modifyRowActions( $actions, $post )
	{
		unset( $actions[ 'inline hide-if-no-js' ] );
		
		$reportType = get_post_meta( $post->ID, self::META_TYPE, true );
		try
		{
			$actions[ 'view' ] = '<a href="' . $reportType::getURL( $post->ID ) . '" rel="bookmark"' . 
				'aria-label="' . esc_attr( $post->title ) .  '">' . 
				esc_html__( 'View Report', Plugin::TEXTDOMAIN ) . '</a>';
		}
		catch ( \Extension $ex)
		{
			unset( $actions[ 'view' ] );
		}
		
		return $actions;
	}

	/**
	 * Add Metabox of Report
	 */
	public function metaBoxAdd()
	{
		add_meta_box( self::CPT . '_metabox', 
			__( 'Report Properties', Plugin::TEXTDOMAIN ), 
			array( $this, 'metaBoxRender' ), 
			array( self::CPT ) );		
	}

	/**
	 * Show Metabox of Report
	 */
	public function metaBoxRender()
	{
		// Nonce field
		wp_nonce_field( Plugin::get()->dir, self::NONCE );

		// current Report Type
		$reportType = get_post_meta( $this->currentReport->id, self::META_TYPE, true );

		// Show Metabox
		include( Plugin::get()->dir . 'views/reportmanager/metaboxrender.php');
		
		// Show Report Metabox
		$this->currentReport->metaBoxRender();
	}

	/**
	 * Save Metabox Data of Report НЕ РАБОТАЕТ!!!!
	 * @param int	$post_id	ID of WP Post
	 */
	public function metaBoxSave( $post_id )
	{
		// Have we our fields?
		if ( ! isset( $_POST[ self::FIELD_TYPE ] ) )
			return;

		// Nonce verification
		if ( ! wp_verify_nonce( $_POST[ self::NONCE ], Plugin::get()->dir->dir ) )
			return;
	
		// Is it autosave?
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return;

		// Can user write data?
		if( ! current_user_can( 'edit_post', $post_id ) )
			return;	

		// Save data
		$reportType = sanitize_text_field( $_POST[ self::FIELD_TYPE ] );
		update_post_meta( $post_id, self::META_TYPE, $reportType );

		// Save Report Specific Data
		$this->currentReport->metaBoxSave( $post_id );
	}

	/**
	 * Add new column
	 * @param mixed	$columns	Array of Columns
	 */
	public function tableColumnAdd( $columns )
	{
		unset( $columns[ 'date' ] );
		$columns[ self::COLUMN_TYPE ] = __( 'Report Type', Plugin::TEXTDOMAIN );
		$columns[ 'date' ] = __( 'Report Date', Plugin::TEXTDOMAIN );
		return $columns;
	}
	
	/**
	 * Show data in new column
	 * @param string	$column_name	column name
	 * @param int	$post_id	Post ID
	 */
	public function tableColumnRender( $column_name, $post_id )
	{
		if( $column_name === self::COLUMN_TYPE )
		{
			$reportType = get_post_meta( $post_id, self::META_TYPE, true );
			echo esc_html( $this->reportTypes[ $reportType ] );
		}
	}	
}