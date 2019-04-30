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

<div>
	<label for="<?php echo Base::FIELD_WIDTH ?>"><?php esc_html_e( 'Report width', Plugin::TEXTDOMAIN ) ?></label>
	<input id="<?php echo Base::FIELD_WIDTH ?>" name="<?php echo Base::FIELD_WIDTH ?>" value="<?php echo esc_attr( $this->width ) ?>" />
</div>

<div>
	<label for="<?php echo Base::FIELD_HEIGHT ?>"><?php esc_html_e( 'Report height', Plugin::TEXTDOMAIN ) ?></label>
	<input id="<?php echo Base::FIELD_HEIGHT ?>" name="<?php echo Base::FIELD_HEIGHT ?>" value="<?php echo esc_attr( $this->height ) ?>" />
</div>