<?php
/**
 * Brand widget.
 *
 * @package boka
 */

class Boka_Brand_Widget extends SiteOrigin_Widget {

    function __construct() {

        parent::__construct(
            'boka-brand-widget',
            __( 'boka Brand Widget', 'boka' ),
            array(
                'description' => __( 'Brand Widget', 'boka' ),
            ),
            array(),

            array(
                'heading_alignment' => array(
                    'type' => 'select',
                    'label' => __( 'Text Alignment', 'boka' ),
                    'default' => 'text-center',
                    'options' => array(
                        'text-left' => __( 'Text Left', 'boka' ),
                        'text-center' => __( 'Text Center', 'boka' ),
                        'text-right' => __( 'Text Right', 'boka' ),
                    )
                ),
                'title' => array(
                    'type'  => 'text',
                    'label' => __( 'Heading', 'boka' ),
                ),

                'brand' => array(
                    'type'       => 'repeater',
                    'label'      => __( 'Brand', 'boka' ),
                    'item_name'  => __( 'Item', 'boka' ),
                    'item_label' => array(
                        'selector'     => "[id*='prefix-boka-brands-']",
                        'update_event' => 'change',
                        'value_method' => 'val',
                    ),
                    'fields' => array(
                        'profile_picture' => array(
                            'type'     => 'media',
                            'library'  => 'image',
                            'label'    => __( 'Image', 'boka' ),
                            'fallback' => true,
                        ),
                        'pricing_button_url' => array(
                            'type' => 'link',
                            'label' => __('Button URL', 'boka'),
                            'default' => ''
                        ),
                    ),
                ),
            )

        );
    }

    function get_template_name( $instance ) {
        return 'default';
    }
}

siteorigin_widget_register( 'boka-brand-widget', __FILE__, 'Boka_Brand_Widget' );
