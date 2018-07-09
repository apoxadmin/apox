<?php
include_once 'constants.inc.php';

function event_getSignedUp($user)
{
	$query = '(SELECT event_name AS name, '
		. ' UNIX_TIMESTAMP(event_date) AS date, '
		. ' event_ic AS ic, '
		. ' event_fund AS fund, '
		. ' event.event_id AS event, '
		. ' shift_start AS start, '
		. ' shift_end AS end, '
        . ' signup_chair AS chair, '
        . ' signup_driving AS driving, '
        . ' signup_camera AS camera, '
		. ' signup_ride AS ride, '
		. ' eventtype_name AS type '
        . ' FROM ((event NATURAL JOIN shift) '
        . ' NATURAL JOIN signup), eventtype '
        . " WHERE user_id = '$user' AND event.eventtype_id = eventtype.eventtype_id "
        . " AND event.event_date > " . db_currentClass('start') . ") "
        . ' UNION (SELECT event_name AS name, '
		. ' UNIX_TIMESTAMP(event_date) AS date, '
		. ' event_ic AS ic, '
		. ' event_fund AS fund, '
		. ' event.event_id AS event, '
		. ' event_date AS start, '
		. ' event_enddate AS end, '
        . ' "" AS chair, '
        . ' "" AS driving, '
        . ' "" AS camera, '
		. ' "" AS ride, '
		. ' eventtype_name AS type '
        . ' FROM (event NATURAL JOIN interest), eventtype '
        . " WHERE user_id = '$user' AND event.eventtype_id = eventtype.eventtype_id"
        . " AND event.event_date > " . db_currentClass('start') . ") "
        . ' ORDER BY date ASC , start ASC';

	return db_select($query, "event_getSignedUp");
}
		
/* returns an array of "events" where the indeces
* of the array are the dates in the month requested.
* Also has a few days from adjacent months. */
function event_getMonth($year, $month, $user = NULL)
{
	// parameter validation!

	// get the timestamp of the month
	$stamp = strtotime('1 ' . $month . ' ' . $year);
	
	if($stamp==-1) 
		return array();
	
	// find out how many days before the month to grab
	$startStamp = strtotime('-'.date('w',$stamp).' days',$stamp);
	
	// get the timestamp of the next month
	$stamp = strtotime('+1 month',$stamp);
	
	// find out how many days in the next month to grab
	$endStamp = strtotime('+'. (7 - date('w',$stamp)) .' days', $stamp);
	
	//	A query searching for events you're signed up on will be constructed thus:
	//
	//	SELECT event_id AS id, event_name AS name, UNIX_TIMESTAMP( event_date ) AS date, eventtype_id AS TYPE , event_id AS ic, MAX(user_id='1014') AS signedUp
	//	FROM event 
	//	NATURAL LEFT JOIN (signup NATURAL JOIN shift)
	//	WHERE event_date >= '2007-05-01' 
	//		AND event_date < '2007-06-01'
	//	GROUP BY event_id
	//	ORDER BY event_date
	
	$sql = 'SELECT event_id AS id, event_name AS name, '
	. ' UNIX_TIMESTAMP(event_date) AS date, eventtype_id AS type, event_ic as ic, event_fund as fund ';
	
	if ($user === NULL)	
		$sql .= ' FROM event ';

	else	//if a user_id was passed, see if that user signed up for any of these
	{
		$sql .= ", MAX(user_id='$user') AS signedUp "
		.' FROM event NATURAL LEFT JOIN ( signup NATURAL JOIN shift ) ';
	}
	
	$sql .= " WHERE event_date >= FROM_UNIXTIME('$startStamp') "
		. " AND event_date < FROM_UNIXTIME('$endStamp') "
		. " GROUP BY event_id ORDER BY event_date";
	
	if ($user !== NULL)
		$sql .= ', signedUp';
	
	return db_select($sql);
}

