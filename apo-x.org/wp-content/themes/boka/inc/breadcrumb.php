<?php

function boka_title( $args = array() ) {

    if ( is_front_page() || is_singular( 'post' ) || is_404() || get_theme_mod( 'enable_page_title' ) ) {
        return;
    }

    global $post;

    $defaults  = array(
        'breadcrumbs_classes' => 'breadcrumb',
    );

    $args      = apply_filters( 'themetim_breadcrumbs_args', wp_parse_args( $args, $defaults ) );

    /***** Begin Markup *****/

    // Open the breadcrumbs
    $html = '<section class="' . esc_attr( $args['breadcrumbs_classes'] ) . '">
		<div class="breadcrumb-wrap text-center text-capitalize">';

    // Post
    if ( is_singular( 'post' ) ) {

        $html .= '<h1>' . esc_html( get_the_title() ) . '</h1>';

    } elseif ( is_singular( 'page' ) ) {

        $html .= '<h1> ' . esc_html( get_the_title() ) . '</h1>';

    } elseif ( is_singular( 'attachment' ) ) {

        $html .= '<h1>' . esc_html( get_the_title() ) . '</h1>';

    } elseif ( is_singular() ) {

        $html .= '<h1>' . $post->post_title . '</h1>';

    } elseif ( is_category() ) {

        $html .= '<h1>' . single_cat_title( '', false ) . '</h1>';

    } elseif ( is_tag() ) {

        $html .= '<h1>' . single_tag_title( '', false ) . '</h1>';

    } elseif ( is_author() ) {

        $html .= '<h1>' . get_queried_object()->display_name . '</h1>';

    } elseif ( is_day() ) {

        $html .= '<h1>' . get_the_date() . '</h1>';

    } elseif ( is_month() ) {

        $html .= '<h1>' . get_the_date( 'F Y' ) . '</h1>';

    } elseif ( is_year() ) {

        $html .= '<h1>' . get_the_date( 'Y' ) . '</h1>';

    } elseif ( is_archive() ) {

        $custom_tax_name = get_queried_object()->name;
        $html .= '<h1>' . esc_html( $custom_tax_name ) . '</h1>';

    } elseif ( is_search() ) {

        $html .= '<h1>'. __( ' Search results for : ', 'boka') . get_search_query() . '</h1>';

    } elseif ( is_404() ) {

        $html .= '<h1>' . __( 'Error 404', 'boka' ) . '</h1>';

    } elseif ( is_home() ) {

        $html .= '<h1>' . esc_html( get_the_title( get_option( 'page_for_posts' ) ) ) . '</h1>';

    }

    $html .= '</div></section>';

    $html = apply_filters( 'boka_breadcrumbs_filter', $html );

    echo wp_kses_post( $html );
}