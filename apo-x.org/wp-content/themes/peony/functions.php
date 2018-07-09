<?php

//Global Variable & Constant
require get_template_directory() . '/peony-global.php';

// Helper library for the theme customizer.
require get_template_directory() . '/inc/customizer-library/customizer-library.php';
// Define options for the theme customizer.
require get_template_directory() . '/inc/customizer-options.php';

// Page options
require get_template_directory() . '/inc/page-options.php';

// MPL header
require get_template_directory() . '/inc/class-header.php';

/**
 * Theme setup
 */
if ( ! function_exists( 'peony_setup' ) ) :

function peony_setup() 
{
	global $content_width, $peony_options;

	$peony_options = get_theme_mods();

	if ( ! isset( $content_width ) ) {
		$content_width = str_replace('px','',peony_option('site_width',1170)); /* pixels */
	}
	
	
	load_theme_textdomain( 'peony' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'title-tag' );
	add_editor_style("editor-style.css");
	add_theme_support( 'custom-logo' );
	add_image_size( 'peony-related-post', 400, 300, true ); //(cropped)
	add_theme_support( 'infinite-scroll', array(
		'type'           => 'scroll',
		'footer_widgets' => array( 'col-aside-right', 'col-aside-left' ),
		'container'      => 'peony-infinite-scroll',
		'wrapper'        => true,
		'render'         => false,
		'posts_per_page' => false,
		'footer' => false,
		
	) );
	
	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'peony' ),
		'secondary' => __( 'Secondary Menu', 'peony' ),
		'top_bar_menu' => __( 'Top Bar Menu', 'peony' ),
		'custom_menu_1' => __( 'Custom Menu 1', 'peony' ),
		'custom_menu_2' => __( 'Custom Menu 2', 'peony' ),
		'custom_menu_3' => __( 'Custom Menu 3', 'peony' ),
		'custom_menu_4' => __( 'Custom Menu 4', 'peony' ),
		'custom_menu_5' => __( 'Custom Menu 5', 'peony' ),
		'custom_menu_6' => __( 'Custom Menu 6', 'peony' ),
	) );
	
	// Woocommerce Support
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
	
	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		 'comment-list', 'gallery', 'caption',
	) );
	
	// Setup the WordPress core custom header feature.
	add_theme_support( 'custom-header', array(
		'default-image'          => '',
		'random-default'         => false,
		'width'                  => '1920',
		'height'                 => '120',
		'flex-height'            => true,
		'flex-width'             => true,
		'default-text-color'     => '',
		'header-text'            => true,
		'uploads'                => true,
		'wp-head-callback'       => '',
		'admin-head-callback'    => '',
		'admin-preview-callback' => ''
	)); 

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'peony_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

}
endif; // peony_setup
add_action( 'after_setup_theme', 'peony_setup' );

/**
 * Get theme textdomain.
 */

function peony_get_textdomain(){
	
	$themename = get_option( 'stylesheet' );
	$themename = preg_replace("/\W/", "_", strtolower($themename) );
	return $themename;
	
	}

/**
 * Get theme option.
 */

function peony_option( $name, $default = false ) {
	   global $peony_options,$peony_default_options;
	   
	   $name = 'peony_'.$name;
	   if( $default == false )
	   $default = isset($peony_default_options[$name])?$peony_default_options[$name]:$default;
	   
		if ( isset( $peony_options[$name] ) ) {
				return apply_filters( "theme_mod_{$name}", $peony_options[$name] );
		}

		if ( is_string( $default ) )
				$default = sprintf( $default, get_template_directory_uri(), get_stylesheet_directory_uri() );
		return apply_filters( "theme_mod_{$name}", $default );
}

/**
 * Register widgets areas.
 */
add_action( 'widgets_init', 'peony_widgets' );
function peony_widgets(){
	global $peony_sidebars ;
	$peony_sidebars =   array(
		''  => __( 'No Sidebar', 'peony' ),
		'default_sidebar'  => __( 'Default Sidebar', 'peony' ),
		'sidebar-1'  => __( 'Sidebar 1', 'peony' ),
		'sidebar-2'  => __( 'Sidebar 2', 'peony' ),
		'sidebar-3'  => __( 'Sidebar 3', 'peony' ),
		'sidebar-4'  => __( 'Sidebar 4', 'peony' ),
		'sidebar-5'  => __( 'Sidebar 5', 'peony' ),
		'sidebar-5'  => __( 'Sidebar 5', 'peony' ),
		'sidebar-6'  => __( 'Sidebar 6', 'peony' ),
		'footer_widget_1'  => __( 'Footer Widget 1', 'peony' ),
		'footer_widget_2'  => __( 'Footer Widget 2', 'peony' ),
		'footer_widget_3'  => __( 'Footer Widget 3', 'peony' ),
		'footer_widget_4'  => __( 'Footer Widget 4', 'peony' ),
		'left_sidebar_404'  => __( '404 Page Left Sidebar', 'peony' ),
		'right_sidebar_404'  => __( '404 Page Right Sidebar', 'peony' ),
		);

	foreach( $peony_sidebars as $k => $v ){
		if( $k !='' ){
			register_sidebar(array(
				'name' => $v,
				'id'   => $k,
				'before_widget' => '<div id="%1$s" class="widget widget-box %2$s">', 
				'after_widget' => '<span class="seperator extralight-border"></span></div>', 
				'before_title' => '<h2 class="widget-title">', 
				'after_title' => '</h2>' 
			));
		}
	}

}

/**
 * Enqueue scripts and styles.
 */

