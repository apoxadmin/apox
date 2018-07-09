<?php
/**
 * businessbuilder Theme Customizer.
 *
 * @package businessbuilder
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function businessbuilder_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
    $wp_customize->get_section('header_image')->title = __( 'Header', 'businessbuilder' );
    $wp_customize->get_section('colors')->title = __( 'Background Color', 'businessbuilder' );
    $wp_customize->remove_control('display_header_text');
    


  $wp_customize->add_section(
    'businessbuilder_need_some_help',
    array(
      'title' => __('Need Some Help?', 'businessbuilder'),
      'priority' => 0,
      'description' => __('
        <p><strong>I have a problem with a plugin</strong>
        <br>
        Not all plugins are integrated in Businessbuilder, so if you are having problems with a plugin, please contact the plugin author.
        </p>
          <p><strong>I have a problem with WordPress Features</strong>
        <br>
        If you are having problems with WordPress or basic features, please go to the <a href="https://wordpress.org/support/" target="_blank">WordPress Support Forum</a> 
        </p>
          <p><strong>I have a problem with Businessbuilder Theme</strong>
        <br>
        If you are having problems with Businessbuilder theme please contact me at Email@vilhodesign.com or through this <a href="http://vilhodesign.com/contact/" target="_blank">contact form</a>.
        </p><br>
        <p><strong>Businessbuilder Premium Features</strong>
        <p>
        <a style="display:block;" href="http://vilhodesign.com/themes/businessbuilder/" target="_blank">
         <img src="http://vilhodesign.com/img/businessbuilder-info.png">
        </a>
        </p>
        ', 'businessbuilder') 
      )
    );  
  $wp_customize->add_setting('businessbuilder_needsomehelp_section', array(
    'sanitize_callback' => 'noneed',
    'type' => 'info_control',
    'capability' => 'edit_theme_options',
    )
  );
  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'needsomehelpsectiontab', array(
    'section' => 'businessbuilder_need_some_help',
    'settings' => 'businessbuilder_needsomehelp_section',
    'type' => 'textarea',
    'priority' => 109
    ) )
  );   

  $wp_customize->add_section(
    'businessbuilder_image_section',
    array(
      'title' => __('Unlock New Features', 'businessbuilder'),
      'priority' => 0,
      'description' => __('
        <p>
        <a style="display:block;" href="http://vilhodesign.com/themes/businessbuilder/" target="_blank">
         <img src="http://vilhodesign.com/img/businessbuilder-info.png">
        </a>
        </p>
        ', 'businessbuilder') 
      )
    );  
  $wp_customize->add_setting('businessbuilder_infosection', array(
    'sanitize_callback' => 'noneed',
    'type' => 'info_control',
    'capability' => 'edit_theme_options',
    )
  );
  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'topinfosection', array(
    'section' => 'businessbuilder_image_section',
    'settings' => 'businessbuilder_infosection',
    'type' => 'textarea',
    'priority' => 109
    ) )
  );  


 
    $wp_customize->add_panel( 'theme_options' ,
        array(
            'title'       => esc_html__( 'Theme Options', 'businessbuilder' ),
            'description' => ''
            )
        );
    $wp_customize->add_setting( 'header_title_color', array(
        'default'           => '#fff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
        ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_title_color', array(
        'label'       => __( 'Header Title Color', 'businessbuilder' ),
        'section'     => 'header_image',
        'priority' => 1,
        'settings'    => 'header_title_color',
        ) ) );

    $wp_customize->add_setting( 'header_tagline_color', array(
        'default'           => '#fff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
        ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_tagline_color', array(
        'label'       => __( 'Tagline Color', 'businessbuilder' ),
        'section'     => 'header_image',
        'priority' => 1,
        'settings'    => 'header_tagline_color',
        ) ) );

    $wp_customize->add_setting( 'header_bg_color', array(
        'default'           => '#1b1b1b',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
        ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_bg_color', array(
        'label'       => __( 'Header Background Color', 'businessbuilder' ),
        'description' => __( 'Applied to header background.', 'businessbuilder' ),
        'section'     => 'header_image',
        'settings'    => 'header_bg_color',
        ) ) );
    $wp_customize->add_control( 'header_textcolor', array(
        'label'    => __( 'Header Text Color', 'businessbuilder' ),
        'section'  => 'head_options',
        ) );





}
add_action( 'customize_register', 'businessbuilder_customize_register' );

function businessbuilder_sanitize_checkbox( $input ){
    if ( $input == 1 || $input == 'true' || $input === true ) {
        return 1;
    } else {
        return 0;
    }
}

function businessbuilder_sanitize_number( $number, $setting ) {
    $number = absint( $number );
    return ( $number ? $number : $setting->default );
}


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function businessbuilder_customize_preview_js() {
	wp_enqueue_script( 'businessbuilder_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'businessbuilder_customize_preview_js' );

/**
 * Load customizer style
 */
