<?php
/**
 * ReportManager::metaBoxRender view
 */
namespace INBI4WP;
?>
<div>
	<label for="<?php echo ReportManager::FIELD_TYPE ?>"><?php esc_html_e( 'Report Type', Plugin::TEXTDOMAIN ) ?></label>
	<select id="<?php echo ReportManager::FIELD_TYPE ?>" name="<?php echo ReportManager::FIELD_TYPE ?>">
		<?php foreach ( $this->reportTypes as $type => $title ): ?>
			<option name="<?php echo esc_attr( $type ) ?>"><?php echo esc_html( $title ) ?></option>
		<?php endforeach ?>
	</select>
</div>