function peony_scripts() {

	global $peony_homepage_sections,$content_width,$post, $peony_sticky_header, $peony_post_meta, $post;
	
	if(is_home()){
		$peony_post_meta = get_post_meta( get_queried_object_id(), '', true);
	}else{
		if ( $post && isset($post->ID) ) {
			$peony_post_meta = get_post_meta( $post->ID, '', true);
		}
	}
	
	$google_fonts        = peony_option('google_fonts');
	$peony_sticky_header = peony_option('sticky_header');
	
	if (trim($google_fonts) != '') {
		$google_fonts = str_replace(' ','+',trim($google_fonts));
		wp_enqueue_style('peony-google-fonts', esc_url('//fonts.googleapis.com/css?family='.$google_fonts), false, '', false );
	}

	wp_enqueue_style( 'bootstrap',  get_template_directory_uri() .'/plugins/bootstrap/css/bootstrap.css', false, '', false );
	wp_enqueue_style( 'font-awesome',  get_template_directory_uri() .'/plugins/font-awesome/css/font-awesome.css', false, '', false );
	wp_enqueue_style( 'owl-carousel',  get_template_directory_uri() .'/plugins/owl-carousel/assets/owl.carousel.css', false, '', false );
	wp_enqueue_style( 'owl-theme-default',  get_template_directory_uri() .'/plugins/owl-carousel/assets/owl.theme.default.css', false, '', false );
	wp_enqueue_style( 'prettyphoto',  get_template_directory_uri() .'/plugins/jquery-prettyPhoto/prettyPhoto.css', false, '', false );
	wp_enqueue_style( 'peony-bbpress',  get_template_directory_uri() .'/css/bbpress.css', false, '', false );

	wp_enqueue_style( 'peony-woocommerce',  get_template_directory_uri() .'/css/woocommerce.css', false, '', false );
	wp_enqueue_style( 'component',  get_template_directory_uri() .'/css/component.css', false, '', false );
	
	if ( isset($peony_post_meta['peony_fullscreen'][0]) && $peony_post_meta['peony_fullscreen'][0] > 0 ){
		
		wp_enqueue_script( 'jquery-scrollify', get_template_directory_uri() . '/plugins/scrollify/jquery.scrollify.js' , array( 'jquery' ), null, true);
	
	}

	wp_enqueue_style( 'peony-style', get_stylesheet_uri(), array('bootstrap'), '', false );

	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/plugins/bootstrap/js/bootstrap.js' , array( 'jquery' ), null, true);
	wp_enqueue_script('masonry');
	wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/plugins/owl-carousel/owl.carousel.js' , array( 'jquery' ), null, true);
	wp_enqueue_script( 'jquery-prettyphoto', get_template_directory_uri() . '/plugins/jquery-prettyPhoto/jquery.prettyPhoto.js' , array( 'jquery' ), null, true);
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	

	wp_enqueue_script( 'jquery-infinitescroll', get_template_directory_uri() . '/plugins/jquery.infinitescroll.js', 'jquery', null, true );
	wp_enqueue_script( 'respond', get_template_directory_uri() . '/plugins/respond.min.js', 'jquery', null, true );
	//wp_enqueue_script( 'peony-header', get_template_directory_uri() . '/js/header.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'peony-main', get_template_directory_uri() . '/js/main.js', array( 'jquery' ), null, true );

	//## home page sections
	$i = 0;
	$custom_css       = '';
	$peony_custom_css = '';

	$display_main_menu     = esc_attr(peony_option('display_main_menu'));
	$nav_drawer_breakpoint = esc_attr(peony_option('nav_drawer_breakpoint'));
	$subnav_width          = esc_attr(peony_option('subnav_width'));
	
	if( !is_numeric($nav_drawer_breakpoint) )
		$nav_drawer_breakpoint = 920;

	$header_background_image     = get_header_image();
	$header_background_position  = peony_option('header_bg_pos');

	$header_background       = '';
	if( $header_background_image ){
		$header_background  .= "header#header{\r\n";
		$header_background  .= "background-image: url(".esc_url($header_background_image).");\r\n";	
		$header_background  .=  "background-position:".esc_attr($header_background_position).";";
		$header_background  .= "}\r\n";	
	}

	$peony_custom_css .= $header_background;
	$header_text_color = get_header_textcolor();

	if ( 'blank' != $header_text_color ) :

	$peony_custom_css .= ".site-nav > h1,
		.site-name,
		.site-tagline {
		color: #".esc_attr( $header_text_color )." !important;
	}\r\n";
	else:

	$peony_custom_css .= ".site-nav > h1,
		.site-name,
		.site-tagline {
			display: none;
		}\r\n
		.site-nav{\r\n
		padding-top: 60px;}\r\n";
		
	endif;

	$peony_custom_css .= "a.site-nav-toggle{display:block;}\r\n
				.normal-site-nav{display:none;}\r\n";
						  
	if( $display_main_menu == '1' || $display_main_menu == 'on' ){				  
	$peony_custom_css .= "@media screen and (min-width: ".$nav_drawer_breakpoint."px){\r\n
				a.site-nav-toggle{display:none !important;}\r\n
				.normal-site-nav{display:block;}\r\n
				}\r\n";
	}
	
	if( is_numeric($subnav_width) && $subnav_width >0 ){
		$peony_custom_css .= ".normal-site-nav ul ul{width:".$subnav_width."px;}";
		}
	

	// Background Colors

	$header_background_color = peony_option('header_background_color');
	$menu_background_color = peony_option('menu_background_color');
	$page_background_color = peony_option('page_background_color');
	$page_title_bar_background_color = peony_option('page_title_bar_background_color');
	$footer_background_color = peony_option('footer_background_color');
	$copyright_background_color = peony_option('copyright_background_color');

	$peony_custom_css .= "header#header{\r\n";
	$peony_custom_css  .=  "background-color:".esc_attr($header_background_color).";";
	$peony_custom_css .= "}\r\n";

	$peony_custom_css .= "header#header .site-nav{\r\n";
	$peony_custom_css  .=  "background-color:".esc_attr($menu_background_color).";";
	$peony_custom_css .= "}\r\n";

	$peony_custom_css .= ".post-wrap,.page-content{\r\n";
	$peony_custom_css  .=  "background-color:".esc_attr($page_background_color).";";
	$peony_custom_css .= "}\r\n";

	$peony_custom_css .= ".page-title-bar{\r\n";
	$peony_custom_css  .=  "background-color:".esc_attr($page_title_bar_background_color).";";
	$peony_custom_css .= "}\r\n";

	$peony_custom_css .= ".footer-widget-area{\r\n";
	$peony_custom_css  .=  "background-color:".esc_attr($footer_background_color).";";
	$peony_custom_css .= "}\r\n";

	$peony_custom_css .= ".footer-info-area{\r\n";
	$peony_custom_css  .=  "background-color:".esc_attr($copyright_background_color).";";
	$peony_custom_css .= "}\r\n";


	//Main Color

	$copyright_color       = peony_option('copyright_color');
	$footer_social_color   = peony_option('footer_social_color');
	$btt_color             = peony_option('btt_color');
	$page_title_color      = peony_option('page_title_color');
	$breadcrumb_text_color = peony_option('breadcrumb_text_color');
	$breadcrumb_link_color = peony_option('breadcrumb_link_color');


	$peony_custom_css .= ".footer-info-area,.footer-info-area p,.footer-info-area a{\r\n";
	$peony_custom_css  .=  "color:".esc_attr($copyright_color).";";
	$peony_custom_css .= "}\r\n";
	
	$btt_color_rgb     = peony_hex2rgb($btt_color );
	$peony_custom_css .= ".scroll-to-top {\r\n";
	$peony_custom_css .=  "background-color: rgba(".absint($btt_color_rgb[0]).",".absint($btt_color_rgb[1]).",".absint($btt_color_rgb[2]).",.2);";
	$peony_custom_css .= "}\r\n";
	
	if( $page_title_color != '' ){
	$peony_custom_css .= "body .page-title,body .page-title h1{\r\n";
	$peony_custom_css  .=  "color:".esc_attr($page_title_color).";";
	$peony_custom_css .= "}\r\n";
	}

	$peony_custom_css .= ".breadcrumb-nav ,.breadcrumb-nav span{\r\n";
	$peony_custom_css  .=  "color:".esc_attr($breadcrumb_text_color).";";
	$peony_custom_css .= "}\r\n";

	$peony_custom_css .= ".breadcrumb-nav a{\r\n";
	$peony_custom_css  .=  "color:".esc_attr($breadcrumb_link_color).";";
	$peony_custom_css .= "}\r\n";

	 //Element Color
	$body_text_color    = peony_option('body_text_color');
	$body_link_color    = peony_option('body_link_color');
	$body_heading_color = peony_option('body_heading_color');
	$sidebar_widget_title_color = peony_option('sidebar_widget_title_color');
	$sidebar_widget_text_color = peony_option('sidebar_widget_text_color');
	$sidebar_link_color = peony_option('sidebar_link_color');

	$peony_custom_css  .= ".entry-content,entry-content p,entry-content span{\r\n";
	$peony_custom_css  .=  "color:".esc_attr($body_text_color).";";
	$peony_custom_css  .= "}\r\n";

	$peony_custom_css  .= ".entry-content a{\r\n";
	$peony_custom_css  .=  "color:".esc_attr($body_link_color).";";
	$peony_custom_css  .= "}\r\n";

	if( $body_heading_color != '' ){
	$peony_custom_css .= "body .entry-content h1,
	body .entry-content h2,
	body .entry-content h3,
	body .entry-content h4,
	body .entry-content h5{\r\n";
	$peony_custom_css  .=  "color:".esc_attr($body_heading_color)." ;";
	$peony_custom_css .= "}\r\n";
	}

	if( $sidebar_widget_title_color != '' ){
	$peony_custom_css .= ".col-aside-right .widget-title,.col-aside-left .widget-title{\r\n";
	$peony_custom_css .=  "color:".esc_attr($sidebar_widget_title_color)." !important;";
	$peony_custom_css .= "}\r\n";
	}
	
	if( $sidebar_widget_text_color != '' ){
	$peony_custom_css  .= ".col-aside-right  .widget-box,
						.col-aside-right .widget-box span,
						.col-aside-left  .widget-box,
						.col-aside-left .widget-box span{\r\n";
	$peony_custom_css  .=  "color:".esc_attr($sidebar_widget_text_color)." !important;";
	$peony_custom_css  .= "}\r\n";
	}
	
	if( $sidebar_link_color != '' ){
	$peony_custom_css .= ".col-aside-right .widget-box a,.col-aside-left .widget-box a{\r\n";
	$peony_custom_css .=  "color:".esc_attr($sidebar_link_color)." !important;";
	$peony_custom_css .= "}\r\n";
	}
	
    //Menu Color
    $menu_toggle_color     = peony_option('menu_toggle_color');
	$menu_font_color       = peony_option('menu_font_color');
	$menu_hover_font_color = peony_option('menu_hover_font_color');

	if( $menu_toggle_color != '' ){
	$peony_custom_css .= ".site-nav-toggle i{\r\n";
	$peony_custom_css .=  "color:".esc_attr($menu_toggle_color).";";
	$peony_custom_css .= "}\r\n";
	$peony_custom_css .= "a.site-nav-toggle{\r\n";
	$peony_custom_css .=  "border: 1px solid ".esc_attr($menu_toggle_color).";";
	$peony_custom_css .= "}\r\n";
	}
	
	
	$peony_custom_css .= "header nav li a span,header nav li a{\r\n";
	$peony_custom_css  .=  "color:".esc_attr($menu_font_color).";";
	$peony_custom_css .= "}\r\n";
	
	$peony_custom_css .= "header nav li a span:hover,header nav li a:hover{\r\n";
	$peony_custom_css .=  "color:".esc_attr($menu_hover_font_color).";";
	$peony_custom_css .= "}\r\n";
	
	
	// page title bar

	$page_title_bar_top_padding           = esc_attr(peony_option('page_title_bar_top_padding'));
	$page_title_bar_bottom_padding        = esc_attr(peony_option('page_title_bar_bottom_padding'));
	$page_title_bar_background_img        = esc_url(peony_option('page_title_bar_background'));
	$page_title_bar_bg_pos                = esc_attr(peony_option('page_title_bar_bg_pos'));
	$page_title_bg_full                   = esc_attr(peony_option('page_title_bg_full'));

	
	
	$page_title_bar_background  = '';
	if( $page_title_bar_background_img ){
		$page_title_bar_background  .= ".page-title-bar{\r\n";
		
		$page_title_bar_background  .= "background-image: url(".$page_title_bar_background_img.");\r\n";
		if( $page_title_bg_full == '1' )
		$page_title_bar_background  .= "-webkit-background-size: cover;
								-moz-background-size: cover;
								-o-background-size: cover;
								background-size: cover;\r\n";
								
		if( $page_title_bar_bg_pos != '' )
		$page_title_bar_background  .= "background-position:".$page_title_bar_bg_pos.";";
								
        $page_title_bar_background  .= "}\r\n";
	}
	
	$peony_custom_css .= ".page-title-bar{
		padding-top:".$page_title_bar_top_padding .";
		padding-bottom:".$page_title_bar_bottom_padding .";
		}";
	
	$peony_custom_css .=  $page_title_bar_background ;

	// footer
	$footer_top_padding           = esc_attr(peony_option('footer_top_padding'));
	$footer_bottom_padding        = esc_attr(peony_option('footer_bottom_padding'));
	
	$peony_custom_css .= ".footer-widget-area{
		padding-top:".$footer_top_padding .";
		padding-bottom:".$footer_bottom_padding .";
		}";


	//  Font Family
	
	$body_font          = str_replace('&#039;','\'', esc_attr(peony_option('body_font')));
	$menu_font          = str_replace('&#039;','\'', esc_attr(peony_option('menu_font')));
	$headings_font      = str_replace('&#039;','\'', esc_attr(peony_option('headings_font')));
	$section_title_font = str_replace('&#039;','\'', esc_attr(peony_option('section_title_font')));
	
	if( $body_font ){
	$peony_custom_css  .= "body,body p{
		font-family:".$body_font.";
		}\r\n";
	}
	if( $menu_font ){
	$peony_custom_css  .= ".site-nav a,.site-nav span{
		font-family:".$menu_font.";
		}\r\n";
	}
	if( $menu_font ){
	$peony_custom_css  .= "h1,h2,h3,h4,h5,h6{
		font-family:".$headings_font.";
		}\r\n";
	}
	if( $section_title_font ){
	$peony_custom_css  .= ".section-title{
		font-family:".$section_title_font.";
		}\r\n";
	}

	// Font size
	
   $body_font_size                  = absint(peony_option('body_font_size'));
   $main_menu_font_size             = absint(peony_option('main_menu_font_size'));
   $secondary_menu_font_size        = absint(peony_option('secondary_menu_font_size'));
   $breadcrumb_font_size            = absint(peony_option('breadcrumb_font_size'));
   $sidebar_heading_font_size       = absint(peony_option('sidebar_heading_font_size'));
   $footer_widget_heading_font_size = absint(peony_option('footer_widget_heading_font_size'));
   
   $h1_font_size   = absint(peony_option('h1_font_size'));
   $h2_font_size   = absint(peony_option('h2_font_size'));
   $h3_font_size   = absint(peony_option('h3_font_size'));
   $h4_font_size   = absint(peony_option('h4_font_size'));
   $h5_font_size   = absint(peony_option('h5_font_size'));
   $h6_font_size   = absint(peony_option('h6_font_size'));
   
   $tagline_font_size    = absint(peony_option('h6_font_size'));
   $meta_data_font_size  = absint(peony_option('meta_data_font_size'));
   $page_title_font_size = absint(peony_option('page_title_font_size'));
   $blog_subtitle_font_size    = absint(peony_option('blog_subtitle_font_size'));
   $pagination_font_size    = absint(peony_option('pagination_font_size'));
   $woocommerce_icon_font_size    = absint(peony_option('woocommerce_icon_font_size'));

    $peony_custom_css  .= "body{ font-size:". $body_font_size ."px}";
	$peony_custom_css  .= "#menu-main > li > a > span{ font-size:". $main_menu_font_size ."px}";
	$peony_custom_css  .= "#menu-main li li a span{ font-size:". $secondary_menu_font_size ."px}";
	$peony_custom_css  .= ".breadcrumb-nav span,.breadcrumb-nav a{ font-size:". $breadcrumb_font_size ."px}";
	$peony_custom_css  .= ".post-wrap .widget-area .widget-title{ font-size:". $sidebar_heading_font_size ."px}";
	$peony_custom_css  .= ".footer-widget-area .widget-title{ font-size:". $footer_widget_heading_font_size ."px}";
	
	$peony_custom_css  .= "h1{ font-size:". $h1_font_size ."px}";
	$peony_custom_css  .= "h2{ font-size:". $h2_font_size ."px}";
	$peony_custom_css  .= "h3{ font-size:". $h3_font_size ."px}";
	$peony_custom_css  .= "h4{ font-size:". $h4_font_size ."px}";
	$peony_custom_css  .= "h5{ font-size:". $h5_font_size ."px}";
	$peony_custom_css  .= "h6{ font-size:". $h6_font_size ."px}";
	
	$peony_custom_css  .= ".site-tagline{ font-size:". $tagline_font_size ."px}";
	$peony_custom_css  .= ".page-title h1{ font-size:". $page_title_font_size ."px}";
	$peony_custom_css  .= ".page-title h3{ font-size:". $blog_subtitle_font_size ."px;font-family:'Open Sans', sans-serif;}";
	$peony_custom_css  .= ".post-pagination li a{ font-size:". $pagination_font_size ."px}";

	$primary_color     = peony_option('primary_color');
	
	if( $primary_color !="" ):
	
	//primary color
	
	$peony_custom_css  .= "
		.peony .text-primary {
	color: ".$primary_color.";
	}
	.entry-category {
    color: ".$primary_color.";
}

