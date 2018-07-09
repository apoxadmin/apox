<?php
/**
 * Customizer functionality for Color customizations.
 *
 * @package Hestia
 * @since Hestia 1.0
 */

/**
 * Hook controls for Color Settings.
 *
 * @since Hestia 1.0
 */
function hestia_colors_customize_register( $wp_customize ) {

	if ( ! class_exists( 'Hestia_Customize_Alpha_Color_Control' ) ) {
		return;
	}

	// Alpha Color Picker setting.
	$wp_customize->add_setting(
		'accent_color', array(
			'default'           => '#e91e63',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'hestia_sanitize_colors',
		)
	);

	// Alpha Color Picker control.
	$wp_customize->add_control(
		new Hestia_Customize_Alpha_Color_Control(
			$wp_customize, 'accent_color', array(
				'label'    => esc_html__( 'Accent Color', 'hestia' ),
				'section'  => 'colors',
				'palette'  => false,
				'priority' => 10,
			)
		)
	);
}

add_action( 'customize_register', 'hestia_colors_customize_register' );

/**
 * Adds inline style from customizer
 *
 * @since Hestia 1.0
 */
function hestia_custom_colors_inline_style() {

	$color_accent = get_theme_mod( 'accent_color', '#e91e63' );

	$custom_css = '';

	if ( ! empty( $color_accent ) ) {

		$custom_css .= '

.header-filter.header-filter-gradient:before {
	background-color: transparent;
} ';

		$custom_css .= '	
a, 
.navbar .dropdown-menu li:hover > a,
.navbar .dropdown-menu li:focus > a,
.navbar .dropdown-menu li:active > a,
.navbar .dropdown-menu li:hover > a > i,
.navbar .dropdown-menu li:focus > a > i,
.navbar .dropdown-menu li:active > a > i,
.navbar.navbar-not-transparent .nav > li:not(.btn).on-section > a, 
.navbar.navbar-not-transparent .nav > li.on-section:not(.btn) > a, 
.navbar.navbar-not-transparent .nav > li.on-section:not(.btn):hover > a, 
.navbar.navbar-not-transparent .nav > li.on-section:not(.btn):focus > a, 
.navbar.navbar-not-transparent .nav > li.on-section:not(.btn):active > a, 
body:not(.home) .navbar-default .navbar-nav > .active:not(.btn) > a,
body:not(.home) .navbar-default .navbar-nav > .active:not(.btn) > a:hover,
body:not(.home) .navbar-default .navbar-nav > .active:not(.btn) > a:focus,
.hestia-blogs article:nth-child(6n+1) .category a, a:hover, .card-blog a.moretag:hover, .card-blog a.more-link:hover, .widget a:hover {
    color:' . esc_attr( $color_accent ) . ';
}

.pagination span.current, .pagination span.current:focus, .pagination span.current:hover {
	border-color:' . esc_attr( $color_accent ) . '
}
           
button,
button:hover,           
input[type="button"],
input[type="button"]:hover,
input[type="submit"],
input[type="submit"]:hover,
input#searchsubmit, 
.pagination span.current, 
.pagination span.current:focus, 
.pagination span.current:hover,
.btn.btn-primary,
.btn.btn-primary:link,
.btn.btn-primary:hover, 
.btn.btn-primary:focus, 
.btn.btn-primary:active, 
.btn.btn-primary.active, 
.btn.btn-primary.active:focus, 
.btn.btn-primary.active:hover,
.btn.btn-primary:active:hover, 
.btn.btn-primary:active:focus, 
.btn.btn-primary:active:hover,
.hestia-sidebar-open.btn.btn-rose,
.hestia-sidebar-close.btn.btn-rose,
.hestia-sidebar-open.btn.btn-rose:hover,
.hestia-sidebar-close.btn.btn-rose:hover,
.hestia-sidebar-open.btn.btn-rose:focus,
.hestia-sidebar-close.btn.btn-rose:focus,
.label.label-primary,
.hestia-work .portfolio-item:nth-child(6n+1) .label,
.nav-cart .nav-cart-content .widget .buttons .button {
    background-color: ' . esc_attr( $color_accent ) . ';
}

@media (max-width: 768px) { 
	.navbar .navbar-nav .dropdown a .caret {
	    background-color: ' . esc_attr( $color_accent ) . ';
	}
	
	.navbar-default .navbar-nav>li>a:hover,
	.navbar-default .navbar-nav>li>a:focus,
	.navbar .navbar-nav .dropdown .dropdown-menu li a:hover,
	.navbar .navbar-nav .dropdown .dropdown-menu li a:focus,
	.navbar button.navbar-toggle:hover,
	.navbar .navbar-nav li:hover > a i {
	    color: ' . esc_attr( $color_accent ) . ';
	}
}

button,
.button,
input[type="submit"], 
input[type="button"], 
.btn.btn-primary,
.hestia-sidebar-open.btn.btn-rose,
.hestia-sidebar-close.btn.btn-rose {
    -webkit-box-shadow: 0 2px 2px 0 ' . hestia_hex_rgba( $color_accent, '0.14' ) . ',0 3px 1px -2px ' . hestia_hex_rgba( $color_accent, '0.2' ) . ',0 1px 5px 0 ' . hestia_hex_rgba( $color_accent, '0.12' ) . ';
    box-shadow: 0 2px 2px 0 ' . hestia_hex_rgba( $color_accent, '0.14' ) . ',0 3px 1px -2px ' . hestia_hex_rgba( $color_accent, '0.2' ) . ',0 1px 5px 0 ' . hestia_hex_rgba( $color_accent, '0.12' ) . ';
}

.card .header-primary, .card .content-primary {
    background: ' . esc_attr( $color_accent ) . ';
}';

		// Hover box shadow
		$custom_css .= '
.button:hover,
button:hover,
input[type="submit"]:hover,
input[type="button"]:hover,
input#searchsubmit:hover, 
.pagination span.current, 
.btn.btn-primary:hover, 
.btn.btn-primary:focus, 
.btn.btn-primary:active, 
.btn.btn-primary.active, 
.btn.btn-primary:active:focus, 
.btn.btn-primary:active:hover, 
.hestia-sidebar-open.btn.btn-rose:hover,
.hestia-sidebar-close.btn.btn-rose:hover,
.pagination span.current:hover{
	-webkit-box-shadow: 0 14px 26px -12px' . hestia_hex_rgba( $color_accent, '0.42' ) . ',0 4px 23px 0 rgba(0,0,0,0.12),0 8px 10px -5px ' . hestia_hex_rgba( $color_accent, '0.2' ) . ';
    box-shadow: 0 14px 26px -12px ' . hestia_hex_rgba( $color_accent, '0.42' ) . ',0 4px 23px 0 rgba(0,0,0,0.12),0 8px 10px -5px ' . hestia_hex_rgba( $color_accent, '0.2' ) . ';
	color: #fff;
}';

		// FORMS UNDERLINE COLOR
		$custom_css .= '
.form-group.is-focused .form-control {
background-image: -webkit-gradient(linear,left top, left bottom,from(' . esc_attr( $color_accent ) . '),to(' . esc_attr( $color_accent ) . ')),-webkit-gradient(linear,left top, left bottom,from(#d2d2d2),to(#d2d2d2));
	background-image: -webkit-linear-gradient(' . esc_attr( $color_accent ) . '),to(' . esc_attr( $color_accent ) . '),-webkit-linear-gradient(#d2d2d2,#d2d2d2);
	background-image: linear-gradient(' . esc_attr( $color_accent ) . '),to(' . esc_attr( $color_accent ) . '),linear-gradient(#d2d2d2,#d2d2d2);
}';

		// Hover Effect for navbar items
		$custom_css .= '
 .navbar:not(.navbar-transparent) .navbar-nav > li:not(.btn) > a:hover,
 body:not(.home) .navbar:not(.navbar-transparent) .navbar-nav > li.active:not(.btn) > a, .navbar:not(.navbar-transparent) .navbar-nav > li:not(.btn) > a:hover i, .navbar .container .nav-cart:hover .nav-cart-icon {
		 color:' . esc_attr( $color_accent ) . '}';

	}// End if().

	$handle = apply_filters( 'hestia_custom_color_handle', 'hestia_style' );
	wp_add_inline_style( $handle, $custom_css );

	// WooCommerce Custom Colors
	if ( class_exists( 'WooCommerce' ) ) {
		// Initialize empty string.
		$custom_css_woocommerce = '';

		if ( ! empty( $color_accent ) ) {
			$custom_css_woocommerce .= '
.woocommerce-cart .shop_table .actions .coupon .input-text:focus,
.woocommerce-checkout #customer_details .input-text:focus, .woocommerce-checkout #customer_details select:focus,
.woocommerce-checkout #order_review .input-text:focus,
.woocommerce-checkout #order_review select:focus,
.woocommerce-checkout .woocommerce-form .input-text:focus,
.woocommerce-checkout .woocommerce-form select:focus,
.woocommerce div.product form.cart .variations select:focus,
.woocommerce .woocommerce-ordering select:focus {
	background-image: -webkit-gradient(linear,left top, left bottom,from(' . esc_attr( $color_accent ) . '),to(' . esc_attr( $color_accent ) . ')),-webkit-gradient(linear,left top, left bottom,from(#d2d2d2),to(#d2d2d2));
	background-image: -webkit-linear-gradient(' . esc_attr( $color_accent ) . '),to(' . esc_attr( $color_accent ) . '),-webkit-linear-gradient(#d2d2d2,#d2d2d2);
	background-image: linear-gradient(' . esc_attr( $color_accent ) . '),to(' . esc_attr( $color_accent ) . '),linear-gradient(#d2d2d2,#d2d2d2);
}
.woocommerce div.product .woocommerce-tabs ul.tabs.wc-tabs li.active a {
	color:' . esc_attr( $color_accent ) . ';
}
.woocommerce div.product .woocommerce-tabs ul.tabs.wc-tabs li.active a,
.woocommerce div.product .woocommerce-tabs ul.tabs.wc-tabs li a:hover {
	border-color:' . esc_attr( $color_accent ) . '
}
.added_to_cart.wc-forward:hover,
#add_payment_method .wc-proceed-to-checkout a.checkout-button:hover,
#add_payment_method .wc-proceed-to-checkout a.checkout-button,
.added_to_cart.wc-forward,
.woocommerce nav.woocommerce-pagination ul li span.current,
.woocommerce ul.products li.product .onsale,
.woocommerce span.onsale,
.woocommerce .single-product div.product form.cart .button,
.woocommerce #respond input#submit,
.woocommerce button.button,
.woocommerce input.button,
.woocommerce-cart .wc-proceed-to-checkout a.checkout-button,
.woocommerce-checkout .wc-proceed-to-checkout a.checkout-button,
.woocommerce #respond input#submit.alt,
.woocommerce a.button.alt,
.woocommerce button.button.alt,
.woocommerce input.button.alt,
.woocommerce input.button:disabled,
.woocommerce input.button:disabled[disabled],
.woocommerce a.button.wc-backward:hover,
.woocommerce a.button.wc-backward,
.woocommerce .single-product div.product form.cart .button:hover,
.woocommerce #respond input#submit:hover,
.woocommerce button.button:hover,
.woocommerce input.button:hover,
.woocommerce-cart .wc-proceed-to-checkout a.checkout-button:hover,
.woocommerce-checkout .wc-proceed-to-checkout a.checkout-button:hover,
.woocommerce #respond input#submit.alt:hover,
.woocommerce a.button.alt:hover,
.woocommerce button.button.alt:hover,
.woocommerce input.button.alt:hover,
.woocommerce input.button:disabled:hover,
.woocommerce input.button:disabled[disabled]:hover,
.woocommerce #respond input#submit.alt.disabled,
.woocommerce #respond input#submit.alt.disabled:hover,
.woocommerce #respond input#submit.alt:disabled,
.woocommerce #respond input#submit.alt:disabled:hover,
.woocommerce #respond input#submit.alt:disabled[disabled],
.woocommerce #respond input#submit.alt:disabled[disabled]:hover,
.woocommerce a.button.alt.disabled,
.woocommerce a.button.alt.disabled:hover,
.woocommerce a.button.alt:disabled,
.woocommerce a.button.alt:disabled:hover,
.woocommerce a.button.alt:disabled[disabled],
.woocommerce a.button.alt:disabled[disabled]:hover,
.woocommerce button.button.alt.disabled,
.woocommerce button.button.alt.disabled:hover,
.woocommerce button.button.alt:disabled,
.woocommerce button.button.alt:disabled:hover,
.woocommerce button.button.alt:disabled[disabled],
.woocommerce button.button.alt:disabled[disabled]:hover,
.woocommerce input.button.alt.disabled,
.woocommerce input.button.alt.disabled:hover,
.woocommerce input.button.alt:disabled,
.woocommerce input.button.alt:disabled:hover,
.woocommerce input.button.alt:disabled[disabled],
.woocommerce input.button.alt:disabled[disabled]:hover,
.woocommerce a.button.woocommerce-Button,
.woocommerce-account .woocommerce-button,
.woocommerce-account .woocommerce-Button,
.woocommerce-account a.button,
.woocommerce-account .woocommerce-button:hover,
.woocommerce-account .woocommerce-Button:hover,
.woocommerce-account a.button:hover,
#secondary div[id^=woocommerce_price_filter] .price_slider .ui-slider-range,
.footer div[id^=woocommerce_price_filter] .price_slider .ui-slider-range,
div[id^=woocommerce_product_tag_cloud].widget a,
div[id^=woocommerce_widget_cart].widget .buttons .button {
    background-color: ' . esc_attr( $color_accent ) . ';
}
.added_to_cart.wc-forward,
.woocommerce .single-product div.product form.cart .button,
.woocommerce #respond input#submit,
.woocommerce button.button,
.woocommerce input.button,
#add_payment_method .wc-proceed-to-checkout a.checkout-button,
.woocommerce-cart .wc-proceed-to-checkout a.checkout-button,
.woocommerce-checkout .wc-proceed-to-checkout a.checkout-button,
.woocommerce #respond input#submit.alt,
.woocommerce a.button.alt,
.woocommerce button.button.alt,
.woocommerce input.button.alt,
.woocommerce input.button:disabled,
.woocommerce input.button:disabled[disabled],
.woocommerce a.button.wc-backward,
.woocommerce div[id^=woocommerce_widget_cart].widget .buttons .button,
.woocommerce-account .woocommerce-button,
.woocommerce-account .woocommerce-Button,
.woocommerce-account a.button {
    -webkit-box-shadow: 0 2px 2px 0 ' . hestia_hex_rgba( $color_accent, '0.14' ) . ',0 3px 1px -2px ' . hestia_hex_rgba( $color_accent, '0.2' ) . ',0 1px 5px 0 ' . hestia_hex_rgba( $color_accent, '0.12' ) . ';
    box-shadow: 0 2px 2px 0 ' . hestia_hex_rgba( $color_accent, '0.14' ) . ',0 3px 1px -2px ' . hestia_hex_rgba( $color_accent, '0.2' ) . ',0 1px 5px 0 ' . hestia_hex_rgba( $color_accent, '0.12' ) . ';
}
.woocommerce nav.woocommerce-pagination ul li span.current,
.added_to_cart.wc-forward:hover,
.woocommerce .single-product div.product form.cart .button:hover,
.woocommerce #respond input#submit:hover,
.woocommerce button.button:hover,
.woocommerce input.button:hover,
#add_payment_method .wc-proceed-to-checkout a.checkout-button:hover,
.woocommerce-cart .wc-proceed-to-checkout a.checkout-button:hover,
.woocommerce-checkout .wc-proceed-to-checkout a.checkout-button:hover,
.woocommerce #respond input#submit.alt:hover,
.woocommerce a.button.alt:hover,
.woocommerce button.button.alt:hover,
.woocommerce input.button.alt:hover,
.woocommerce input.button:disabled:hover,
.woocommerce input.button:disabled[disabled]:hover,
.woocommerce a.button.wc-backward:hover,
.woocommerce div[id^=woocommerce_widget_cart].widget .buttons .button:hover,
.hestia-sidebar-open.btn.btn-rose:hover,
.hestia-sidebar-close.btn.btn-rose:hover,
.pagination span.current:hover,
.woocommerce-account .woocommerce-button:hover,
.woocommerce-account .woocommerce-Button:hover,
.woocommerce-account a.button:hover {
	-webkit-box-shadow: 0 14px 26px -12px' . hestia_hex_rgba( $color_accent, '0.42' ) . ',0 4px 23px 0 rgba(0,0,0,0.12),0 8px 10px -5px ' . hestia_hex_rgba( $color_accent, '0.2' ) . ';
    box-shadow: 0 14px 26px -12px ' . hestia_hex_rgba( $color_accent, '0.42' ) . ',0 4px 23px 0 rgba(0,0,0,0.12),0 8px 10px -5px ' . hestia_hex_rgba( $color_accent, '0.2' ) . ';
	color: #fff;
}
#secondary div[id^=woocommerce_price_filter] .price_slider .ui-slider-handle,
.footer div[id^=woocommerce_price_filter] .price_slider .ui-slider-handle {
	border-color: ' . esc_attr( $color_accent ) . ';
}';
		}// End if().
		wp_add_inline_style( 'hestia_woocommerce_style', $custom_css_woocommerce );
	}// End if().

}
add_action( 'wp_enqueue_scripts', 'hestia_custom_colors_inline_style', 10 );

/**
 * HEX colors conversion to RGBA.
 *
 * @return string RGBA string.
 * @since Hestia 1.0
 */
function hestia_hex_rgba( $input, $opacity = false ) {

	$default = 'rgb(0,0,0)';

	// Return default if no color provided
	if ( empty( $input ) ) {
		return $default;
	}

	// Sanitize $color if "#" is provided
	if ( $input[0] == '#' ) {
		$input = substr( $input, 1 );
	}

	// Check if color has 6 or 3 characters and get values
	if ( strlen( $input ) == 6 ) {
		$hex = array( $input[0] . $input[1], $input[2] . $input[3], $input[4] . $input[5] );
	} elseif ( strlen( $input ) == 3 ) {
		$hex = array( $input[0] . $input[0], $input[1] . $input[1], $input[2] . $input[2] );
	} else {
		return $default;
	}

	// Convert hexadeciomal color to rgb(a)
	$rgb = array_map( 'hexdec', $hex );

	// Check for opacity
	if ( $opacity ) {
		if ( abs( $opacity ) > 1 ) {
			$opacity = 1.0;
		}
		$output = 'rgba(' . implode( ',', $rgb ) . ',' . $opacity . ')';
	} else {
		$output = 'rgb(' . implode( ',', $rgb ) . ')';
	}

	// Return rgb(a) color.
	return $output;
}

/**
 * Generate gradient second color based on Header Gradient color
 *
 * @return string RGBA string.
 * @since Hestia 1.1.53
 */
function hestia_generate_gradient_color( $input, $opacity = false ) {

	$default = 'rgb(0,0,0)';

	// Return default if no color provided
	if ( empty( $input ) ) {
		return $default;
	}

	// Sanitize $color if "#" is provided
	if ( $input[0] == '#' ) {
		$input = substr( $input, 1 );
	}

	// Check if color has 6 or 3 characters and get values
	if ( strlen( $input ) == 6 ) {
		$hex = array( $input[0] . $input[1], $input[2] . $input[3], $input[4] . $input[5] );
	} elseif ( strlen( $input ) == 3 ) {
		$hex = array( $input[0] . $input[0], $input[1] . $input[1], $input[2] . $input[2] );
	} else {
		return $default;
	}

	// Convert hexadeciomal color to rgb(a)
	$rgb = array_map( 'hexdec', $hex );

	$rgb[0] = $rgb[0] + 66;
	$rgb[1] = $rgb[1] + 28;
	$rgb[2] = $rgb[2] - 21;

	if ( $rgb[0] >= 255 ) {
		$rgb[0] = 255;
	}

	if ( $rgb[1] >= 255 ) {
		$rgb[1] = 255;
	}

	if ( $rgb[2] <= 0 ) {
		$rgb[2] = 0;
	}

	// Check for opacity
	if ( $opacity ) {
		if ( abs( $opacity ) > 1 ) {
			$opacity = 1.0;
		}
		$output = 'rgba(' . implode( ',', $rgb ) . ',' . $opacity . ')';
	} else {
		$output = 'rgb(' . implode( ',', $rgb ) . ')';
	}

	// Return rgb(a) color.
	return $output;
}
