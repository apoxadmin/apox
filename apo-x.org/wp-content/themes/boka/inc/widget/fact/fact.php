<?php
/**
 * Fact widget.
 *
 * @package boka
 */

class Boka_Fact_Widget extends SiteOrigin_Widget {

	function __construct() {

		parent::__construct(
			'boka-fact-widget',
			__( 'boka Fact Widget', 'boka' ),
			array(
				'description' => __( 'Show your visitors some facts about your company.', 'boka' ),
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
					'default' => 'text-center',
					'options' => array(
						'text-left' => __( 'Text Left', 'boka' ),
						'text-center' => __( 'Text Center', 'boka' ),
						'text-right' => __( 'Text Right', 'boka' ),
					)
				),
				'fact' => array(
					'type'       => 'repeater',
					'label'      => __( 'Fact', 'boka' ),
					'item_name'  => __( 'Item', 'boka' ),
					'item_label' => array(
						'selector'     => "[id*='prefix-boka-fact-']",
						'update_event' => 'change',
						'value_method' => 'val',
					),
					'fields' => array(
						'menu_title' => array(
							'type'  => 'text',
							'label' => __( 'Title', 'boka' ),
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
					),
				),
			)

		);
	}

	function get_template_name( $instance ) {
		return 'default';
	}
}

siteorigin_widget_register( 'boka-fact-widget', __FILE__, 'Boka_Fact_Widget' );
