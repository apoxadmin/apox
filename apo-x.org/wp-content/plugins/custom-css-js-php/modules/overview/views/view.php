<?php
/**
 * Custom css-js-php.
 * @package Core
 * @author Flipper Code <flippercode>
 **/
 $productInfo = array('productName' => __('Custom css-js-php',WCJP_TEXT_DOMAIN),
                        'productSlug' => 'custom-css-js-php',
                        'productTagLine' => 'Write custom code for php, html, javascript or css and insert in to your theme using shortcode, actions or filters.',
                        'productTextDomain' => WCJP_TEXT_DOMAIN,
                        'productIconImage' => WCJP_URL.'core/core-assets/images/wp-poet.png',
                        'productVersion' => WCJP_VERSION,
                        'productImagePath' => WCJP_URL.'core/core-assets/product-images/',
                        'is_premium' => 'false'
    );

    $productOverviewObj = new Flippercode_Product_Overview($productInfo);
