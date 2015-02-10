<?php
/*
	Generates an array of timezones in display order from UTC-12:00 to UTC+14:00.
	
	note: according to Wikipedia, UTC-12:00 is "Baker Island, Howland Island (both uninhabited)"
		  hence why timezone_identifiers_list() doesn't have any results for UTC-12:00.  I'm pretty
		  sure uninhabited islands don't have events to count down to, but since it's a valid
		  timezone, we're going to tack it on manually.
*/
function list_of_timezones()
{
	$raw_list_of_gmt_timezones = array();
	$curr_timestamp = time();
		   
	foreach ( timezone_identifiers_list() as $key => $zone )
	{
		// change the timezone
		date_default_timezone_set( $zone );
	
		$diff_from_gmt = date( 'P', $curr_timestamp );
		array_push( $raw_list_of_gmt_timezones, $diff_from_gmt );
	}
	
	// we're done playing with timezones, reset back to blog default
	date_default_timezone_set( get_option( 'gmt_offset' ) );

	// we only want the uniques now
	$unique_list_of_gmt_timezones = array_unique( $raw_list_of_gmt_timezones );

	// split the signs	
	$east = preg_grep( '/\+(.+?)$/', $unique_list_of_gmt_timezones);
	$west = preg_grep( '/\-(.+?)$/', $unique_list_of_gmt_timezones);
	
	// sort
	sort( $east );
	rsort( $west );
	
	// replace "+00:00" with "GMT"
	if ( ( $key = array_search( '+00:00', $east ) ) !== false )
	{
		$east[$key] = 'GMT';
	}

	// glue 'em together
	$list_of_gmt_timezones = array_merge( array('-12:00'), $west, $east );

	return $list_of_gmt_timezones;
}
?>