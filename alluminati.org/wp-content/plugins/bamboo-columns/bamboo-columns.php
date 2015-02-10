<?php
/******************************************************************/
/*
	Plugin Name: Bamboo Columns
	Plugin URI:  http://www.bamboosolutions.co.uk/wordpress/bamboo-columns
	Author:      Bamboo Solutions
	Author URI:  http://www.bamboosolutions.co.uk
	Version:     1.3
	Description: This plugin provides several shortcodes for organising your content into multi-column layouts. It supports two, three and four column layouts and allows for content to span multiple columns if required.
*/
/******************************************************************/

	add_action( 'init', 'bamboo_columns_styles' );

	add_filter( 'the_content', 'bamboo_column_content_filter' );

	add_shortcode( 'column-half-1',	'bamboo_column_half_1' );
	add_shortcode( 'column-half-2',	'bamboo_column_half_2' );

	add_shortcode( 'column-third-1-2',	'bamboo_column_third_1_2' );
	add_shortcode( 'column-third-2-3', 	'bamboo_column_third_2_3' );
	add_shortcode( 'column-third-1',		'bamboo_column_third_1' );
	add_shortcode( 'column-third-2',		'bamboo_column_third_2' );
	add_shortcode( 'column-third-3',		'bamboo_column_third_3' );

	add_shortcode( 'column-quarter-1-2-3',	'bamboo_column_quarter_1_2_3' );
	add_shortcode( 'column-quarter-1-2',   	'bamboo_column_quarter_1_2' );
	add_shortcode( 'column-quarter-2-3-4', 	'bamboo_column_quarter_2_3_4' );
	add_shortcode( 'column-quarter-2-3',   	'bamboo_column_quarter_2_3' );
	add_shortcode( 'column-quarter-3-4',   	'bamboo_column_quarter_3_4' );
	add_shortcode( 'column-quarter-1',     	'bamboo_column_quarter_1' );
	add_shortcode( 'column-quarter-2',     	'bamboo_column_quarter_2' );
	add_shortcode( 'column-quarter-3',     	'bamboo_column_quarter_3' );
	add_shortcode( 'column-quarter-4',     	'bamboo_column_quarter_4' );

/******************************************************************/

	function bamboo_columns_styles() {

		wp_enqueue_style( 'bamboo-columns', plugins_url( '', __FILE__) . '/bamboo-columns.css' );

	}

/******************************************************************/

	function bamboo_column_content_filter( $content ){

		$array = array (
			'[/column-half-1]<br />' => '[/column-half-1]',
			'[/column-third-1]<br />' => '[/column-third-1]',
			'[/column-third-2]<br />' => '[/column-third-2]',
			'[/column-third-1-2]<br />' => '[/column-third-1-2]',
			'[/column-quarter-1]<br />' => '[/column-quarter-1]',
			'[/column-quarter-2]<br />' => '[/column-quarter-2]',
			'[/column-quarter-3]<br />' => '[/column-quarter-3]',
			'[/column-quarter-1-2]<br />' => '[/column-quarter-1-2]',
			'[/column-quarter-1-2-3]<br />' => '[/column-quarter-1-2-3]',
			'[/column-quarter-2-3]<br />' => '[/column-quarter-2-3]',
			'[/column-quarter-2-3-4]<br />' => '[/column-quarter-2-3-4]',
			'[/column-quarter-3-4]<br />' => '[/column-quarter-3-4]'
		);

		$content = strtr($content, $array);
		return $content;

	}

/******************************************************************/

	function bamboo_column_half_1( $atts, $content=null ) {

		$content = do_shortcode( $content );

		$style = '';
		if( isset( $atts['background'] ) ) {
			$style = 'style="background-color:#' . $atts['background'] . '" ';
		}

		$html = "<div {$style}class=\"column-half first\">$content</div>";

		return $html;

	}

/******************************************************************/

	function bamboo_column_half_2( $atts, $content=null ) {

		$content = do_shortcode( $content );

		$style = '';
		if( isset( $atts['background'] ) ) {
			$style = 'style="background-color:#' . $atts['background'] . '" ';
		}

		$html = "<div {$style}class=\"column-half second\">$content</div>";

		return $html;

	}

/******************************************************************/

	function bamboo_column_third_1( $atts, $content=null ) {

		$content = do_shortcode( $content );

		$style = '';
		if( isset( $atts['background'] ) ) {
			$style = 'style="background-color:#' . $atts['background'] . '" ';
		}

		$html = "<div {$style}class=\"column-third first\">$content</div>";

		return $html;

	}

