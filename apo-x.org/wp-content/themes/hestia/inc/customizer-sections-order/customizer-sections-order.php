<?php
/**
 * Customizer sections ordem main file
 *
 * @package Hestia
 */

/**
 * Function to enqueue sections order main script.
 */
function hestia_sections_customizer_script() {
	wp_enqueue_script( 'hestia_customizer-sections-order-script', get_template_directory_uri() . '/inc/customizer-sections-order/js/customizer-sections-order.js', array( 'jquery', 'jquery-ui-sortable' ), HESTIA_VERSION, true );
	$control_settings = array(
		'sections_container' => '#accordion-panel-hestia_frontpage_sections > ul, #sub-accordion-panel-hestia_frontpage_sections',
		'blocked_items'      => '#accordion-section-hestia_slider, #accordion-section-hestia_info_jetpack, #accordion-section-hestia_info_woocommerce',
		'saved_data_input'   => '#customize-control-sections_order input',
	);
	wp_localize_script( 'hestia_customizer-sections-order-script', 'control_settings', $control_settings );
	wp_enqueue_style( 'hestia_customizer-sections-order-style', get_template_directory_uri() . '/inc/customizer-sections-order/css/customizer-sections-order-style.css', array( 'dashicons' ), HESTIA_VERSION );
}
add_action( 'customize_controls_enqueue_scripts', 'hestia_sections_customizer_script' );


/**
 * Register input for sections order.
 *
 * @param object $wp_customize Customizer object.
 */
function hestia_section_control_register( $wp_customize ) {

	$wp_customize->add_setting(
		'sections_order', array(
			'sanitize_callback' => 'hestia_sanitize_sections_order',
		)
	);

	$wp_customize->add_control(
		'sections_order', array(
			'section'  => 'hestia_general',
			'type'     => 'hidden',
			'priority' => 80,
		)
	);

}
add_action( 'customize_register', 'hestia_section_control_register' );


/**
 * Function for returning section priority
 *
 * @param int    $value Default priority.
 * @param string $key Section id.
 *
 * @return int
 */
function hestia_get_section_priority( $value, $key = '' ) {
	$orders = get_theme_mod( 'sections_order' );
	if ( ! empty( $orders ) ) {
		$json = json_decode( $orders );
		if ( isset( $json->$key ) ) {
			return $json->$key;
		} elseif ( $key === 'sidebar-widgets-subscribe-widgets' && isset( $json->hestia_subscribe ) ) {
			return $json->hestia_subscribe;
		}
	}

	return $value;
}
add_filter( 'hestia_section_priority', 'hestia_get_section_priority', 10, 2 );


/**
 * Function to refresh customize preview when changing sections order
 */
function hestia_refresh_positions() {
	$section_order         = get_theme_mod( 'sections_order' );
	$section_order_decoded = json_decode( $section_order, true );
	if ( ! empty( $section_order_decoded ) ) {
		remove_all_actions( 'hestia_sections' );
		foreach ( $section_order_decoded as $k => $priority ) {
			if ( $k !== 'hestia_subscribe' ) {
				if ( $k === 'sidebar-widgets-subscribe-widgets' ) {
					add_action( 'hestia_sections', 'hestia_subscribe', $priority );
				}
				if ( function_exists( $k ) ) {
					add_action( 'hestia_sections', $k, $priority );
				}
			}
		}
	}
}
add_action( 'customize_preview_init', 'hestia_refresh_positions', 1 );

/**
 * Function to sanitize sections order control
 *
 * @param string $input Sections order in json format.
 */
function hestia_sanitize_sections_order( $input ) {

	$json = json_decode( $input, true );
	foreach ( $json as $section => $priority ) {
		if ( ! is_string( $section ) || ! is_int( $priority ) ) {
			return false;
		}
	}
	$filter_empty = array_filter( $json, 'hestia_not_empty' );
	return json_encode( $filter_empty );
}

/**
 * Function to filter json empty elements.
 *
 * @param int $val Element of json decoded.
 *
 * @return bool
 */
function hestia_not_empty( $val ) {
	return ! empty( $val );
}
