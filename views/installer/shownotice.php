<?php
/**
 * Installer::showNotice view
 */
namespace INBI4WP;
?>
<div class="updated notice is-dismissible">
	<p><?php esc_html_e( 'Thank you for using Google Data Studio Reports For WordPress!', Plugin::TEXTDOMAIN ) ?></p>
	<p>
		<?php esc_html_e( 'Click', Plugin::TEXTDOMAIN ) ?>
		<a href="<?php echo $this->adminURL?>&install=demo"><?php esc_html_e( 'here', Plugin::TEXTDOMAIN ) ?></a>
		<?php esc_html_e( 'to install demo reports.', Plugin::TEXTDOMAIN ) ?>
	</p>
</div>