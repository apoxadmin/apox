<?php 

/* 
	Krystal Shop Theme functions file
*/	

add_action( 'after_setup_theme', 'krystal_shop_theme_setup', 99 );
function krystal_shop_theme_setup(){
  //remove header styles
  remove_action( 'krystal_action_header', 'krystal_header_style_1' );
  remove_action( 'krystal_action_header', 'krystal_header_style_2' );
  remove_action( 'wp', 'krystal_action_header_hook' );
  remove_action( 'admin_menu', 'krystal_add_menu' );
	add_action('wp_enqueue_scripts', 'krystal_shop_load_scripts');
}

function krystal_shop_load_scripts() {	
	wp_register_style( 'krystal-shop-load-style' , trailingslashit(get_stylesheet_directory_uri()).'style.css', false, '1.0', 'screen');
	wp_enqueue_style( 'krystal-shop-load-style' );
  wp_enqueue_style( 'krystal-shop-woocommerce-css' , trailingslashit(get_stylesheet_directory_uri()).'css/woocommerce-style.css', false, '1.0', 'screen');
  wp_enqueue_style( 'krystal-shop-google-font', 'https://fonts.googleapis.com/css?family=Poiret+One:400', array(), '1.0'); 
}

/** 
* WooCommerce Support
*/

add_action( 'after_setup_theme', 'krystal_shop_wc_support' );
function krystal_shop_wc_support() {
  add_theme_support( 'woocommerce' );
  add_theme_support( 'wc-product-gallery-zoom' );
  add_theme_support( 'wc-product-gallery-lightbox' );
  add_theme_support( 'wc-product-gallery-slider' );
}

/** 
* Register Widget Area
*/

function krystal_shop_widgets_init() {
  register_sidebar( array(
      'name'          => __( 'Woocommerce Sidebar', 'krystal-shop' ),
      'id'            => 'woosidebar',
      'description'   => __( 'Add widgets here.', 'krystal-shop' ),
      'before_widget' => '<aside id="%1$s" class="widget %2$s">',
      'after_widget'  => '</aside>',
      'before_title'  => '<h5 class="widget-title">',
      'after_title'   => '</h5>',
  ) ); 

}
add_action( 'widgets_init', 'krystal_shop_widgets_init' );

/**
 * Custom product search form
*/
 
if ( !function_exists('krystal_shop_product_search_form') ) :
function krystal_shop_product_search_form( $form ) {
    $form = '<form role="search" method="get" id="searchform" class="searchform" action="' . esc_url(home_url( '/' )) . '" >
    <div class="search">
      <input type="text" value="' . get_search_query() . '" class="product-search" name="s" id="s" placeholder="'. __('Search products.','krystal-shop'). '">
      <label for="searchsubmit" class="search-icon"><i class="fa fa-search"></i></label>
      <input type="hidden" name="post_type" value="product" />
      <input type="submit" id="searchsubmit" value="'. __( 'Search','krystal-shop' ) .'" />
    </div>
    </form>';
    return $form;
}
endif;
add_filter( 'get_product_search_form', 'krystal_shop_product_search_form', 100 );

/**
 * Display Dynamic CSS.
 */
function krystal_shop_dynamic_css_wrap() {
  require_once( get_stylesheet_directory(). '/css/dynamic.css.php' );
  ?>
    <style type="text/css" id="krystal-shop-theme-dynamic-style">
        <?php echo krystal_shop_dynamic_css_stylesheet(); ?>
    </style>
  <?php 
}
add_action( 'wp_head', 'krystal_shop_dynamic_css_wrap' );

/**
* Admin Scripts
*/
if ( ! function_exists( 'krystal_shop_admin_scripts' ) ) :
function krystal_shop_admin_scripts($hook) {
  if('appearance_page_krystal-shop-theme-info' != $hook)
    return;  
  wp_enqueue_style( 'krystal-shop-info-css', trailingslashit(get_stylesheet_directory_uri()).'css/krystal-shop-theme-info.css', false );  
}
endif;
add_action( 'admin_enqueue_scripts', 'krystal_shop_admin_scripts' );

/** 
* Plugins Required
*/
add_action( 'tgmpa_register', 'krystal_shop_register_required_plugins' );
function krystal_shop_register_required_plugins() {
    $plugins = array(      
      array(
          'name'               => 'WooCommerce',
          'slug'               => 'woocommerce',
          'source'             => '',
          'required'           => false,          
          'force_activation'   => false,
      ) 
    );

    $config = array(
            'id'           => 'krystal-shop',
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

//include info
require_once( get_stylesheet_directory(). '/inc/theme-info.php' );

//include customizer
require_once( get_stylesheet_directory(). '/inc/customizer/customizer.php' );

//include woocommerce functions
require_once( get_stylesheet_directory(). '/inc/woocommerce-functions.php' );

//include template functions
require_once( get_stylesheet_directory(). '/inc/template-functions.php' );

//include Widgets
require_once( get_stylesheet_directory(). '/inc/widgets/woo-categories-section.php' );

?>
