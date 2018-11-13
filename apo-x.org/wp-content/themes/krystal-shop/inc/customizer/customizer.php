<?php
/**
 * Krystal Shop Theme Customizer
 *
 * @package krystal-shop
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */

if ( ! function_exists( 'krystal_shop_customize_register' ) ) :
function krystal_shop_customize_register( $wp_customize ) {

    if(krystal_shop_is_woocommerce_activated()){

         //Shop Settings
        
        $wp_customize->add_section(
            'krystal_shop_settings',
            array (
                'priority'      => 25,
                'capability'    => 'edit_theme_options',
                'theme_supports'=> '',
                'title'         => __( 'Shop Settings', 'krystal-shop' )
            )
        );

        // cart menu
        $wp_customize->add_setting(
            'kr_menu_cart',
            array(
                'type' => 'theme_mod',
                'default'           => true,
                'sanitize_callback' => 'krystal_shop_sanitize_checkbox_selection'
            )
        );

        $wp_customize->add_control(
            'kr_menu_cart',
            array(
                'settings'      => 'kr_menu_cart',
                'section'       => 'krystal_shop_settings',
                'type'          => 'checkbox',
                'label'         => __( 'Show Menu Cart:', 'krystal-shop' ),
                'description'   => __( 'This will add a cart icon in primary menu of website', 'krystal-shop' ),
            )
        );

        // Shop Name 
        $wp_customize->add_setting(
            'kr_shop_name',
            array(
                'type' => 'theme_mod',
                'default'           => __('SHOP','krystal-shop'),
                'sanitize_callback' => 'krystal_shop_sanitize_textarea',            
            )
        );

        $wp_customize->add_control(
            'kr_shop_name',
            array(
                'settings'      => 'kr_shop_name',
                'section'       => 'krystal_shop_settings',
                'type'          => 'textbox',
                'label'         => __( 'Shop Name', 'krystal-shop' ),
                'description'   => '',
            )
        );

        // Shop Styles
        $wp_customize->add_setting(
            'kr_shop_styles',
            array(
                'type' => 'theme_mod',
                'default'           => 'default',
                'sanitize_callback' => 'krystal_shop_sanitize_shop_styles_selection'
            )
        );

        $wp_customize->add_control(
            'kr_shop_styles',
            array(
                'settings'      => 'kr_shop_styles',
                'section'       => 'krystal_shop_settings',
                'type'          => 'radio',
                'label'         => __( 'Select Sidebar Position:', 'krystal-shop' ),
                'description'   => '',
                'choices' => array(
                                'default' => __('Full Width', 'krystal-shop'),
                                'right' => __('Rignt Sidebar', 'krystal-shop'),
                                'left' => __('Left Sidebar', 'krystal-shop'),
                                ),
            )
        ); 

        // Button Styles
        $wp_customize->add_setting(
            'kr_shop_button_styles',
            array(
                'type' => 'theme_mod',
                'default'           => 'solid',
                'sanitize_callback' => 'krystal_shop_sanitize_button_styles_selection'
            )
        );

        $wp_customize->add_control(
            'kr_shop_button_styles',
            array(
                'settings'      => 'kr_shop_button_styles',
                'section'       => 'krystal_shop_settings',
                'type'          => 'radio',
                'label'         => __( 'Select Button Color:', 'krystal-shop' ),
                'description'   => '',
                'choices' => array(
                                'transparent' => __('Transparent Color', 'krystal-shop'),
                                'solid' => __('Solid Color', 'krystal-shop'),
                                ),
            )
        );           
    }  
   
}
endif;

add_action( 'customize_register', 'krystal_shop_customize_register' );

/**
 * Sanitize textarea.
 *
 * @param string $input
 * @return string
 */
if ( ! function_exists( 'krystal_shop_sanitize_textarea' ) ) :
function krystal_shop_sanitize_textarea( $input ) {
    return sanitize_textarea_field( $input );
}
endif;


/**
 * Sanitize Shop sidebar radio option 
 *
 * @param string $input
 * @return string
 */
if ( ! function_exists( 'krystal_shop_sanitize_shop_styles_selection' ) ) :
function krystal_shop_sanitize_shop_styles_selection(  $input ){
    $valid = array(
        'default' => __('Full Width', 'krystal-shop'),
        'right' => __('Rignt Sidebar', 'krystal-shop'),
        'left' => __('Left Sidebar', 'krystal-shop'),      
     );

     if ( array_key_exists( $input, $valid ) ) {
        return $input;
     } else {
        return '';
     }
}
endif;

/**
 * Sanitize Shop buttons radio option 
 *
 * @param string $input
 * @return string
 */
if ( ! function_exists( 'krystal_shop_sanitize_button_styles_selection' ) ) :
function krystal_shop_sanitize_button_styles_selection(  $input ){
    $valid = array(
        'transparent' => __('Transparent Color', 'krystal-shop'),
        'solid' => __('Solid Color', 'krystal-shop'),      
     );

     if ( array_key_exists( $input, $valid ) ) {
        return $input;
     } else {
        return '';
     }
}
endif;

/**
 * Sanitize checkbox.
 *
 * @param bool $checked Whether the checkbox is checked.
 * @return bool Whether the checkbox is checked.
 */
if ( ! function_exists( 'krystal_shop_sanitize_checkbox_selection' ) ) :
function krystal_shop_sanitize_checkbox_selection( $checked ) {
    // Boolean check.
    return ( ( isset( $checked ) && true == $checked ) ? true : false );
}
endif;