.entry-meta a:hover,
.entry-footer a:hover {
    color: ".$primary_color.";
}
	.peony .text-muted {
		color: #777;
	}
	
	.peony .text-light {
		color: #fff;
	}
	
	.peony a:active,
	.peony a:hover {
		color: ".$primary_color.";
	}
	
	.peony mark,
	.peony ins {
		background: ".$primary_color.";
	}
	
	.peony ::selection {
		background: ".$primary_color.";
	}
	
	.peony ::-moz-selection {
		background: ".$primary_color.";
	}
	
	.peony .btn-normal,
	.peony .mpl-btn-normal,
	.peony .mpl-contact-form input[type=\"submit\"],
	.peony .comment-form input[type=\"submit\"] {
		background-color: ".$primary_color.";
	}
	
	.peony .btn-normal:hover,
	.peony .mpl-btn-normal:hover,
	.peony .mpl-contact-form input[type=\"submit\"]:hover,
	.peony .comment-form input[type=\"submit\"]:hover {
		background-color: ".$primary_color.";
	}
	
	.peony .mpl-gallery-item-overlay a {
		color: ".$primary_color.";
	}
	
	.peony .img-box .img-overlay-icons i {
		background-color: ".$primary_color.";
	}
	
	.peony .mpl-person:hover .img-box {
		border-color: ".$primary_color.";
	}
	
	.peony .mpl-contact.style5 .mpl-contact-info {
		background-color: ".$primary_color.";
	}

	.peony .mpl-contact.style4 .mpl-contact-info i {
		background-color: ".$primary_color.";	
	}
	
	.peony .mpl-pricing-box.featured .panel-title,
	.peony .mpl-pricing-box.featured .pricing-tag {
		color: ".$primary_color.";
	}
	
	.peony .mpl-contact-form .form-control:focus,
	.peony .mpl-contact.style5 .mpl-contact-form .form-control:focus {
		border-color: ".$primary_color.";
	}
	
	.peony .entry-meta a:hover {
		color: ".$primary_color.";
	}
	
	.peony .mpl-blog-grid h3.entry-title a:hover {
		color: ".$primary_color.";
	}
	
	header.overlay .normal-site-nav > ul > li.current-menu-item > a,
	.normal-site-nav > ul > li.current-menu-item > a,
	.normal-site-nav .current-menu-item a,
	.peony .normal-site-nav > ul > li > a:hover,
	.peony .normal-site-nav > ul > li.active > a,
	.peony .normal-site-nav > ul > li.current > a{
		color: ".$primary_color.";
	}
	
	.peony .mpl-skill .progress-bar,
	.peony .mpl-progress-num {
		background-color: ".$primary_color.";
	}
	
	.woocommerce .star-rating {
		color: ".$primary_color.";
	}
	
	.woocommerce #respond input#submit,
	.woocommerce a.button,
	.woocommerce button.button,
	.woocommerce input.button,
	.woocommerce #respond input#submit.alt,
	.woocommerce a.button.alt,
	.woocommerce button.button.alt,
	.woocommerce input.button.alt {
		background-color: ".$primary_color.";
	}
	.woocommerce #respond input#submit:hover,
	.woocommerce a.button:hover,
	.woocommerce button.button:hover,
	.woocommerce input.button:hover,
	.woocommerce #respond input#submit.alt:hover,
	.woocommerce a.button.alt:hover,
	.woocommerce button.button.alt:hover,
	.woocommerce input.button.alt:hover {
		background-color: ".$primary_color.";
	}
	.yith-wcwl-wishlistexistsbrowse a,
	.yith-wcwl-wishlistaddedbrowse a {
	color: ".$primary_color." !important;
	}";
	
	endif;

	wp_add_inline_style( 'peony-style', $peony_custom_css );
	
	$blog_carousel_col = 3;
	
	$blog_pagination_type  = esc_attr(peony_option('blog_pagination_type','pagination'));
	
	$peony_side_menu = '';
	$postid          = '';
	
	$side_nav_show  = isset($peony_post_meta['peony_side_menu'][0])?$peony_post_meta['peony_side_menu'][0]:'';
	$side_nav_style = isset($peony_post_meta['peony_side_menu_style'][0])?$peony_post_meta['peony_side_menu_style'][0]:'smalldotstroke';
	if( is_numeric($side_nav_style) )
	$side_nav_style = 'smalldotstroke';
		
	wp_localize_script( 'peony-main', 'peony_params', array(
		'ajaxurl'  => admin_url('admin-ajax.php'),
		'themeurl' => get_template_directory_uri(),
		'blog_carousel_col'    => $blog_carousel_col,
		'blog_pagination_type' => $blog_pagination_type,
		'nav_drawer_breakpoint' => $nav_drawer_breakpoint,
		'sticky_header' => $peony_sticky_header,
		'postid' => $postid,
		'side_nav' => array( 
							'show' => $side_nav_show, 
							'style' => $side_nav_style, 
							),
	)  );

}
add_action( 'wp_enqueue_scripts', 'peony_scripts' );



/**
 * Convert Hex Code to RGB
 */
function peony_hex2rgb( $hex ) 
{
    if ( strpos( $hex,'rgb' ) !== FALSE ) {
        $rgb_part = strstr( $hex, '(' );
        $rgb_part = trim($rgb_part, '(' );
        $rgb_part = rtrim($rgb_part, ')' );
        $rgb_part = explode( ',', $rgb_part );

        $rgb = array($rgb_part[0], $rgb_part[1], $rgb_part[2], $rgb_part[3]);

    } elseif( $hex == 'transparent' ) {
        $rgb = array( '255', '255', '255', '0' );
    } else {

        $hex = str_replace( '#', '', $hex );

        if( strlen( $hex ) == 3 ) {
            $r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
            $g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
            $b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
        } else {
            $r = hexdec( substr( $hex, 0, 2 ) );
            $g = hexdec( substr( $hex, 2, 2 ) );
            $b = hexdec( substr( $hex, 4, 2 ) );
        }
        $rgb = array( $r, $g, $b );
    }

    return $rgb; 
}


/**
 * Get summary
 */
function peony_get_summary(){
	 
	$excerpt_or_content = peony_option('excerpt_or_content');
	 
	if( $excerpt_or_content == 'full_content' ){
		$output = get_the_content();
	}
	else{
		$output = get_the_excerpt();
	}
	return  $output;
	}


/**
 * Send email via contact form
 */
function peony_contact(){
  
  
	if( isset($_POST['terms']) && $_POST['terms']=='yes' && isset($_POST['checkboxWarning']) && $_POST['checkboxWarning'] === '') {
		$Error = __('Tick the checkbox to agree to our terms and conditions.','peony');
		$hasError = true;
	} 
  
	if(trim($_POST['message']) === '') {
		$Error =  __('Please enter a message.','peony');
		$hasError = true;
	} else {
		if(function_exists('stripslashes')) {
			$message = stripslashes(trim($_POST['message']));
		} else {
			$message = trim($_POST['message']);
		}
	}
  
  
	if(trim($_POST['subject']) === '') {
		$Error = __('Please enter your subject.','peony');
		$hasError = true;
	} else {
		$subject = trim($_POST['subject']);
	}
  
  
	if(trim($_POST['email']) === '')  {
		$Error = __('Please enter your email address.','peony');
		$hasError = true;
	} else if (!preg_match("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", trim($_POST['email']))) {
		$Error = __('You entered an invalid email address.','peony');
		$hasError = true;
	} else {
		$email = trim($_POST['email']);
	}
  
  
	if(trim($_POST['name']) === '') {
		$Error = __('Please enter your name.','peony');
		$hasError = true;
	} else {
		$name = trim($_POST['name']);
	}

	if(!isset($hasError)) {
	  
	if (isset($_POST['receiver']) && preg_match("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", trim($_POST['receiver']))) {
		$emailTo = $_POST['receiver'];
	}
	else{
		$emailTo = get_option('admin_email');
	}
	if($emailTo !=""){
	if(trim($_POST['subject']) === '')
		$subject = 'From '.$name;
	else
		$subject = trim($_POST['subject']);
	  
	$body  = __('Name','peony').': ';
	$body .= $name;
	$body .= "\n\n";
	$body .= __('Email','peony').': ';
	$body .= $email;
	$body .= "\n\n";
	$body .= __('Message','peony').': ';
	$body .= $message;
	$body .= "\n\n";
	  
	$headers  = sprintf(__('From: %s <%s>','peony'),$name,$emailTo);
	$headers .= "\r\n" ;
	$headers .=  sprintf(__('Reply-To: %s' ,'peony'), $email);;

	wp_mail($emailTo, $subject, $body, $headers);
	$emailSent = true;
	}
	echo json_encode(array("msg"=>__("Your message has been successfully sent!",'peony'),"error"=>0));
	  
	}
	else
	{
		echo json_encode(array("msg"=>$Error,"error"=>1));
	}
	die() ;
	}


add_action('wp_ajax_peony_contact',  'peony_contact');
add_action('wp_ajax_nopriv_peony_contact', 'peony_contact');
 
 
/**
 * Get breadcrumbs
 */

function peony_get_breadcrumb( $options = array()){
	global $post,$wp_query ;
	$postid = isset($post->ID)?$post->ID:"";
	
	$show_breadcrumb = "";
	if ( 'page' == get_option( 'show_on_front' ) && ( '' != get_option( 'page_for_posts' ) ) && $wp_query->get_queried_object_id() == get_option( 'page_for_posts' ) ) { 
	$postid = $wp_query->get_queried_object_id();
   }
  
	if(isset($postid) && is_numeric($postid)){
		$show_breadcrumb = get_post_meta( $postid, '_peony_show_breadcrumb', true );
	}
	if($show_breadcrumb == 'yes' || $show_breadcrumb==""){
	
		peony_breadcrumb( $options);
	}
	   
	}
	
/**
 * Get post content css class
 */
 function peony_get_content_class( $sidebar = '' ){
	 
	if( $sidebar == 'left' )
	return 'left-aside';
	if( $sidebar == 'right' )
	return 'right-aside';
	if( $sidebar == 'both' )
	return 'both-aside';
	if( $sidebar == 'none' )
	return 'no-aside';
	
	return 'no-aside';
	 
	}
	 
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function peony_posted_on( $echo = true ) {
	
	$return = '';
	$items  = array();
	$display_post_meta = peony_option('display_post_meta');
		
	if( $display_post_meta == '1' ){
		
	$display_meta_author     = peony_option('display_meta_author');
	$display_meta_date       = peony_option('display_meta_date');
	
	if( $display_meta_date == '1' )
		$items[] =  '<span class="entry-date">'. get_the_date(  ).'</span>';
		
	if( $display_meta_author == '1' )
		$items[] = '<span class="entry-author">'.__('By' ,'peony').' '.get_the_author_link().'</span>';
	
	$return .=  '<div class="entry-meta">';
	$return .=	implode(' | ', $items);
    $return .=  '</div>';
													
	}

	if( $echo == true )
		echo $return;
	else
		return $return;

}

/**
 * Modifies WordPress's built-in comments_popup_link() function to return a string instead of echo comment results
 */
function peony_get_comments_popup_link( $zero = false, $one = false, $more = false, $peony_css_class = '', $none = false ) {
	global $wpcommentspopupfile, $wpcommentsjavascript;
 
	$id = get_the_ID();
	 
	if ( false === $zero ) $zero = __( 'No Comments', 'peony');
	if ( false === $one ) $one = __( '1 Comment', 'peony');
	if ( false === $more ) $more = __( '% Comments', 'peony');
	if ( false === $none ) $none = __( 'Comments Off', 'peony');
 
	$number = get_comments_number( $id );
 
	$str = '';
 
	if ( 0 == $number && !comments_open() && !pings_open() ) {
		$str = '<span' . ((!empty($peony_css_class)) ? ' class="' . esc_attr( $peony_css_class ) . '"' : '') . '>' . $none . '</span>';
		return $str;
	}
	
 
	if ( post_password_required() ) {
     
		return '';
	}
 
    $str = '<a href="';
	if ( $wpcommentsjavascript ) {
		if ( empty( $wpcommentspopupfile ) )
			$home = esc_url(home_url());
		else
			$home = get_option('siteurl');
		$str .= $home . '/' . $wpcommentspopupfile . '?comments_popup=' . $id;
		$str .= '" onclick="wpopen(this.href); return false"';
		} else { // if comments_popup_script() is not in the template, display simple comment link
        if ( 0 == $number )
			$str .= esc_url(get_permalink()) . '#respond';
		else
			$str .= get_comments_link();
		$str .= '"';
	}
 
	if ( !empty( $peony_css_class ) ) {
		$str .= ' class="'.$peony_css_class.'" ';
	}
	$title = the_title_attribute( array('echo' => 0 ) );
 
	$str .= apply_filters( 'comments_popup_link_attributes', '' );
 
    $str .= ' title="' . esc_attr( sprintf( __('Comment on %s', 'peony'), $title ) ) . '">';
    $str .= peony_get_comments_number_str( $zero, $one, $more );
    $str .= '</a>';
     
	return $str;
}

/**
 * Modifies WordPress's built-in comments_number() function to return string instead of echo
 */
function peony_get_comments_number_str( $zero = false, $one = false, $more = false, $deprecated = '' ) {
	if ( !empty( $deprecated ) )
		_deprecated_argument( __FUNCTION__, '1.3' );
 
	$number = get_comments_number();
 
	if ( $number > 1 )
		$output = str_replace('%', number_format_i18n($number), ( false === $more ) ? __('% Comments', 'peony') : $more);
	elseif ( $number == 0 )
		$output = ( false === $zero ) ? __('No Comments', 'peony') : $zero;
	else // must be one
	$output = ( false === $one ) ? __('1 Comment', 'peony') : $one;
 
	return apply_filters('comments_number', $output, $number);
}


/**
 *  Custom comments list
 */	
function peony_comment($comment, $args, $depth) {

?>
   
<li <?php comment_class("comment media-comment"); ?> id="comment-<?php comment_ID() ;?>">
	<div class="media-avatar media-left">
	<?php echo get_avatar($comment,'70','' ); ?>
  </div>
  <div class="media-body">
      <div class="media-inner">
          <h4 class="media-heading clearfix">
             <?php echo get_comment_author_link();?> - <?php comment_date(); ?> <?php edit_comment_link(__('(Edit)','peony'),'  ','') ;?>
             <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ;?>
          </h4>
          
          <?php if ($comment->comment_approved == '0') : ?>
                   <em><?php _e('Your comment is awaiting moderation.','peony') ;?></em>
                   <br />
                <?php endif; ?>
                
          <div class="comment-content"><?php comment_text() ;?></div>
      </div>
  </div>
</li>
                                            
<?php
	}
/**
 * Infinite Scroll
 */
function peony_infinite_scroll_js() {
	if( ! is_singular() ) { ?>
	<script>
	
	
/**
 * Infinite Scroll + Masonry + ImagesLoaded
 */
 
(function($) {

if( (!peony_params.blog_pagination_type || peony_params.blog_pagination_type == 'pagination') && $('.blog-grid').length ){
	var $container = $('.blog-grid');

	// Masonry + ImagesLoaded
	$container.imagesLoaded(function(){
		$container.masonry({
			itemSelector: '.entry-box-wrap',
			
		});
	});
}

if( peony_params.blog_pagination_type == 'infinite_scroll' && $('.blog-grid').length ){
	// Main content container
	var $container = $('.blog-grid');

	// Masonry + ImagesLoaded
	$container.imagesLoaded(function(){
		$container.masonry({
			itemSelector: '.entry-box-wrap',
			
		});
	});

	// Infinite Scroll
	$container.infinitescroll({

		// selector for the paged navigation (it will be hidden)
		navSelector  : ".post-pagination",
		// selector for the NEXT link (to page 2)
		nextSelector : "a.next",
		// selector for all items you'll retrieve
		itemSelector : ".entry-box-wrap",

		// finished message
		loading: {
			finishedMsg: '<?php _e( 'No more pages to load.', 'peony' ); ?>'
			}
		},

		// Trigger Masonry as a callback
		function( newElements ) {
			// hide new items while they are loading
			var $newElems = $( newElements ).css({ opacity: 0 });
			// ensure that images load before adding to masonry layout
			$newElems.imagesLoaded(function(){
				// show elems now they're ready
				$newElems.animate({ opacity: 1 });
				$container.masonry( 'appended', $newElems, true );
			});

	});
}

if( peony_params.blog_pagination_type == 'infinite_scroll' && $('.blog-list-wrap').length && !$('.blog-grid').length ){
	// Main content container
	var $container = $('.blog-list-wrap');

	// Infinite Scroll
	$container.infinitescroll({

		// selector for the paged navigation (it will be hidden)
		navSelector  : ".post-pagination",
		// selector for the NEXT link (to page 2)
		nextSelector : "a.next",
		// selector for all items you'll retrieve
		itemSelector : ".entry-box-wrap",

		// finished message
		loading: {
			finishedMsg: '<?php _e( 'No more pages to load.', 'peony' ); ?>'
			}
		});

}

})(jQuery);

	
</script>
    <?php
	
	}
}

add_action( 'wp_footer', 'peony_infinite_scroll_js',100 );
	 
/**
* Shows a breadcrumb for all types of pages.
*/

function peony_breadcrumb( $args = array() ) {
	if ( function_exists( 'is_bbpress' ) && is_bbpress() )
		$breadcrumb = new peony_bbPress_Breadcrumb( $args );
	else
		$breadcrumb = new peony_Breadcrumb( $args );
		return $breadcrumb->trail();
	}
  
  
  /**
  * Creates a breadcrumbs menu for the site based on the current page that's being viewed by the user.
  *
  */
class peony_Breadcrumb {
  /**
  * Array of items belonging to the current breadcrumb.
  */
	public $items = array();
  /**
  * Arguments used to build the breadcrumb.
  */
	public $args = array();
  /**
  * Sets up the breadcrumb.
  */
	public function __construct( $args = array() ) {
	/* Remove the bbPress breadcrumbs. */
	add_filter( 'bbp_get_breadcrumb', '__return_false' );
	$defaults = array(
	'container' => 'div',
	'separator' => '&#47;',
	'before' => '',
	'after' => '',
	'show_on_front' => true,
	'network' => false,
	//'show_edit_link' => false,
	'show_title' => true,
	'show_browse' => true,
	'echo' => true,
	/* Post taxonomy (examples follow). */
	'post_taxonomy' => array(
	  'portfolio' => 'portfolio_category',
	// 'book' => 'genre',
	),

	'labels' => array()
	);
	$this->args = apply_filters( 'breadcrumb_trail_args', wp_parse_args( $args, $defaults ) );
	/* Merge the user-added labels with the defaults. */
	$this->args['labels'] = wp_parse_args( $this->args['labels'], $this->default_labels() );
	$this->do_trail_items();
  }
  
  /**
  * Formats and outputs the breadcrumb.
  */
	public function trail() {
	$breadcrumb = '';
	
	if ( !empty( $this->items ) && is_array( $this->items ) ) {

	$this->items = array_unique( $this->items );
	
	$breadcrumb = "\n\t\t" . '<' . tag_escape( $this->args['container'] ) . ' class="breadcrumb-trail breadcrumbs" itemprop="breadcrumb">';
	
	$breadcrumb .= ( !empty( $this->args['before'] ) ? "\n\t\t\t" . '<span class="trail-before">' . $this->args['before'] . '</span> ' . "\n\t\t\t" : '' );
	
	if ( true === $this->args['show_browse'] )
	$breadcrumb .= "\n\t\t\t" . '<span class="trail-browse">' . $this->args['labels']['browse'] . '</span> ';
	
	if ( 1 < count( $this->items ) )
	array_unshift( $this->items, '<span class="trail-begin">' . array_shift( $this->items ) . '</span>' );
	
	array_push( $this->items, '<span class="trail-end">' . array_pop( $this->items ) . '</span>' );
	
	$separator = ( !empty( $this->args['separator'] ) ? '<span class="sep">' . $this->args['separator'] . '</span>' : '<span class="sep">/</span>' );
	
	$breadcrumb .= join( "\n\t\t\t {$separator} ", $this->items );
	
	$breadcrumb .= ( !empty( $this->args['after'] ) ? "\n\t\t\t" . ' <span class="trail-after">' . $this->args['after'] . '</span>' : '' );
	
	$breadcrumb .= "\n\t\t" . '</' . tag_escape( $this->args['container'] ) . '>';
	}
	
	$breadcrumb = apply_filters( 'breadcrumb_trail', $breadcrumb, $this->args );
	if ( true === $this->args['echo'] )
	 echo $breadcrumb;
	else
	return $breadcrumb;
  }
  
  /**
  * Returns an array of the default labels.
  */
	public function default_labels() {
	$labels = array(
	'browse' => __( 'Browse:', 'peony' ),
	'home' => __( 'Home', 'peony' ),
	'error_404' => __( '404 Not Found', 'peony' ),
	'archives' => __( 'Archives', 'peony' ),
	'search' => __( 'Search results for &#8220;%s&#8221;', 'peony' ),
	'paged' => __( 'Page %s', 'peony' ),
	'archive_minute' => __( 'Minute %s', 'peony' ),
	'archive_week' => __( 'Week %s', 'peony' ),
	'archive_minute_hour' => '%s',
	'archive_hour' => '%s',
	'archive_day' => '%s',
	'archive_month' => '%s',
	'archive_year' => '%s',
	);
	return $labels;
	}
  
  /**
  * Runs through the various WordPress conditional tags to check the current page being viewed. Once
  * a condition is met, a specific method is launched to add items to the $items array.
  */
	public function do_trail_items() {
	/* If viewing the front page. */
	if ( is_front_page() ) {
	$this->do_front_page_items();
	}
	/* If not viewing the front page. */
	else {
	/* Add the network and site home links. */
	$this->do_network_home_link();
	$this->do_site_home_link();
	/* If viewing the home/blog page. */
	if ( is_home() ) {
	$this->do_posts_page_items();
	}
	/* If viewing a single post. */
	elseif ( is_singular() ) {
	$this->do_singular_items();
	}
	/* If viewing an archive page. */
	elseif ( is_archive() ) {
	if ( is_post_type_archive() )
	$this->do_post_type_archive_items();
	elseif ( is_category() || is_tag() || is_tax() )
	$this->do_term_archive_items();
	elseif ( is_author() )
	$this->do_user_archive_items();
	elseif ( get_query_var( 'minute' ) && get_query_var( 'hour' ) )
	$this->do_minute_hour_archive_items();
	elseif ( get_query_var( 'minute' ) )
	$this->do_minute_archive_items();
	elseif ( get_query_var( 'hour' ) )
	$this->do_hour_archive_items();
	elseif ( is_day() )
	$this->do_day_archive_items();
	elseif ( get_query_var( 'w' ) )
	$this->do_week_archive_items();
	elseif ( is_month() )
	$this->do_month_archive_items();
	elseif ( is_year() )
	$this->do_year_archive_items();
	else
	$this->do_default_archive_items();
	}
	/* If viewing a search results page. */
	elseif ( is_search() ) {
	$this->do_search_items();
	}
	/* If viewing the 404 page. */
	elseif ( is_404() ) {
	$this->do_404_items();
	}
	}
	/* Add paged items if they exist. */
	$this->do_paged_items();
	$this->items = apply_filters( 'breadcrumb_trail_items', $this->items, $this->args );
  }
  
  /**
  * Gets front items based on $wp_rewrite->front.
  */
	public function do_rewrite_front_items() {
	global $wp_rewrite;
	if ( $wp_rewrite->front )
	$this->do_path_parents( $wp_rewrite->front );
	}
  
  /**
  * Adds the page/paged number to the items array.
  */
	public function do_paged_items() {
	/* If viewing a paged singular post. */
	if ( is_singular() && 1 < get_query_var( 'paged' ) && true === $this->args['show_title'] )
	$this->items[] = sprintf( $this->args['labels']['paged'], number_format_i18n( absint( get_query_var( 'paged' ) ) ) );
	/* If viewing a paged archive-type page. */
	elseif ( is_paged() && true === $this->args['show_title'] )
	$this->items[] = sprintf( $this->args['labels']['paged'], number_format_i18n( absint( get_query_var( 'paged' ) ) ) );
	}
  
  /**
  * Adds the network (all sites) home page link to the items array.
  */
	public function do_network_home_link() {
	if ( is_multisite() && !is_main_site() && true === $this->args['network'] )
	$this->items[] = '<a href="' . esc_url(network_home_url()) . '" title="' . esc_attr( $this->args['labels']['home'] ) . '" rel="home">' . $this->args['labels']['home'] . '</a>';
	}
  
  /**
  * Adds the current site's home page link to the items array.
  */
	public function do_site_home_link() {
	$label = ( is_multisite() && !is_main_site() && true === $this->args['network'] ) ? get_bloginfo( 'name' ) : $this->args['labels']['home'];
	$rel = ( is_multisite() && !is_main_site() && true === $this->args['network'] ) ? '' : ' rel="home"';
	$this->items[] = '<a href="' . esc_url(home_url() ). '" title="' . esc_attr( get_bloginfo( 'name' ) ) . '"' . $rel .'>' . $label . '</a>';
	}
  
  /**
  * Adds items for the front page to the items array.
  */
	public function do_front_page_items() {
	  /* Only show front items if the 'show_on_front' argument is set to 'true'. */
	  if ( true === $this->args['show_on_front'] || is_paged() || ( is_singular() && 1 < get_query_var( 'paged' ) ) ) {
	  /* If on a paged view, add the home link items. */
	  if ( is_paged() ) {
	  $this->do_network_home_link();
	  $this->do_site_home_link();
	  }
	  /* If on the main front page, add the network home link item and the home item. */
	  else {
	  $this->do_network_home_link();
	  if ( true === $this->args['show_title'] )
	  $this->items[] = ( is_multisite() && true === $this->args['network'] ) ? get_bloginfo( 'name' ) : $this->args['labels']['home'];
	  }
	  }
	}
  
  /**
  * Adds items for the posts page (i.e., is_home()) to the items array.
  */
	public function do_posts_page_items() {
	  /* Get the post ID and post. */
	  $post_id = get_queried_object_id();
	  $post = get_page( $post_id );
	  if ( 0 < $post->post_parent )
	  $this->do_post_parents( $post->post_parent );
	  /* Get the page title. */
	  $title = get_the_title( $post_id );
	  /* Add the posts page item. */
	  if ( is_paged() )
	  $this->items[] = '<a href="' . get_permalink( $post_id ) . '" title="' . esc_attr( $title ) . '">' . $title . '</a>';
	  elseif ( $title && true === $this->args['show_title'] )
	  $this->items[] = $title;
	}
  
  /**
  * Adds singular post items to the items array.
  */
	public function do_singular_items() {
	  
	   $show_categories        = peony_option('breadcrumb_show_categories');
	   $show_post_type_archive = peony_option('breadcrumb_show_post_type_archive');
	  /* Get the queried post. */
	  $post = get_queried_object();
	  $post_id = get_queried_object_id();
	  
	  if( $show_categories == '1'){
	  if ( 0 < $post->post_parent )
	  $this->do_post_parents( $post->post_parent );
	  /* If the post doesn't have a parent, get its hierarchy based off the post type. */
	  else
	  $this->do_post_hierarchy( $post_id );
	  }
	  if( $show_post_type_archive == '1'){
	  /* Display terms for specific post type taxonomy if requested. */
	  $this->do_post_terms( $post_id );
	  }
	  /* End with the post title. */
	  if ( $post_title = single_post_title( '', false ) ) {
	  if ( 1 < get_query_var( 'paged' ) )
	  $this->items[] = '<a href="' . esc_url(get_permalink( $post_id )) . '" title="' . esc_attr( $post_title ) . '">' . $post_title . '</a>';
	  elseif ( true === $this->args['show_title'] )
	  $this->items[] = (strlen($post_title)>23?substr($post_title,0,20 ).'&hellip;':$post_title );
	  }
  }
  
  /**
  * Adds a specific post's parents to the items array.
  */
	public function do_post_parents( $post_id ) {
	  $parents = array();
	  while ( $post_id ) {
	  /* Get the post by ID. */
	  $post = get_post( $post_id );
	  /* Add the formatted post link to the array of parents. */
	  $parents[] = '<a href="' . esc_url(get_permalink( $post_id )) . '" title="' . esc_attr( get_the_title( $post_id ) ) . '">' . get_the_title( $post_id ) . '</a>';
	  /* If there's no longer a post parent, brea out of the loop. */
	  if ( 0 >= $post->post_parent )
	  break;
	  /* Change the post ID to the parent post to continue looping. */
	  $post_id = $post->post_parent;
	  }
	  /* Get the post hierarchy based off the final parent post. */
	  
	  $this->do_post_hierarchy( $post_id );
	  /* Merge the parent items into the items array. */
	  $this->items = array_merge( $this->items, array_reverse( $parents ) );
  }
  
  /**
  * Adds a post's terms from a specific taxonomy to the items array.
  */
	public function do_post_terms( $post_id ) {
	  /* Get the post type. */
	  $post_type = get_post_type( $post_id );
	  /* Add the terms of the taxonomy for this post. */
	  if ( !empty( $this->args['post_taxonomy'][ $post_type ] ) )
	  $this->items[] = get_the_term_list( $post_id, $this->args['post_taxonomy'][ $post_type ], '', ', ', '' );
	  }
	 
	  public function do_post_hierarchy( $post_id ) {
	  /* Get the post type. */
	  $post_type = get_post_type( $post_id );
	  $post_type_object = get_post_type_object( $post_type );
	  /* If this is the 'post' post type, get the rewrite front items and map the rewrite tags. */
	  if ( 'post' === $post_type ) {
	  
	  $this->do_rewrite_front_items();
	  /* Map the rewrite tags. */
	  $this->map_rewrite_tags( $post_id, get_option( 'permalink_structure' ) );
	  }
	  /* If the post type has rewrite rules. */
	  elseif ( false !== $post_type_object->rewrite ) {
	  if ( $post_type_object->rewrite['with_front'] )
	  $this->do_rewrite_front_items();
	  /* If there's a path, check for parents. */
	  if ( !empty( $post_type_object->rewrite['slug'] ) )
	  $this->do_path_parents( $post_type_object->rewrite['slug'] );
	  }
	  if ( !empty( $post_type_object->has_archive ) ) {
	  /* Add support for a non-standard label of 'archive_title' (special use case). */
	  $label = !empty( $post_type_object->labels->archive_title ) ? $post_type_object->labels->archive_title : $post_type_object->labels->name;
	  $this->items[] = '<a href="' . esc_url(get_post_type_archive_link( $post_type )) . '">' . $label . '</a>';
	  }
	}
  
  /**
  * Gets post types by slug. This is needed because the get_post_types() function doesn't exactly
  */
	public function get_post_types_by_slug( $slug ) {
	  $return = array();
	  $post_types = get_post_types( array(), 'objects' );
	  foreach ( $post_types as $type ) {
	  if ( $slug === $type->has_archive || ( true === $type->has_archive && $slug === $type->rewrite['slug'] ) )
	  $return[] = $type;
	  }
	  return $return;
	}
  
	public function do_term_archive_items() {
	  global $wp_rewrite;
	  /* Get some taxonomy and term variables. */
	  $term = get_queried_object();
	  $taxonomy = get_taxonomy( $term->taxonomy );
	  /* If there are rewrite rules for the taxonomy. */
	  if ( false !== $taxonomy->rewrite ) {
	  if ( $taxonomy->rewrite['with_front'] && $wp_rewrite->front )
	  $this->do_rewrite_front_items();
	  /* Get parent pages by path if they exist. */
	  $this->do_path_parents( $taxonomy->rewrite['slug'] );
	  /* Add post type archive if its 'has_archive' matches the taxonomy rewrite 'slug'. */
	  if ( $taxonomy->rewrite['slug'] ) {
	  $slug = trim( $taxonomy->rewrite['slug'], '/' );
	 
	  $matches = explode( '/', $slug );
	  /* If matches are found for the path. */
	  if ( isset( $matches ) ) {
	  /* Reverse the array of matches to search for posts in the proper order. */
	  $matches = array_reverse( $matches );
	  /* Loop through each of the path matches. */
	  foreach ( $matches as $match ) {
	  /* If a match is found. */
	  $slug = $match;
	  /* Get public post types that match the rewrite slug. */
	  $post_types = $this->get_post_types_by_slug( $match );
	  if ( !empty( $post_types ) ) {
	  $post_type_object = $post_types[0];
	  /* Add support for a non-standard label of 'archive_title' (special use case). */
	  $label = !empty( $post_type_object->labels->archive_title ) ? $post_type_object->labels->archive_title : $post_type_object->labels->name;
	  $this->items[] = '<a href="' . esc_url(get_post_type_archive_link( $post_type_object->name )) . '" title="' . esc_attr( $label ) . '">' . $label . '</a>';
	  /* Break out of the loop. */
	  break;
	  }
	  }
	  }
	  }
	  }
	  /* If the taxonomy is hierarchical, list its parent terms. */
	  if ( is_taxonomy_hierarchical( $term->taxonomy ) && $term->parent )
	  $this->do_term_parents( $term->parent, $term->taxonomy );
	  if ( is_paged() )
	  $this->items[] = '<a href="' . esc_url( get_term_link( $term, $term->taxonomy ) ) . '" title="' . esc_attr( single_term_title( '', false ) ) . '">' . single_term_title( '', false ) . '</a>';
	  elseif ( true === $this->args['show_title'] )
	  $this->items[] = single_term_title( '', false );
  }
 
  public function do_post_type_archive_items() {
	  /* Get the post type object. */
	  $post_type_object = get_post_type_object( get_query_var( 'post_type' ) );
	  if ( false !== $post_type_object->rewrite ) {
	  if ( $post_type_object->rewrite['with_front'] )
	  $this->do_rewrite_front_items();
	  /* If there's a rewrite slug, check for parents. */
	  if ( !empty( $post_type_object->rewrite['slug'] ) )
	  $this->do_path_parents( $post_type_object->rewrite['slug'] );
	  }
	  if ( is_paged() )
	  $this->items[] = '<a href="' . esc_url( get_post_type_archive_link( $post_type_object->name ) ) . '" title="' . esc_attr( post_type_archive_title( '', false ) ) . '">' . post_type_archive_title( '', false ) . '</a>';
	  elseif ( true === $this->args['show_title'] )
	  $this->items[] = post_type_archive_title( '', false );
  }
  /**
  * Adds the items to the trail items array for user (author) archives.
  */
	public function do_user_archive_items() {
	  global $wp_rewrite;
	  
	  $this->do_rewrite_front_items();
	  /* Get the user ID. */
	  $user_id = get_query_var( 'author' );
	  /* If $author_base exists, check for parent pages. */
	  if ( !empty( $wp_rewrite->author_base ) )
	  $this->do_path_parents( $wp_rewrite->author_base );
	  if ( is_paged() )
	  $this->items[] = '<a href="'. esc_url( get_author_posts_url( $user_id ) ) . '" title="' . esc_attr( get_the_author_meta( 'display_name', $user_id ) ) . '">' . get_the_author_meta( 'display_name', $user_id ) . '</a>';
	  elseif ( true === $this->args['show_title'] )
	  $this->items[] = get_the_author_meta( 'display_name', $user_id );
  }

	public function do_minute_hour_archive_items() {
  
	  $this->do_rewrite_front_items();
	  if ( true === $this->args['show_title'] )
	  $this->items[] = sprintf( $this->args['labels']['archive_minute_hour'], get_the_time( _x( 'g:i a', 'minute and hour archives time format', 'peony' ) ) );
  }
 
	public function do_minute_archive_items() {
  
	  $this->do_rewrite_front_items();
	  if ( true === $this->args['show_title'] )
	  $this->items[] = sprintf( $this->args['labels']['archive_minute'], get_the_time( _x( 'i', 'minute archives time format', 'peony' ) ) );
  }
  
	public function do_hour_archive_items() {
  
	  $this->do_rewrite_front_items();
	  if ( true === $this->args['show_title'] )
	  $this->items[] = sprintf( $this->args['labels']['archive_hour'], get_the_time( _x( 'g a', 'hour archives time format', 'peony' ) ) );
  }

	public function do_day_archive_items() {
  
	  $this->do_rewrite_front_items();
	  $year = sprintf( $this->args['labels']['archive_year'], get_the_time( _x( 'Y', 'yearly archives date format', 'peony' ) ) );
	  $month = sprintf( $this->args['labels']['archive_month'], get_the_time( _x( 'F', 'monthly archives date format', 'peony' ) ) );
	  $day = sprintf( $this->args['labels']['archive_day'], get_the_time( _x( 'j', 'daily archives date format', 'peony' ) ) );
	  $this->items[] = '<a href="' . get_year_link( get_the_time( 'Y' ) ) . '" title="' . esc_attr( $year ) . '">' . $year . '</a>';
	  $this->items[] = '<a href="' . get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) . '" title="' . esc_attr( $month ) . '">' . $month . '</a>';
	  if ( is_paged() )
	  $this->items[] = '<a href="' . get_day_link( get_the_time( 'Y' ), get_the_time( 'm' ), get_the_time( 'd' ) ) . '" title="' . esc_attr( $day ) . '">' . $day . '</a>';
	  elseif ( true === $this->args['show_title'] )
	  $this->items[] = $day;
  }

	public function do_week_archive_items() {
  
	  $this->do_rewrite_front_items();
	  $year = sprintf( $this->args['labels']['archive_year'], get_the_time( _x( 'Y', 'yearly archives date format', 'peony' ) ) );
	  $week = sprintf( $this->args['labels']['archive_week'], get_the_time( _x( 'W', 'weekly archives date format', 'peony' ) ) );
	  $this->items[] = '<a href="' . get_year_link( get_the_time( 'Y' ) ) . '" title="' . esc_attr( $year ) . '">' . $year . '</a>';
	  if ( is_paged() )
	  $this->items[] = get_archives_link( add_query_arg( array( 'm' => get_the_time( 'Y' ), 'w' => get_the_time( 'W' ) ), esc_url(home_url()) ), $week, false );
	  elseif ( true === $this->args['show_title'] )
	  $this->items[] = $week;
  }

	public function do_month_archive_items() {
  
	  $this->do_rewrite_front_items();
	  $year = sprintf( $this->args['labels']['archive_year'], get_the_time( _x( 'Y', 'yearly archives date format', 'peony' ) ) );
	  $month = sprintf( $this->args['labels']['archive_month'], get_the_time( _x( 'F', 'monthly archives date format', 'peony' ) ) );
	  $this->items[] = '<a href="' . get_year_link( get_the_time( 'Y' ) ) . '" title="' . esc_attr( $year ) . '">' . $year . '</a>';
	  if ( is_paged() )
	  $this->items[] = '<a href="' . get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) . '" title="' . esc_attr( $month ) . '">' . $month . '</a>';
	  elseif ( true === $this->args['show_title'] )
	  $this->items[] = $month;
  }

	public function do_year_archive_items() {
  
	  $this->do_rewrite_front_items();
	  $year = sprintf( $this->args['labels']['archive_year'], get_the_time( _x( 'Y', 'yearly archives date format', 'peony' ) ) );
	  if ( is_paged() )
	  $this->items[] = '<a href="' . get_year_link( get_the_time( 'Y' ) ) . '" title="' . esc_attr( $year ) . '">' . $year . '</a>';
	  elseif ( true === $this->args['show_title'] )
	  $this->items[] = $year;
  }
  
	public function do_default_archive_items() {
	  if ( is_date() || is_time() )
	  $this->do_rewrite_front_items();
	  if ( true === $this->args['show_title'] )
	  $this->items[] = $this->args['labels']['archives'];
  }
 
	public function do_search_items() {
	  if ( is_paged() )
	  $this->items[] = '<a href="' . get_search_link() . '" title="' . esc_attr( sprintf( $this->args['labels']['search'], get_search_query() ) ) . '">' . sprintf( $this->args['labels']['search'], get_search_query() ) . '</a>';
	  elseif ( true === $this->args['show_title'] )
	  $this->items[] = sprintf( $this->args['labels']['search'], get_search_query() );
  }
  
	public function do_404_items() {
     if ( true === $this->args['show_title'] )
     $this->items[] = $this->args['labels']['error_404'];
  }

	function do_path_parents( $path ) {
	  $path = trim( $path, '/' );
	  if ( empty( $path ) )
	  return;
	  $post = get_page_by_path( $path );
	  if ( !empty( $post ) ) {
	  $this->do_post_parents( $post->ID );
	  }
	  elseif ( is_null( $post ) ) {
	  $path = trim( $path, '/' );
	  preg_match_all( "/\/.*?\z/", $path, $matches );
	  if ( isset( $matches ) ) {
	  $matches = array_reverse( $matches );
	  foreach ( $matches as $match ) {
	  if ( isset( $match[0] ) ) {
	  $path = str_replace( $match[0], '', $path );
	  $post = get_page_by_path( trim( $path, '/' ) );
	  if ( !empty( $post ) && 0 < $post->ID ) {
	  $this->do_post_parents( $post->ID );
	  break;
	  }
	  }
	  }
	  }
	  }
	}

	function do_term_parents( $term_id, $taxonomy ) {
	  $parents = array();
	  while ( $term_id ) {
	  $term = get_term( $term_id, $taxonomy );
	  $parents[] = '<a href="' . get_term_link( $term, $taxonomy ) . '" title="' . esc_attr( $term->name ) . '">' . $term->name . '</a>';
	  $term_id = $term->parent;
	  }
	  if ( !empty( $parents ) )
	  $this->items = array_merge( $this->items, $parents );
	}

	public function map_rewrite_tags( $post_id, $path ) {
	  $post = get_post( $post_id );
	  if ( empty( $post ) || is_wp_error( $post ) || 'post' !== $post->post_type )
	  return $trail;
	  $path = trim( $path, '/' );
	  $matches = explode( '/', $path );
	  if ( is_array( $matches ) ) {
	  foreach ( $matches as $match ) {
	  $tag = trim( $match, '/' );
	  if ( '%year%' == $tag )
	  $this->items[] = '<a href="' . get_year_link( get_the_time( 'Y', $post_id ) ) . '">' . sprintf( $this->args['labels']['archive_year'], get_the_time( _x( 'Y', 'yearly archives date format', 'peony' ) ) ) . '</a>';
	  elseif ( '%monthnum%' == $tag )
	  $this->items[] = '<a href="' . get_month_link( get_the_time( 'Y', $post_id ), get_the_time( 'm', $post_id ) ) . '">' . sprintf( $this->args['labels']['archive_month'], get_the_time( _x( 'F', 'monthly archives date format', 'peony' ) ) ) . '</a>';
	  elseif ( '%day%' == $tag )
	  $this->items[] = '<a href="' . get_day_link( get_the_time( 'Y', $post_id ), get_the_time( 'm', $post_id ), get_the_time( 'd', $post_id ) ) . '">' . sprintf( $this->args['labels']['archive_day'], get_the_time( _x( 'j', 'daily archives date format', 'peony' ) ) ) . '</a>';
	  elseif ( '%author%' == $tag )
	  $this->items[] = '<a href="' . get_author_posts_url( $post->post_author ) . '" title="' . esc_attr( get_the_author_meta( 'display_name', $post->post_author ) ) . '">' . get_the_author_meta( 'display_name', $post->post_author ) . '</a>';
	  elseif ( '%category%' == $tag ) {
	  $this->args['post_taxonomy'][ $post->post_type ] = false;
	  $terms = get_the_category( $post_id );
	  if ( $terms ) {
	  usort( $terms, '_usort_terms_by_ID' );
	  $term = get_term( $terms[0], 'category' );
	  if ( 0 < $term->parent )
	  $this->do_term_parents( $term->parent, 'category' );
	  $this->items[] = '<a href="' . get_term_link( $term, 'category' ) . '" title="' . esc_attr( $term->name ) . '">' . $term->name . '</a>';
		   }
		  }
		 }
		}
	   }
  }
 
	class peony_bbPress_Breadcrumb extends peony_Breadcrumb {

	public function do_trail_items() {
	$this->do_network_home_link();
	$this->do_site_home_link();
	$post_type_object = get_post_type_object( bbp_get_forum_post_type() );
	if ( !empty( $post_type_object->has_archive ) && !bbp_is_forum_archive() )
	$this->items[] = '<a href="' . esc_url(get_post_type_archive_link( bbp_get_forum_post_type() )) . '">' . bbp_get_forum_archive_title() . '</a>';
	if ( bbp_is_forum_archive() ) {
	if ( true === $this->args['show_title'] )
	$this->items[] = bbp_get_forum_archive_title();
	}
	elseif ( bbp_is_topic_archive() ) {
	if ( true === $this->args['show_title'] )
	$this->items[] = bbp_get_topic_archive_title();
	}
	elseif ( bbp_is_topic_tag() ) {
	if ( true === $this->args['show_title'] )
	$this->items[] = bbp_get_topic_tag_name();
	}
	elseif ( bbp_is_topic_tag_edit() ) {
	$this->items[] = '<a href="' . bbp_get_topic_tag_link() . '">' . bbp_get_topic_tag_name() . '</a>';
	if ( true === $this->args['show_title'] )
	$this->items[] = __( 'Edit', 'peony' );
	}
	elseif ( bbp_is_single_view() ) {
	if ( true === $this->args['show_title'] )
	$this->items[] = bbp_get_view_title();
	}
	elseif ( bbp_is_single_topic() ) {
	$topic_id = get_queried_object_id();
	$this->do_post_parents( bbp_get_topic_forum_id( $topic_id ) );
	if ( bbp_is_topic_split() || bbp_is_topic_merge() || bbp_is_topic_edit() )
	$this->items[] = '<a href="' . bbp_get_topic_permalink( $topic_id ) . '">' . bbp_get_topic_title( $topic_id ) . '</a>';
	elseif ( true === $this->args['show_title'] )
	$this->items[] = bbp_get_topic_title( $topic_id );
	if ( bbp_is_topic_split() && true === $this->args['show_title'] )
	$this->items[] = __( 'Split', 'peony' );
	elseif ( bbp_is_topic_merge() && true === $this->args['show_title'] )
	$this->items[] = __( 'Merge', 'peony' );
	elseif ( bbp_is_topic_edit() && true === $this->args['show_title'] )
	$this->items[] = __( 'Edit', 'peony' );
	}
	elseif ( bbp_is_single_reply() ) {
	$reply_id = get_queried_object_id();
	$this->do_post_parents( bbp_get_reply_topic_id( $reply_id ) );
	if ( bbp_is_reply_edit() ) {
	$this->items[] = '<a href="' . bbp_get_reply_url( $reply_id ) . '">' . bbp_get_reply_title( $reply_id ) . '</a>';
	if ( true === $this->args['show_title'] )
	$this->items[] = __( 'Edit', 'peony' );
	} elseif ( true === $this->args['show_title'] ) {
	$this->items[] = bbp_get_reply_title( $reply_id );
	}
	}
	elseif ( bbp_is_single_forum() ) {
	$forum_id = get_queried_object_id();
	$forum_parent_id = bbp_get_forum_parent_id( $forum_id );
	if ( 0 !== $forum_parent_id)
	$this->do_post_parents( $forum_parent_id );
	if ( true === $this->args['show_title'] )
	$this->items[] = bbp_get_forum_title( $forum_id );
	}
	elseif ( bbp_is_single_user() || bbp_is_single_user_edit() ) {
	if ( bbp_is_single_user_edit() ) {
	$this->items[] = '<a href="' . esc_url(bbp_get_user_profile_url()) . '">' . bbp_get_displayed_user_field( 'display_name' ) . '</a>';
	if ( true === $this->args['show_title'] )
	$this->items[] = __( 'Edit', 'peony' );
	} elseif ( true === $this->args['show_title'] ) {
	$this->items[] = bbp_get_displayed_user_field( 'display_name' );
	}
	}
	$this->items = apply_filters( 'breadcrumb_trail_get_bbpress_items', $this->items, $this->args );
	}
  }
  
 
