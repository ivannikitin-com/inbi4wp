<?php
/**
 * Reports\Page::reportRender view
 */
namespace INBI4WP\Reports;
use INBI4WP\Plugin as Plugin;
?>
<style>#wpcontent { padding-left: 0 }</style>
<div style="height:100vh">
	<iframe 
		src="<?php echo $this->url ?>" 
		width="<?php echo $this->width ?>" 
		height="<?php echo $this->height ?>" 
		frameborder="0" 
		style="border:0" 
		allowfullscreen></iframe>
<div>