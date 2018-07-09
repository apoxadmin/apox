<?php
/**
 * Render Shortcode.
 * @author Flipper Code <hello@flippercode.com>
 * @package Core
 */

global $wpdb;
$modelFactory = new FactoryModelPMP();
$layout_obj = $modelFactory->create_object( 'layout' );
if ( isset( $options['id'] ) ) {
	$layout_obj = $layout_obj->fetch( array( array( 'layout_id', '=', intval( wp_unslash( $options['id'] ) ) ) ) );
	$data = (array) $layout_obj[0];
	if ( 'carousel' == $data['layout_post_setting']['pagination_style'] ) {
		wp_enqueue_script( 'pmp-frontend-carousel' );
		wp_enqueue_style( 'pmp-carousel' );
		wp_enqueue_style( 'pmp-carousel-theme' );
	} else if ( 'infinite' == $data['layout_post_setting']['pagination_style'] ) {
		wp_enqueue_script( 'pmp-frontend-jscroll' );
	}

	wp_enqueue_script( 'pmp-frontend' );
	wp_enqueue_style( 'pmp-frontend' );
	$wpp_js_lang = array();
	$wpp_js_lang['ajax_url'] = admin_url( 'admin-ajax.php' );
	$wpp_js_lang['nonce'] = wp_create_nonce( 'pmp-call-nonce' );
	$wpp_js_lang['loading_image'] = WCJP_IMAGES.'loader.gif';
	$wpp_js_lang['confirm'] = __( 'Are you sure to delete item?',WCJP_TEXT_DOMAIN );
	$wpp_js_lang['pagination_style'] = $data['layout_post_setting']['pagination_style'];
	wp_localize_script( 'pmp-frontend', 'wpp_js_lang', $wpp_js_lang );
	$obj = new FlipperCode_Layout();
	//overwrite template with layout attributes.
	if( isset( $options['layout'] ) ) {
		$data['layout_type'] = $options['layout'];
	}

	if( isset( $options['thumbnail'] ) ) {
		$data['layout_post_setting']['thumb_position'] = $options['thumbnail'];
	}

	$shortcode_data = $obj->wpp_load_template( $data );
	return $shortcode_data['html'];
}

?>
