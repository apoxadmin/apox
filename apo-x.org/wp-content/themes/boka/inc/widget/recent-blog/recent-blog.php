<?php
/**
 * Recent Blog Widget.
 *
 * @package boka
 */

class Themetim_Recent_Blog_Widget extends SiteOrigin_Widget {

	function __construct() {

		parent::__construct(
			'boka-recent-blog-widget',
			__( 'boka Recent Blog Widget', 'boka' ),
			array(
				'description' => __( 'boka Recent Blog', 'boka' ),
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
				'title' => array(
					'type'  => 'text',
					'label' => __( 'Heading', 'boka' ),
				),
				'post_limit' => array(
					'type' => 'number',
					'label' => __( 'Post Limit', 'boka' ),
                    'default' => '2'
				),
			)

		);
	}

	function get_template_name( $instance ) {
		return 'default';
	}
}

siteorigin_widget_register( 'boka-recent-blog-widget', __FILE__, 'Themetim_Recent_Blog_Widget' );