/**
 * Selective Refresh
 */
	function peony_register_blogname_partials( WP_Customize_Manager $wp_customize ) {
	  
	// Abort if selective refresh is not available.
		if ( ! isset( $wp_customize->selective_refresh ) ) {
			return;
		}
 
   	    $customizer_library = Customizer_Library::Instance();

		$options = $customizer_library->get_options();

		// Bail early if we don't have any options.
		if ( empty( $options ) ) {
			return;
		}

		// Loops through each of the options
		foreach ( $options as $option ) {
			
		if( isset($option['id']) ){
			$wp_customize->selective_refresh->add_partial( $option['id'].'_selective', array(
        'selector' => '.'.$option['id'],
        'settings' => array( $option['id'] ),
        
    ) );
	}
			
	}
    
	$wp_customize->selective_refresh->add_partial( 'header_site_title', array(
		'selector' => '.site-name',
		'settings' => array( 'blogname' ),
		
	) );
	
	$wp_customize->selective_refresh->add_partial( 'header_site_description', array(
		'selector' => '.site-tagline',
		'settings' => array( 'blogdescription' ),
		
	) );
}
add_action( 'customize_register', 'peony_register_blogname_partials' );


/**
 * get woocommerce_breadcrumd
 */

function peony_woocommerce_breadcrumb()
{
	$breadcrumb_menu_prefix    = esc_attr(peony_option('breadcrumb_menu_prefix',''));
	$breadcrumb_menu_separator = esc_attr(peony_option('breadcrumb_menu_separator','/'));
?>
    <div class="breadcrumb-nav text-light peony_display_breadcrumb">
    <?php
    $args = array(
        'delimiter' => $breadcrumb_menu_separator,
        'before' => '<span class="breadcrumb-title">' . $breadcrumb_menu_prefix . '</span>',
    );
    woocommerce_breadcrumb($args);
    ?>
    </div>
    <?php
}

