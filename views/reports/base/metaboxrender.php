<?php
/**
 * Reports\Base::metaBoxRender view
 */
namespace INBI4WP\Reports;
use INBI4WP\Plugin as Plugin;
?>
<div>
	<label for="<?php echo Base::FIELD_URL ?>"><?php esc_html_e( 'Report URL', Plugin::TEXTDOMAIN ) ?></label>
	<input id="<?php echo Base::FIELD_URL ?>" name="<?php echo Base::FIELD_URL ?>" value="<?php echo esc_attr( $this->url ) ?>" />
</div>