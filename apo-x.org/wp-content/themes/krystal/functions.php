<?php
/**
 * krystal functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package krystal
 */

 // Register Custom Navigation Walker
 require_once(get_template_directory() .'/inc/wp_bootstrap_navwalker.php');

 //Register Required plugin
require_once(get_template_directory() .'/inc/class-tgm-plugin-activation.php');

if ( ! function_exists( 'krystal_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function krystal_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on krystal, use a find and replace
	 * to change 'krystal' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'krystal', get_template_directory() . '/languages' );

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

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary', 'krystal' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(		
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Gallery post format
	add_theme_support( 'post-formats', array( 'gallery' ));

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * krystal theme info
	 */
	require get_template_directory() . '/inc/theme-info.php';

	/*
	* About page instance
	*/
	$config = array();
	Krystal_About_Page::krystal_init( $config );

}
endif;
add_action( 'after_setup_theme', 'krystal_setup' );


/**
* Custom Logo 
*
*
*/
function krystal_logo_setup() {
    add_theme_support( 'custom-logo', array(
	   'height'      => 60,
	   'width'       => 180,
	   'flex-height' => true,
	   'flex-width' => true,	   
	) );
}
add_action( 'after_setup_theme', 'krystal_logo_setup' );


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function krystal_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'krystal_content_width', 640 );
}
add_action( 'after_setup_theme', 'krystal_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function krystal_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Blog Sidebar', 'krystal' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here.', 'krystal' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

  register_sidebar( array(
		'name'          => __( 'Footer Column1', 'krystal' ),
		'id'            => 'footer-column1',
		'description'   => __( 'Add widgets here.', 'krystal' ),
		'before_widget' => '<div id="%1$s" class="section %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

  register_sidebar( array(
		'name'          => __( 'Footer Column2', 'krystal' ),
		'id'            => 'footer-column2',
		'description'   => __( 'Add widgets here.', 'krystal' ),
		'before_widget' => '<div id="%1$s" class="section %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

  register_sidebar( array(
		'name'          => __( 'Footer Column3', 'krystal' ),
		'id'            => 'footer-column3',
		'description'   => __( 'Add widgets here.', 'krystal' ),
		'before_widget' => '<div id="%1$s" class="section %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

  register_sidebar( array(
		'name'          => __( 'Footer Column4', 'krystal' ),
		'id'            => 'footer-column4',
		'description'   => __( 'Add widgets here.', 'krystal' ),
		'before_widget' => '<div id="%1$s" class="section %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

}
add_action( 'widgets_init', 'krystal_widgets_init' );

/**
* Admin Scripts
*/
if ( ! function_exists( 'krystal_admin_scripts' ) ) :
function krystal_admin_scripts($hook) {
  if('appearance_page_krystal-theme-info' != $hook)
    return;  
  wp_enqueue_style( 'krystal-info-css', get_template_directory_uri() . '/css/krystal-theme-info.css', false );  
}
endif;
add_action( 'admin_enqueue_scripts', 'krystal_admin_scripts' );


/**
 * Display Dynamic CSS.
 */
function krystal_dynamic_css_wrap() {

  require_once( get_parent_theme_file_path( '/css/dynamic.css.php' ) );  
?>
  <style type="text/css" id="custom-theme-dynamic-style">
    <?php echo krystal_dynamic_css_stylesheet(); ?>
  </style>
<?php }
add_action( 'wp_head', 'krystal_dynamic_css_wrap' );



function krystal_scripts() {
	wp_enqueue_style( 'style', get_stylesheet_uri() );
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.css', array(), '3.3.7');	
	wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/css/font-awesome.css', array(), '4.6.3');	
	wp_enqueue_style( 'krystal-google-font', 'https://fonts.googleapis.com/css?family=Poppins:300,400,700,900', array(), '1.0');		
	wp_enqueue_style( 'magnific-popup-css', get_template_directory_uri() . '/css/magnific-popup.css', array(), '1.1.0');
	wp_enqueue_style( 'animate', get_template_directory_uri() . '/css/animate.css', array(), '1.0');	
	wp_enqueue_style( 'm-customscrollbar-css', get_template_directory_uri() . '/css/jquery.mCustomScrollbar.css', array(), '1.0');		
    wp_enqueue_style( 'krystal-style', get_template_directory_uri() . '/css/krystal-style.css', array(), '1.0.10');    
	wp_enqueue_style( 'krystal-responsive', get_template_directory_uri() . '/css/krystal-style-responsive.css', array(), '1.0.10');	    

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/js/bootstrap.js', array(), '3.3.7', true );
	wp_enqueue_script( 'jquery-easing', get_template_directory_uri() . '/js/jquery.easing.1.3.js', array('jquery'), '1.3', true );
	wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/js/modernizr.js', array(), '2.6.2', true );		
	wp_enqueue_script( 'parallax', get_template_directory_uri() . '/js/parallax.js',array(),'1.4.2', true );	
	wp_enqueue_script( 'jquery-magnific', get_template_directory_uri() . '/js/jquery.magnific-popup.js',array(),'1.1.0', true );	
	wp_enqueue_script( 'krystal-script', get_template_directory_uri() . '/js/krystal-main.js', array('jquery'), '1.0.10', true );		
	wp_enqueue_script( 'html5shiv',get_template_directory_uri().'/js/html5shiv.js',array(), '3.7.3');
	wp_script_add_data( 'html5shiv', 'conditional', 'lt IE 9' );

	wp_enqueue_script( 'respond', get_template_directory_uri().'/js/respond.js' );
    wp_script_add_data( 'respond', 'conditional', 'lt IE 9' );

}
add_action( 'wp_enqueue_scripts', 'krystal_scripts' );



/**
* Custom excerpt length.
*/
function krystal_my_excerpt_length($length) {
	if ( is_admin() ) {
		return $length;
	}
  	return 25;
}
add_filter('excerpt_length', 'krystal_my_excerpt_length');


/**
* Registers an editor stylesheet for the theme.
*/
function krystal_theme_add_editor_styles() {
    add_editor_style(get_template_directory_uri() . '/css/custom-editor-style.css' );
}
add_action( 'admin_init', 'krystal_theme_add_editor_styles' );


/**
* Custom search form
*/
function krystal_search_form( $form ) {
    $form = '<form role="search" method="get" id="searchform" class="searchform" action="' . esc_url(home_url( '/' )) . '" >
    <div class="search">
      <input type="text" value="' . get_search_query() . '" class="blog-search" name="s" id="s" placeholder="'. esc_attr__( 'Search here','krystal' ) .'">
      <label for="searchsubmit" class="search-icon"><i class="fa fa-search"></i></label>
      <input type="submit" id="searchsubmit" value="'. esc_attr__( 'Search','krystal' ) .'" />
    </div>
    </form>';
    return $form;
}
add_filter( 'get_search_form', 'krystal_search_form', 100 );


/** 
*Excerpt More
*/
function krystal_excerpt_more( $more ) {
	if ( is_admin() ) {
		return $more;
	}
    return '&hellip;';
}
add_filter('excerpt_more', 'krystal_excerpt_more');


/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function krystal_pingback_header() {
  if ( is_singular() && pings_open() ) {
    printf( '<link rel="pingback" href="%s">' . "\n", get_bloginfo( 'pingback_url' ) );
  }
}
add_action( 'wp_head', 'krystal_pingback_header' );


/**
 * Using home page title instead of site name 
 */


if ( !function_exists('krystal_breadcrumb_title') ) :
function krystal_breadcrumb_title($title, $type, $id) {
 if ($type[0] === 'home') {
    $title = get_the_title(get_option('page_on_front'));
  }
  return $title;
}
endif;
add_filter('bcn_breadcrumb_title', 'krystal_breadcrumb_title', 42,3);


/**
 *  Set homepage and blog page after demo import
 */

function krystal_after_import_setup() {    
        
    //Assign menus to their locations
    $main_menu = get_term_by( 'name', 'Primary', 'nav_menu' );
    set_theme_mod( 'nav_menu_locations', array(
          'primary' => $main_menu->term_id,
        )
    );

    //Assign front page
    $front_page = get_page_by_title( 'Home' );  
    $blog_page = get_page_by_title( 'Blog' );  

    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page -> ID );    
    update_option( 'page_for_posts', $blog_page -> ID );     
   
}
add_action( 'pt-ocdi/after_import', 'krystal_after_import_setup' );



/** 
*plugins Required
*/
add_action( 'tgmpa_register', 'krystal_register_required_plugins' );

function krystal_register_required_plugins() {

    $plugins = array(      
      array(
          'name'               => 'Contact Form 7',
          'slug'               => 'contact-form-7',
          'source'             => '',
          'required'           => false,          
          'force_activation'   => false,
      ),
      array(
          'name'               => 'Elementor Page Builder',
          'slug'               => 'elementor',
          'source'             => '',
          'required'           => false,          
          'force_activation'   => false,
      ),
      array(
          'name'               => 'Breadcrumb NavXT',
          'slug'               => 'breadcrumb-navxt',
          'source'             => '',
          'required'           => false,          
          'force_activation'   => false,
      ),
      array(
          'name'               => 'One Click Demo Import',
          'slug'               => 'one-click-demo-import',
          'source'             => '',
          'required'           => false,          
          'force_activation'   => false,
      ),       
    );

    $config = array(
            'id'           => 'krystal',
            'default_path' => '',
            'menu'         => 'tgmpa-install-plugins',
            'has_notices'  => true,
            'dismissable'  => true,
            'dismiss_msg'  => '',
            'is_automatic' => false,
            'message'      => '',
            'strings'      => array()
    );

    tgmpa( $plugins, $config );

}

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer/customizer.php';

/**
 * Template functions
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Extra classes for this theme.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Load Widgets.
 */
require get_template_directory() . '/inc/widgets.php';

/**
 * Upgrade Pro
 */
require_once( trailingslashit( get_template_directory() ) . 'krystal-pro/class-customize.php' );