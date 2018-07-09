<?php

/**
 * Removed breadcrumbs
 */
add_action( 'init', 'boka_remove_wc_breadcrumbs' );
function boka_remove_wc_breadcrumbs() {
    remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
}

/**
 * boka_hide_page_title
 *
 * Removes the "shop" title on the main shop page
 */
add_filter( 'woocommerce_show_page_title' , 'boka_hide_page_title' );
function boka_hide_page_title() {
    return false;
}

/**
 * Change number or products per row to 3
 */
add_filter('loop_shop_columns', 'loop_columns');
if (!function_exists('loop_columns')) {
    function loop_columns() {
        return 3; // 3 products per row
    }
}

/**
 * Opening div for our content wrapper
 */
add_action('woocommerce_before_main_content', 'boka_open_div', 5);

function boka_open_div() {
    echo '<div class="col-md-9 col-sm-12 col-xs-12 padding-gap-1 archive-woo">';
}

/**
 * Closing div for our content wrapper
 */
add_action('woocommerce_after_main_content', 'boka_close_div', 50);

function boka_close_div() {
    echo '</div>';
}

/**
 * Related Product Columns
 */
add_filter( 'woocommerce_output_related_products_args', 'boka_related_products_args' );
function boka_related_products_args( $args ) {
    $args['posts_per_page'] = 3; // 4 related products
    $args['columns'] = 3; // arranged in 2 columns
    return $args;
}

/**
 * Update mini-cart when products are added to the cart via AJAX
 */
add_filter( 'woocommerce_add_to_cart_fragments', function( $fragments ) {
    ob_start();
    ?>
    <div class="mini-cart">
        <?php woocommerce_mini_cart(); ?>
    </div>
    <?php $fragments['div.mini-cart'] = ob_get_clean();
    return $fragments;
} );

/**
 * Update contents count via AJAX
 */
add_filter('woocommerce_add_to_cart_fragments', 'boka_header_add_to_cart_fragment');
function boka_header_add_to_cart_fragment( $fragments ) {
    global $woocommerce;
    ob_start();
    ?>
    <a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>"><i class="fa fa-shopping-basket"></i><span><?php echo sprintf(_n(' %d', ' %d', $woocommerce->cart->cart_contents_count, 'boka'), $woocommerce->cart->cart_contents_count ); ?></span></a>
    <?php
    $fragments['a.cart-contents'] = ob_get_clean();
    return $fragments;
}