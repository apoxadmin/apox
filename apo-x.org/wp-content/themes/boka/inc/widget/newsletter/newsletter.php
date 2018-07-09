<?php
/**
 * Newsletter widget.
 *
 * @package boka
 */

class Boka_newsletter_Widget extends SiteOrigin_Widget {

    function __construct() {

        parent::__construct(
            'boka-newsletter-widget',
            __( 'boka Newsletter Widget', 'boka' ),
            array(
                'description' => __( 'Newsletter Widget', 'boka' ),
            ),
            array(),

            array(
                'title' => array(
                    'type'  => 'text',
                    'label' => __( 'Heading', 'boka' ),
                    'default' => 'Follow Us'
                ),
                'action_url' => array(
                    'type'  => 'textarea',
                    'label' => __( 'Action URL', 'boka' ),
                    'default' => ''
                ),
            )

        );
    }

    function get_template_name( $instance ) {
        return 'default';
    }
}

siteorigin_widget_register( 'boka-newsletter-widget', __FILE__, 'Boka_newsletter_Widget' );
