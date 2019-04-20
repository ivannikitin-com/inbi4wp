<?php
/**
 * Google Data Studio Reports For WordPress
 * Class Plugin
 */
namespace INBI4WP;

class Plugin
{
	/**
	 * @const TEXTDOMAIN Text domain
	 */
	const TEXTDOMAIN = 'inbi4wp';
	
	/**
	 * @const LANG Translations folder
	 */
	const LANG = 'languages';	
	
	/**
	 * Plugin folder
	 * @var string
	 */
	public $dir = '';
	
	/**
	 * Instance of ReportManager
	 * @var string
	 */
	public $reportManager;	
	
	/**
	 * Constructor
	 * @param string	$pluginDir	Plugin Folder
	 */
	public function __construct( $pluginDir )
	{
		$this->dir = $pluginDir;
		add_action( 'plugins_loaded', array( $this, 'loadTextDomain' ) );
		add_action( 'init', array( $this, 'init' ) );
	}
	
	/**
	 * Load textdomain
	 */
	public function loadTextDomain()
	{
		load_plugin_textdomain( self::TEXTDOMAIN, $this->dir . self::LANG );
	}
	
	/**
	 * Plugin initialization
	 */
	public function init()
	{
		// Run plugin only in admin area
		if( is_admin() )
		{
			$this->reportManager = new ReportManager( $this );
		}
	}
}