/*
 * Output Page Title Bar
 * title_bar_type - 0 :  page title bar
 *                - 1 :  post title bar
 *                - 2 :  post archive title bar
 *                - 3 :  post list title bar
 *                - 4 :  search title bar
 *                - 5 : Woocommerce title bar
 */
function peony_output_page_title_bar($title_bar_type, $page_title_bar_style, $display_breadcrumb, 
                        $breadcrumb_menu_prefix, $breadcrumb_menu_separator, $title_bar_css='')
{
	?>
	<section class="page-title-bar <?php echo $page_title_bar_style;?> no-subtitle peony_enable_page_title_bar">
    <div class="container">
        <hgroup class="page-title text-light">
            <?php if ($title_bar_type == 0) : ?>
                <h1><?php the_title();?></h1>

            <?php elseif ($title_bar_type == 1) : ?>
                <?php $post_title = get_the_title(); ?>
                <h1><?php echo strlen($post_title)>63?substr($post_title,0,60 ).'&hellip;':$post_title;?></h1>

            <?php elseif ($title_bar_type == 2) : ?>
                <h1><?php 
				if( is_archive() )
					the_archive_title();
				else
					single_cat_title(); 
				
				?></h1>
                <?php if(peony_option('blog_subtitle')): ?>
                    <h3 class="peony_blog_subtitle"><?php echo esc_attr(peony_option('blog_subtitle'));?></h3>
                <?php endif;?>

            <?php elseif ($title_bar_type == 3) : ?>
                <h1 class="peony_blog_title"><?php echo esc_attr(peony_option('blog_title'));?></h1>
                <?php if(peony_option('blog_subtitle')):?>
                <h3 class="peony_blog_subtitle"><?php echo esc_attr(peony_option('blog_subtitle'));?></h3>
                <?php endif;?>

            <?php elseif ($title_bar_type == 5) : ?>
                <?php if (is_shop()):?>
			    <h1><?php woocommerce_page_title(); ?></h1>
                <?php elseif ( is_product_category() || is_product_tag() ):?>
                <h1><?php single_term_title();?></h1>
                <?php else:?>
                <h1><?php the_title(); ?></h1>
                <?php endif; ?>
            <?php endif; ?>
        </hgroup>
        <?php if (!is_front_page()):?>
        	<?php if ($display_breadcrumb == '1' && $title_bar_type != 2 && $title_bar_type != 3): ?>
            	<?php if ($title_bar_type == 5) : ?>
            		<?php peony_woocommerce_breadcrumb(); ?>
            	<?php else: ?>
           			<?php peony_get_breadcrumb(array("before"=>"<div class='breadcrumb-nav text-light peony_display_breadcrumb'>".$breadcrumb_menu_prefix,"after"=>"</div>","show_browse"=>false,"separator"=>$breadcrumb_menu_separator)); ?>
          		<?php endif ?>
        	<?php endif;?>
        <?php endif;?>
        <div class="clearfix"></div>
    </div>
	</section>
	<?php
}
  
