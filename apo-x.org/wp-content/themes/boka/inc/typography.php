<?php

/**
 * Boka Typography & Color Settings
 */

function boka_typography_color( $color ) {

    $color = '';

    /**
     * Primary Color
     */

    $primary_color = get_theme_mod( 'primary_color', '#1488cc' );

    $color .= ".primary-menu .xs-angle-down,.sticky-post a:before,.team-social a,.footer-main,a,.navbar-default .navbar-nav>.active>a,.woocommerce ul.products li.product .button,.widget-area .search-form .search-submit,.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button,.woocommerce nav.woocommerce-pagination ul li a, .woocommerce nav.woocommerce-pagination ul li span,.woocommerce div.product form.cart .button,.woocommerce #review_form #respond .form-submit input,.woocommerce input.button , .woocommerce-cart .wc-proceed-to-checkout a.checkout-button,.woocommerce #payment #place_order ,.wpcf7-submit{ color: " . esc_attr($primary_color) . "; } ";

    $color .= ".breadcrumb,.cart-icon>a>span,.woocommerce .widget_price_filter .ui-slider .ui-slider-range,.woocommerce ul.products li.product .onsale,button,input[type=submit],.navbar-default .navbar-toggle:focus, .navbar-default .navbar-toggle:hover,.navbar-default .navbar-toggle .icon-bar,.woocommerce nav.woocommerce-pagination ul li span.current,.footer-main,.camera_wrap .slider-button .btn,.search-cart .badge,.dropdown-menu>.active>a, .dropdown-menu>.active>a:focus, .dropdown-menu>.active>a:hover,.dropdown-menu>li>a:focus, .dropdown-menu>li>a:hover,.woocommerce ul.products li.product .button,.widget-area .search-form .search-submit,.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button,.woocommerce nav.woocommerce-pagination ul li a, .woocommerce nav.woocommerce-pagination ul li span,.woocommerce div.product form.cart .button,.woocommerce #review_form #respond .form-submit input,.woocommerce input.button , .woocommerce-cart .wc-proceed-to-checkout a.checkout-button,.woocommerce #payment #place_order ,.wpcf7-submit,.btn{ background-color:" . esc_attr($primary_color) . "; } ";

    $color .= "button,input[type=submit],.navbar-default .navbar-toggle,.woocommerce nav.woocommerce-pagination ul li span.current,.wpcf7 .wpcf7-submit,.widget-area .search-form .search-field,.service-url,.camera_wrap .slider-button .btn,.search-cart .badge,.dropdown-menu>.active>a, .dropdown-menu>.active>a:focus, .dropdown-menu>.active>a:hover,.dropdown-menu>li>a:focus, .dropdown-menu>li>a:hover,.woocommerce ul.products li.product .button,.widget-area .search-form .search-submit,.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button,.woocommerce nav.woocommerce-pagination ul li a, .woocommerce nav.woocommerce-pagination ul li span,.woocommerce div.product form.cart .button,.woocommerce #review_form #respond .form-submit input,.woocommerce input.button , .woocommerce-cart .wc-proceed-to-checkout a.checkout-button,.woocommerce #payment #place_order ,.btn{ border-color: " . esc_attr($primary_color) . "; } ";

    $color .= "button,input[type=submit],.camera_wrap .slider-button .btn,.search-cart .badge,.dropdown-menu>.active>a, .dropdown-menu>.active>a:focus, .dropdown-menu>.active>a:hover,.dropdown-menu>li>a:focus, .dropdown-menu>li>a:hover,.woocommerce ul.products li.product .button,.widget-area .search-form .search-submit,.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button,.woocommerce nav.woocommerce-pagination ul li a, .woocommerce nav.woocommerce-pagination ul li span,.woocommerce div.product form.cart .button,.woocommerce #review_form #respond .form-submit input,.woocommerce input.button , .woocommerce-cart .wc-proceed-to-checkout a.checkout-button,.woocommerce #payment #place_order ,.wpcf7-submit,.btn{ color: #fff; } ";

    /**
     * Header Tob Bar
     */

    if ( get_theme_mod( 'enable_top_bar' ) ) :

        $top_bar_bg = get_theme_mod( 'top_bar_bg', '#000' );
        $top_bar_text_color = get_theme_mod( 'top_bar_text_color', '#fff' );
        $color .= ".top-bar { background-color:" . esc_attr( $top_bar_bg ) . "; } ";
        $color .= ".top-bar * { color:" . esc_attr( $top_bar_text_color ) . "; } ";

    endif;

    /**
     * Header Banner Image With Contents
     */

    $header_banner_bg = get_theme_mod( 'header_banner_bg', '#1488cc' );
    $hero_area_heading_color = get_theme_mod( 'hero_area_heading_color', '#fff' );
    $header_banner_text_color = get_theme_mod( 'header_banner_text_color', '#fff' );
    $header_banner_btn_txt_color = get_theme_mod( 'header_banner_btn_txt_color', '#717171' );
    $header_banner_btn_bg_color = get_theme_mod( 'header_banner_btn_bg_color', '#fff' );

    $color .= ".header-banner-image { background-color:" . esc_attr( $header_banner_bg ) . "; } ";
    $color .= ".header-banner-contents h1{ color:" . esc_attr( $hero_area_heading_color ) . "; } ";
    $color .= ".header-banner-contents p { color:" . esc_attr( $header_banner_text_color ) . "; } ";
    $color .= ".header-banner-contents .btn { color:" . esc_attr( $header_banner_btn_txt_color ) . "; background-color:" . esc_attr( $header_banner_btn_bg_color ) . "; border-color:" . esc_attr( $header_banner_btn_bg_color ) . "; } ";


    /**
     * Menu
     */

    $menu_font_weight = get_theme_mod( 'menu_font_weight', '400' );
    $menu_color = get_theme_mod( 'menu_color', '#888888' );
    $submenu_bg = get_theme_mod( 'submenu_bg', '#fff' );
    $menu_font_size = get_theme_mod( 'menu_font_size', '16' );
    $color .= ".dropdown-menu { background-color:" . esc_attr( $submenu_bg ) . "; } ";
    $color .= ".primary-menu .navbar-nav>li>a,.search-cart a{ font-size: " . esc_attr($menu_font_size) . "px;} ";
    $color .= ".primary-menu .navbar-nav>li>a,.search-cart a,.site-title a, .site-description{ color:" . esc_attr( $menu_color ) . ";} ";
    $color .= ".primary-menu .navbar-nav>li>a,.dropdown-menu a{ font-weight:" . esc_attr( $menu_font_weight ) . ";} ";

    /**
     * Header Section
     */

    $header_bg_color = get_theme_mod( 'header_bg_color', '#ffffff' );

    $header_border_color = get_theme_mod( 'header_border_color', '#ffffff' );
    $header_border_style = get_theme_mod( 'header_border_style', 'none' );
    $header_border_size = get_theme_mod( 'header_border_size', '1' );

    $header_top_padding = '';
    if ( get_theme_mod( 'header_top_padding' ) ){
        $header_top_padding = 'padding-top: '.get_theme_mod( 'header_top_padding' ).'px;';
    }

    $header_bottom_padding = '';
    if ( get_theme_mod( 'header_bottom_padding' ) ){
        $header_bottom_padding = 'padding-bottom: '.get_theme_mod( 'header_bottom_padding' ).'px;';
    }

    if ( get_theme_mod( 'header_border_size' ) ){
        $header_border_color = 'border-bottom: '.  $header_border_size .'px ' . esc_attr( $header_border_style ) .' '. esc_attr( $header_border_color ) .';';
    }

    $color .= ".header { background:" . esc_attr($header_bg_color) . "; } ";
    $color .= ".header { $header_border_color } ";
    $color .= ".header { $header_top_padding } ";
    $color .= ".header { $header_bottom_padding } ";

    /**
    * Footer Section
    */

    $footer_bg_color = get_theme_mod( 'footer_bg_color' );
    $footer_text_color = get_theme_mod( 'footer_text_color', '#717171' );

    $footer_border_color = get_theme_mod( 'footer_border_color', '#ffffff' );
    $footer_border_style = get_theme_mod( 'footer_border_style', 'none' );
    $footer_border_size = get_theme_mod( 'footer_border_size', '1' );

    $footer_top_padding = '';
    if ( get_theme_mod( 'footer_top_padding' ) ){
        $footer_top_padding = 'padding-top: '.get_theme_mod( 'footer_top_padding' ).'px;';
    }

    $footer_bottom_padding = '';
    if ( get_theme_mod( 'footer_bottom_padding' ) ){
        $footer_bottom_padding = 'padding-bottom: '.get_theme_mod( 'footer_bottom_padding' ).'px;';
    }

    $footer_border = '';
    if ( get_theme_mod( 'header_border_size' ) ){
        $footer_border = 'border-top: '.  $footer_border_size .'px ' . esc_attr( $footer_border_style ) .' '. esc_attr( $footer_border_color ) .';';
    }

    $color .= ".footer-main { background:" . esc_attr($footer_bg_color) . "; $footer_border $footer_top_padding } ";
    $color .= ".footer-bottom {  $footer_bottom_padding } ";

    $color .= ".footer-top ,.footer-main, .footer-main a, .footer-main h4{  color: ". esc_attr($footer_text_color) .";} ";

    /**
     * Font Family
     */

    $body_font_family = get_theme_mod('body_font_family');
    if ( $body_font_family !='' ) {
        $color .= "body{ font-family:" . $body_font_family . ";}";
    }else{
        $color .= "body{ font-family: 'Source Sans Pro', sans-serif;}";
    }

    $heading_font_family = get_theme_mod('heading_font_family');
    if ( $heading_font_family !='' ) {
        $color .= "h1,h2,h3,h4,h5,h6,.h1, .h2, .h3, h1, h2, h3{ font-family:" . $heading_font_family . ";}";
    }else{
        $color .= "h1,h2,h3,h4,h5,h6,.h1, .h2, .h3, h1, h2, h3{ font-family: 'Nunito', sans-serif;}";
    }

    /**
     * Body
     */

    $body_text_color = get_theme_mod( 'bg_text_color', '#717171' );
    $body_font_size = get_theme_mod( 'body_font_size', '18' );
    $body_font_weight = get_theme_mod( 'body_font_weight', '300' );

    $color .= "body { color:" . esc_attr($body_text_color) . "; font-weight:" . esc_attr($body_font_weight) ."; font-size: " . esc_attr($body_font_size) . "px;} ";

    /**
     * Heading
     */

    $heading_color = get_theme_mod( 'heading_color', '#333' );
    $heading_font_weight = get_theme_mod( 'heading_font_weight', '300' );
    $color .= "h1, h2, h3, h4, h5, h6,h1 a, h2 a, h3 a, h4 a, h5 a, h6 a,.h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6{ color:" . esc_attr($heading_color) . "; font-weight:" . esc_attr($heading_font_weight) .";} ";

    if ( get_theme_mod( 'link_color' ) ){
        $color .= "a{ color:" . esc_attr( get_theme_mod( 'link_color' ) ) . "} ";
    }

    $link_hover_color = get_theme_mod( 'link_hover_color', '#2939b4' );
    $color .= "a:hover,a:focus,.site-info a:hover,.woocommerce ul.products li.product .price,.woo-widget a,.navbar-default .navbar-nav>li>a:focus, .navbar-default .navbar-nav>li>a:hover{ color:" . esc_attr($link_hover_color) . "} ";

    /**
     * Page Title
     */

    $page_title_background_color = get_theme_mod( 'page_title_background_color', '#1488cc' );
    $page_title_text_color = get_theme_mod( 'page_title_text_color', '#ffffff' );
    $page_title_background_image = get_theme_mod( 'page_title_background_image' );
    $page_title_font_size = get_theme_mod( 'page_title_font_size', '48' );
    $page_title_padding = get_theme_mod( 'page_title_padding', '85' );

    if ( $page_title_background_image != '' ){
        $page_title_background_image = "background-image: url( $page_title_background_image )";
    }

    $color .= ".breadcrumb{ background-color:" . esc_attr( $page_title_background_color ) . "; padding:" . esc_attr( $page_title_padding ) ."px 15px; $page_title_background_image } .breadcrumb h1{ font-size:" . esc_attr( $page_title_font_size ) ."px; color:" . esc_attr( $page_title_text_color ) ."; } ";

    /**
     * Typography & Color Inline
     */
    wp_add_inline_style( 'boka-style', $color );
}
add_action( 'wp_enqueue_scripts', 'boka_typography_color' );