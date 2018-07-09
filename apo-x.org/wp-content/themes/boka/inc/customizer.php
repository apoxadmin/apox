<?php
/**
 * Boka Customizer.
 *
 * @package boka
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function boka_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	$wp_customize->get_section( 'title_tagline' )->title = __('Header', 'boka');

	/**
	 * Class Boka Divider
	 */
	class boka_divider extends WP_Customize_Control {
		public $type = 'divider';
		public $label = '';
		public function render_content() { ?>
			<h3 style="margin-top:15px; margin-bottom:0;background:#2cde9a;padding:9px 5px;color:#fff;text-transform:uppercase; text-align: center;letter-spacing: 2px;"><?php echo esc_html( $this->label ); ?></h3>
			<?php
		}
	}

	/*********************************************
	 * General
	 *********************************************/
	$wp_customize->add_setting('boka_options[divider]', array(
			'type'              => 'divider_control',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'esc_attr',
		)
	);
	$wp_customize->add_panel( 'general_settings_panel', array(
		'title' => __( 'General Settings', 'boka' ),
		'priority' => 10
	) );

	/********************* Sections ************************/

	$wp_customize->add_section( 'background_image', array(
		'title'          => __( 'Body Background Image', 'boka' ),
		'theme_supports' => 'custom-background',
		'panel' => 'general_settings_panel',
		'priority'       => 20
	) );

	$wp_customize->add_section( 'site_width', array(
		'title'          => __( 'Site Width', 'boka' ),
		'panel' => 'general_settings_panel',
		'priority'       => 10
	) );

	/********************* Site Layout ************************/

	$wp_customize->add_setting(
		'site_layout',
		array(
			'default'           => 'wide',
			'sanitize_callback' => 'boka_layout_sanitize',
		)
	);
	$wp_customize->add_control(
		'site_layout',
		array(
			'type'        => 'radio',
			'label'       => __( 'Site Layout', 'boka' ),
			'priority'       => 10,
			'section'     => 'site_width',
			'choices' => array(
				'wide'    => __( 'Wide', 'boka' ),
				'boxed'     => __( 'Boxed', 'boka' )
			),
		)
	);

	/*********************************************
	 * Header
	 *********************************************/

	/**
	 * Boka Divider
	 */

	$wp_customize->add_control( new boka_divider( $wp_customize, 'header_logo', array(
			'label' => __('Logo', 'boka'),
			'section' => 'title_tagline',
			'settings' => 'boka_options[divider]',
			'priority'      => 5
		) )
	);
	$wp_customize->add_control( new boka_divider( $wp_customize, 'header_favicon', array(
			'label' => __('Favicon', 'boka'),
			'section' => 'title_tagline',
			'settings' => 'boka_options[divider]',
			'priority'      => 50
		) )
	);

	$wp_customize->add_panel( 'header_panel', array(
		'title' => __( 'Header', 'boka' ),
		'priority' => 20
	) );

	/********************* Sections ************************/

	$wp_customize->add_section( 'title_tagline', array(
		'title'          => __( 'Header Content', 'boka' ),
		'panel' => 'header_panel',
		'priority'       => 5
	) );

	$wp_customize->add_section( 'header_design', array(
		'title'          => __( 'Header Design Options', 'boka' ),
		'panel' => 'header_panel',
		'priority'       => 10
	) );

	$wp_customize->add_section( 'menu_design', array(
		'title'          => __( 'Menu Design', 'boka' ),
		'panel' => 'header_panel',
		'priority'       => 20
	) );

	$wp_customize->add_section( 'top_bar', array(
		'title'          => __( 'Top Bar', 'boka' ),
		'panel' => 'header_panel',
		'priority'       => 30
	) );

	$wp_customize->add_section( 'header_image', array(
		'title'          => __( 'Hero Area', 'boka' ),
		'panel' => 'header_panel',
		'priority'       => 40
	) );

	/********************* Site Title and Tagline Color ************************/
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'header_textcolor',
			array(
				'label'         => __('Site Title and Tagline Color', 'boka'),
				'section'       => 'title_tagline'
			)
		)
	);
	/********************* Search ************************/

	$wp_customize->add_setting( 'search_enable', array(
		'default'           => '',
		'sanitize_callback' => 'boka_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'search_enable', array(
		'label' => __( 'Show/Hide Search Icon in Header', 'boka' ),
		'type' => 'checkbox',
		'section' => 'title_tagline',
		'priority'       => 40
	) );

	/********************* Header Design Option ************************/

	$wp_customize->add_setting(
		'header_bg_color',
		array(
			'default'           => '#fff',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'header_bg_color',
			array(
				'label'         => __('Header Background Color', 'boka'),
				'section'       => 'header_design',
				'settings'      => 'header_bg_color'
			)
		)
	);

	$wp_customize->add_setting(
		'header_border_color',
		array(
			'default'           => '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'header_border_color',
			array(
				'label'         => __('Header Border Color', 'boka'),
				'section'       => 'header_design'
			)
		)
	);

	$wp_customize->add_setting(
		'header_border_style',
		array(
			'default'           => 'none',
			'sanitize_callback' => 'boka_border_style_sanitize',
		)
	);
	$wp_customize->add_control(
		'header_border_style',
		array(
			'type'        => 'select',
			'label'       => __( 'Header Border style', 'boka' ),
			'section'     => 'header_design',
			'choices' => array(
				'none'    => __( 'none', 'boka' ),
				'dotted'     => __( 'dotted', 'boka' ),
				'dashed'     => __( 'dashed', 'boka' ),
				'solid'     => __( 'solid', 'boka' ),
				'double'     => __( 'double', 'boka' ),
				'groove'     => __( 'groove', 'boka' ),
				'ridge'     => __( 'ridge', 'boka' )
			),
		)
	);

	$wp_customize->add_setting( 'header_border_size', array(
		'default'           => '1',
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'header_border_size', array(
		'label' => __( 'Header Border Size', 'boka' ),
		'type' => 'number',
		'section' => 'header_design'
	) );

	$wp_customize->add_setting( 'header_top_padding', array(
		'default'           => '',
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'header_top_padding', array(
		'label' => __( 'Header Padding Top', 'boka' ),
		'type' => 'number',
		'section' => 'header_design'
	) );

	$wp_customize->add_setting( 'header_bottom_padding', array(
		'default'           => '',
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'header_bottom_padding', array(
		'label' => __( 'Header Padding Bottom', 'boka' ),
		'type' => 'number',
		'section' => 'header_design'
	) );

	/********************* Menu Design ************************/
	$wp_customize->add_setting(
		'menu_layout',
		array(
			'default'           => 'wide',
			'sanitize_callback' => 'boka_layout_sanitize',
		)
	);
	$wp_customize->add_control(
		'menu_layout',
		array(
			'type'        => 'radio',
			'label'       => __( 'Menu Layout', 'boka' ),
			'section'     => 'menu_design',
			'choices' => array(
				'wide'    => __( 'default', 'boka' ),
				'collapse'     => __( 'Collapsed ( Pro Version )', 'boka' )
			),
		)
	);

	$wp_customize->add_setting(
		'menu_color',
		array(
			'default'           => '#888888',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'menu_color',
			array(
				'label'         => __('Menu Item Font Color', 'boka'),
				'section'       => 'menu_design'
			)
		)
	);

	$wp_customize->add_setting( 'menu_font_size', array(
		'default'           => '16',
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'menu_font_size', array(
		'label' => __( 'Menu Item Font Size', 'boka' ),
		'type' => 'number',
		'section' => 'menu_design'
	) );

	$wp_customize->add_setting( 'menu_font_weight', array(
		'default'           => '400',
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'menu_font_weight', array(
		'label' => __( 'Menu Item Font Weight', 'boka' ),
		'type' => 'number',
		'section' => 'menu_design'
	) );

	$wp_customize->add_setting( 'menu_indicator', array(
		'default'           => '',
		'sanitize_callback' => 'boka_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'menu_indicator', array(
		'label' => __( 'Show/Hide Dropdown Indicator ( Pro Version )', 'boka' ),
		'type' => 'checkbox',
		'section' => 'menu_design'
	) );

	$wp_customize->add_setting(
		'submenu_bg',
		array(
			'default'           => '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'submenu_bg',
			array(
				'label'         => __('Dropdown Area Background Color', 'boka'),
				'section'       => 'menu_design'
			)
		)
	);

	/********************* Top Bar ************************/
	$wp_customize->add_setting( 'enable_top_bar', array(
		'default'           => '',
		'sanitize_callback' => 'boka_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'enable_top_bar', array(
		'label' => __( 'Show/Hide Top Bar', 'boka' ),
		'type' => 'checkbox',
		'section' => 'top_bar'
	) );

	$wp_customize->add_setting(
		'top_bar_bg',
		array(
			'default'           => '#000',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'top_bar_bg',
			array(
				'label'         => __('Top Bar Background Color', 'boka'),
				'section'       => 'top_bar'
			)
		)
	);

	$wp_customize->add_setting(
		'top_bar_text_color',
		array(
			'default'           => '#fff',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'top_bar_text_color',
			array(
				'label'         => __('Top Bar Text Color', 'boka'),
				'section'       => 'top_bar'
			)
		)
	);

	$wp_customize->add_setting( 'enable_top_bar_social', array(
		'default'           => '',
		'sanitize_callback' => 'boka_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'enable_top_bar_social', array(
		'label' => __( 'Show/Hide Social Icons in Top Bar', 'boka' ),
		'type' => 'checkbox',
		'section' => 'top_bar'
	) );

	$wp_customize->add_setting( 'top_bar_text', array(
		'default'           => '',
		'sanitize_callback' => 'boka_sanitize_text',
	) );
	$wp_customize->add_control( 'top_bar_text', array(
		'label' => __( 'Top Bar Text', 'boka' ),
		'type' => 'textarea',
		'section' => 'top_bar',
		'priority'       => 30
	) );

	/********************* Header Banner Image with content ************************/
	$wp_customize->add_setting( 'enable_hero_area', array(
		'default'           => '',
		'sanitize_callback' => 'boka_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'enable_hero_area', array(
		'label' => __( 'Show/Hide Hero Area', 'boka' ),
		'type' => 'checkbox',
		'section' => 'header_image',
		'priority'       => 5
	) );

	$wp_customize->add_setting(
		'header_banner_bg',
		array(
			'default'           => '#1488cc',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'header_banner_bg',
			array(
				'label'         => __('Hero Area Background Color', 'boka'),
				'section'       => 'header_image',
				'priority'       => 10
			)
		)
	);

	$wp_customize->add_setting( 'header_banner_heading', array(
		'default'           => '',
		'sanitize_callback' => 'boka_sanitize_text',
	) );
	$wp_customize->add_control( 'header_banner_heading', array(
		'label' => __( 'Hero Area Heading', 'boka' ),
		'type' => 'text',
		'section' => 'header_image',
		'priority'       => 10
	) );

	$wp_customize->add_setting(
		'hero_area_heading_color',
		array(
			'default'           => '#fff',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'hero_area_heading_color',
			array(
				'label'         => __('Heading Font Color', 'boka'),
				'section'       => 'header_image',
				'priority'       => 10
			)
		)
	);

	$wp_customize->add_setting( 'header_banner_text', array(
		'default'           => '',
		'sanitize_callback' => 'boka_sanitize_text',
	) );
	$wp_customize->add_control( 'header_banner_text', array(
		'label' => __( 'Hero Area Paragraph', 'boka' ),
		'type' => 'textarea',
		'section' => 'header_image',
		'priority'       => 10
	) );

	$wp_customize->add_setting(
		'header_banner_text_color',
		array(
			'default'           => '#fff',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'header_banner_text_color',
			array(
				'label'         => __('Paragraph Font Color', 'boka'),
				'section'       => 'header_image',
				'priority'       => 10
			)
		)
	);

	$wp_customize->add_setting( 'header_banner_button_text', array(
		'default'           => '',
		'sanitize_callback' => 'boka_sanitize_text',
	) );
	$wp_customize->add_control( 'header_banner_button_text', array(
		'label' => __( 'Hero Area Button Text', 'boka' ),
		'type' => 'text',
		'section' => 'header_image',
		'priority'       => 10
	) );

	$wp_customize->add_setting( 'header_banner_button_link', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'header_banner_button_link', array(
		'label' => __( 'Button URL', 'boka' ),
		'type' => 'url',
		'section' => 'header_image',
		'priority'       => 10
	) );

	$wp_customize->add_setting(
		'header_banner_btn_bg_color',
		array(
			'default'           => '#fff',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'header_banner_btn_bg_color',
			array(
				'label'         => __('Button Background Color', 'boka'),
				'section'       => 'header_image'
			)
		)
	);

	$wp_customize->add_setting(
		'header_banner_btn_txt_color',
		array(
			'default'           => '#717171',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'header_banner_btn_txt_color',
			array(
				'label'         => __('Button Text Color', 'boka'),
				'section'       => 'header_image'
			)
		)
	);

	/*********************************************
	 * Social Links
	 *********************************************/
	$wp_customize->add_section( 'social_settings', array(
		'title' => __( 'Social Media', 'boka' ),
		'priority' => 60,
	) );

	/********************* Social ************************/
	$wp_customize->add_setting( 'header_fb', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'header_fb', array(
		'label' => __( 'Facebook', 'boka' ),
		'type' => 'url',
		'section' => 'social_settings',
		'settings' => 'header_fb'
	) );
	$wp_customize->add_setting( 'header_tw', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'header_tw', array(
		'label' => __( 'Twitter', 'boka' ),
		'type' => 'url',
		'section' => 'social_settings',
		'settings' => 'header_tw'
	) );
	$wp_customize->add_setting( 'header_li', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'header_li', array(
		'label' => __( 'Linkedin', 'boka' ),
		'type' => 'url',
		'section' => 'social_settings',
		'settings' => 'header_li'
	) );
	$wp_customize->add_setting( 'header_pint', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'header_pint', array(
		'label' => __( 'Pinterest', 'boka' ),
		'type' => 'url',
		'section' => 'social_settings',
		'settings' => 'header_pint'
	) );
	$wp_customize->add_setting( 'header_ins', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'header_ins', array(
		'label' => __( 'Instagram', 'boka' ),
		'type' => 'url',
		'section' => 'social_settings',
		'settings' => 'header_ins'
	) );
	$wp_customize->add_setting( 'header_dri', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'header_dri', array(
		'label' => __( 'Dribbble', 'boka' ),
		'type' => 'url',
		'section' => 'social_settings',
		'settings' => 'header_dri'
	) );
	$wp_customize->add_setting( 'header_plus', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'header_plus', array(
		'label' => __( 'Plus Google', 'boka' ),
		'type' => 'url',
		'section' => 'social_settings',
		'settings' => 'header_plus'
	) );
	$wp_customize->add_setting( 'header_you', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'header_you', array(
		'label' => __( 'YouTube', 'boka' ),
		'type' => 'url',
		'section' => 'social_settings',
		'settings' => 'header_you'
	) );

	/*********************************************
	 * Blog
	 *********************************************/

	$wp_customize->add_panel( 'blog_panel', array(
		'title' => __( 'Blog', 'boka' ),
		'priority' => 85
	) );

	/********************* Sections ************************/

	$wp_customize->add_section( 'blog_layout_settings', array(
		'title'          => __( 'Blog Layout', 'boka' ),
		'panel' => 'blog_panel',
		'priority'       => 10
	) );

	$wp_customize->add_section( 'blog_meta', array(
		'title'          => __( 'Post Meta', 'boka' ),
		'panel' => 'blog_panel',
		'priority'       => 20
	) );

	$wp_customize->add_section( 'blog_content_excerpt', array(
		'title'          => __( 'Post Excerpts', 'boka' ),
		'panel' => 'blog_panel',
		'priority'       => 30
	) );

	$wp_customize->add_section( 'blog_featured_image', array(
		'title'          => __( 'Featured Image', 'boka' ),
		'panel' => 'blog_panel',
		'priority'       => 40
	) );

	/********************* Blog Layout ************************/
	$wp_customize->add_setting(
		'blog_layout',
		array(
			'default'           => 'default',
			'sanitize_callback' => 'boka_blog_layout_sanitize',
		)
	);
	$wp_customize->add_control(
		'blog_layout',
		array(
			'type'        => 'radio',
			'label'       => __( 'Blog Layout', 'boka' ),
			'priority'       => 10,
			'section'     => 'blog_layout_settings',
			'choices' => array(
				'default'    => __( 'Default ( Sidebar )', 'boka' ),
				'blog-wide'     => __( 'Full Width', 'boka' ),
				'masonry'     => __( 'Masonry ( Two Columns )', 'boka' )
			),
		)
	);
	/********************* Blog Meta ************************/
	$wp_customize->add_setting( 'meta_index_enable', array(
		'default'           => '',
		'sanitize_callback' => 'boka_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'meta_index_enable', array(
		'label' => __( 'Show/Hide Blog Posts Meta', 'boka' ),
		'type' => 'checkbox',
		'section' => 'blog_meta',
		'priority'       => 20
	) );

	$wp_customize->add_setting( 'meta_single_enable', array(
		'default'           => '',
		'sanitize_callback' => 'boka_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'meta_single_enable', array(
		'label' => __( 'Show/Hide Single Posts Meta', 'boka' ),
		'type' => 'checkbox',
		'section' => 'blog_meta',
		'priority'       => 20
	) );
	/********************* Excerpt length ************************/
	$wp_customize->add_setting( 'excerpt_content_enable', array(
		'default'           => '',
		'sanitize_callback' => 'boka_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'excerpt_content_enable', array(
		'label' => __( 'Show/Hide Post Excerpts', 'boka' ),
		'type' => 'checkbox',
		'section' => 'blog_content_excerpt'
	) );
	$wp_customize->add_setting( 'excerpt_lenght', array(
		'default'           => '45',
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'excerpt_lenght', array(
		'type'        => 'number',
		'section'     => 'blog_content_excerpt',
		'settings' => 'excerpt_lenght',
		'label'       => __('Excerpt length', 'boka'),
		'description' => __('Default: 45 words', 'boka'),
		'input_attrs' => array(
			'min'   => 10,
			'max'   => 200,
			'step'  => 5,
		),
	) );
	/********************* Featured Image ************************/
	$wp_customize->add_setting( 'featured_image_index_enable', array(
		'default'           => '',
		'sanitize_callback' => 'boka_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'featured_image_index_enable', array(
		'label' => __( 'Show/Hide Blog Posts Featured Image', 'boka' ),
		'type' => 'checkbox',
		'section' => 'blog_featured_image',
		'priority'       => 30
	) );

	$wp_customize->add_setting( 'featured_image_single_enable', array(
		'default'           => '',
		'sanitize_callback' => 'boka_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'featured_image_single_enable', array(
		'label' => __( 'Show/Hide Single Posts Featured Image', 'boka' ),
		'type' => 'checkbox',
		'section' => 'blog_featured_image',
		'priority'       => 30
	) );
	/*********************************************
	 * Footer
	 *********************************************/
	$wp_customize->add_panel( 'footer_panel', array(
		'title' => __( 'Footer', 'boka' ),
		'priority' => 85
	) );

	/********************* Sections ************************/

	$wp_customize->add_section( 'footer_content', array(
		'title' => __( 'Footer Content', 'boka' ),
		'panel' => 'footer_panel',
		'priority' => 10,
	) );

	$wp_customize->add_section( 'footer_design', array(
		'title' => __( 'Footer Design Options', 'boka' ),
		'panel' => 'footer_panel',
		'priority' => 20,
	) );

	/********************* Footer Content ************************/
	$wp_customize->add_setting(
		'footer_widget_column',
		array(
			'default'           => 'two',
			'sanitize_callback' => 'boka_footer_column_sanitize',
		)
	);
	$wp_customize->add_control(
		'footer_widget_column',
		array(
			'type'        => 'radio',
			'label'       => __( 'Footer Column Settings', 'boka' ),
			'priority'       => 10,
			'section'     => 'footer_content',
			'choices' => array(
				'two'    => __( 'Two Columns', 'boka' ),
				'three'    => __( 'Three Columns', 'boka' ),
				'four'    => __( 'Four Columns', 'boka' )
			),
		)
	);

	$wp_customize->add_setting( 'social_footer_enable', array(
		'default'           => '',
		'sanitize_callback' => 'boka_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'social_footer_enable', array(
		'label' => __( 'Show/Hide Social Icons in Footer', 'boka' ),
		'type' => 'checkbox',
		'priority'       => 10,
		'section' => 'footer_content'
	) );

	$wp_customize->add_setting( 'copyright', array(
		'default'           => 'Boka By ThemeTim',
		'sanitize_callback' => 'boka_sanitize_text',
	) );
	$wp_customize->add_control( 'copyright', array(
		'label' => __( 'Footer Copyright Text', 'boka' ),
		'type' => 'textarea',
		'section' => 'footer_content',
		'priority'       => 10
	) );

	/********************* Footer Design Options ************************/
	$wp_customize->add_setting(
		'footer_bg_color',
		array(
			'default'           => '#1488cc',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'footer_bg_color',
			array(
				'label'         => __('Footer Background Color', 'boka'),
				'section'       => 'footer_design'
			)
		)
	);

	$wp_customize->add_setting(
		'footer_border_color',
		array(
			'default'           => '#cccccc',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'footer_border_color',
			array(
				'label'         => __('Footer Border Color', 'boka'),
				'section'       => 'footer_design'
			)
		)
	);

	$wp_customize->add_setting(
		'footer_text_color',
		array(
			'default'           => '#717171',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'footer_text_color',
			array(
				'label'         => __('Footer Text Color', 'boka'),
				'section'       => 'footer_design'
			)
		)
	);

	$wp_customize->add_setting(
		'footer_border_style',
		array(
			'default'           => 'none',
			'sanitize_callback' => 'boka_border_style_sanitize',
		)
	);
	$wp_customize->add_control(
		'footer_border_style',
		array(
			'type'        => 'select',
			'label'       => __( 'Footer Border style', 'boka' ),
			'section'     => 'footer_design',
			'choices' => array(
				'none'    => __( 'none', 'boka' ),
				'dotted'     => __( 'dotted', 'boka' ),
				'dashed'     => __( 'dashed', 'boka' ),
				'solid'     => __( 'solid', 'boka' ),
				'double'     => __( 'double', 'boka' ),
				'groove'     => __( 'groove', 'boka' ),
				'ridge'     => __( 'ridge', 'boka' )
			),
		)
	);

	$wp_customize->add_setting( 'footer_border_size', array(
		'default'           => '1',
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'footer_border_size', array(
		'label' => __( 'Footer Border Size', 'boka' ),
		'type' => 'number',
		'section' => 'footer_design'
	) );

	$wp_customize->add_setting( 'footer_top_padding', array(
		'default'           => '',
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'footer_top_padding', array(
		'label' => __( 'Footer Padding Top', 'boka' ),
		'type' => 'number',
		'section' => 'footer_design'
	) );

	$wp_customize->add_setting( 'footer_bottom_padding', array(
		'default'           => '28',
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'footer_bottom_padding', array(
		'label' => __( 'Footer Padding Bottom', 'boka' ),
		'type' => 'number',
		'section' => 'footer_design'
	) );

	/*********************************************
	 * Color
	 *********************************************/

	$wp_customize->add_setting(
		'primary_color',
		array(
			'default'           => '#1488cc',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'primary_color',
			array(
				'label'         => __('Primary Color', 'boka'),
				'section'       => 'colors',
				'settings'      => 'primary_color',
				'priority'       => 5
			)
		)
	);
	$wp_customize->add_setting(
		'link_color',
		array(
			'default'           => '#1488cc',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'link_color',
			array(
				'label'         => __('Link Color', 'boka'),
				'section'       => 'colors',
				'settings'      => 'link_color'
			)
		)
	);
	$wp_customize->add_setting(
		'link_hover_color',
		array(
			'default'           => '#2939b4',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'link_hover_color',
			array(
				'label'         => __('Link Hover Color', 'boka'),
				'section'       => 'colors',
				'settings'      => 'link_hover_color'
			)
		)
	);

	/*********************************************
	 * Typography
	 *********************************************/

	$wp_customize->add_panel( 'typography_panel', array(
		'title' => __( 'Typography', 'boka' ),
		'priority' => 40
	) );

	/********************* Sections ************************/

	$wp_customize->add_section( 'body_font', array(
		'title'          => __( 'Body Font', 'boka' ),
		'panel' => 'typography_panel',
		'priority'       => 10
	) );

	$wp_customize->add_section( 'heading_font', array(
		'title'          => __( 'Heading Font', 'boka' ),
		'panel' => 'typography_panel',
		'priority'       => 20
	) );

	/********************* Body Font ************************/
	$wp_customize->add_setting(
		'bg_text_color',
		array(
			'default'           => '#717171',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'bg_text_color',
			array(
				'label'         => __('Body Font Color', 'boka'),
				'section'       => 'body_font'
			)
		)
	);
	$wp_customize->add_setting( 'body_font_size', array(
		'default'           => '18',
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'body_font_size', array(
		'label' => __( 'Body Font Size', 'boka' ),
		'type' => 'number',
		'section' => 'body_font'
	) );

	$wp_customize->add_setting(
		'body_font_name',
		array(
			'default' => 'Source+Sans+Pro:300,400,700',
			'sanitize_callback'     => 'boka_sanitize_text',
		)
	);
	$wp_customize->add_control(
		'body_font_name',
		array(
			'type' => 'text',
			'label' => __('Body Font Name', 'boka'),
			'section' => 'body_font'
		)
	);
	$wp_customize->add_setting(
		'body_font_family',
		array(
			'default' => '\'Source Sans Pro\', sans-serif',
			'sanitize_callback'     => 'boka_sanitize_text',
		)
	);
	$wp_customize->add_control(
		'body_font_family',
		array(
			'type' => 'text',
			'label' => __('Body Font Family', 'boka'),
			'section' => 'body_font'
		)
	);
	$wp_customize->add_setting( 'body_font_weight', array(
		'default'           => '300',
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'body_font_weight', array(
		'label' => __( 'Body Font Weight', 'boka' ),
		'type' => 'text',
		'section' => 'body_font'
	) );

	/********************* Heading Font ************************/
	$wp_customize->add_setting(
		'heading_color',
		array(
			'default'           => '#333',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'heading_color',
			array(
				'label'         => __('Heading Color', 'boka'),
				'section'       => 'heading_font'
			)
		)
	);

	$wp_customize->add_setting('heading_font_name', array(
		'default'        => 'Nunito:300,400',
		'sanitize_callback'     => 'boka_sanitize_text',
	));
	$wp_customize->add_control( 'heading_font_name', array(
		'label'   => __('Heading Font Name', 'boka'),
		'section' => 'heading_font',
		'type'    => 'text'

	));
	$wp_customize->add_setting('heading_font_family', array(
		'default'        => '\'Nunito\', sans-serif',
		'sanitize_callback'     => 'boka_sanitize_text',
	));
	$wp_customize->add_control( 'heading_font_family', array(
		'label'   => __('Heading Font Family', 'boka'),
		'section' => 'heading_font',
		'type'    => 'text'

	));
	$wp_customize->add_setting( 'heading_font_weight', array(
		'default'           => '300',
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'heading_font_weight', array(
		'label' => __( 'Heading Font Weight', 'boka' ),
		'type' => 'text',
		'section' => 'heading_font'
	) );

	/*********************************************
	 * Page Title
	 *********************************************/

	$wp_customize->add_section( 'page_title_panel', array(
		'title'          => __( 'Page Title', 'boka' ),
		'priority'       => 50
	) );

	$wp_customize->add_setting( 'enable_page_title', array(
		'default'           => '',
		'sanitize_callback' => 'boka_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'enable_page_title', array(
		'label' => __( 'Show/Hide Page Title', 'boka' ),
		'type' => 'checkbox',
		'section' => 'page_title_panel'
	) );

	$wp_customize->add_setting(
		'page_title_background_color',
		array(
			'default'           => '#1488cc',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'page_title_background_color',
			array(
				'label'         => __('Background Color', 'boka'),
				'section' => 'page_title_panel'
			)
		)
	);

	$wp_customize->add_setting(
		'page_title_text_color',
		array(
			'default'           => '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'page_title_text_color',
			array(
				'label'         => __('Text Color', 'boka'),
				'section' => 'page_title_panel'
			)
		)
	);

	$wp_customize->add_setting( 'page_title_background_image', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw'
	) );

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'page_title_background_image',
			array(
				'label'          => __( 'Upload Background Image', 'boka' ),
				'type'           => 'image',
				'section'        => 'page_title_panel',
			)
		)
	);

	$wp_customize->add_setting( 'page_title_font_size', array(
		'default'           => '48',
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'page_title_font_size', array(
		'label' => __( 'Font Size', 'boka' ),
		'type' => 'number',
		'section' => 'page_title_panel'
	) );

	$wp_customize->add_setting( 'page_title_padding', array(
		'default'           => '85',
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'page_title_padding', array(
		'label' => __( 'Padding Top/Bottom', 'boka' ),
		'type' => 'number',
		'section' => 'page_title_panel'
	) );
}
add_action( 'customize_register', 'boka_customize_register' );

/**
 * Text
 * @param $input
 * @return string
 */

function boka_sanitize_text( $input ) {
	return wp_kses_post( force_balance_tags( $input ) );
}

/**
 * Checkbox
 * @param $input
 * @return int|string
 */
function boka_sanitize_checkbox( $input ) {
	if ( $input == 1 ) {
		return 1;
	} else {
		return '';
	}
}

/**
 * Site/Menu Layout Settings
 * @param $input
 * @return string
 * boka_footer_column_sanitize
 */
function boka_layout_sanitize( $input ) {
	$valid = array(
		'wide'    => __('Wide', 'boka'),
		'boxed'     => __('Boxed', 'boka'),
		'collapse'     => __('Collapse', 'boka')
	);

	if ( array_key_exists( $input, $valid ) ) {
		return $input;
	} else {
		return '';
	}
}

/**
 * Blog Layout Settings
 * @param $input
 * @return string
 */
function boka_blog_layout_sanitize( $input ) {
	$valid = array(
		'default'    => __( 'Default ( Sidebar )', 'boka' ),
		'blog-wide'     => __( 'Full Width', 'boka' ),
		'masonry'     => __( 'Masonry ( Two Columns )', 'boka' )
	);

	if ( array_key_exists( $input, $valid ) ) {
		return $input;
	} else {
		return '';
	}
}

/**
 * Header Border Style Settings
 * @param $input
 * @return string
 */
function boka_border_style_sanitize( $input ) {
	$valid = array(
		'none'    => __( 'none', 'boka' ),
		'dotted'     => __( 'dotted', 'boka' ),
		'dashed'     => __( 'dashed', 'boka' ),
		'solid'     => __( 'solid', 'boka' ),
		'double'     => __( 'double', 'boka' ),
		'groove'     => __( 'groove', 'boka' ),
		'ridge'     => __( 'ridge', 'boka' )
	);

	if ( array_key_exists( $input, $valid ) ) {
		return $input;
	} else {
		return '';
	}
}

/**
 * Footer Column Settings
 * @param $input
 * @return string
 */
function boka_footer_column_sanitize( $input ) {
	$valid = array(
		'two'    => __( 'Two Column', 'boka' ),
		'three'    => __( 'Three Column', 'boka' ),
		'four'    => __( 'Four Column', 'boka' )
	);

	if ( array_key_exists( $input, $valid ) ) {
		return $input;
	} else {
		return '';
	}
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function boka_customize_preview_js() {
	wp_enqueue_script( 'boka_customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'boka_customize_preview_js' );


