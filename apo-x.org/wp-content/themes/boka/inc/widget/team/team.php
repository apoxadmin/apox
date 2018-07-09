<?php
/**
 * Team widget.
 *
 * @package boka
 */

class Boka_Team_Widget extends SiteOrigin_Widget {

	function __construct() {

		parent::__construct(
			'boka-team-widget',
			__( 'boka Team Widget', 'boka' ),
			array(
				'description' => __( 'Team Widget', 'boka' ),
			),
			array(),
			array(
				'team' => array(
					'type'       => 'repeater',
					'label'      => __( 'Team', 'boka' ),
					'item_name'  => __( 'Item', 'boka' ),
					'item_label' => array(
						'selector'     => "[id*='prefix-boka-team-']",
						'update_event' => 'change',
						'value_method' => 'val',
					),
					'fields' => array(
						'name' => array(
							'type'  => 'text',
							'label' => __( 'Name', 'boka' ),
						),
						'position' => array(
							'type'  => 'text',
							'label' => __( 'Position', 'boka' ),
						),
						'profile_picture' => array(
							'type'     => 'media',
							'library'  => 'image',
							'label'    => __( 'Image', 'boka' ),
							'fallback' => true,
						),
						'facebook' => array(
							'type'  => 'link',
							'label' => __( 'Facebook URL', 'boka' ),
						),
						'linkedin' => array(
							'type'  => 'link',
							'label' => __( 'Linkedin URL', 'boka' ),
						),
						'twitter' => array(
							'type'  => 'link',
							'label' => __( 'Twitter URL', 'boka' ),
						),
						'youtube' => array(
							'type'  => 'link',
							'label' => __( 'YouTube URL', 'boka' ),
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

siteorigin_widget_register( 'boka-team-widget', __FILE__, 'Boka_Team_Widget' );
