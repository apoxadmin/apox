<?php
/**
 * Krystal Theme Customizer
 *
 * @package krystal
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */

if ( ! function_exists( 'krystal_customize_register' ) ) :
function krystal_customize_register( $wp_customize ) {

    require( get_template_directory() . '/inc/customizer/custom-controls/control-custom-content.php' );  

    // General Settings
    $wp_customize->add_section(
        'krystal_general_settings',
        array (
            'priority'      => 25,
            'capability'    => 'edit_theme_options',
            'theme_supports'=> '',
            'title'         => __( 'General Settings', 'krystal' )
        )
    );

    // Enable/disable section
    $wp_customize->add_setting(
        'kr_home_disable_section',
        array(
            'type' => 'theme_mod',
            'default'           => false,
            'sanitize_callback' => 'krystal_sanitize_checkbox_selection'
        )
    );

    $wp_customize->add_control(
        'kr_home_disable_section',
        array(
            'settings'      => 'kr_home_disable_section',
            'section'       => 'krystal_general_settings',
            'type'          => 'checkbox',
            'label'         => __( 'Disable Home Background Image Section:', 'krystal' ),
            'description'   => __( 'Choose whether to show this section in Home Page or not', 'krystal' ),           
        )
    );

    // Background selection
    $wp_customize->add_setting(
        'kr_home_bg_radio',
        array(
            'type' => 'theme_mod',
            'default'           => 'image',
            'sanitize_callback' => 'krystal_sanitize_radio_pagebg_selection'
        )
    );

    $wp_customize->add_control(
        'kr_home_bg_radio',
        array(
            'settings'      => 'kr_home_bg_radio',
            'section'       => 'krystal_general_settings',
            'type'          => 'radio',
            'label'         => __( 'Choose Home Background Color or Background Image:', 'krystal' ),
            'description'   => __('This setting will change the Home background area.', 'krystal'),
            'choices' => array(
                            'color' => __('Background Color','krystal'),
                            'image' => __('Background Image','krystal'),
                            ),
        )
    );

    // Background color
    $wp_customize->add_setting(
        'kr_home_bg_color',
        array(
            'type' => 'theme_mod',
            'default'           => '#555555',
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
        $wp_customize,
        'kr_home_bg_color',
        array(
        'label'      => __( 'Select Background Color', 'krystal' ),
        'description'   => __('This setting will add background color if Background Color was selected above.', 'krystal'),
        'section'    => 'krystal_general_settings',
        'settings'   => 'kr_home_bg_color',
        ) )
    );

    // Home Background Image 
    $wp_customize->add_setting(
        'kr_theme_home_bg',
        array(
            'type' => 'theme_mod',
            'sanitize_callback' => 'krystal_sanitize_image'
        )
    );

    $wp_customize->add_control(
      new WP_Customize_Image_Control(
          $wp_customize,
          'kr_theme_home_bg',
          array(
              'settings'      => 'kr_theme_home_bg',
              'section'       => 'krystal_general_settings',
              'label'         => __( 'Home Background Image', 'krystal' ),
              'description'   => __( 'This setting will add background image if Background Image was selected above.', 'krystal' )
          )
      )
    );

    // Home Section Heading text 
    $wp_customize->add_setting(
        'kr_home_heading_text',
        array(            
            'default'           => __('ENTER YOUR HEADING HERE','krystal'),
            'sanitize_callback' => 'krystal_sanitize_textarea',
            'transport' => 'postMessage',
        )
    );

    $wp_customize->add_control(
        'kr_home_heading_text',
        array(
            'settings'      => 'kr_home_heading_text',
            'section'       => 'krystal_general_settings',
            'type'          => 'textarea',
            'label'         => __( 'Heading Text', 'krystal' ),
            'description'   => __( 'heading for the home section', 'krystal' ),
        )
    );

    $wp_customize->selective_refresh->add_partial( 'kr_home_heading_text', array(
        'selector'            => '.slide-bg-section h1',   
        'settings'            => 'kr_home_heading_text',     
        'render_callback'     => 'krystal_home_heading_text_render_callback',
        'fallback_refresh'    => false, 
    ));

    // Home Section SubHeading text
    $wp_customize->add_setting(
        'kr_home_subheading_text',
        array(            
            'default'           => __('ENTER YOUR SUBHEADING HERE','krystal'),
            'sanitize_callback' => 'krystal_sanitize_textarea',
            'transport' => 'postMessage',
        )
    );

    $wp_customize->add_control(
        'kr_home_subheading_text',
        array(
            'settings'      => 'kr_home_subheading_text',
            'section'       => 'krystal_general_settings',
            'type'          => 'textarea',
            'label'         => __( 'SubHeading Text', 'krystal' ),
            'description'   => __( 'Subheading for the home section', 'krystal' ),
        )
    );

    $wp_customize->selective_refresh->add_partial( 'kr_home_subheading_text', array(
        'selector'            => '.slide-bg-section p',   
        'settings'            => 'kr_home_subheading_text',     
        'render_callback'     => 'krystal_home_subheading_text_render_callback',
        'fallback_refresh'    => false, 
    ));

    // Home Section Button text 
    $wp_customize->add_setting(
        'kr_home_button_text',
        array( 
            'type' => 'theme_mod',           
            'default'           => '',
            'sanitize_callback' => 'krystal_sanitize_html',
            
        )
    );

    $wp_customize->add_control(
        'kr_home_button_text',
        array(
            'settings'      => 'kr_home_button_text',
            'section'       => 'krystal_general_settings',
            'type'          => 'textbox',
            'label'         => __( 'Button Text', 'krystal' ),
            'description'   => __( 'Button text for the home section', 'krystal' ),
        )
    );  


    // Home Section Button url 
    $wp_customize->add_setting(
        'kr_home_button_url',
        array(
            'type' => 'theme_mod',
            'default'           => '',
            'sanitize_callback' => 'krystal_sanitize_url'
        )
    );

    $wp_customize->add_control(
        'kr_home_button_url',
        array(
            'settings'      => 'kr_home_button_url',
            'section'       => 'krystal_general_settings',
            'type'          => 'textbox',
            'label'         => __( 'Button URL', 'krystal' ),
            'description'   => __( 'Button URL for the home section, you can paste youtube or vimeo video url also', 'krystal' ),
        )
    );


    // Home Section Button2 text
    $wp_customize->add_setting(
        'kr_home_button2_text',
        array(
            'type' => 'theme_mod',
            'default'           => '',
            'sanitize_callback' => 'krystal_sanitize_html'
        )
    );

    $wp_customize->add_control(
        'kr_home_button2_text',
        array(
            'settings'      => 'kr_home_button2_text',
            'section'       => 'krystal_general_settings',
            'type'          => 'textbox',
            'label'         => __( 'Button 2 Text', 'krystal' ),
            'description'   => __( 'Button 2 text for the home section', 'krystal' ),
        )
    );


    // Home Section Button2 url 
    $wp_customize->add_setting(
        'kr_home_button2_url',
        array(
            'type' => 'theme_mod',
            'default'           => '',
            'sanitize_callback' => 'krystal_sanitize_url'
        )
    );

    $wp_customize->add_control(
        'kr_home_button2_url',
        array(
            'settings'      => 'kr_home_button2_url',
            'section'       => 'krystal_general_settings',
            'type'          => 'textbox',
            'label'         => __( 'Button 2 URL', 'krystal' ),
            'description'   => __( 'Button 2 URL for the home section, you can paste youtube or vimeo video url also', 'krystal' ),
        )
    );

    // text position
    $wp_customize->add_setting(
        'kr_home_text_position',
        array(
            'type' => 'theme_mod',
            'default'           => 'center',
            'sanitize_callback' => 'krystal_sanitize_home_text_position_radio_selection'
        )
    );

    $wp_customize->add_control(
        'kr_home_text_position',
        array(
            'settings'      => 'kr_home_text_position',
            'section'       => 'krystal_general_settings',
            'type'          => 'radio',
            'label'         => __( 'Select Text Position:', 'krystal' ),
            'description'   => '',
            'choices' => array(
                            'left' =>__( 'Left', 'krystal' ),
                            'center' =>__( 'Center', 'krystal' ),
                            'right' => __( 'Right', 'krystal' ),                            
                            ),
        )
    );

    // Parallax Scroll for background image 
    $wp_customize->add_setting(
        'kr_home_parallax',
        array(
            'type' => 'theme_mod',
            'default'           => true,
            'sanitize_callback' => 'krystal_sanitize_checkbox_selection'
        )
    );

    $wp_customize->add_control(
        'kr_home_parallax',
        array(
            'settings'      => 'kr_home_parallax',
            'section'       => 'krystal_general_settings',
            'type'          => 'checkbox',
            'label'         => __( 'Enable Parallax Scroll:', 'krystal' ),
            'description'   => __( 'Choose whether to show a parallax scroll feature for the Home Background image', 'krystal' ),           
        )
    );

    // Enable Dark Overlay
    $wp_customize->add_setting(
        'kr_home_dark_overlay',
        array(
            'type' => 'theme_mod',
            'default'           => true,
            'sanitize_callback' => 'krystal_sanitize_checkbox_selection'
        )
    );

    $wp_customize->add_control(
        'kr_home_dark_overlay',
        array(
            'settings'      => 'kr_home_dark_overlay',
            'section'       => 'krystal_general_settings',
            'type'          => 'checkbox',
            'label'         => __( 'Enable Dark Overlay:', 'krystal' ),
            'description'   => __( 'Choose whether to show a dark overlay over background image', 'krystal' ),           
        )
    );

    // Blog Homepage
    $wp_customize->add_setting(
        'kr_blog_homepage',
        array(
            'type' => 'theme_mod',
            'default'           => false,
            'sanitize_callback' => 'krystal_sanitize_checkbox_selection'
        )
    );

    $wp_customize->add_control(
        'kr_blog_homepage',
        array(
            'settings'      => 'kr_blog_homepage',
            'section'       => 'krystal_general_settings',
            'type'          => 'checkbox',
            'label'         => __( 'Use this for Blog Homepage:', 'krystal' ),
            'description'   => __( 'Check this if you are having a Blog as front page', 'krystal' ),           
        )
    );

    //Header Styles
    $wp_customize->add_section(
        'kr_header_styles_settings',
        array (
            'priority'      => 25,
            'capability'    => 'edit_theme_options',
            'theme_supports'=> '',
            'title'         => __( 'Header Styles', 'krystal' )
        )
    );
    
    $wp_customize->add_setting(
        'kr_header_styles',
        array(
            'type' => 'theme_mod',
            'default'           => 'style1',
            'sanitize_callback' => 'krystal_sanitize_header_style_radio_selection'
        )
    );

    $wp_customize->add_control(
        'kr_header_styles',
        array(
            'settings'      => 'kr_header_styles',
            'section'       => 'kr_header_styles_settings',
            'type'          => 'radio',
            'label'         => __( 'Choose Header Style:', 'krystal' ),
            'description'   => '',
            'choices' => array(
                            'style1' => __('Header Style1 - This will show full background image as header with menu over the image', 'krystal'),
                            'style2' => __('Header Style2 - This header style will show background image below menu', 'krystal'),
                            ),
        )
    );
    

    //Sticky Header Settings
    $wp_customize->add_section(
        'krystal_sticky_header_settings',
        array (
            'priority'      => 25,
            'capability'    => 'edit_theme_options',
            'theme_supports'=> '',
            'title'         => __( 'Sticky Header Settings', 'krystal' )
        )
    );

    //enable sticky menu
    $wp_customize->add_setting(
        'kr_sticky_menu',
        array(
            'type' => 'theme_mod',
            'default'           => true,
            'sanitize_callback' => 'krystal_sanitize_checkbox_selection'
        )
    );

    $wp_customize->add_control(
        'kr_sticky_menu',
        array(
            'settings'      => 'kr_sticky_menu',
            'section'       => 'krystal_sticky_header_settings',
            'type'          => 'checkbox',
            'label'         => __( 'Enable Sticky Header Feature:', 'krystal' ),
            'description'   => __( 'Choose whether to enable a sticky header feature for the site', 'krystal' ),            
        )
    );

    // Mobile logo
    $wp_customize->add_setting(
        'kr_alt_logo',
        array(
            'type' => 'theme_mod',
            'sanitize_callback' => 'krystal_sanitize_image'
        )
    );

    $wp_customize->add_control(
      new WP_Customize_Image_Control(
          $wp_customize,
          'kr_alt_logo',
          array(
              'settings'      => 'kr_alt_logo',
              'section'       => 'krystal_sticky_header_settings',
              'label'         => __( 'Logo for Sticky Header', 'krystal' ),
              'description'   => __( 'Upload logo for Sticky Header. Recommended height is 45px', 'krystal' )
          )
      )
    );

    // Scroll Down Settings //
    $wp_customize->add_section(
        'krystal_scrolldown_settings',
        array (
            'priority'      => 25,
            'capability'    => 'edit_theme_options',
            'theme_supports'=> '',
            'title'         => __( 'Scroll Down Settings', 'krystal' )
        )
    );  

    $wp_customize->add_setting(
        'kr_home_scroll_down',
        array(
            'type' => 'theme_mod',
            'default'           => true,
            'sanitize_callback' => 'krystal_sanitize_checkbox_selection'
        )
    );

    $wp_customize->add_control(
        'kr_home_scroll_down',
        array(
            'settings'      => 'kr_home_scroll_down',
            'section'       => 'krystal_scrolldown_settings',
            'type'          => 'checkbox',
            'label'         => __( 'Enable Home scroll Feature:', 'krystal' ),
            'description'   => __( 'Choose whether to enable a scroll down feature for the Home section', 'krystal' ),           
        )
    );


    // Scroll Button url //
    $wp_customize->add_setting(
        'kr_scroll_button_url',
        array(
            'type' => 'theme_mod',
            'default'           => '',
            'sanitize_callback' => 'krystal_sanitize_url'
        )
    );

    $wp_customize->add_control(
        'kr_scroll_button_url',
        array(
            'settings'      => 'kr_scroll_button_url',
            'section'       => 'krystal_scrolldown_settings',
            'type'          => 'textbox',
            'label'         => __( 'Scroll Button URL', 'krystal' ),
            'description'   => __( 'Scroll Button URL for the home section', 'krystal' ),
        )
    );

    // Page settings
    $wp_customize->add_section(
        'krystal_page_settings',
        array (
            'priority'      => 25,
            'capability'    => 'edit_theme_options',
            'theme_supports'=> '',
            'title'         => __( 'Page Settings', 'krystal' )
        )
    );

    // Background selection
    $wp_customize->add_setting(
        'kr_page_bg_radio',
        array(
            'type' => 'theme_mod',
            'default'           => 'color',
            'sanitize_callback' => 'krystal_sanitize_radio_pagebg_selection'
        )
    );

    $wp_customize->add_control(
        'kr_page_bg_radio',
        array(
            'settings'      => 'kr_page_bg_radio',
            'section'       => 'krystal_page_settings',
            'type'          => 'radio',
            'label'         => __( 'Choose Page Title Background Color or Background Image:', 'krystal' ),
            'description'   => __('This setting will change the background of the page title area.', 'krystal'),
            'choices' => array(
                            'color' => __('Background Color','krystal'),
                            'image' => __('Background Image','krystal'),
                            ),
        )
    );

    // Background color
    $wp_customize->add_setting(
        'kr_page_bg_color',
        array(
            'type' => 'theme_mod',
            'default'           => '#555555',
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
        $wp_customize,
        'kr_page_bg_color',
        array(
        'label'      => __( 'Select Background Color', 'krystal' ),
        'description'   => __('This setting will add background color to the page title area if Background Color was selected above.', 'krystal'),
        'section'    => 'krystal_page_settings',
        'settings'   => 'kr_page_bg_color',
        ) )
    );

    // Background Image
    $wp_customize->add_setting(
        'kr_page_bg_image',
        array(
            'type' => 'theme_mod',
            'sanitize_callback' => 'krystal_sanitize_image'
        )
    );

    $wp_customize->add_control(
      new WP_Customize_Image_Control(
          $wp_customize,
          'kr_page_bg_image',
          array(
              'settings'      => 'kr_page_bg_image',
              'section'       => 'krystal_page_settings',
              'label'         => __( 'Select Background Image for Page', 'krystal' ),
              'description'   => __('This setting will add background image to the page title area if Background Image was selected above.', 'krystal'),
          )
      )
    );

    // Parallax Scroll for background image 
    $wp_customize->add_setting(
        'kr_page_bg_parallax',
        array(
            'type' => 'theme_mod',
            'default'           => true,
            'sanitize_callback' => 'krystal_sanitize_checkbox_selection'
        )
    );

    $wp_customize->add_control(
        'kr_page_bg_parallax',
        array(
            'settings'      => 'kr_page_bg_parallax',
            'section'       => 'krystal_page_settings',
            'type'          => 'checkbox',
            'label'         => __( 'Enable Parallax Scroll:', 'krystal' ),
            'description'   => __( 'Choose whether to show a parallax scroll feature for the Page Background image', 'krystal' ),           
        )
    );

    // Enable Dark Overlay
    $wp_customize->add_setting(
        'kr_page_dark_overlay',
        array(
            'type' => 'theme_mod',
            'default'           => false,
            'sanitize_callback' => 'krystal_sanitize_checkbox_selection'
        )
    );

    $wp_customize->add_control(
        'kr_page_dark_overlay',
        array(
            'settings'      => 'kr_page_dark_overlay',
            'section'       => 'krystal_page_settings',
            'type'          => 'checkbox',
            'label'         => __( 'Enable Dark Overlay:', 'krystal' ),
            'description'   => __( 'Choose whether to show a dark overlay over page header background', 'krystal' ),           
        )
    );

    // page title height from top //
    $wp_customize->add_setting(
        'kr_pagetitle_hft',
        array(
            'type' => 'theme_mod',
            'default'           => '125',
            'sanitize_callback' => 'absint'
        )
    );

    $wp_customize->add_control(
        'kr_pagetitle_hft',
        array(
            'settings'      => 'kr_pagetitle_hft',
            'section'       => 'krystal_page_settings',
            'type'          => 'textbox',
            'label'         => __( 'Page Title Height from Top(px)', 'krystal' ),
            'description'   => __( 'This will add top padding to the page title. Do not write px or em', 'krystal' ),
        )
    );

    // page title height from bottom //
    $wp_customize->add_setting(
        'kr_pagetitle_hfb',
        array(
            'type' => 'theme_mod',
            'default'           => '125',
            'sanitize_callback' => 'absint'
        )
    );

    $wp_customize->add_control(
        'kr_pagetitle_hfb',
        array(
            'settings'      => 'kr_pagetitle_hfb',
            'section'       => 'krystal_page_settings',
            'type'          => 'textbox',
            'label'         => __( 'Page Title Height from Bottom(px)', 'krystal' ),
            'description'   => __( 'This will add bottom padding to the page title. Do not write px or em', 'krystal' ),
        )
    );

          

    // Color Settings 
    $wp_customize->add_section(
        'krystal_color_settings',
        array (
            'priority'      => 25,
            'capability'    => 'edit_theme_options',
            'theme_supports'=> '',
            'title'         => __( 'Color Settings', 'krystal' )
        )
    );               

    
    // Link Color
    $wp_customize->add_setting(
        'kr_link_color',
        array(
            'type' => 'theme_mod',
            'default'           => '#444444',
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
        $wp_customize,
        'kr_link_color',
        array(
        'label'      => __( 'Links Color', 'krystal' ),
        'section'    => 'krystal_color_settings',
        'settings'   => 'kr_link_color',
        ) )
    );

    // Link Hover Color
    $wp_customize->add_setting(
        'kr_link_hover_color',
        array(
            'type' => 'theme_mod',
            'default'           => '#000000',
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
        $wp_customize,
        'kr_link_hover_color',
        array(
        'label'      => __( 'Links Hover Color', 'krystal' ),
        'section'    => 'krystal_color_settings',
        'settings'   => 'kr_link_hover_color',
        ) )
    );

    // Heading Color
    $wp_customize->add_setting(
        'kr_heading_color',
        array(
            'type' => 'theme_mod',
            'default'           => '#444444',
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
        $wp_customize,
        'kr_heading_color',
        array(
        'label'      => __( 'Headings Color', 'krystal' ),
        'section'    => 'krystal_color_settings',
        'settings'   => 'kr_heading_color',
        ) )
    );

    // Heading Hover Color
    $wp_customize->add_setting(
        'kr_heading_hover_color',
        array(
            'type' => 'theme_mod',
            'default'           => '#000000',
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
        $wp_customize,
        'kr_heading_hover_color',
        array(
        'label'      => __( 'Heading Hover Color', 'krystal' ),
        'section'    => 'krystal_color_settings',
        'settings'   => 'kr_heading_hover_color',
        ) )
    );


    // Buttons Color
    $wp_customize->add_setting(
        'kr_button_color',
        array(
            'type' => 'theme_mod',
            'default'           => '#444444',
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
        $wp_customize,
        'kr_button_color',
        array(
        'label'      => __( 'Buttons Color', 'krystal' ),
        'section'    => 'krystal_color_settings',
        'settings'   => 'kr_button_color',
        ) )
    );

    // Buttons Hover Color
    $wp_customize->add_setting(
        'kr_button_hover_color',
        array(
            'type' => 'theme_mod',
            'default'           => '#000000',
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
        $wp_customize,
        'kr_button_hover_color',
        array(
        'label'      => __( 'Buttons Hover Color', 'krystal' ),
        'section'    => 'krystal_color_settings',
        'settings'   => 'kr_button_hover_color',
        ) )
    );    


    // Transparent Buttons Hover Color
    $wp_customize->add_setting(
        'kr_trans_button_hover_color',
        array(
            'type' => 'theme_mod',
            'default'           => '#000000',
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
        $wp_customize,
        'kr_trans_button_hover_color',
        array(
        'label'      => __( 'Transparent Buttons Hover Color', 'krystal' ),
        'section'    => 'krystal_color_settings',
        'settings'   => 'kr_trans_button_hover_color',
        ) )
    );

    // Top menu color
    $wp_customize->add_setting(
        'kr_top_menu_color',
        array(
            'type' => 'theme_mod',
            'default'           => '#ffffff',
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
        $wp_customize,
        'kr_top_menu_color',
        array(
        'label'      => __( 'Top Menu Color', 'krystal' ),
        'section'    => 'krystal_color_settings',
        'settings'   => 'kr_top_menu_color',
        ) )
    );

    // Top menu button background color
    $wp_customize->add_setting(
        'kr_top_menu_button_color',
        array(
            'type' => 'theme_mod',
            'default'           => '#5b9dd9',
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
        $wp_customize,
        'kr_top_menu_button_color',
        array(
        'label'      => __( 'Top Menu Button Color', 'krystal' ),
        'section'    => 'krystal_color_settings',
        'settings'   => 'kr_top_menu_button_color',
        ) )
    );

    // Top menu button text color
    $wp_customize->add_setting(
        'kr_top_menu_button_text_color',
        array(
            'type' => 'theme_mod',
            'default'           => '#fff',
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
        $wp_customize,
        'kr_top_menu_button_text_color',
        array(
        'label'      => __( 'Top Menu Button Text Color', 'krystal' ),
        'section'    => 'krystal_color_settings',
        'settings'   => 'kr_top_menu_button_text_color',
        ) )
    );

    // Menu dropdown color
    $wp_customize->add_setting(
        'kr_top_menu_dd_color',
        array(
            'type' => 'theme_mod',
            'default'           => '#dd3333',
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
        $wp_customize,
        'kr_top_menu_dd_color',
        array(
        'label'      => __( 'Menu Dropdown Background Color', 'krystal' ),
        'section'    => 'krystal_color_settings',
        'settings'   => 'kr_top_menu_dd_color',
        ) )
    );

    // Home Background Image text color
    $wp_customize->add_setting(
        'kr_home_bg_image_text_color',
        array(
            'type' => 'theme_mod',
            'default'           => '#ffffff',
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
        $wp_customize,
        'kr_home_bg_image_text_color',
        array(
        'label'      => __( 'Home Background Image Text Color', 'krystal' ),
        'section'    => 'krystal_color_settings',
        'settings'   => 'kr_home_bg_image_text_color',
        ) )
    );

    // Page Background Image text color
    $wp_customize->add_setting(
        'kr_page_bg_image_text_color',
        array(
            'type' => 'theme_mod',
            'default'           => '#ffffff',
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
        $wp_customize,
        'kr_page_bg_image_text_color',
        array(
        'label'      => __( 'Page Background Image Text Color', 'krystal' ),
        'section'    => 'krystal_color_settings',
        'settings'   => 'kr_page_bg_image_text_color',
        ) )
    );

    // Contact form elements color
    $wp_customize->add_setting(
        'kr_cf_text_color',
        array(
            'type' => 'theme_mod',
            'default'           => '#555555',
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
        $wp_customize,
        'kr_cf_text_color',
        array(
        'label'      => __( 'Contact Form Color', 'krystal' ),
        'section'    => 'krystal_color_settings',
        'settings'   => 'kr_cf_text_color',
        ) )
    );

    // Contact form button color
    $wp_customize->add_setting(
        'kr_cf_button_bg_color',
        array(
            'type' => 'theme_mod',
            'default'           => '#555555',
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
        $wp_customize,
        'kr_cf_button_bg_color',
        array(
        'label'      => __( 'Contact Form Button Hover Color', 'krystal' ),
        'section'    => 'krystal_color_settings',
        'settings'   => 'kr_cf_button_bg_color',
        ) )
    );
    
     //Blog Settings
    $wp_customize->add_section(
        'krystal_blog_settings',
        array (
            'priority'      => 25,
            'capability'    => 'edit_theme_options',
            'theme_supports'=> '',
            'title'         => __( 'Blog Settings', 'krystal' )
        )
    );    

    // Blog Sidebar
    $wp_customize->add_setting(
        'kr_blog_sidebar',
        array(
            'type' => 'theme_mod',
            'default'           => 'right',
            'sanitize_callback' => 'krystal_sanitize_blog_sidebar_radio_selection'
        )
    );

    $wp_customize->add_control(
        'kr_blog_sidebar',
        array(
            'settings'      => 'kr_blog_sidebar',
            'section'       => 'krystal_blog_settings',
            'type'          => 'radio',
            'label'         => __( 'Select sidebar position:', 'krystal' ),
            'description'   => '',
            'choices' => array(
                            'right' => __( 'Right', 'krystal' ),
                            'left' =>__( 'Left', 'krystal' ),
                            ),
        )
    );

    //Footer Settings
    $wp_customize->add_section(
        'krystal_footer_settings',
        array (
            'priority'      => 25,
            'capability'    => 'edit_theme_options',
            'theme_supports'=> '',
            'title'         => __( 'Footer Settings', 'krystal' )
        )
    );

    // Copyright text
    $wp_customize->add_setting(
        'kr_copyright_text',
        array(
            'type' => 'theme_mod',
            'default'           => __('Copyrights 2017 krystal. All Rights Reserved','krystal'),
            'sanitize_callback' => 'krystal_sanitize_textarea'
        )
    );

    $wp_customize->add_control(
        'kr_copyright_text',
        array(
            'settings'      => 'kr_copyright_text',
            'section'       => 'krystal_footer_settings',
            'type'          => 'textarea',
            'label'         => __( 'Footer copyright text', 'krystal' ),
            'description'   => __( 'Copyright text to be displayed in the footer. HTML allowed.', 'krystal' )
        )
    );   

    // Footer widgets
    $wp_customize->add_setting(
        'kr_footer_widgets',
        array(
            'type' => 'theme_mod',
            'default'           => '4',
            'sanitize_callback' => 'krystal_sanitize_footer_widgets_radio_selection'
        )
    );

    $wp_customize->add_control(
        'kr_footer_widgets',
        array(
            'settings'      => 'kr_footer_widgets',
            'section'       => 'krystal_footer_settings',
            'type'          => 'radio',
            'label'         => __( 'Number of Footer Widgets:', 'krystal' ),
            'description'   => '',
            'choices' => array(
                            '3' => __( '3', 'krystal' ),
                            '4' =>__( '4', 'krystal' ),
                            ),
        )
    );       

    // Footer background color
    $wp_customize->add_setting(
        'kr_footer_bg_color',
        array(
            'type' => 'theme_mod',
            'default'           => '#000000',
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
        $wp_customize,
        'kr_footer_bg_color',
        array(
        'label'      => __( 'Footer Background Color', 'krystal' ),
        'section'    => 'krystal_footer_settings',
        'settings'   => 'kr_footer_bg_color',
        ) )
    );    
   

    // Footer Content Color
    $wp_customize->add_setting(
        'kr_footer_content_color',
        array(
            'type' => 'theme_mod',
            'default'           => '#ffffff',
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
        $wp_customize,
        'kr_footer_content_color',
        array(
        'label'      => __( 'Footer Content Color', 'krystal' ),
        'section'    => 'krystal_footer_settings',
        'settings'   => 'kr_footer_content_color',
        ) )
    );  

    // Footer links Color
    $wp_customize->add_setting(
        'kr_footer_links_color',
        array(
            'type' => 'theme_mod',
            'default'           => '#b3b3b3',
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
        $wp_customize,
        'kr_footer_links_color',
        array(
        'label'      => __( 'Footer Links Color', 'krystal' ),
        'section'    => 'krystal_footer_settings',
        'settings'   => 'kr_footer_links_color',
        ) )
    );

    // Preloader Settings
    $wp_customize->add_section(
        'krystal_preloader_settings',
        array (
            'priority'      => 25,
            'capability'    => 'edit_theme_options',
            'theme_supports'=> '',
            'title'         => __( 'Preloader Settings', 'krystal' )
        )
    );

    // Preloader Enable radio button 
    $wp_customize->add_setting(
        'kr_preloader_display',
        array(
            'type' => 'theme_mod',
            'default'           => true,
            'sanitize_callback' => 'krystal_sanitize_checkbox_selection'
        )
    );

    $wp_customize->add_control(
        'kr_preloader_display',
        array(
            'settings'      => 'kr_preloader_display',
            'section'       => 'krystal_preloader_settings',
            'type'          => 'checkbox',
            'label'         => __( 'Enable Preloader for site:', 'krystal' ),
            'description'   => __( 'Choose whether to show a preloader before a site opens', 'krystal' ),            
        )
    ); 

    // Image for preloader 
    $wp_customize->add_setting(
        'kr_preloader_image',
        array(
            'type' => 'theme_mod',
            'sanitize_callback' => 'krystal_sanitize_image'
        )
    );

    $wp_customize->add_control(
      new WP_Customize_Image_Control(
          $wp_customize,
          'kr_preloader_image',
          array(
              'settings'      => 'kr_preloader_image',
              'section'       => 'krystal_preloader_settings',
              'label'         => __( 'Preloader Image', 'krystal' ),
              'description'   => __( 'Upload image for preloader', 'krystal' )
          )
      )
    );    
   
}
endif;

