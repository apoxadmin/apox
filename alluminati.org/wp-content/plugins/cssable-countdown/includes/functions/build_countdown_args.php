<?php
function build_countdown_args( $unique, $widget_options )
{
	extract( $widget_options, EXTR_SKIP );
	
	$whichway = ( strtolower( $direction ) == 'down' ) ? 'until' : 'since';
	$quickdate = intval( $year ) . ', ' .
				( intval( $month ) - 1 ). ', ' .
				intval( $day ) . ', ' .
				$hour . ', ' .
				$minutes . ', ' .
				$seconds . ', 0';

	// create an array of all possible options
	$build_args = array(
		$whichway		=> 'new Date(' . $quickdate . ')',
		'timezone'		=> convert_timezone_to_decimal($timezone),
		
		// text
		'description'	=> $event,
		
		// expiration
		'hasExpiryText'	=> ( !empty( $expiryText ) ? true : false ),
		'expiryText'	=> '<div id="' . $unique . '" class="times-up">' . addslashes( $expiryText ) . '</div>',
		'expiryUrl'		=> addslashes( $expiryUrl ),
		'alwaysExpire'	=> $alwaysExpire ? 'true' : 'false',
		
		// formatting
		'format'		=> $format,
		'kbw_format'	=> $kbw_format,
		'significant'	=> $significant,
		
		'format_years'		=> $format_years,
		'format_months'		=> $format_months,
		'format_weeks'		=> $format_weeks,
		'format_days'		=> $format_days,
		'format_hours'		=> $format_hours,
		'format_minutes'	=> $format_minutes,
		'format_seconds'	=> $format_seconds,
		
		// styling
		'compact'		=> $compact ? 'true' : 'false',
		'layout_type'	=> $layout_type,
		'layout'		=> $layout,
		
		// localization
		'lang'			=> convert_wp_lang_to_valid_language_code( $lang ),
	);
	
	// print_args: [key] => (bool) are quotes required?
	
	// these values are always required
	$print_args = array( $whichway	=> false,
						'timezone'	=> true,
						'format'	=> true,
						'alwaysExpire' => true);
	
	// these values are displayed if their conditionals are met
	if ( !empty( $event ) )			$print_args['description'] = true;
	if ( !empty( $expiryText ) )	$print_args['expiryText'] = true;
	if ( !empty( $expiryUrl ) )
	{
		$print_args['expiryUrl'] = true;
		$print_args['alwaysExpire'] = true;
	}
	
	if ( empty( $kbw_format ) )
	{
		if ( !empty( $layout ) && $layout != 'default' )
		{
			$print_args['layout'] = true;
		}
		
		if ( $compact )					$print_args['compact'] = true;
	}
	else
	{
		$print_args['kbw_format'] = true;
		if ( $significant != -1 )		$print_args['significant'] = false;
	}
	
	return array( $build_args, $print_args );
}
?>