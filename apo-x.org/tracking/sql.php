<?php

include_once dirname(dirname(__FILE__)) . '/include/database.inc.php';

function getEvents($type, $ic)
{
	$date = NOW; // now
	
	if($type == '*' && $ic)
	{
		$sql = " SELECT event_id, event_name, UNIX_TIMESTAMP(event_date) AS date FROM event "
			. " WHERE event_date < FROM_UNIXTIME($date) AND event_date > " . db_currentClass('start') . " AND eventtype_id NOT IN (1,7) "
			. ' AND event_ic > 0 ORDER BY event_date';
	}
	else
	{
		$sql = " SELECT event_id, event_name, UNIX_TIMESTAMP(event_date) AS date FROM event "
			. " WHERE event_date < FROM_UNIXTIME($date) AND event_date > " . db_currentClass('start') . " AND eventtype_id = $type";
		if($ic == false)
			$sql .= ' AND event_ic = 0 ';
		$sql .= " ORDER BY event_date";
	}

	$table = db_select($sql, "getEvents()");
	
	return $table;
}

function getTrackedUser($user, $type, $class_id)
{
	if ($class_id == db_currentClass('class_id')) {
		//$start_date = db_currentClass('start');
		$sql = "SELECT class_start FROM class WHERE class_id = '$class_id'";
		$result = db_select1($sql);
		$start_date = $result['class_start'];
		$end_date = "NOW";
	} else {
		$sql = "SELECT class_start FROM class WHERE class_id = '$class_id'";
		$result = db_select1($sql);
		$start_date = $result['class_start'];
		$sql = "SELECT class_start FROM class WHERE class_start > '$start_date' ORDER BY class_start ASC LIMIT 1";
		$result = db_select1($sql);
		$end_date = $result['class_start'];
	}

	if($type == 'ic')
	{
		$sql = 'SELECT DISTINCT event.event_id AS event_id, '
            . ' event_name, UNIX_TIMESTAMP(event_date) AS date '
			. ' FROM event NATURAL JOIN tracking'
			. " WHERE event_date < '$end_date' AND event_ic > 0 "
            . " AND user_id = '$user' "
			. " AND event.event_date > '$start_date'"
			. ' ORDER BY event_date';
	}
	else if($type == 'fundraiser')
	{
		$sql = 'SELECT DISTINCT event.event_id AS event_id, '
            . ' event_name, UNIX_TIMESTAMP(event_date) AS date '
			. ' FROM event NATURAL JOIN tracking'
			. " WHERE event_date < '$end_date' AND event_fund > 0 "
            . " AND user_id = '$user' "
			. " AND event.event_date > '$start_date'"
			. ' ORDER BY event_date';
	}
	else
	{
		if($type == 6 || $type == 9) // Meeting or CAW
			$ic = ' AND event_ic = 0 ';
		$sql = 'SELECT DISTINCT event.event_id AS event_id, event_name, '
            . ' UNIX_TIMESTAMP(event_date) AS date '
			. ' FROM event NATURAL JOIN tracking'
			. " WHERE event_date < '$end_date' "
            . " AND eventtype_id = '$type' AND user_id = '$user' "
			. " AND event.event_date > '$start_date' '$ic' "
			. ' ORDER BY event_date';
	}

	$events = db_select($sql, "getTracked()");

	$set = '0, ';
	foreach($events as $event)
		$set .= $event['event_id'] . ', ';
	$set = substr($set, 0, -2);

	$sql = 'SELECT event_id, hours, projects, chairs, passengers, miles'
		. ' FROM tracking'
		. " WHERE user_id = '$user' AND event_id IN ($set)";
			
	$result = mysql_query($sql) or die(mysql_error());
	$lines = array();
	while($line = mysql_fetch_assoc($result))
		$lines[$line['event_id']] = $line;
	mysql_free_result($result);
		
	foreach($events as $key => $event)
	{
		$events[$key]['h'] = $lines[$event['event_id']]['hours'];
		$events[$key]['p'] = $lines[$event['event_id']]['projects'];
		$events[$key]['c'] = $lines[$event['event_id']]['chairs'];
		$events[$key]['ppl'] = $lines[$event['event_id']]['passengers'];
		$events[$key]['mi'] = $lines[$event['event_id']]['miles'];
		
	}
	
	return $events;
}

