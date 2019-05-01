<?php
/**
 * Reports\Base::metaBoxRender view
 */
namespace INBI4WP\Reports;
use INBI4WP\Plugin as Plugin;
use INBI4WP\ReportManager as ReportManager;
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

<script>
jQuery(function($){
	console.log('Reports\Base::metaBoxRender view');
	// Select onchange
	$('#<?php echo ReportManager::FIELD_TYPE ?>').on('change', function(){
		var option = this.options[this.selectedIndex].value;
		// Sets the default values of width and height
		$('#<?php echo Base::FIELD_WIDTH ?>').val(inbi4wp_reportsData[option].defaultWidth);
		$('#<?php echo Base::FIELD_HEIGHT ?>').val(inbi4wp_reportsData[option].defaultHeight);
	});
});
</script>