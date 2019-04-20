<?php
/**
 * Google Data Studio Reports For WordPress
 * Class Plugin
 */
namespace INBI4WP\Reports;
use INBI4WP\Plugin as Plugin;

class Page extends Base
{
	/**
	 * Returns report type title
	 * @static
	 * @return string
	 */
	static public function getTitle()
	{
		return __( 'Admin Page Report', Plugin::TEXTDOMAIN );
	}
}