function getTrackedEventAll($event)
{

	// Get info for all non-hidden users
	$sql = "SELECT user_id, user_name AS name, class_nick, status_id "
		. " FROM user NATURAL JOIN class WHERE status_id NOT IN (".STATUS_ADMINISTRATOR.','.STATUS_DEPLEDGE.','.STATUS_INACTIVE.','.STATUS_ALUMNI.','.STATUS_ADMINISTRATOR.','.STATUS_DEACTIVATED.") AND user_hidden = '0' "
		. ' ORDER BY user_name asc';
		
	$result = mysql_query($sql) or die(mysql_error());
	$users = array();
	while($user = mysql_fetch_assoc($result))
		$users[$user['user_id']] = $user; // Populate an array with user id's
	mysql_free_result($result);
		
	$set = '0, ';
	foreach($users as $user)
		$set .= $user['user_id'] . ', '; // Construct a comma-separated string of all non-hidden user id's
	$set = substr($set, 0, -2);

	// Get the tracking info for all non-hidden users for input event
	$sql = 'SELECT user_id, hours, projects, chairs, passengers, miles'
		. ' FROM tracking'
		. " WHERE event_id = '$event' AND user_id IN ($set)";
		
	$result = mysql_query($sql) or die(mysql_error());
	$lines = array();
	while($line = mysql_fetch_assoc($result)) // Add tracking info to users array
	{
		$users[$line['user_id']]['h'] = $line['hours'];
		$users[$line['user_id']]['p'] = $line['projects'];
		$users[$line['user_id']]['c'] = $line['chairs'];
		$users[$line['user_id']]['ppl'] = $line['passengers'];
		$users[$line['user_id']]['mi'] = $line['miles'];
	}
	mysql_free_result($result);
	
	// Get tracking info from trackingbyuser table for all non-hidden users for input event
	$sql = "SELECT user_id, details, passengers, miles"
		. " FROM trackingbyuser"
		. " WHERE event_id = '$event' AND user_id IN ($set)";
		
	$result = mysql_query($sql) or die(mysql_error());
	while($line = mysql_fetch_assoc($result)) // Add trackingbyuser info to users array
	{
		$users[$line['user_id']]['details'] = $line['details'];
		if(!isset($users[$line['user_id']]['h']))
		{
			$users[$line['user_id']]['ppl'] = $line['passengers'];
			$users[$line['user_id']]['mi'] = $line['miles'];
		}
	}
		
	mysql_free_result($result);

	// Get all chairs for the input event
	$sql = "SELECT user_id"
		. " FROM chair"
		. " WHERE event_id = '$event' AND user_id IN ($set)";
		
	$result = mysql_query($sql) or die(mysql_error());
	while($line = mysql_fetch_assoc($result)) // Add chair info to users array
		$users[$line['user_id']]['chair'] = 'yes';
	mysql_free_result($result);

	return $users; // $users is now an array of arrays, containing an array for each non-hidden user, with each sub-array containing tracking, trackingbyuser, and chair info for that user and the input event
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//This is the rewritten function to grab only specific users///////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function getTrackedEvent($event)
{

	// Get info for all non-hidden users
	//$sql = "SELECT user_id, user_name AS name, class_nick, status_id "
	//	. " FROM user NATURAL JOIN class WHERE status_id NOT IN (".STATUS_ADMINISTRATOR.','.STATUS_DEPLEDGE.','.STATUS_DEACTIVATED.") AND user_hidden = '0' "
	//	. ' ORDER BY user_name asc';
	

	//written 02/16/2014, returns a list of only relevant users
	$sql = 'SELECT t1.user_id, t1.user_name AS name, t1.class_nick, t1.status_id '
		   ."FROM (select * from user NATURAL JOIN class ) as t1, (select * from signup NATURAL JOIN shift where event_id = $event) as t2 "
           ."WHERE t1.user_id = t2.user_id AND status_id NOT IN ( ".STATUS_ADMINISTRATOR.','.STATUS_DEPLEDGE.','.STATUS_DEACTIVATED." ) AND user_hidden = 0 "
           .'ORDER BY user_name asc';
		
	$result = mysql_query($sql) or die(mysql_error());
	$length = 0;
	$users = array();

	while($user = mysql_fetch_assoc($result)){
		$users[$user['user_id']] = $user; // Populate an array with user id's
	}
	mysql_free_result($result);
		
	$set = '0, ';
	foreach($users as $user){
		$set .= $user['user_id'] . ', '; // Construct a comma-separated string of all non-hidden user id's
	}
	$set = substr($set, 0, -2);
	// Get the tracking info for all non-hidden users for input event
	$sql = 'SELECT user_id, hours, projects, chairs, passengers, miles'
		. ' FROM tracking'
		. " WHERE event_id = '$event' AND user_id IN ($set)";
		
	$result = mysql_query($sql) or die(mysql_error());
	$lines = array();
	while($line = mysql_fetch_assoc($result)) // Add tracking info to users array
	{
		$users[$line['user_id']]['h'] = $line['hours'];
		$users[$line['user_id']]['p'] = $line['projects'];
		$users[$line['user_id']]['c'] = $line['chairs'];
		$users[$line['user_id']]['ppl'] = $line['passengers'];
		$users[$line['user_id']]['mi'] = $line['miles'];
	}
	mysql_free_result($result);
	
	// Get tracking info from trackingbyuser table for all non-hidden users for input event
	$sql = "SELECT user_id, details, passengers, miles"
		. " FROM trackingbyuser"
		. " WHERE event_id = '$event' AND user_id IN ($set)";
		
	$result = mysql_query($sql) or die(mysql_error());
	$a = 0;
	while($line = mysql_fetch_assoc($result)) // Add trackingbyuser info to users array
	{
		$users[$line['user_id']]['details'] = $line['details'];
		if(!isset($users[$line['user_id']]['h']))
		{
			$users[$line['user_id']]['ppl'] = $line['passengers'];
			$users[$line['user_id']]['mi'] = $line['miles'];
		}
	}
		
	mysql_free_result($result);

	// Get all chairs for the input event
	$sql = "SELECT user_id"
		. " FROM chair"
		. " WHERE event_id = '$event' AND user_id IN ($set)";
		
	$result = mysql_query($sql) or die(mysql_error());
	$a = 0;
	while($line = mysql_fetch_assoc($result)){ // Add chair info to users array
		$users[$line['user_id']]['chair'] = 'yes';
		$a++;
	}
	mysql_free_result($result);

	return $users; // $users is now an array of arrays, containing an array for each non-hidden user, with each sub-array containing tracking, trackingbyuser, and chair info for that user and the input event
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function getTrackingTime($event)
{
	$sql = 'SELECT user_name '
		. ' as name, UNIX_TIMESTAMP(time) AS date '
		. " FROM user NATURAL JOIN trackingtime WHERE event_id = '$event' "
		. ' ORDER BY time desc';
		
	return db_select($sql, 'getTrackingTime()');
}

function getCTotal($user, $class_id)
{
	if ($class_id == db_currentClass('class_id')) {
		$start_date = db_currentClass('start');
		$end_date = "NOW";
	} else {
		$sql = "SELECT class_start FROM class WHERE class_id = '$class_id'";
		$result = db_select1($sql);
		$start_date = $result['class_start'];
		$sql = "SELECT class_start FROM class WHERE class_start > '$start_date' ORDER BY class_start ASC LIMIT 1";
		$result = db_select1($sql);
		$end_date = $result['class_start'];
	}

	$service = EVENTTYPE_SERVICE;

	$sql = 'SELECT fourc_c, count(fourc_c) as C FROM tracking, event, fourc '
		. ' WHERE tracking.event_id = event.event_id '
        . ' AND fourc.event_id = event.event_id '
		. " AND user_id = '$user' AND event.eventtype_id = '$service' "
		. " AND tracking.hours >= 0 " //if you get negative hours, you don't get the C
		. " AND event.event_date > '$start_date' "
		. " AND event.event_date < '$end_date' "
		. ' GROUP BY fourc_c ORDER BY fourc_c';

	$table = db_select($sql);

	return $table;
}

function getCommTracking()
{
	$sql = 'SELECT user_name AS name, user.user_id, '
            . ' class_nick, credit, details, dues '
			. ' FROM class, user LEFT JOIN trackingcomm '
                . ' ON user.user_id = trackingcomm.user_id '
			. " WHERE user_hidden = '0' "
            . ' AND user.class_id = class.class_id '
			. ' ORDER BY user_name ';
			
	return db_select($sql);
}

function setCommTracking($users, $credit, $details, $dues)
{
	$sql = 'REPLACE INTO trackingcomm (user_id, credit, details,dues) VALUES ';

	$values = array();
	
	foreach($users as $user)
	{
		$values[] = "('$user', '{$credit[$user]}', '{$details[$user]}','{$dues[$user]}')";
	}

	$sql .= implode($values, ',');

	return mysql_query($sql) or 
		die('Could not insert values into trackingcomm: ' . mysql_error());
}

function getGeneralTracking($key)
{
	$sql = 'SELECT user_name AS name, user.user_id, value, class_nick '
			. ' FROM class, user LEFT JOIN trackinggeneral '
                . ' ON user.user_id = trackinggeneral.user_id '
			. " WHERE user_hidden = '0' "
			. " AND (`key` IS NULL OR `key` = '$key') "
            . " AND user.class_id = class.class_id "
			. ' ORDER BY user_name ';
	
    return db_select($sql);
}

function setGeneralTracking($users, $key, $value)
{
	$sql = 'REPLACE INTO trackinggeneral (user_id, `key`, value) VALUES ';

	$values = array();
	
	foreach($users as $user)
		$values[] = "('$user', '$key', '{$value[$user]}')";

	$sql .= implode($values, ',');

	return mysql_query($sql) or 
		die('Could not insert values into trackinggeneral: ' . mysql_error());
}

?>
