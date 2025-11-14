<?php
/**
 * side bar template
 *
 * @package WordPress
 * @subpackage Cozipress
 */
?>
<?php if ( ! is_active_sidebar( 'cozipress-woocommerce-sidebar' ) ) {	return; } ?>
<div class="col-lg-4 pl-lg-4 order-0">
	<div class="sidebar">
		<?php dynamic_sidebar('cozipress-woocommerce-sidebar'); ?>
	</div>
</div>