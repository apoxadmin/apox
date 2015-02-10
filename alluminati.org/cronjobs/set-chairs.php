<?php
// Checks for chairless events happening 3 days and randomly assigns someone signed up to be chair.

// Add include path, needed in cronjobs because it uses a different php.ini which doesn't have our include directory
$path = '/home/alluminati/alluminati.org/include';
set_include_path(get_include_path() . PATH_SEPARATOR . $path);

include_once 'database.inc.php';
db_open();

// Get all chairless shifts on the 3rd day from now
$query = ' SELECT event_name, signup.shift_id, shift.event_id, shift.shift_capacity '
         . ' FROM event, shift, signup '
         . ' WHERE event.event_id = shift.event_id AND '
         . ' shift.shift_id = signup.shift_id AND '
         . ' event_date > DATE_ADD(CURRENT_DATE(), INTERVAL 3 DAY) AND '
         . ' event_date < DATE_ADD(CURRENT_DATE(), INTERVAL 10 DAY) '
		 . ' GROUP BY signup.shift_id '
		 . ' HAVING SUM(signup_chair) < 1 ';

$result = db_select($query);

foreach ($result as $shift) {

	// For each chairless shift, get all signups
	$query = ' SELECT user_name, user_email, user.user_id, shift.shift_capacity '
	         . ' FROM event, shift, signup, user '
	         . ' WHERE event.event_id = shift.event_id AND '
	         . ' shift.shift_id = signup.shift_id AND '
			 . ' user.user_id = signup.user_id AND '
			 . ' shift.shift_id = '.$shift['shift_id']
			 . ' ORDER BY signup.signup_order ';
	
	// If shift has cap, only get people who aren't waitlisted
	if ($shift['shift_capacity'] > 0)
		$query = $query . ' LIMIT ' . $shift['shift_capacity'];
	
	$result = db_select($query);
	
	// Randomly select someone signed up to become chair
	$rand_key = array_rand($result);
	$newchair = $result[$rand_key];
	
	// Make them chair
	$query = " UPDATE signup SET signup_chair = 1 "
			 . " WHERE user_id = {$newchair['user_id']} AND "
			 . " shift_id = " . $shift['shift_id']
			 . " LIMIT 1";
			 
	mysql_query($query) or die();
	
	// Email them to let them know
	$name = $newchair['user_name'];
	$email = $newchair['user_email'];
	$event = $shift['event_name'];
	$subject = 'You\'re now chairing a service project!';
    $message = "Congratulations $name,<br /><br />"
             . "You've been randomly selected to chair an event that is happening in 3 days!<br />"
             . "Please make the appropriate arrangements.<br />"
             . "The event you're chairing is: <a href=\"http://www.alluminati.org/event/show.php?id=".$shift['event_id']."\">$event</a><br /><br />"
             . "Sincerely,<br />The Chi Robot<br />";
    $headers  = 'From: The Chi Robot <admin@apo-x.org>' . "\r\n";
    $headers .= 'Cc: service@apo-x.org' . "\r\n";
	// These headers needed to send HTML email:
	$headers .= 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
    mail($email, $subject, $message, $headers);
	
	echo "Made $name chair of $event.\n";
}
?>
