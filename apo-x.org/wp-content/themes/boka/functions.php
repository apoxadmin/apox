<?php
/**
 * Boka functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package boka
 */
if ( ! function_exists( 'boka_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function boka_setup() {
		/*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on Boka WordPress Framework, use a find and replace
         * to change 'boka' to the name of your theme in all the template files.
         */
		load_theme_textdomain( 'boka', get_template_directory() . '/languages' );
		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );
		/*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
		add_theme_support( 'title-tag' );
		/*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
		add_theme_support( 'post-thumbnails' );
		/*
         * Define custom image size
         */
		add_image_size( 'boka-medium-thumb', 500, 500, true );
		add_image_size('boka-team-thumb', 350);

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary', 'boka' ),
			'footer-1' => esc_html__( 'Footer Menu', 'boka' ),
		) );
		/*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support('custom-background', apply_filters('boka_custom_background_args', array(
			'default-color' => 'f9f9f9',
			'default-image' => '',
		)));

	}
endif;
add_action( 'after_setup_theme', 'boka_setup' );
/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function boka_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'boka_content_width', 1170 );
}
add_action( 'after_setup_theme', 'boka_content_width', 0 );
/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function boka_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'boka' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'boka' ),
		'before_widget' => '<section id="%1$s" class="widget boka-widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title margin-null">',
		'after_title'   => '</h3>',
	) );

	if ( class_exists( 'WooCommerce' ) ) {

		register_sidebar( array(
			'name'          => __( 'WooCommerce', 'boka' ),
			'id'            => 'woocommerce-sidebar',
			'description'   => esc_html__( 'Add widgets here to appear in your WooCommerce sidebar.', 'boka' ),
			'before_widget' => '<section id="%1$s" class="widget boka-widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title margin-null">',
			'after_title'   => '</h3>',
		) );

	}

	$args_footer_widgets = array(
		'name'          => __( 'Footer %d', 'boka' ),
		'id'            => 'footer-widget',
		'description'   => '',
		'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="footer-widget-title">',
		'after_title'   => '</h3>'
	);

	register_sidebars( 4, $args_footer_widgets );

}
add_action( 'widgets_init', 'boka_widgets_init' );
/**
 * Enqueue scripts and styles.
 */
function boka_scripts() {

	if ( get_theme_mod('body_font_name') ) {
		wp_enqueue_style( 'boka-body-fonts', '//fonts.googleapis.com/css?family=' . esc_attr( get_theme_mod( 'body_font_name' ) ) );
	} else {
		wp_enqueue_style( 'boka-body-fonts', '//fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700');
	}
	if ( get_theme_mod('heading_font_name') ) {
		wp_enqueue_style( 'boka-heading-fonts', '//fonts.googleapis.com/css?family=' . esc_attr( get_theme_mod( 'heading_font_name' ) ) );
	} else {
		wp_enqueue_style( 'boka-heading-fonts', '//fonts.googleapis.com/css?family=Nunito:300,400');
	}

	wp_enqueue_style( 'animate', get_template_directory_uri() . '/assets/css/animate.min.css', array(), '3.5.1' );
	wp_enqueue_style( 'boka-font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.min.css', array(), '4.7.0' );
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css', array(), '3.3.6' );
	wp_enqueue_style( 'camera', get_template_directory_uri() . '/assets/css/camera.css', array(), '1.3.4' );
	wp_enqueue_style( 'boka-style', get_stylesheet_uri() );

	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array(), '3.3.6', true );
	wp_enqueue_style( 'boka-mobile', get_template_directory_uri() . '/assets/css/mobile.css', array(), '1.0.0' );

	wp_enqueue_script( 'jquery-mobile-customized', get_template_directory_uri() . '/assets/js/jquery.mobile.customized.min.js', array('jquery'), '1.4.5', true );
	wp_enqueue_script( 'easing', get_template_directory_uri() . '/assets/js/jquery.easing.1.3.min.js', array('jquery'), '1.3', true );
	wp_enqueue_script( 'masonry', get_template_directory_uri() . '/assets/js/masonry.js', array('jquery'), '4.2.0', true );
	wp_enqueue_script( 'camera', get_template_directory_uri() . '/assets/js/camera.min.js', array('jquery'), '1.3.4', true );
	wp_enqueue_script( 'jquery-fitvids', get_template_directory_uri() . '/assets/js/jquery.fitvids.js', array('jquery'), '1.1', true );
	wp_enqueue_script( 'boka-script', get_template_directory_uri() . '/assets/js/script.js', array('jquery'), '1.0', true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'boka_scripts' );
/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';
/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';
/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';
/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
/**
 * Boka Typography, Color
 */
require get_template_directory() . '/inc/typography.php';
/**
 * woocommerce support
 */
add_action( 'after_setup_theme', 'boka_woocommerce_support' );
function boka_woocommerce_support() {
	add_theme_support( 'woocommerce' );
}
/**
 * woocommerce Hook
 */
require get_template_directory() . '/inc/woocommerce.php';
/**
 * Boka SO Widget
 */
require get_template_directory() . '/inc/widget/widget-setting.php';
/**
 * Boka Bootstrap Menu
 */
if ( ! class_exists( 'wp_bootstrap_navwalker' )) {
	require get_template_directory() . '/inc/wp_bootstrap_navwalker.php';
}
/**
 * Boka Theme Functions
 */
require get_template_directory() . '/inc/theme-functions.php';
/**
 * Boka the excerpt length
 */
function boka_excerpt_length( $excerpt_length ) {
	$excerpt = get_theme_mod('excerpt_lenght', '60');
	return $excerpt;
}
add_filter( 'excerpt_length', 'boka_excerpt_length', 999 );
/**
 * Gallery Image Fixed (Jetpack)
 */
add_filter( 'tiled_gallery_content_width', 'boka_custom_tiled_gallery_width' );
function boka_custom_tiled_gallery_width($width){
	$width = 1170;
	return $width;
}
/**
 * Custom Logo
 */
function boka_custom_logo() {

	$defaults = array(
		'width'       => 250,
		'height'      => 45,
		'flex-width'  => true,
		'flex-height' => true,
	);
	add_theme_support( 'custom-logo', $defaults );

}
add_action( 'after_setup_theme', 'boka_custom_logo' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';
/**
 * Breadcrumb
 */
require get_template_directory() . '/inc/breadcrumb.php';
/**
 *TGM Plugin activation.
 */
require get_template_directory() . '/inc/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'boka_active_plugins' );
function boka_active_plugins() {
	$plugins = array(
		array(
			'name'      => 'Contact Form 7',
			'slug'      => 'contact-form-7',
			'required'  => false,
		),
		array(
			'name'      => 'WooCommerce',
			'slug'      => 'woocommerce',
			'required'  => false,
		),
		array(
			'name'      => 'Page Builder by SiteOrigin',
			'slug'      => 'siteorigin-panels',
			'required'  => false,
		),
		array(
			'name'      => 'Widgets Bundle by SiteOrigin',
			'slug'      => 'so-widgets-bundle',
			'required'  => false,
		)
	);
	tgmpa( $plugins );
}