/*
 * Make Page Title Bar
 * title_bar_type - 0 :  page title bar
 *                - 1 :  post title bar
 *                - 2 :  post archive title bar
 *                - 3 :  post list title bar
 *                - 4 :  search title bar
 *                - 5 : Woocommerce title bar
 */
function peony_make_page_title_bar($title_bar_type)
{
	global $post;

	if( !$post )
		return ;

	$enable_page_title_bar     = absint(peony_option('enable_page_title_bar'));			// 1 - Enable 0 - Disable
	$enable_blog_title_bar     = esc_attr(peony_option('enable_blog_title_bar'));
	$page_title_bar_style      = esc_attr(peony_option('page_title_bar_style'));
	$display_breadcrumb        = esc_attr(peony_option('display_breadcrumb'));
	$breadcrumb_menu_prefix    = esc_attr(peony_option('breadcrumb_menu_prefix',''));
	$breadcrumb_menu_separator = esc_attr(peony_option('breadcrumb_menu_separator','/'));
	$title_bar_css = '';

	$page_title_bar = get_post_meta($post->ID, 'peony_enable_page_title_bar',true);// '0' - Default '1' - Yes '2' - No

	if ($page_title_bar == '2' )
		$enable_page_title_bar = 0;
		

if ( is_front_page() )
		$enable_page_title_bar = 0;
		
	if ($title_bar_type == PAGE_TITLE_BAR || $title_bar_type == WOOCOMMERCE_TITLE_BAR) {
		if ($enable_page_title_bar) {
        	peony_output_page_title_bar($title_bar_type, $page_title_bar_style, $display_breadcrumb, 
                            	$breadcrumb_menu_prefix, $breadcrumb_menu_separator, $title_bar_css);
		}
	} else {
		if ($enable_blog_title_bar) {
			peony_output_page_title_bar($title_bar_type, $page_title_bar_style, $display_breadcrumb, $breadcrumb_menu_prefix, 
							$breadcrumb_menu_separator, $title_bar_css);
		}
	}
}