function event_add($name, $timestamp, $endtimestamp, $type, $ic, $fund, $location, $address, $map, $mileage, $description, $contact, $custom1, $custom2, $custom3, $custom4, $custom5, $hot)
{
	// parameter validation!
	$query = 'INSERT INTO event(event_id, event_name, event_date, '
		. ' event_enddate, eventtype_id, event_ic,event_fund, event_location , event_address , event_map , event_mileage, event_description, event_contact, event_custom1, event_custom2, event_custom3, event_custom4, event_custom5, event_hot) '
		. " VALUES ('', '$name',FROM_UNIXTIME('$timestamp'), "
		. " FROM_UNIXTIME('$endtimestamp'),'$type','$ic','$fund','$location', '$address' , '$map','$mileage','$description', '$contact', '$custom1', '$custom2', '$custom3', '$custom4', '$custom5', '$hot')";
	
	mysql_query($query) or die("Query failed =(");
	
	// i hate doing this, maybe it can go away later?
	$query = 'SELECT event_id AS id'
		. ' FROM event '
		. " WHERE event_name = '$name' and "
		. " event_date = FROM_UNIXTIME('$timestamp') and "
		. " event_enddate = FROM_UNIXTIME('$endtimestamp') and "
		. " eventtype_id = '$type' and "
		. " event_ic = '$ic' and "
		. " event_fund = '$fund' and "
		. " event_location = '$location' and "
		. " event_map = '$map' AND "
		. " event_mileage = '$mileage' AND "
		. " event_description = '$description' and "
		. " event_contact = '$contact' AND "
		. " event_custom1 = '$custom1' AND "
		. " event_custom2 = '$custom2' AND "
		. " event_custom3 = '$custom3' AND "
		. " event_custom4 = '$custom4' AND "
		. " event_custom5 = '$custom5' AND "
		. " event_hot = '$hot' ";
	
	$result = mysql_query($query) or die("Query failed (event_add)!!");
	$line = mysql_fetch_assoc($result) or die("Event not found!");
	
	mysql_free_result($result);
	
	return $line['id'];
} 

function event_update($name, $timestamp, $endtimestamp, $type, $ic, $fund, $location, $address, $map, $mileage, $description, $id, $contact, $custom1, $custom2, $custom3, $custom4, $custom5, $hot)
{
	// parameter validation!
	
	$query = "UPDATE event set event_name = '$name', "
		. " event_date = FROM_UNIXTIME('$timestamp'), "
		. " event_enddate = FROM_UNIXTIME('$endtimestamp'), "
		. " eventtype_id = '$type', "
		. " event_ic = '$ic', "
		. " event_fund = '$fund', "
		. " event_location = '$location', "
		. " event_address = '$address', "
		. " event_map = '$map', "
		. " event_mileage = '$mileage', "
		. " event_description = '$description', "
		. " event_contact = '$contact', "
		. " event_custom1 = '$custom1', "
		. " event_custom2 = '$custom2', "
		. " event_custom3 = '$custom3', "
		. " event_custom4 = '$custom4', "
		. " event_custom5 = '$custom5', "
		. " event_hot = '$hot' "
		. " WHERE event_id = $id "
		. " LIMIT 1 ";
	
	mysql_query($query) or die("Query failed =(");
} 

function event_delete($id)
{
	include_once 'signup.inc.php';
	
	$query = "DELETE from event WHERE event_id = $id LIMIT 1 ";
	mysql_query($query) or die("Query failed =(");
	
	// delete the shifts associated with the event
	$shifts = shift_getAll($id);
	$query = "DELETE from shift WHERE event_id = $id ";
	mysql_query($query) or die("Query 2 failed =(");
	
	// delete the signups associated with each shift (bad way to do this)
	$query = "DELETE from signup WHERE ";
	foreach($shifts as $s)
		$query .= " shift_id = '{$s['shift']}' or ";
		
	$query .= ' 0 ';
	
	mysql_query($query) or die("Query 3 failed =(");

	$query = "DELETE from tracking WHERE event_id = $id ";
	mysql_query($query) or die("Query 4 failed =(");
	
	$query = "DELETE from trackingbyuser WHERE event_id = $id ";
	mysql_query($query) or die("Query 5 failed =(");
	
	$query = "DELETE from trackingtime WHERE event_id = $id ";
	mysql_query($query) or die("Query 6 failed =(");

	// temp?
	fourc_delete($id);
	
} 

