<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package businessbuilder
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function businessbuilder_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'businessbuilder_body_classes' );

/**
 * Custom excerpt more
 */
function businessbuilder_custom_excerpt_more( $link ) {
	if ( is_admin() ) {
		return $link;
	}
	return ' &hellip; ';
}
add_filter( 'excerpt_more', 'businessbuilder_custom_excerpt_more' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function businessbuilder_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', bloginfo( 'pingback_url' ), '">';
	}
}
add_action( 'wp_head', 'businessbuilder_pingback_header' );

function businessbuilder_light_get_image_src( $image_id, $size = 'full' ) {
	$img_attr = wp_get_attachment_image_src( intval( $image_id ), $size );
	if ( ! empty( $img_attr[0] ) ) {
		return $img_attr[0];
	}
}

function businessbuilder_excerpt_length( $length ) {
  return 100;
}
add_filter( 'excerpt_length', 'businessbuilder_excerpt_length', 1 );


/* Theme information Page */ 
add_action( 'admin_menu', 'businessbuilder_register_backend' );
function businessbuilder_register_backend() {
  add_theme_page( __('About Businessbuilder', 'businessbuilder'), __('Businessbuilder', 'businessbuilder'), 'edit_theme_options', 'about-businessbuilder.php', 'businessbuilder_backend');
}
 
function businessbuilder_backend(){ ?>
<div class="themepage-wrapper">
  <div class="headings-wrapper">
    <h2>Businessbuilder Informaton And Support</h2>
    <h3>If you can't find a solution, feel free to email me at Email@vilhodesign.com</h3>
  </div>
  <div class="themepage-left">
    <div class="help-box-wrapper">
      <a href="https://wordpress.org/support/" class="help-box" target="_blank">
        General WordPress Support 
      </a>
    </div>
    <div class="help-box-wrapper">
      <a href="http://vilhodesign.com/contact/" class="help-box" target="_blank">
        Businessbuilder Theme Support 
        <span>Email@vilhodesign.com</span>
      </a>
    </div>
    <div class="help-box-wrapper">
     <a href="http://vilhodesign.com/themes/businessbuilder/" class="help-box" target="_blank">
      Businessbuilder Theme Demo 
    </a>
  </div>
  <div class="help-box-wrapper">
    <a href="http://vilhodesign.com/themes/businessbuilder/" class="help-box" target="_blank">
      Businessbuilder Premium 
    </a>
  </div>
</div>
<div class="themepage-right">
        <a style="display:block;" href="http://vilhodesign.com/themes/businessbuilder/" target="_blank">
        <img src="http://vilhodesign.com/img/businessbuilder-info.png"> 
        </a>
</div>
</div>
<?php }

