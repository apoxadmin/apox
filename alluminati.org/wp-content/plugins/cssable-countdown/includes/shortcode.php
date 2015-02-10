<?php
////////////////////////////////////////////////////////////////
//
//	Shortcode class
//
////////////////////////////////////////////////////////////////
function CSSable_Countdown_Widget_shortcode( $atts, $content = null )
{
	global $periods;
	
	$current_offset = get_option( 'gmt_offset' );
	
	$instance = shortcode_atts( array(
				// shortcode quickdate
				'date'		=> '',
				'time'		=> '',
				
				'event'		=> '',
				'direction' => 'Down',

				'month'		=> date( 'm' ),
				'day'		=> date( 'd' ),
				'year'		=> date( 'Y' ),
				'hour'		=> 0,
				'minutes'	=> 0,
				'seconds'	=> 0,
				'timezone'	=> get_option( 'gmt_offset' ),

				// final format to be used in the countdown
				'format'		=> 'ydHMS',
				
				// expiration options
				'expiryText'	=> '',
				'expiryUrl'		=> '',
				'alwaysExpire'	=> true, // false = event only triggers if the counter actively times out
				
				// options from KBW docs
				'significant'	=> -1,
				
				// layout options
				'layout_type'	=> 'default',
				'compact'		=> false,
				'layout'		=> '',
			), $atts );
		
	if ( $atts['date'] )
	{
		if ( ($timestamp = strtotime( $atts['date'] ) ) !== false )
		{
			$instance['month'] = date( 'n', $timestamp );
			$instance['day'] = date( 'j', $timestamp );
			$instance['year'] = date( 'Y', $timestamp );
		}
	}
	
	if ( $atts['time'] )
	{
		if ( ($timestamp = strtotime( $atts['time'] ) ) !== false )
		{
			$instance['hour'] = date( 'H', $timestamp );
			$instance['minutes'] = date( 'i', $timestamp );
			$instance['seconds'] = date( 's', $timestamp );
		}
	}
	
	// WordPress lowercases all attributes passed in by shortcodes
	if ( isset( $atts['expirytext'] ) )
	{
		$instance['expiryText'] = $atts['expirytext'];
	}
	
	if ( isset( $atts['expiryurl'] ) )
	{
		$instance['expiryUrl'] = $atts['expiryurl'];
	}
	
	if ( !preg_match( '/^[yYoOwWdDhHmMsS]+$/', $atts['format'] ) )
	{
		$instance['kbw_format'] = 'ydHMS';
	}
	else
	{
		$instance['kbw_format'] = $atts['format'];
		
		// need to parse out the letters for format_x
		foreach ( $periods as $pd => $val )
		{
			if ( preg_match( '/([' . $val . strtoupper( $val ) . '])/', $instance['kbw_format'], $matches ) )
			{
				$instance[$pd] = $matches[1];
			}
		}
	}
	
	// keep this last because of the generate_layout()
	if ( isset( $atts['display'] ) )
	{
		$instance['layout_type'] = $atts['display'];
	}
	
	switch ( $instance['layout_type'] )
	{
				case 'list':		$instance['layout'] = generate_layout( $instance );
		break;	case 'text':		$instance['layout'] = '';
		break;	case 'compact':		$instance['compact'] = true;
		break;	default:			$instance['layout_type'] = 'default';
	}
	
	// faking a widget here
	$args = array (	'before_widget'   => '',
					'before_title'    => '',
					'after_title'     => '',
					'after_widget'    => '' );
	
	ob_start();
	the_widget( 'CSSable_Countdown_Widget', $instance, $args );
	$cd_code = ob_get_contents();
	ob_end_clean();
	
	return $cd_code;
}

// register shortcode
add_shortcode( 'countdown', 'CSSable_Countdown_Widget_shortcode');
add_filter( 'widget_text', 'shortcode_unautop');
add_filter('widget_text', 'do_shortcode');
?>