<?php
/**
 * Social Media widget.
 *
 * @package boka
 */

class Boka_social_Widget extends SiteOrigin_Widget {

    function __construct() {

        parent::__construct(
            'boka-social-widget',
            __( 'boka Social Media Widget', 'boka' ),
            array(
                'description' => __( 'Social Media Widget', 'boka' ),
            ),
            array(),

            array(
                'title' => array(
                    'type'  => 'text',
                    'label' => __( 'Heading', 'boka' ),
                    'description' => __('<h2>## Please Go To Appearance -> Customize -> Social Media Settings For Social Links ##</h2>', 'boka')
                ),
            )

        );
    }

    function get_template_name( $instance ) {
        return 'default';
    }
}

siteorigin_widget_register( 'boka-social-widget', __FILE__, 'Boka_social_Widget' );
