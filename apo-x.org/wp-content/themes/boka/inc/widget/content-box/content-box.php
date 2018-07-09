<?php
/**
 * Content Box Widget.
 *
 * @package boka
 */

class Boka_ContentBox_Widget extends SiteOrigin_Widget {

	function __construct() {

		parent::__construct(
			'boka-contentbox-widget',
			__( 'boka Content Box Widget', 'boka' ),
			array(
				'description' => __( 'boka Content Box Widget', 'boka' ),
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
				'contentBox' => array(
					'type'       => 'repeater',
					'label'      => __( 'Content Box', 'boka' ),
					'item_name'  => __( 'Item', 'boka' ),
					'item_label' => array(
						'selector'     => "[id*='prefix-boka-content-box-']",
						'update_event' => 'change',
						'value_method' => 'val',
					),
					'fields' => array(
						'image_icon' => array(
							'type'     => 'radio',
							'default' => 'image',
							'options' => array(
								'image' => __( 'Image', 'boka' ),
								'icon' => __( 'Icon', 'boka' )
							)
						),
						'image' => array(
							'type'     => 'media',
							'library'  => 'image',
							'label'    => __( 'Image', 'boka' ),
							'fallback' => true,
						),
						'icons' => array(
							'type' => 'icon',
							'label' => __('Select an icon', 'boka'),
						),
						'icon_size' => array(
							'type' => 'number',
							'label' => __( 'Icon Size', 'boka' ),
							'default' => '54'
						),
						'icon_color' => array(
							'type' => 'color',
							'label' => __( 'Icon Color', 'boka' ),
							'default' => '#1488cc'
						),
						'title' => array(
							'type'  => 'text',
							'label' => __( 'Title', 'boka' ),
						),
						'sub_title' => array(
							'type' => 'textarea',
							'label' => __( 'Content', 'boka' ),
						)
					),
				),
				'per_row' => array(
					'type'    => 'select',
					'label'   => __( 'Number of columns', 'boka' ),
					'default' => 3,
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

siteorigin_widget_register( 'boka-contentbox-widget', __FILE__, 'Boka_ContentBox_Widget' );
