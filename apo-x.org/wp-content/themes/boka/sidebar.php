<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package boka
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area col-md-3 col-sm-12 col-xs-12 padding-gap-1" role="complementary">
	<?php
	if ( class_exists( 'WooCommerce' ) && ( is_shop() || is_product() ) ) {
		dynamic_sidebar( 'woocommerce-sidebar' );
	}else {
		dynamic_sidebar( 'sidebar-1' );
	}
	?>
</aside><!-- #secondary -->