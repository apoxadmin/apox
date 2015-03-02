<?php 
include_once dirname(dirname(__FILE__)) . '/include/template.inc.php'; 
include_once dirname(dirname(__FILE__)) . '/include/user.inc.php';
include_once dirname(dirname(__FILE__)) . '/include/sql.php';

$myid = $_SESSION['id'];
$myclass = $_SESSION['class'];
$action = $_REQUEST['action'];

// TODO: users shouldn't be able to modify anyone's tracking...
if($myclass!='admin' and $myclass!='user')
{
	show_note('You must be logged in!');
}

function tracking_setUsers($users, $event, $h, $ph, $p, $c, $ppl0 = 0, $mi0 = 0)
{
	foreach($users as $user)
	{
		$hh = $h[$user] - $ph[$user];
		$pp = $p[$user];
		$cc = $c[$user];
		$ppl = ($ppl0 == 0)? 0:$ppl0[$user];
		$mi = ($mi0 == 0)? 0:$mi0[$user];
	
		$sql = 'INSERT INTO `tracking` ( `user_id` , `event_id` , `hours` , '
		. ' `projects` , `chairs`, `passengers`, `miles`) '
		. " VALUES ('$user', '$event', '$hh', '$pp', '$cc', '$ppl', '$mi')";
	
		if(!mysql_query($sql))
		{
			if(mysql_errno()==1062) // duplicate entry
			{
				$sql = "UPDATE tracking SET hours = '$hh', "
					. " projects = '$pp', "
					. " chairs = '$cc', "
			        . " passengers = '$ppl', "
				  	. " miles = '$mi' "
					. " WHERE user_id = '$user' "
                    . " AND event_id = '$event' LIMIT 1 ";
				
				mysql_query($sql) 
                    or die('omg! big problem.. tell your webmaster!');
			}
			else
			{
				die('omg! big problem... tell your webmaster!');
			}
		}
	}
}

function details_setUsers($users, $event, $details, $ppl0 = 0, $mi0 = 0)
{
    // the case of no users being set
	if(!is_array($users))
        return;
    
    foreach($users as $user)
	{
		$dd = $details[$user];
		$ppl = ($ppl0 == 0)? 0:$ppl0[$user];
		$mi = ($mi0 == 0)? 0:$mi0[$user];
	
		$sql = 'INSERT INTO `trackingbyuser` ( `user_id` , '
             . '`event_id` , `details`, `passengers`, `miles` ) '
		    . " VALUES ('$user', '$event', '$dd', '$ppl', '$mi')";
	
		if(!mysql_query($sql))
		{
			if(mysql_errno()==1062) // duplicate entry
			{
				$sql = "UPDATE trackingbyuser SET details = '$dd', "
					. " passengers = '$ppl', "
					. " miles = '$mi' "
					. " WHERE user_id = '$user' "
                    . " AND event_id = '$event' LIMIT 1 ";
				
				mysql_query($sql) 
                or die('omg! tell your webmaster! (Duplicate entry)');
			}
			else
			{
				die('omg! tell your webmaster! (inexplicable failure of details_setUsers)');
			}
		}
	}
}

function details_setTime($user, $event, $time)
{
		$sql = 'INSERT INTO `trackingtime` (`user_id`, `event_id`, `time`) '
		. " VALUES ('$user', '$event', FROM_UNIXTIME('$time'))";
	
		mysql_query($sql) or die('settime()'.mysql_error());
}

function tracking_deleteUsers($users, $event)
{
	$user_set = '0';
	
	// delete users not in the list and that were displayed
	foreach($users as $user)
		$user_set .= ', ' . $user;
	
	$sql = " DELETE FROM tracking "
         . " WHERE event_id = '$event' AND user_id NOT IN ($user_set) "
	 . " AND user_id IN (SELECT user_id FROM user WHERE user_hidden = 0)";
         
	mysql_query($sql) or die('Couldn\'t remove users from tracking!');
}

function details_deleteUsers($users, $event)
{
    // the case of no users being set
	if(!is_array($users))
        return;
	
    $user_set = '0';
	
	// delete users not in the list and that were displayed
	foreach($users as $user)
		$user_set .= ', ' . $user;
	
	$sql = " DELETE FROM trackingbyuser "
         . " WHERE event_id = '$event' AND user_id NOT IN ($user_set) "
	 . " AND user_id IN (SELECT user_id FROM user WHERE user_hidden = 0)";
	
    mysql_query($sql) or die('Couldn\'t remove users from trackingbyuser!');
}