function businessbuilder_customizer_load_css(){
    wp_enqueue_style( 'businessbuilder-customizer', get_template_directory_uri() . '/css/customizer.css' );
}
add_action('customize_controls_print_styles', 'businessbuilder_customizer_load_css');



if(! function_exists('businessbuilder_custom_css' ) ):
/**
* Set the header background color 
*/
function businessbuilder_custom_css(){

    ?>

<style type="text/css">
    header#masthead { background-color: <?php echo esc_attr(get_theme_mod( 'header_bg_color')); ?>; }
    .site-title{ color: <?php echo esc_attr(get_theme_mod( 'header_title_color')); ?>; }
    p.site-description:before{ background: <?php echo esc_attr(get_theme_mod( 'header_tagline_color')); ?>; }
    p.site-description{ color: <?php echo esc_attr(get_theme_mod( 'header_tagline_color')); ?>; }
    .button-divider{ background-color: <?php echo esc_attr(get_theme_mod( 'header_button_divider_color')); ?>; }
    .header-button{ border-color: <?php echo esc_attr(get_theme_mod( 'header_button_color')); ?>; }
    .header-button{ color: <?php echo esc_attr(get_theme_mod( 'header_button_color')); ?>; }
    #site-navigation .menu li, #site-navigation .menu .sub-menu, #site-navigation .menu .children, nav#site-navigation{ background: <?php echo esc_attr(get_theme_mod( 'navigation_background_color')); ?>; }
    #site-navigation .menu li a, #site-navigation .menu li a:hover, #site-navigation .menu li a:active, #site-navigation .menu > li.menu-item-has-children > a:after, #site-navigation ul.menu ul a, #site-navigation .menu ul ul a, #site-navigation ul.menu ul a:hover, #site-navigation .menu ul ul a:hover, div#top-search a, div#top-search a:hover { color: <?php echo esc_attr(get_theme_mod( 'navigation_link_color')); ?>; }
    .m_menu_icon { background-color: <?php echo esc_attr(get_theme_mod( 'navigation_link_color')); ?>; }
    #top-social a, #top-social a:hover, #top-social a:active, #top-social a:focus, #top-social a:visited{ color: <?php echo esc_attr(get_theme_mod( 'navigation_social_link_color')); ?>; }  
    .top-widgets h1, .top-widgets h2, .top-widgets h3, .top-widgets h4, .top-widgets h5, .top-widgets h6 { color: <?php echo esc_attr(get_theme_mod( 'topwidgets_headline_color')); ?>; }
    .top-widgets p, .top-widgets, .top-widgets li, .top-widgets ol, .top-widgets cite{ color: <?php echo esc_attr(get_theme_mod( 'topwidgets_text_color')); ?>; }
    .top-widgets ul li a, .top-widgets a, .top-widgets a:hover, .top-widgets a:visited, .top-widgets a:focus, .top-widgets a:active, .top-widgets ol li a, .top-widgets li a, .top-widgets .menu li a, .top-widgets .menu li a:hover, .top-widgets .menu li a:active, .top-widgets .menu li a:focus{ color: <?php echo esc_attr(get_theme_mod( 'topwidgets_link_color')); ?>; }
    .blog .entry-cate a { color: <?php echo esc_attr(get_theme_mod( 'blogpage_category_color')); ?>; }
    .blog h2.entry-title a { color: <?php echo esc_attr(get_theme_mod( 'blogpage_headline_color')); ?>; }
    .blog time.entry-date { color: <?php echo esc_attr(get_theme_mod( 'blogpage_date_color')); ?>; }
    .blog .nav-next a:before, .blog .nav-previous a:before, .blog .posts-navigation a, .blog .entry-content, .blog .entry-content p { color: <?php echo esc_attr(get_theme_mod( 'blogpage_text_color')); ?>; }
    .blog .entry-more a, .blog .entry-more a:hover { background: <?php echo esc_attr(get_theme_mod( 'blogpage_button_color')); ?>; }
    .blog .entry-more a:hover { background: <?php echo esc_attr(get_theme_mod( 'blogpage_button_color')); ?>; }
    .blog #primary article.post { border-color: <?php echo esc_attr(get_theme_mod( 'blogpage_border_color')); ?>; }
    .single-post .comment-metadata time, .page .comment-metadata time, .single-post time.entry-date.published, .page time.entry-date.published, .single-post .posted-on a, .page .posted-on a { color: <?php echo esc_attr(get_theme_mod( 'postpage_date')); ?>; }
    .single-post #main th, .page #main th, .single-post .entry-cate a h2.entry-title, .single-post h1.entry-title, .page h2.entry-title, .page h1.entry-title, .single-post #main h1, .single-post #main h2, .single-post #main h3, .single-post #main h4, .single-post #main h5, .single-post #main h6, .page #main h1, .page #main h2, .page #main h3, .page #main h4, .page #main h5, .page #main h6 { color: <?php echo esc_attr(get_theme_mod( 'postpage_headline')); ?>; }
    .comments-title:after{ background: <?php echo esc_attr(get_theme_mod( 'postpage_headline')); ?>; }
    .post #main .nav-next a:before, .single-post #main .nav-previous a:before, .page #main .nav-previous a:before, .single-post #main .nav-next a:before, .single-post #main a, .page #main a{ color: <?php echo esc_attr(get_theme_mod( 'postpage_link')); ?>; }
    .page #main, .page #main p, .page #main th,.page .comment-form label, .single-post #main, .single-post #main p, .single-post #main th,.single-post .comment-form label, .single-post .comment-author .fn, .page .comment-author .fn   { color: <?php echo esc_attr(get_theme_mod( 'postpage_text')); ?>; }
     .page .comment-form input.submit, .single-post .comment-form input.submit,.single-post .comment-form input.submit:hover, .page .comment-form input.submit:hover { background-color: <?php echo esc_attr(get_theme_mod( 'postpage_button')); ?>; }
    .single-post #main .entry-cate a, .page #main .entry-cate a { color: <?php echo esc_attr(get_theme_mod( 'postpage_category')); ?>; }
    .single-post .comment-content, .page .comment-content, .single-post .navigation.post-navigation, .page .navigation.post-navigation, .single-post #main td, .page #main td,  .single-post #main th, .page #main th, .page #main input[type="url"], .single-post #main input[type="url"],.page #main input[type="text"], .single-post #main input[type="text"],.page #main input[type="email"], .single-post #main input[type="email"], .page #main textarea, .single-post textarea { border-color: <?php echo esc_attr(get_theme_mod( 'postpage_border')); ?>; }
    .top-widget-wrapper{ border-color: <?php echo esc_attr(get_theme_mod( 'topwidgets_border_color')); ?>; }
    .footer-widgets-wrapper{ background: <?php echo esc_attr(get_theme_mod( 'footer_background')); ?>; }
    .footer-widgets-wrapper h1, .footer-widgets-wrapper h2,  .footer-widgets-wrapper h3,  .footer-widgets-wrapper h4,  .footer-widgets-wrapper h5,  .footer-widgets-wrapper h6 { color: <?php echo esc_attr(get_theme_mod( 'footer_headline')); ?>; }
    .footer-widget-single, .footer-widget-single p, .footer-widgets-wrapper p, .footer-widgets-wrapper { color: <?php echo esc_attr(get_theme_mod( 'footer_text')); ?>; }
    .footer-widgets-wrapper  ul li a, .footer-widgets-wrapper li a,.footer-widgets-wrapper a,.footer-widgets-wrapper a:hover,.footer-widgets-wrapper a:active,.footer-widgets-wrapper a:focus, .footer-widget-single a, .footer-widget-single a:hover, .footer-widget-single a:active{ color: <?php echo esc_attr(get_theme_mod( 'footer_link')); ?>; }
    .footer-widget-single h3, .footer-widgets .search-form input.search-field { border-color: <?php echo esc_attr(get_theme_mod( 'footer_border')); ?>; }
    footer .site-info { background: <?php echo esc_attr(get_theme_mod( 'footer_copyright_background')); ?>; }
     footer .site-info { color: <?php echo esc_attr(get_theme_mod( 'footer_copyright_text')); ?>; }

    .mobile-site-name a { color: <?php echo esc_attr(get_theme_mod( 'mobile_site_name_color')); ?>; }
    .top-widgets-wrapper h3 { color: <?php echo esc_attr(get_theme_mod( 'top_widgets_title_color')); ?>; }
    .top-widgets-wrapper p, .top-widgets-wrapper, .top-widgets-wrapper .textwidget, .top-widgets-wrapper li { color: <?php echo esc_attr(get_theme_mod( 'top_widgets_text_color')); ?>; }
.top-widgets-wrapper a, .top-widgets-wrapper .menu li a { color: <?php echo esc_attr(get_theme_mod( 'top_widgets_link_color')); ?>; }
}   
</style>
<?php }
add_action( 'wp_head', 'businessbuilder_custom_css' );
endif;
