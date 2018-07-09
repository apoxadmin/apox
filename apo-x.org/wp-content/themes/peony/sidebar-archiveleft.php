<?php
	$left_sidebar = esc_attr(peony_option('left_sidebar_blog_archive',''));

	if ( $left_sidebar && is_active_sidebar( $left_sidebar ) ){
		dynamic_sidebar( $left_sidebar );
	}
	elseif( is_active_sidebar( 'default_sidebar' ) ) {
		dynamic_sidebar('default_sidebar');
	}