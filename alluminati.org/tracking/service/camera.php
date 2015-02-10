<?php

include_once 'template.inc.php';

show_header();

$date = NOW;
$sql = 'SELECT user_name AS name, '
		. ' UNIX_TIMESTAMP(event_date) AS time, COUNT(DISTINCT event.event_id) AS score '
		. ' FROM user, event, shift, signup '
		. ' WHERE event.event_id = shift.event_id AND shift.shift_id = signup.shift_id '
		. ' AND user.user_id = signup.user_id AND signup_camera > 0 '
        . " AND event_date > " . db_currentClass('start') . " AND event_date < FROM_UNIXTIME($date) "
		. ' GROUP BY user.user_id '
		. ' ORDER BY score DESC, user_name, event_date';

$photographers = db_select($sql);

?>
<table>
	<tr><td class="heading" colspan="2">Camera Tracking</td></tr>
	<tr><th>Name</th><th>Events</th></tr>
	<?php
	foreach($photographers as $photographer)
	{
		extract($photographer);
		//$event = date('n/j/y ', $time) . $event_name;
		
		echo "<tr><td>$name</td><td>$score</td></tr>\n";
	}
	?>
</table>
<?php

show_footer();
?>
