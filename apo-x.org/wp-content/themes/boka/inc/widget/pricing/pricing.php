<?php
/**
 * Pricing widget.
 *
 * @package boka
 */

class Boka_Pricing_Widget extends SiteOrigin_Widget {

	function __construct() {

		parent::__construct(
			'boka-pricing-widget',
			__( 'boka Pricing Table Widget', 'boka' ),
			array(
				'description' => __( 'Pricing Table Widget', 'boka' ),
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

				'pricing' => array(
					'type'       => 'repeater',
					'label'      => __( 'Pricing', 'boka' ),
					'item_name'  => __( 'Item', 'boka' ),
					'item_label' => array(
						'selector'     => "[id*='prefix-boka-pricing-']",
						'update_event' => 'change',
						'value_method' => 'val',
					),
					'fields' => array(
						'color' => array(
							'type' => 'color',
							'label' => __( 'Plan Color', 'boka' ),
							'default' => '#1488cc'
						),
						'planName' => array(
							'type'  => 'text',
							'label' => __( 'Plan Name', 'boka' ),
						),
						'amount' => array(
							'type'  => 'text',
							'label' => __( 'Amount', 'boka' ),
						),
						'currency' => array(
							'type'  => 'text',
							'label' => __( 'Currency ', 'boka' ),
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
						'button_url' => array(
							'type' => 'link',
							'label' => __('Button URL', 'boka'),
							'default' => ''
						),
					),
				),
				'per_row' => array(
					'type'    => 'select',
					'label'   => __( 'Select Columns', 'boka' ),
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

siteorigin_widget_register( 'boka-pricing-widget', __FILE__, 'Boka_Pricing_Widget' );
