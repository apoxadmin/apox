<?php
/**
 * Editor Widget.
 *
 * @package boka
 */

class Boka_Editor_Widget extends SiteOrigin_Widget {

	function __construct() {

		parent::__construct(
			'boka-editor-widget',
			__( 'boka Editor Widget', 'boka' ),
			array(
				'description' => __( 'boka Editor Widget', 'boka' ),
			),
			array(),

			array(
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
				'icon' => array(
					'type' => 'icon',
					'label' => __('Select an icon', 'boka'),
				),
				'icon_size' => array(
					'type' => 'number',
					'label' => __( 'Icon Size', 'boka' ),
					'default' => '14'
				),
				'icon_color' => array(
					'type' => 'color',
					'label' => __( 'Icon Color', 'boka' ),
					'default' => '#000'
				),
				'title' => array(
					'type'  => 'text',
					'label' => __( 'Heading', 'boka' ),
				),
				'sub_title' => array(
					'type' => 'text',
					'label' => __( 'Sub Heading', 'boka' ),
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
				'button_text' => array(
					'type' => 'text',
					'label' => __('Button Title', 'boka'),
					'default' => ''
				),
				'button_style' => array(
					'type' => 'select',
					'label' => __( 'Button Style', 'boka' ),
					'default' => 'btn-default',
					'options' => array(
						'btn-default' => __( 'Default', 'boka' ),
						'btn-primary' => __( 'Primary', 'boka' ),
						'btn-success' => __( 'Success', 'boka' ),
					)
				),
				'button_url' => array(
					'type' => 'link',
					'label' => __('Button URL', 'boka'),
					'default' => ''
				),
			)

		);
	}

	function get_template_name( $instance ) {
		return 'default';
	}
}

siteorigin_widget_register( 'boka-editor-widget', __FILE__, 'Boka_Editor_Widget' );
