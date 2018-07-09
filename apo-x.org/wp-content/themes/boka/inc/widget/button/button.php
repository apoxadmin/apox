<?php
/**
 * Button Widget.
 *
 * @package boka
 */

class Boka_Button_Widget extends SiteOrigin_Widget {

	function __construct() {

		parent::__construct(
			'boka-button-widget',
			__( 'boka Button Widget', 'boka' ),
			array(
				'description' => __( 'boka Button Widget', 'boka' ),
			),
			array(),

			array(
				'heading_alignment' => array(
					'type' => 'select',
					'label' => __( 'Alignment', 'boka' ),
					'default' => 'text-left',
					'options' => array(
						'text-left' => __( 'Left', 'boka' ),
						'text-center' => __( 'Center', 'boka' ),
						'text-right' => __( 'Right', 'boka' ),
					)
				),
				'color' => array(
					'type' => 'color',
					'label' => __( 'Text Color', 'boka' ),
					'default' => ''
				),
				'bgColor' => array(
					'type' => 'color',
					'label' => __( 'BG Color', 'boka' ),
					'default' => ''
				),
				'button_text' => array(
					'type' => 'text',
					'label' => __('Title', 'boka'),
					'default' => __('Learn More', 'boka'),
				),
				'button_url' => array(
					'type' => 'link',
					'label' => __('URL', 'boka'),
					'default' => ''
				),
			)

		);
	}

	function get_template_name( $instance ) {
		return 'default';
	}
}

siteorigin_widget_register( 'boka-button-widget', __FILE__, 'Boka_Button_Widget' );
