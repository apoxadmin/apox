<?php
/**
 * Testimonial widget.
 *
 * @package boka
 */

class Boka_Testimonial_Widget extends SiteOrigin_Widget {

	function __construct() {

		parent::__construct(
			'boka-testimonial-widget',
			__( 'boka Testimonial Widget', 'boka' ),
			array(
				'description' => __( 'Testimonial Widget', 'boka' ),
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
					'label' => __( 'Title', 'boka' ),
				),

				'testimonial' => array(
					'type'       => 'repeater',
					'label'      => __( 'Testimonial', 'boka' ),
					'item_name'  => __( 'Item', 'boka' ),
					'item_label' => array(
						'selector'     => "[id*='prefix-boka-testimonial-']",
						'update_event' => 'change',
						'value_method' => 'val',
					),
					'fields' => array(
						'testimonial_name' => array(
							'type'  => 'text',
							'label' => __( 'Name', 'boka' ),
						),
						'position' => array(
							'type'  => 'text',
							'label' => __( 'Position', 'boka' ),
						),
						'testimonial_texteditor' => array(
							'type' => 'textarea',
							'label' => __( 'Content', 'boka' ),
						),
						'testimonial_profile_picture' => array(
							'type'     => 'media',
							'library'  => 'image',
							'label'    => __( 'Image', 'boka' ),
							'fallback' => true,
						),
					),
				),
				'control' => array(
					'type' => 'section',
					'label' => __( 'Control' , 'boka' ),
					'hide' => true,
					'fields' => array(
						'style' => array(
							'type' => 'select',
							'label' => __( 'Style of Testimonial', 'boka' ),
							'default' => 'default',
							'options' => array(
								'default' => __( 'Default', 'boka' ),
								'style-1' => __( 'Style 1', 'boka' ),
								'style-2' => __( 'Style 2', 'boka' ),
							)
						),
						'per_row' => array(
							'type'    => 'select',
							'label'   => __( 'Select Columns', 'boka' ),
							'description'   => __( 'it will be work for the default setting', 'boka' ),
							'default' => 3,
							'options' => array(
								'12' => 1,
								'6' => 2,
								'4' => 3
							),
						),
						'padding' => array(
							'type' => 'number',
							'label' => __( 'Wrapper Padding', 'boka' ),
							'default' => '70'
						),
						'bg_color' => array(
							'type' => 'color',
							'label' => __( 'Background Color', 'boka' ),
							'default' => ''
						),
						'color_name' => array(
							'type' => 'color',
							'label' => __( 'Name Color', 'boka' ),
							'default' => ''
						),
						'color_position' => array(
							'type' => 'color',
							'label' => __( 'Position Color', 'boka' ),
							'default' => '#000'
						),
						'color_content' => array(
							'type' => 'color',
							'label' => __( 'Content Color', 'boka' ),
							'default' => '#000'
						),
						'indicators' => array(
							'type' => 'checkbox',
							'label' => __( 'Show/Hide Slider Indicators ( will not work DEFAULT )', 'boka' ),
							'default' => ''
						),
						'left_right_arrow' => array(
							'type' => 'checkbox',
							'label' => __( 'Show/Hide Slider Arrow ( will not work DEFAULT )', 'boka' ),
							'default' => ''
						),
						'quote' => array(
							'type' => 'checkbox',
							'label' => __( 'Show/Hide Quote image', 'boka' ),
							'default' => ''
						),
					)
				),
			)
		);
	}

	function get_template_name( $instance ) {
		return 'default';
	}
}

siteorigin_widget_register( 'boka-testimonial-widget', __FILE__, 'Boka_Testimonial_Widget' );