/******************************************************************/

	function bamboo_column_third_2( $atts, $content=null ) {

		$content = do_shortcode( $content );

		$style = '';
		if( isset( $atts['background'] ) ) {
			$style = 'style="background-color:#' . $atts['background'] . '" ';
		}

		$html = "<div {$style}class=\"column-third second\">$content</div>";

		return $html;

	}

/******************************************************************/

	function bamboo_column_third_3( $atts, $content=null ) {

		$content = do_shortcode( $content );

		$style = '';
		if( isset( $atts['background'] ) ) {
			$style = 'style="background-color:#' . $atts['background'] . '" ';
		}

		$html = "<div {$style}class=\"column-third third\">$content</div>";

		return $html;

	}

/******************************************************************/

	function bamboo_column_third_1_2( $atts, $content=null ) {

		$content = do_shortcode( $content );

		$style = '';
		if( isset( $atts['background'] ) ) {
			$style = 'style="background-color:#' . $atts['background'] . '" ';
		}

		$html = "<div {$style}class=\"column-third first-second\">$content</div>";

		return $html;

	}

/******************************************************************/

	function bamboo_column_third_2_3( $atts, $content=null ) {

		$content = do_shortcode( $content );

		$style = '';
		if( isset( $atts['background'] ) ) {
			$style = 'style="background-color:#' . $atts['background'] . '" ';
		}

		$html = "<div {$style}class=\"column-third second-third\">$content</div>";

		return $html;

	}

/******************************************************************/

	function bamboo_column_quarter_1( $atts, $content=null ) {

		$content = do_shortcode( $content );

		$style = '';
		if( isset( $atts['background'] ) ) {
			$style = 'style="background-color:#' . $atts['background'] . '" ';
		}

		$html = "<div {$style}class=\"column-quarter first\">$content</div>";

		return $html;

	}

/******************************************************************/

	function bamboo_column_quarter_2( $atts, $content=null ) {

		$content = do_shortcode( $content );

		$style = '';
		if( isset( $atts['background'] ) ) {
			$style = 'style="background-color:#' . $atts['background'] . '" ';
		}

		$html = "<div {$style}class=\"column-quarter second\">$content</div>";

		return $html;

	}

/******************************************************************/

	function bamboo_column_quarter_3( $atts, $content=null ) {

		$content = do_shortcode( $content );

		$style = '';
		if( isset( $atts['background'] ) ) {
			$style = 'style="background-color:#' . $atts['background'] . '" ';
		}

		$html = "<div {$style}class=\"column-quarter third\">$content</div>";

		return $html;

	}

/******************************************************************/

	function bamboo_column_quarter_4( $atts, $content=null ) {

		$content = do_shortcode( $content );

		$style = '';
		if( isset( $atts['background'] ) ) {
			$style = 'style="background-color:#' . $atts['background'] . '" ';
		}

		$html = "<div {$style}class=\"column-quarter fourth\">$content</div>";

		return $html;

	}

/******************************************************************/

	function bamboo_column_quarter_1_2( $atts, $content=null ) {

		$content = do_shortcode( $content );

		$style = '';
		if( isset( $atts['background'] ) ) {
			$style = 'style="background-color:#' . $atts['background'] . '" ';
		}

		$html = "<div {$style}class=\"column-quarter first-second\">$content</div>";

		return $html;

	}

/******************************************************************/

	function bamboo_column_quarter_1_2_3( $atts, $content=null ) {

		$content = do_shortcode( $content );

		$style = '';
		if( isset( $atts['background'] ) ) {
			$style = 'style="background-color:#' . $atts['background'] . '" ';
		}

		$html = "<div {$style}class=\"column-quarter first-second-third\">$content</div>";

		return $html;

	}

/******************************************************************/

	function bamboo_column_quarter_2_3( $atts, $content=null ) {

		$content = do_shortcode( $content );

		$style = '';
		if( isset( $atts['background'] ) ) {
			$style = 'style="background-color:#' . $atts['background'] . '" ';
		}

		$html = "<div {$style}class=\"column-quarter second-third\">$content</div>";

		return $html;

	}

/******************************************************************/

	function bamboo_column_quarter_2_3_4( $atts, $content=null ) {

		$content = do_shortcode( $content );

		$style = '';
		if( isset( $atts['background'] ) ) {
			$style = 'style="background-color:#' . $atts['background'] . '" ';
		}

		$html = "<div {$style}class=\"column-quarter second-third-fourth\">$content</div>";

		return $html;

	}

/******************************************************************/

	function bamboo_column_quarter_3_4( $atts, $content=null ) {

		$content = do_shortcode( $content );

		$style = '';
		if( isset( $atts['background'] ) ) {
			$style = 'style="background-color:#' . $atts['background'] . '" ';
		}

		$html = "<div {$style}class=\"column-quarter third-fourth\">$content</div>";

		return $html;

	}

/******************************************************************/
?>