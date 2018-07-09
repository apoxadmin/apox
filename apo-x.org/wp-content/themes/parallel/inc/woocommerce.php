<?php
/**
 * Add WooCommerce support
 */

add_action( 'after_setup_theme', 'parallel_woocommerce_support' );
function parallel_woocommerce_support() {
    add_theme_support( 'woocommerce' );
}