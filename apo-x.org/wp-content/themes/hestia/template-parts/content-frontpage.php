<?php
/**
 * The default template for displaying content
 *
 * Used for frontpage.
 *
 * @package Hestia
 * @since Hestia 1.0
 */
if ( is_customize_preview() ) {
	$frontpage_id = get_option( 'page_on_front' );
	$default      = '';
	if ( ! empty( $frontpage_id ) ) {
		$default = get_post_field( 'post_content', $frontpage_id );
		$content = get_theme_mod( 'hestia_page_editor', $default );
		echo apply_filters( 'hestia_text', $content );
	} else {
		the_content();
	}
} else {
	the_content();
}