function event_get($id)
{
	// parameter validation!

	$query = 'SELECT e.event_id AS id, e.event_name AS name, e.event_location AS location, '
	. ' e.event_description AS description, '
	. ' UNIX_TIMESTAMP(e.event_date) AS date, UNIX_TIMESTAMP(e.event_enddate) AS enddate, '
	. ' t.eventtype_name AS type, t.eventtype_id AS typeid, e.event_ic as ic, e.event_fund as fund, e.event_contact as contact, '
	. ' e.event_address AS address, '
	. ' e.event_mileage AS mileage, '
	. ' e.event_custom1 AS custom1, e.event_custom2 AS custom2, e.event_custom3 AS custom3, e.event_custom4 AS custom4, e.event_custom5 AS custom5, '
	. ' e.event_hot AS hot, '
	. ' e.event_map AS map '
	. ' FROM event e,eventtype t WHERE e.eventtype_id = t.eventtype_id and ' . "event_id = $id";
	
	return db_select1($query);
}

// Returns true if event type should have multiple shifts and shifts should be modifiable by ExComm.
function event_multipleShifts($event) {
	//if ($event['type']=='Service' || $event['type']=='Interviews' || $event['type']=='Leadership' || $event['ic'] == true) {
    if ($event['type']=='Service' || 
        $event['type']=='Interviews' || 
        $event['type']=='Leadership' || 
        $event['type'] == 'Fellowship' || 
        $event['type'] == 'Fundraiser' || 
        $event['type'] == 'Special' || 
        $event['type'] == 'Family') {
		return true;
	} else {
		return false;
	}
}	

function event_multipleShiftsNumeric($typeID) {
	if ($typeID == EVENTTYPE_SERVICE || $typeID == EVENTTYPE_LEADERSHIP || $typeID == EVENTTYPE_INTERVIEWS) {
		return true;
	} else {
		return false;
	}
}

function eventtype_getAll()
{
	$query = 'SELECT `eventtype_id` AS id, `eventtype_name` AS name FROM eventtype';
	
	$result = mysql_query($query) or die("Query Failed!!!");
	
	$types = array();
	while($line = mysql_fetch_assoc($result))
		array_push($types,$line);
	
	mysql_free_result($result);
	
	return $types;
}

function fourc_get($event, $text = true)
{
	$query = 'SELECT fourc_c AS c '
	. " FROM fourc WHERE event_id = $event";
	
	$result = mysql_query($query) or die("Query failed!!");
	$line = mysql_fetch_assoc($result);
	if($line == false)
		return '?';
	
	mysql_free_result($result);
	
	if(!$text)
		return $line['c'];
	
	switch($line['c'])
	{
	case 0:
		return 'Chapter';
	case 1:
		return 'Campus';
	case 2:
		return 'Community';
	case 3:
		return 'Country';
	} 
	
	return '?';
}

function fourc_set($event, $c)
{
	if(fourc_get($event) == '?')
		$query = 'INSERT INTO fourc(event_id, fourc_c) '
			. " VALUES ('$event','$c')";
	else
		$query = "UPDATE fourc set fourc_c = '$c' "
			. " WHERE event_id = $event "
			. " LIMIT 1 ";
	
	mysql_query($query) or die("couldn't set 4 Cs =(");
}

function fourc_delete($event)
{
	// delete the fourc associated with the event
	$query = "DELETE from fourc WHERE event_id = $event LIMIT 1 ";
	mysql_query($query) or die("fourc_delete failed =(");
}

?>
