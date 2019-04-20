<?php
/**
 * Reports\Base::metaBoxRender view
 */
namespace INBI4WP\Reports;
use INBI4WP\Plugin as Plugin;
?>
<div>
	<label for="inbi4wp-report-url"><?php esc_html_e( 'Report URL', Plugin::TEXTDOMAIN ) ?></label>
	<input id="inbi4wp-report-url" name="inbi4wp-report-url" value="<?php echo esc_attr( $this->url ) ?>" />
</div>