add_action( 'customize_register', 'krystal_customize_register' );


/**
* Render callback for kr_topbar_phone
*
* 
* @return mixed
*/
if ( ! function_exists( 'krystal_topbar_phone_render_callback' ) ) :
function krystal_topbar_phone_render_callback(){
    return wp_kses_post( get_theme_mod( 'kr_topbar_phone' ) );
}
endif;

/**
* Render callback for kr_home_heading_text
*
* 
* @return mixed
*/
if ( ! function_exists( 'krystal_home_heading_text_render_callback' ) ) :
function krystal_home_heading_text_render_callback() {
    return wp_kses_post( get_theme_mod( 'kr_home_heading_text' ) );
}
endif;

/**
* Render callback for kr_home_subheading_text
*
* 
* @return mixed
*/
if ( ! function_exists( 'krystal_home_subheading_text_render_callback' ) ) :
function krystal_home_subheading_text_render_callback() {
    return wp_kses_post( get_theme_mod( 'kr_home_subheading_text' ) );
}
endif;

/**
 * Sanitize text box.
 *
 * @param string $input
 * @return string
 */
if ( ! function_exists( 'krystal_sanitize_text' ) ) :
function krystal_sanitize_text( $input ) {
    return esc_html( $input );
}
endif;

/**
 * Sanitize radio option buttons
 *
 * @param string $input
 * @return string
 */
