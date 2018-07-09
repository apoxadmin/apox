<?php
/**
 * Heading Widget.
 *
 * @package boka
 */

class Boka_Heading_Widget extends SiteOrigin_Widget {

	function __construct() {

		parent::__construct(
			'boka-editor-widget',
			__( 'boka Heading Widget', 'boka' ),
			array(
				'description' => __( 'Boka Heading Widget', 'boka' ),
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
				'heading_tag' => array(
					'type' => 'select',
					'label' => __( 'Select Title Tag', 'boka' ),
					'default' => 'h2',
					'options' => array(
						'h1' => __( 'H1', 'boka' ),
						'h2' => __( 'H2', 'boka' ),
						'h3' => __( 'H3', 'boka' ),
						'h4' => __( 'H4', 'boka' ),
						'h5' => __( 'H5', 'boka' ),
						'h6' => __( 'H6', 'boka' )
					)
				),
				'color' => array(
					'type' => 'color',
					'label' => __( 'Text Color', 'boka' ),
					'default' => ''
				),
				'heading' => array(
					'type'  => 'text',
					'label' => __( 'Title', 'boka' ),
				),
				'sub_title' => array(
					'type' => 'textarea',
					'label' => __( 'Sub Heading', 'boka' ),
				),
			)

		);
	}

	function get_template_name( $instance ) {
		return 'default';
	}
}

siteorigin_widget_register( 'boka-editor-widget', __FILE__, 'Boka_Heading_Widget' );
