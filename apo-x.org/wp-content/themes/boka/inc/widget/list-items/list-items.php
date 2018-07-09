<?php
/**
 * List Items Widget.
 *
 * @package boka
 */

class Boka_List_Items_Widget extends SiteOrigin_Widget {

	function __construct() {

		parent::__construct(
			'boka-list-items-widget',
			__( 'boka List Items Widget', 'boka' ),
			array(
				'description' => __( 'boka List Items Widget', 'boka' ),
			),
			array(),

			array(
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
					'type' => 'text',
					'label' => __( 'Content', 'boka' ),
				),
				'listItems' => array(
					'type'       => 'repeater',
					'label'      => __( 'List Items', 'boka' ),
					'item_name'  => __( 'Item', 'boka' ),
					'item_label' => array(
						'selector'     => "[id*='prefix-boka-list-items-']",
						'update_event' => 'change',
						'value_method' => 'val',
					),
					'fields' => array(
						'icons' => array(
							'type' => 'icon',
							'label' => __('Select an icon', 'boka'),
						),
						'icon_size' => array(
							'type' => 'number',
							'label' => __( 'Icon Size', 'boka' ),
							'default' => '18'
						),
						'icon_color' => array(
							'type' => 'color',
							'label' => __( 'Icon Color', 'boka' ),
							'default' => '#717171'
						),
						'sub_title' => array(
							'type' => 'text',
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

siteorigin_widget_register( 'boka-list-items-widget', __FILE__, 'Boka_List_Items_Widget' );
