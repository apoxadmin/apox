<?php
//	Include the Custom Header code
define( 'HEADER_IMAGE', '%s/images/logo.png' ); // The default logo located in themes folder
define( 'HEADER_IMAGE_WIDTH', apply_filters( '', 600 ) ); // Width of Logo
define( 'HEADER_IMAGE_HEIGHT', apply_filters( '', 120 ) ); // Height of Logo
define( 'NO_HEADER_TEXT', true );
add_custom_image_header( 'header_style', 'admin_header_style' ); // This Enables the Appearance > Header
function header_style() { ?>
<style type="text/css">
#header #title a {
background: url(<?php header_image(); ?>) no-repeat;
}
</style>
<?php }
// Following Code is for Styling the Admin Side
if ( ! function_exists( 'admin_header_style' ) ) :
function admin_header_style() {
?>
<style type="text/css">
#headimg {
height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
width: <?php echo HEADER_IMAGE_WIDTH; ?>px;
}
#headimg h1, #headimg #desc {
display: none;
}
</style>
<?php
}
endif;
?>