function tracking_setEvents($events, $user, $h, $p, $c, $ppl0=0, $mi0=0)
{
	if(!count($events))
		return;

	foreach($events as $event)
	{
		$hh = $h[$event];
		$pp = $p[$event];
		$cc = $c[$event];
		$ppl = ($ppl0 == 0)? 0:$ppl0[$event];
		$mi = ($mi0 == 0)? 0:$mi0[$event];
		
	
		$sql = 'INSERT INTO `tracking` ( `user_id` , `event_id` , `hours` , '
		. ' `projects` , `chairs`, `passengers`, `miles`) '
		. " VALUES ('$user', '$event', '$hh', '$pp', '$cc', '$ppl', '$mi')";
	
		if(!mysql_query($sql))
		{
			if(mysql_errno()==1062) // duplicate entry
			{
				$sql = "UPDATE tracking SET hours = '$hh', "
					. " projects = '$pp', "
					. " chairs = '$cc', "
					. " passengers = '$ppl', "
					. " miles = '$mi' "
					. " WHERE user_id = '$user' AND event_id = '$event' "
                    . " LIMIT 1 ";
				
				mysql_query($sql) or die('omg! big problem.. tell your webmaster!');
			}
			else
			{
				die('omg! big problem... tell your webmaster!');
			}
		}
	}
}

function tracking_deleteEvents($events, $all, $user)
{
	if(!count($events))
		$events = array();
		
	if(strlen($all) <= 0)
		die('You should not be seeing this! Contact your webmaster!');

	$set = '0';
	
	// delete events not in the list
	foreach($events as $event)
		$set .= ', ' . $event;
	
	$sql = "DELETE FROM tracking WHERE user_id = '$user' AND event_id IN ($all) AND event_id NOT IN ($set)";
	mysql_query($sql) or die('Couldn\'t remove events from tracking!');
}

if($action=='settracking')
{
	$_SESSION['confirmation'] = 'Tracking updated.';
	if (isset($_POST['ppl']) && isset($_POST['mi']))
		tracking_setUsers($_POST['user'], $_POST['event'], $_POST['h'], $_POST['ph'], $_POST['p'], $_POST['c'], $_POST['ppl'], $_POST['mi'] );
	else
		tracking_setUsers($_POST['user'], $_POST['event'], $_POST['h'], $_POST['ph'], $_POST['p'], $_POST['c']);
	tracking_deleteUsers($_POST['user'], $_POST['event']);
}
elseif($action=='settrackinguser')
{
	$_SESSION['confirmation'] = 'Tracking updated.';
	tracking_setEvents($_POST['event'], $_POST['user'], $_POST['h'], $_POST['p'], $_POST['c'], $_POST['ppl'], $_POST['mi']);
	tracking_deleteEvents($_POST['event'], $_POST['all'], $_POST['user']);
}
elseif($action=='setdetails')
{
	$_SESSION['confirmation'] = 'Tracking submitted to excomm.';
	details_setUsers($_POST['user'], $_POST['event'],  $_POST['details'], $_POST['ppl'], $_POST['mi']);
	details_deleteUsers($_POST['user'], $_POST['event']);
	details_setTime($myid, $_POST['event'], NOW);
}
elseif($action=='setcommtracking')
{
	setCommTracking($_POST['user'], $_POST['credit'], $_POST['details'],  $_POST['dues']);
}
elseif($action=='setgeneraltracking')
{
	setGeneralTracking($_POST['user'], $_POST['key'], $_POST['value']);
}
/*elseif($action=='maileval')
{
	$subject = 'eval: ' . $_POST['title'];

	$user = user_get($myid, 'fl');

	$body = 'Evaluation form submitted by: ' . $user['name'] . "\n\n"
	. 'Chair Name(s): ' . $_POST['chairs'] . "\n\n"
	. 'Project Title: ' . $_POST['title']  . "\n\n"
	. 'Date: ' . $_POST['date']  . "\n\n"
	. 'Organization We Worked With: ' . $_POST['who']  . "\n\n"
	. 'Supervisor Name: ' . $_POST['who2']  . "\n\n"
	. 'Shifts: ' . $_POST['shifts']  . "\n\n"
	. 'Description of Projects: ' . $_POST['description']  . "\n\n"
	. 'Number of Volunteers: ' . $_POST['number']  . "\n\n"
	. 'Were there enough, not enough, or too many volunteers? ' . "\n" . $_POST['a']  . "\n\n"
	. 'Positive Points of the Project: ' . "\n" . $_POST['b']  . "\n\n"
	. 'Negative Points of the Project: ' . "\n" . $_POST['c']  . "\n\n"
	. 'How did the volunteers feel doing the project? Would they do it again? ' . "\n" . $_POST['d']  . "\n\n"
	. 'What would make this project more enjoyable? ' . "\n" . $_POST['e']  . "\n\n"
	. 'General Comments or Concerns: ' . "\n" . $_POST['f'];
	
	mail('servicevps@gmail.com', $subject, $body);
}*/

// override defaults given above
if(isset($_POST['confirmation']))
	$_SESSION['confirmation'] = $_POST['confirmation'];

?>
<HTML>
<HEAD>
<meta http-equiv="refresh" content="0;url=<?php echo $_POST['redirect'] ?>">
</HEAD>
</HTML>