/*
 * Make Sidebar
 */
function peony_make_sidebar($sidebar, $template_part)
{
    if ($sidebar == 'left' || $sidebar == 'both') { ?>
        <div class="col-aside-left">
            <aside class="blog-side left text-left">
                <div class="widget-area">
                <?php get_sidebar($template_part.'left');?>
                </div>
            </aside>
        </div>
    <?php 
    }
    if ($sidebar == 'right' || $sidebar == 'both') { ?>
        <div class="col-aside-right">
            <div class="widget-area">
            <?php get_sidebar($template_part.'right');?>
            </div>
        </div>
    <?php 
    }
}

/**
 * Ajax fullpage footer
 */
	function peony_ajax_footer(){

	$enable_tooltip  = esc_attr(peony_option('enable_tooltip'));

	if($enable_tooltip == '1')
		$tooltip = 'tooltip';
	else
		$tooltip = '';

	$ajax_footer = '<footer style="position: absolute; bottom: 0; left: 0; width: 100%;">
					<div class="footer-info-area" style="background: #000;">
						<div class="container text-center">
							<div class="row">
								<div class="col-md-4 text-left">
									<div class="site-info">
										'.sprintf(__( 'Designed by <a href="%s">Magee Theme</a>. All Rights Reserved.', 'peony' ),esc_url('http://www.mageewp.com/')).'
									</div>
								</div>
								<div class="col-md-4 text-center">
									<ul class="footer-sns peony_footer_social_icon_1">';
								
		for( $j=1;$j<=8;$j++ ){
					
		$social_icon  = esc_attr(peony_option('footer_social_icon_'.$j));
		$social_title = esc_attr(peony_option('footer_social_title_'.$j));
		$social_link  = esc_url(peony_option('footer_social_link_'.$j));
		if( $social_icon != '' ){
			$social_icon  = 'fa-'.str_replace('fa-','',$social_icon);
			$ajax_footer .= '<li><a href="'.$social_link.'" title="'.$social_title.'" data-placement="top" data-toggle="'.$tooltip.'" target="_blank"><i class="fa '.$social_icon.'"></i></a></li>';
			}
		}		
	
		$ajax_footer .= '</ul>									
								</div>
								<div class="col-md-4 text-right">
									<a href="javascript:;" class="scroll-to-top"><i class="fa fa-angle-up"></i></a>
								</div>
							</div>							
						</div>
					</div>			
				</footer>';
				
	echo $ajax_footer;
	exit(0);
	
}



