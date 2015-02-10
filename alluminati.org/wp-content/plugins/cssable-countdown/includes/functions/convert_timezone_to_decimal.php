<?php
// timezone needs to be converted from ±hh:ss to ±hh.s because Javascript whyyyyy
function convert_timezone_to_decimal( $tz )
{
	if ( 'GMT' == $tz )
	{
		return '0';
	}
	else
	{
		preg_match( '/([+-])(\d+)(?:\:(\d+))?/', $tz, $matches );
		$sign = $matches[1];
		$hh = (int)$matches[2];
		$mm = (int)$matches[3];
		
		if ( !empty( $mm ) )
		{
			$mm = '.' . ( $mm / 60 ) * 100;
		}
		else
		{
			$mm = '';
		}
		
		return $sign . $hh . $mm;
	}
}

// and the reverse
function convert_decimal_to_timezone( $dec )
{
	if ( '0' == $dec )
	{
		return 'GMT';
	}
	else
	{
		preg_match( '/([+-])(\d+)(?:\.(\d+))?/', $dec, $matches );
		$sign = $matches[1];
		$hh = (int)$matches[2];
		
		if ( isset( $matches[3] ) )
		{
			$mm = (int)$matches[3];
			
			$mm = 60 * $mm;
		}
		else
		{
			$mm = '00';
		}
		
		return $sign . str_pad( $hh, 2, '0', STR_PAD_LEFT ) . ':' . $mm;
	}
}
?>