<?php

// Emails everyone 3 days before their service as a reminder.

// Add include path, needed in cronjobs because it uses a different php.ini which doesn't have our include directory
$path = '/home/alluminati/apo-x.org/include';
set_include_path(get_include_path() . PATH_SEPARATOR . $path);

include_once 'database.inc.php';
db_open();

$query = ' SELECT user_name, user_email, event_name, event.event_id '
         . ' FROM event, shift, signup, user '
         . ' WHERE event.event_id = shift.event_id AND '
         . ' shift.shift_id = signup.shift_id AND '
         . ' signup.user_id = user.user_id AND '
         . ' event_date > DATE_ADD(CURRENT_DATE(), INTERVAL 3 DAY) AND '
         . ' event_date < DATE_ADD(CURRENT_DATE(), INTERVAL 4 DAY)';

$users = db_select($query);

$prev_name = '';
$prev_email = '';

foreach($users as $user)
{
    extract($user);
    if($user_email == $prev_email && $event_name == $prev_name)
        continue;
    $prev_email = $user_email;
    $prev_name = $event_name;

    send_mail($user_email, $user_name, $event_name, $event_id);
}

function send_mail($email, $name, $event, $event_id)
{
    $subject = 'Service Reminder';
    $message = "Hi $name,<br /><br />"
             . "You have signed up for an event that is happening in 3 days. <br />"
             . "This is a reminder. The chair should contact you soon.<br />"
             . "The event you are attending is: <a href=\"http://www.apo-x.org/event/show.php?id=$event_id.\">$event</a><br /><br />"
             . "Sincerely,<br />The Chi Robot";
    $headers  = 'From: The Chi Robot <admin@apo-x.org>' . "\r\n";

	$headers .= 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";


    mail($email, $subject, $message, $headers);
}

?>
