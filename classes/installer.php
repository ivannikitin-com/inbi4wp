<?php
/**
 * Google Data Studio Reports For WordPress
 * Class Installer installs demo reports on activation plugin
 */
namespace INBI4WP;
use \WP_Query as WP_Query;

class Installer
{
	/**
	 * @const FLAG Transient flag for user notice show
	 */
	const FLAG = 'inbi4wp_show_notice';
	
	/**
	 * Report List URL
	 */
	private $adminURL;	
	
	
	/**
	 * Plugin activatation method salling during register_activation_hook
	 * @static
	 */
	static public function activate()
	{
		// Check reports present in DB
		$query = new WP_Query( array( 
			'post_type'		=> ReportManager::CPT,
			'post_status'	=> array( 'publish' ),
		) );
		
		// If no reports show dialog for user
		if ( ! $query->have_posts() )
		{
			set_transient( self::FLAG, true, 12 * HOUR_IN_SECONDS );
		}
	}
	
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->adminURL = '/wp-admin/edit.php?post_type=' . ReportManager::CPT;
		
		// Install demo 
		if ( isset( $_GET['install'] ) && $_GET['install'] == 'demo' )
		{
			$this->installDemo();
		}
		
		// If flag is true show notice
		if ( get_transient( self::FLAG ) )
		{
			add_action( 'admin_notices', array( $this, 'showNotice' ) );
		}
	}
	
	/**
	 * Show user notice
	 */	
	public function showNotice()
	{
		include( Plugin::get()->dir . 'views/installer/shownotice.php' );
	}
	
	/**
	 * Install demo reports
	 */	
	private function installDemo()
	{
		Reports\Welcome::add(
			_x( 'https://datastudio.google.com/embed/reporting/1VBoRCoJSOUbTZECO68GC2CJxJb8Q51et/page/qDTo', 'URL Demo Welcome Site Stats', Plugin::TEXTDOMAIN ),
			__( 'Demo Welcome Site Stats', Plugin::TEXTDOMAIN )
		);		
		
		Reports\Page::add(
			_x( 'https://datastudio.google.com/embed/reporting/1Hsn7UlMla3RpNWkkLb3Q-0VvZhHlvaGo/page/UGXo', 'URL Demo Site Usage Report', Plugin::TEXTDOMAIN ),
			__( 'Demo Site Usage Report', Plugin::TEXTDOMAIN )
		);
		
		Reports\Page::add(
			_x( 'https://datastudio.google.com/embed/reporting/1prV-6QHhexEG9u-nIMvvQISWgnUtZPPv/page/1M', 'URL Demo Marketing Report', Plugin::TEXTDOMAIN ),
			__( 'Demo Marketing Report', Plugin::TEXTDOMAIN )
		);
		
		Reports\Page::add(
			_x( 'https://datastudio.google.com/embed/reporting/1TELKZNOYeOHpkv9ODSQWY7a6DB1PNoNU/page/6zXD', 'URL Demo Search Console Report', Plugin::TEXTDOMAIN ),
			__( 'Demo Search Console Report', Plugin::TEXTDOMAIN )
		);
		
		Reports\Page::add(
			_x( 'https://datastudio.google.com/embed/reporting/1Y1UXSy42IfCESUj02VifjfatJNtswldB/page/qlD', 'URL Demo Ecommerce & Google Ads Dashboard', Plugin::TEXTDOMAIN ),
			__( 'Demo Ecommerce & Google Ads Dashboard', Plugin::TEXTDOMAIN )
		);		
		
		Reports\DashboardWidget::add(
			_x( 'https://datastudio.google.com/embed/reporting/19-chqd7aUG22UY1w4P1Ze_3hZAPX4UgA/page/MPTo', 'URL Demo Purchase Funnel', Plugin::TEXTDOMAIN ),
			__( 'Demo Purchase Funnel', Plugin::TEXTDOMAIN )
		);

		delete_transient( self::FLAG );
		wp_safe_redirect( $this->adminURL );
	}		
}