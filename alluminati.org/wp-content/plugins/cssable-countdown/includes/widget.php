<?php
// if the timer has already expired on page load, show the expiry text if selected
$eventDate = mktime($widget_options['hour'],
					$widget_options['minutes'],
					$widget_options['seconds'],
					$widget_options['month'],
					$widget_options['day'],
					$widget_options['year']);

// reverse comparision direction if it's a countup
if ( strtolower( $direction ) == 'up' )
{
	$comparator = time() < $eventDate;
}
else
{
	$comparator = time() > $eventDate;
}

/*
	notes:
	
	$this->number only works inside widget()
		http://code.hyperspatial.com/396/widget-instance-unique-id/
		
	only widgets will have $this->number.  shortcodes do NOT get auto-generated numbers,
	so we'll have to use a global ID tracker.
		http://wordpress.stackexchange.com/questions/10917/the-widget-and-widgets-id
*/
// initialize the list of instanced IDs
global $list_of_instanced_ids;

// get the instanced id (in case of multiple instances)
$new_unique = sizeof( $list_of_instanced_ids );
array_push( $list_of_instanced_ids, $new_unique );

$unique = 'cssable-countdown-' . $new_unique;

// has the time already expired AND we have text to show?
if ( $widget_options['direction'] == 'down' && $comparator && !empty( $widget_options['expiryText'] ) )
{
	echo '<div id="' . $unique . '" class="cssable-countdown layout-type_' . $widget_options['layout_type'] . '">';
	echo "\t" . '<div class="times-up">' . $widget_options['expiryText'] . '</div>';
	echo '</div>';
}
else
{
	// build the countdown's args
	$aggregate_args = build_countdown_args( $unique, $widget_options );
	$build_args = $aggregate_args[0];
	$print_args = $aggregate_args[1];
	
	// print the countdown
	print_countdown( $unique, $build_args, $print_args );
}
?>  