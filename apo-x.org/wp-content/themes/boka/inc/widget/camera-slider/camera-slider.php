<?php
/**
 * Camera Slider widget.
 *
 * @package boka
 */

class Boka_CameraSlider_Widget extends SiteOrigin_Widget {

	function __construct() {

		parent::__construct(
			'boka-camera-slider-widget',
			__( 'boka Camera Slider Widget', 'boka' ),
			array(
				'description' => __( 'Camera Slider Widget', 'boka' ),
			),
			array(),

			array(
				'CameraSlider' => array(
					'type'       => 'repeater',
					'label'      => __( 'Camera Slider', 'boka' ),
					'item_name'  => __( 'Item', 'boka' ),
					'item_label' => array(
						'selector'     => "[id*='prefix-boka-camera-slider-']",
						'update_event' => 'change',
						'value_method' => 'val',
					),
					'fields' => array(
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
						'text_position' => array(
							'type' => 'select',
							'label' => __( 'Text Position', 'boka' ),
							'default' => '0 auto',
							'options' => array(
								'auto auto auto 0' => __( 'Text Left', 'boka' ),
								'0 auto' => __( 'Text Center', 'boka' ),
								'auto 0 auto auto' => __( 'Text Right', 'boka' ),
							)
						),
						'CameraSlider_image' => array(
							'type'     => 'media',
							'library'  => 'image',
							'label'    => __( 'Slide Image', 'boka' ),
							'fallback' => true,
						),
						'CameraSlider_title_color' => array(
							'type' => 'color',
							'label' => __( 'Title Color', 'boka' ),
							'default' => '#000'
						),
						'title_animation' => array(
							'type'  => 'text',
							'label' => __( 'Title Animation', 'boka' ),
							'default' => 'slideInUp',
							'description' => __( 'Take an <a href="https://daneden.github.io/animate.css/">Animation</a> code and put in field', 'boka' )
						),
						'CameraSlider_title' => array(
							'type'  => 'text',
							'label' => __( 'Title', 'boka' ),
						),
						'CameraSlider_subtitle_color' => array(
							'type' => 'color',
							'label' => __( 'Content Color', 'boka' ),
							'default' => '#000'
						),
						'content_animation' => array(
							'type'  => 'text',
							'label' => __( 'Content Animation', 'boka' ),
							'default' => 'slideInUp',
							'description' => __( 'Take an <a href="https://daneden.github.io/animate.css/">Animation</a> code and put in field', 'boka' )
						),
						'CameraSlider_subtitle' => array(
							'type'  => 'textarea',
							'label' => __( 'Content', 'boka' ),
						),
						'color' => array(
							'type' => 'color',
							'label' => __( 'Button Text Color', 'boka' ),
							'default' => ''
						),
						'bgColor' => array(
							'type' => 'color',
							'label' => __( 'Button BG Color', 'boka' ),
							'default' => ''
						),
						'btn_animation' => array(
							'type'  => 'text',
							'label' => __( 'Button Animation', 'boka' ),
							'default' => 'slideInUp',
							'description' => __( 'Take an <a href="https://daneden.github.io/animate.css/">Animation</a> code and put in field', 'boka' )
						),
						'CameraSlider_button_text' => array(
							'type' => 'text',
							'label' => __('Button Title', 'boka'),
							'default' => ''
						),
						'CameraSlider_button_url' => array(
							'type' => 'link',
							'label' => __('Button URL', 'boka'),
							'default' => ''
						),
					),
				),
				'control' => array(
					'type' => 'section',
					'label' => __( 'Control' , 'boka' ),
					'hide' => true,
					'fields' => array(
						'height' => array(
							'type' => 'slider',
							'label' => __( 'Slider Height', 'boka' ),
							'default' => 50,
							'min' => 10,
							'max' => 100,
							'integer' => true
						),
						'effect' => array(
							'type' => 'select',
							'label' => __( 'Slider Effect', 'boka' ),
							'default' => 'random',
							'options' => array(
								'random' => __( 'random', 'boka' ),
								'simpleFade' => __( 'simpleFade', 'boka' ),
								'curtainTopLeft' => __( 'curtainTopLeft', 'boka' ),
								'curtainTopRight' => __( 'curtainTopRight', 'boka' ),
								'curtainBottomLeft' => __( 'curtainBottomLeft', 'boka' ),
								'curtainBottomRight' => __( 'curtainBottomRight', 'boka' ),
								'curtainSliceLeft' => __( 'curtainSliceLeft', 'boka' ),
								'curtainSliceRight' => __( 'curtainSliceRight', 'boka' ),
								'blindCurtainTopLeft' => __( 'blindCurtainTopLeft', 'boka' ),
								'blindCurtainTopRight' => __( 'blindCurtainTopRight', 'boka' ),
								'blindCurtainBottomLeft' => __( 'blindCurtainBottomLeft', 'boka' ),
								'blindCurtainBottomRight' => __( 'blindCurtainBottomRight', 'boka' ),
								'blindCurtainSliceBottom' => __( 'blindCurtainSliceBottom', 'boka' ),
								'blindCurtainSliceTop' => __( 'blindCurtainSliceTop', 'boka' ),
								'stampede' => __( 'stampede', 'boka' ),
								'mosaic' => __( 'mosaic', 'boka' ),
								'mosaicReverse' => __( 'mosaicReverse', 'boka' ),
								'mosaicRandom' => __( 'mosaicRandom', 'boka' ),
								'mosaicSpiral' => __( 'mosaicSpiral', 'boka' ),
								'mosaicSpiralReverse' => __( 'mosaicSpiralReverse', 'boka' ),
								'topLeftBottomRight' => __( 'topLeftBottomRight', 'boka' ),
								'bottomRightTopLeft' => __( 'bottomRightTopLeft', 'boka' ),
								'bottomLeftTopRight' => __( 'bottomLeftTopRight', 'boka' ),
								'scrollLeft' => __( 'scrollLeft', 'boka' ),
								'scrollRight' => __( 'scrollRight', 'boka' ),
								'scrollHorz' => __( 'scrollHorz', 'boka' ),
								'scrollBottom' => __( 'scrollBottom', 'boka' ),
								'scrollTop' => __( 'scrollTop', 'boka' ),
							)
						),
						'loader' => array(
							'type' => 'select',
							'label' => __( 'Loader', 'boka' ),
							'default' => 'bar',
							'options' => array(
								'none' => __( 'none', 'boka' ),
								'bar' => __( 'bar', 'boka' ),
								'pie' => __( 'pie', 'boka' ),
							)
						),
						'barPosition' => array(
							'type' => 'select',
							'label' => __( 'Bar Position', 'boka' ),
							'default' => 'bottom',
							'options' => array(
								'left' => __( 'left', 'boka' ),
								'right' => __( 'right', 'boka' ),
								'top' => __( 'top', 'boka' ),
								'bottom' => __( 'bottom', 'boka' ),
							)
						)
					)
				),
			)

		);
	}

	function get_template_name( $instance ) {
		return 'default';
	}
}

siteorigin_widget_register( 'boka-camera-slider-widget', __FILE__, 'Boka_CameraSlider_Widget' );