if ( ! function_exists( 'krystal_sanitize_radio_selection' ) ) :
function krystal_sanitize_radio_selection( $input ) {
    $valid = array(
        'yes' => __('Yes', 'krystal'),
        'no' => __('No', 'krystal'),
     );

     if ( array_key_exists( $input, $valid ) ) {
        return $input;
     } else {
        return '';
     }
}
endif;

/**
 * Sanitize checkbox option buttons
 *
 * @param string $input
 * @return bool
 */
if ( ! function_exists( 'krystal_sanitize_checkbox_selection' ) ) :
function krystal_sanitize_checkbox_selection( $input ) {
    return ( ( isset( $input ) && true == $input ) ? true : false );
}
endif;

/**
 * Sanitize blog sidebar radio option 
 *
 * @param string $input
 * @return string
 */
if ( ! function_exists( 'krystal_sanitize_blog_sidebar_radio_selection' ) ) :
function krystal_sanitize_blog_sidebar_radio_selection(  $input ){
    $valid = array(
        'right' => __( 'Right', 'krystal' ),  
        'left' =>__( 'Left', 'krystal' ),      
     );

     if ( array_key_exists( $input, $valid ) ) {
        return $input;
     } else {
        return '';
     }
}
endif;

/**
 * Sanitize Footer Widgets Number select
 *
 * @param string $input
 * @return string
 */
