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
	const LANG = '/languages';
	
    /**
     * @var Plugin
     */
    private static $instance;	
	
	/**
	 * Plugin folder
	 * @var string
	 */
	public $dir = '';
	
	/**
	 * Plugin file
	 * @var string
	 */
	private $file = '';	
	
	/**
	 * Instance of ReportManager
	 * @var string
	 */
	public $reportManager;	

	/**
	 * Instance of Installer
	 * @var string
	 */
	private $installer;	

    /**
     * Gets the instance via lazy initialization (created on first usage)
	 * @param string $pluginDir	plugin folder. Must be specified at the first call ! 
     */
    public static function get( $pluginDir = '' ): Plugin
    {
        if (null === static::$instance) {
            static::$instance = new static( $pluginDir );
        }

        return static::$instance;
    }
	
	/**
	 * Constructor
	 * @param string	$pluginFile	Plugin File
	 */
	private function __construct( $pluginFile )
	{
		$this->file = $pluginFile;
		$this->dir = plugin_dir_path( $pluginFile );
		add_action( 'plugins_loaded', array( $this, 'loadTextDomain' ) );
		add_action( 'init', array( $this, 'init' ) );
		register_activation_hook( $this->file, array( $this, 'activate' ) );
	}
	
	/**
	 * Load textdomain
	 */
	public function loadTextDomain()
	{
		load_plugin_textdomain( self::TEXTDOMAIN, false, basename( dirname( $this->file ) ) . self::LANG );
	}
	
	/**
	 * Plugin initialization
	 */
	public function init()
	{
		// Run plugin only in admin area
		if( is_admin() )
		{
			$this->reportManager = new ReportManager();
			$this->installer = new Installer();
		}
	}
	
	/**
	 * Plugin activatation
	 */
	public function activate()
	{
		Installer::activate();
	}	
}