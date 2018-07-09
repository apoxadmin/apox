<?php
/**
 * Service widget.
 *
 * @package boka
 */

class Boka_Service_Widget extends SiteOrigin_Widget {

	function __construct() {

		parent::__construct(
			'boka-service-widget',
			__( 'boka Service Widget', 'boka' ),
			array(
				'description' => __( 'Service Widget', 'boka' ),
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
				'icon' => array(
					'type' => 'icon',
					'label' => __('Select an icon', 'boka'),
				),
				'icon_size' => array(
					'type' => 'number',
					'label' => __( 'Icon Size', 'boka' ),
					'default' => '40'
				),
				'icon_color' => array(
					'type' => 'color',
					'label' => __( 'Icon Color', 'boka' ),
					'default' => '#f93759'
				),
				'title' => array(
					'type'  => 'text',
					'label' => __( 'Heading', 'boka' ),
				),
				'texteditor' => array(
					'type' => 'tinymce',
					'default' => '',
					'rows' => 7,
					'default_editor' => 'html',
					'button_filters' => array(
						'mce_buttons' => array( $this, 'filter_mce_buttons' ),
						'mce_buttons_2' => array( $this, 'filter_mce_buttons_2' ),
						'mce_buttons_3' => array( $this, 'filter_mce_buttons_3' ),
						'mce_buttons_4' => array( $this, 'filter_mce_buttons_5' ),
						'quicktags_settings' => array( $this, 'filter_quicktags_settings' ),
					),
				),
				'url' => array(
					'type'  => 'link',
					'label' => __( 'URL', 'boka' ),
				),
			)

		);
	}

	function get_template_name( $instance ) {
		return 'default';
	}
}

siteorigin_widget_register( 'boka-service-widget', __FILE__, 'Boka_Service_Widget' );
