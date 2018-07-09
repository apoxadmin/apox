<?php
/**
 * Portfolio widget.
 *
 * @package boka
 */

class Boka_Portfolio_Widget extends SiteOrigin_Widget {

	function __construct() {

		parent::__construct(
			'boka-portfolio-widget',
			__( 'boka Portfolio Widget', 'boka' ),
			array(
				'description' => __( 'Displays Portfolio Widget', 'boka' ),
			),
			array(),
			array(
				'title' => array(
					'type'  => 'text',
					'label' => __( 'Title', 'boka' ),
				),
				'heading_alignment' => array(
					'type' => 'select',
					'label' => __( 'Text Alignment', 'boka' ),
					'default' => 'text-left',
					'options' => array(
						'text-left' => __( 'Text Left', 'boka' ),
						'text-center' => __( 'Text Center', 'boka' ),
						'text-right' => __( 'Text Right', 'boka' ),
					)
				),
				'portfolio' => array(
					'type'       => 'repeater',
					'label'      => __( 'Portfolio', 'boka' ),
					'item_name'  => __( 'Item', 'boka' ),
					'item_label' => array(
						'selector'     => "[id*='prefix-boka-portfolio-']",
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
						'menu_title' => array(
							'type'  => 'text',
							'label' => __( 'Title', 'boka' ),
						),
						'button_url' => array(
							'type' => 'link',
							'label' => __('Button URL', 'boka'),
							'default' => ''
						),
					),
				),
				'per_row' => array(
					'type'    => 'select',
					'label'   => __( 'Menus per row', 'boka' ),
					'default' => 4,
					'options' => array(
						'12' => 1,
						'6' => 2,
						'4' => 3,
						'3' => 4,
					),
				),
			)
		);
	}

	function get_template_name( $instance ) {
		return 'default';
	}
}

siteorigin_widget_register( 'boka-portfolio-widget', __FILE__, 'Boka_Portfolio_Widget' );