function peony_body_class(){
	
	global $peony_post_meta;
		
	$body_class = 'peony';

	$skin = peony_option('skin');
	if ($skin == '1')
		$body_class .= ' dark';
	
	if (isset($peony_post_meta['peony_fullscreen'][0]) && $peony_post_meta['peony_fullscreen'][0]=='2')
		$body_class .= ' anime-3d';
		
	return $body_class;
	
	}
	
	
function peony_wrapper_class(){
	
	$layout = esc_attr(peony_option('layout'));
	$wrapper = '';
	if ($layout == 'boxed')
		$wrapper = ' wrapper-boxed container ';
		
	return $wrapper;
	
	}
	
function peony_default_header(){
	
	ob_start();
	get_template_part('header-templates/header','classic');
	$return = ob_get_contents();
	ob_end_clean();
	return $return;
	
	}
 
/**
 * Tgm Plugin Activation
 */

require_once dirname( __FILE__ ) . '/inc/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'peony_theme_register_required_plugins' );


function peony_theme_register_required_plugins() {

	$plugins = array(

		array(
			'name'               => __( 'Mageewp Page Layout', 'peony' ),
			'slug'               => 'mageewp-page-layout',
			'source'             => esc_url('https://downloads.wordpress.org/plugin/mageewp-page-layout.zip'),
			'required'           => true,
			'force_activation'   => false, 
			'force_deactivation' => false,
			'external_url'       => '', 
			'is_callable'        => '',
		),
	);
	
	$description = '<br><span style="font-weight: 400 !important ;">'.__( 'As one indispensable plugin of theme Peony, Magee Page Layout comes with pre-built sections and page styles, make sure you install the plugin immediately after theme installation to keep the theme function normally.', 'peony' ).'</span>';

	$config = array(
		'id'           => 'peony-mageewp-page-layout',
		'default_path' => '',
		'menu'         => 'tgmpa-install-plugins',
		'parent_slug'  => 'themes.php',
		'capability'   => 'edit_theme_options',
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => '',
		'is_automatic' => false,
		'message'      => '',
		'strings'      => array(
		'notice_can_install_required'     => _n_noop(
					/* translators: 1: plugin name(s). */
					'This theme requires the following plugin: %1$s.'.$description,
					'This theme requires the following plugins: %1$s.'.$description,
					'peony'
				),
		'notice_can_activate_required'    => _n_noop(
					/* translators: 1: plugin name(s). */
					'The following required plugin is currently inactive: %1$s.'.$description,
					'The following required plugins are currently inactive: %1$s.'.$description,
					'peony'
				),
		)

	);

	tgmpa( $plugins, $config );
}