if ( ! function_exists( 'krystal_sanitize_footer_widgets_radio_selection' ) ) :
function krystal_sanitize_footer_widgets_radio_selection( $input ){
    $valid = array(
        '3' => __( '3', 'krystal' ),
        '4' =>__( '4', 'krystal' ),
     );

     if ( array_key_exists( $input, $valid ) ) {
        return $input;
     } else {
        return '';
     }
}
endif;

/**
 * Sanitize radio bg option buttons
 *
 * @param string $input
 * @return string
 */
if ( ! function_exists( 'krystal_sanitize_radio_bg_selection' ) ) :
function krystal_sanitize_radio_bg_selection( $input ) {
    $valid = array(        
        'color' => __('Background Color','krystal'),
        'image' =>  __('Background Image','krystal'),
     );

     if ( array_key_exists( $input, $valid ) ) {
        return $input;
     } else {
        return '';
     }
}
endif;

/**
 * Sanitize blog style radio option
 *
 * @param string $input
 * @return string
 */
if ( ! function_exists( 'krystal_sanitize_blog_style_radio_selection' ) ) :
function krystal_sanitize_blog_style_radio_selection( $input ) {
    $valid = array(        
        'style1' => __('Style 1', 'krystal'),
        'style2' => __('Style 2', 'krystal'),
     );

     if ( array_key_exists( $input, $valid ) ) {
        return $input;
     } else {
        return '';
     }
}
endif;


