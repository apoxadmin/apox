<?php
/**
 * Featured List Widget.
 *
 * @package boka
 */

class Boka_Featured_List_Widget extends SiteOrigin_Widget {

	function __construct() {

		parent::__construct(
			'boka-featured-list-widget',
			__( 'boka Featured List Widget', 'boka' ),
			array(
				'description' => __( 'boka Featured List Widget', 'boka' ),
			),
			array(),

			array(
				'FeaturedList' => array(
					'type'       => 'repeater',
					'label'      => __( 'Featured List', 'boka' ),
					'item_name'  => __( 'Item', 'boka' ),
					'item_label' => array(
						'selector'     => "[id*='prefix-boka-featured-list-']",
						'update_event' => 'change',
						'value_method' => 'val',
					),
					'fields' => array(
						'image_icon' => array(
							'type'     => 'radio',
							'default' => 'icon',
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
						'icon_color' => array(
							'type' => 'color',
							'label' => __( 'Icon Color', 'boka' ),
							'default' => '#fff'
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
				)
			)

		);
	}

	function get_template_name( $instance ) {
		return 'default';
	}
}

siteorigin_widget_register( 'boka-featured-list-widget', __FILE__, 'Boka_Featured_List_Widget' );