/**
 * Sanitize radio pagebg option buttons
 *
 * @param string $input
 * @return string
 */
if ( ! function_exists( 'krystal_sanitize_radio_pagebg_selection' ) ) :
function krystal_sanitize_radio_pagebg_selection( $input ) {
    $valid = array(        
        'color' => __('Background Color','krystal'),
        'image' =>  __('Background Image','krystal'),
     );

     if ( array_key_exists( $input, $valid ) ) {
        return $input;
     } else {
        return '';
     }
}
endif;


/**
 * Sanitize Header style radio option
 *
 * @param string $input
 * @return string
 */
if ( ! function_exists( 'krystal_sanitize_header_style_radio_selection' ) ) :
function krystal_sanitize_header_style_radio_selection( $input ) {
    $valid = array(        
        'style1' => __('Header Style1 - This will show full background image as header with menu over the image', 'krystal'),
        'style2' => __('Header Style2 - This header style will show background image below menu', 'krystal'),
     );

     if ( array_key_exists( $input, $valid ) ) {
        return $input;
     } else {
        return '';
     }
}
endif;

/**
 * Sanitize home text position radio option
 *
 * @param string $input
 * @return string
 */
if ( ! function_exists( 'krystal_sanitize_home_text_position_radio_selection' ) ) :
function krystal_sanitize_home_text_position_radio_selection( $input ) {
    $valid = array(        
        'left' =>__( 'Left', 'krystal' ),
        'center' =>__( 'Center', 'krystal' ),
        'right' => __( 'Right', 'krystal' ),
     );

     if ( array_key_exists( $input, $valid ) ) {
        return $input;
     } else {
        return '';
     }
}
endif;

/**
 * Sanitize Footer Widget radio option
 *
 * @param string $input
 * @return string
 */
if ( ! function_exists( 'krystal_sanitize_footer_widgets_radio_selection' ) ) :
function krystal_sanitize_footer_widgets_radio_selection( $input ) {
    $valid = array(        
        '3' => __( '3', 'krystal' ),
        '4' =>__( '4', 'krystal' ),
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
if ( ! function_exists( 'krystal_sanitize_checkbox' ) ) :
function krystal_sanitize_checkbox( $checked ) {
    // Boolean check.
    return ( ( isset( $checked ) && true == $checked ) ? true : false );
}
endif;

/**
 * URL sanitization.
 *
 * @see esc_url_raw() https://developer.wordpress.org/reference/functions/esc_url_raw/
 *
 * @param string $url URL to sanitize.
 * @return string Sanitized URL.
 */
if ( ! function_exists( 'krystal_sanitize_url' ) ) :
function krystal_sanitize_url( $url ) {
    return esc_url_raw( $url );
}
endif;

/**
 * Select sanitization
 * @see sanitize_key()               https://developer.wordpress.org/reference/functions/sanitize_key/
 * @see $wp_customize->get_control() https://developer.wordpress.org/reference/classes/wp_customize_manager/get_control/
 *
 * @param string               $input   Slug to sanitize.
 * @param WP_Customize_Setting $setting Setting instance.
 * @return string Sanitized slug if it is a valid choice; otherwise, the setting default.
 */
if ( ! function_exists( 'krystal_sanitize_select' ) ) :
function krystal_sanitize_select( $input, $setting ) {

    // Ensure input is a slug.
    $input = sanitize_key( $input );

    // Get list of choices from the control associated with the setting.
    $choices = $setting->manager->get_control( $setting->id )->choices;

    // If the input is a valid key, return it; otherwise, return the default.
    return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}
endif;

/**
 * Sanitize textarea.
 *
 * @param string $input
 * @return string
 */
if ( ! function_exists( 'krystal_sanitize_textarea' ) ) :
function krystal_sanitize_textarea( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}
endif;

/**
 * Sanitize image.
 *
 * @param string               $image   Image filename.
 * @param WP_Customize_Setting $setting Setting instance.
 * @return string The image filename if the extension is allowed; otherwise, the setting default.
 */
if ( ! function_exists( 'krystal_sanitize_image' ) ) :
function krystal_sanitize_image( $image, $setting ) {
    /*
     * Array of valid image file types.
     *
     * The array includes image mime types that are included in wp_get_mime_types()
     */
    $mimes = array(
        'jpg|jpeg|jpe' => 'image/jpeg',
        'gif'          => 'image/gif',
        'png'          => 'image/png',
        'bmp'          => 'image/bmp',
        'tif|tiff'     => 'image/tiff',
        'ico'          => 'image/x-icon'
    );
    // Return an array with file extension and mime_type.
    $file = wp_check_filetype( $image, $mimes );
    // If $image has a valid mime_type, return it; otherwise, return the default.
    return ( $file['ext'] ? $image : $setting->default );
}
endif;

/**
 * Sanitize the Sidebar Position value.
 *
 * @param string $position.
 * @return string (left|right).
 */
if ( ! function_exists( 'krystal_sanitize_sidebar_position' ) ) :
function krystal_sanitize_sidebar_position( $position ) {
    if ( ! in_array( $position, array( 'left', 'right' ) ) ) {
        $position = 'right';
    }
    return $position;
}
endif;

/**
 * HTML sanitization
 *
 * @see wp_filter_post_kses() https://developer.wordpress.org/reference/functions/wp_filter_post_kses/
 *
 * @param string $html HTML to sanitize.
 * @return string Sanitized HTML.
 */
if ( ! function_exists( 'krystal_sanitize_html' ) ) :
function krystal_sanitize_html( $html ) {
    return wp_filter_post_kses( $html );
}
endif;

/**
 * CSS sanitization.
 *
 * @see wp_strip_all_tags() https://developer.wordpress.org/reference/functions/wp_strip_all_tags/
 *
 * @param string $css CSS to sanitize.
 * @return string Sanitized CSS.
 */
if ( ! function_exists( 'krystal_sanitize_css' ) ) :
function krystal_sanitize_css( $css ) {
    return wp_strip_all_tags( $css );
}
endif;

/**
 * Enqueue the customizer stylesheet.
 */
if ( ! function_exists( 'krystal_enqueue_customizer_stylesheets' ) ) :
function krystal_enqueue_customizer_stylesheets() {
    wp_register_style( 'krystal-customizer-css', get_template_directory_uri() . '/inc/customizer/assets/customizer.css', NULL, NULL, 'all' );
    wp_enqueue_style( 'krystal-customizer-css' );
}
endif;

add_action( 'customize_controls_print_styles', 'krystal_enqueue_customizer_stylesheets' );
