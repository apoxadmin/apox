<?php 

include_once 'constants.inc.php';
include_once 'assassins.php';

function killsbyhour()
{
	$sql = "SELECT EXTRACT(HOUR FROM obit_time) AS time, count( * ) AS kills FROM assassins_obits GROUP BY EXTRACT(HOUR FROM obit_time)";

	$result = mysql_query($sql) or die("Query Failed (killsofhour)!". mysql_error());
	
	$killsTable = array();
	while($line = mysql_fetch_assoc($result))
		array_push($killsTable,$line);
	
	mysql_free_result($result);

	return $killsTable;
}

function killsbyday()
{
	$sql = "SELECT EXTRACT(DAY FROM obit_time) AS day, count( * ) AS kills FROM assassins_obits GROUP BY EXTRACT(DAY FROM obit_time)";

	$result = mysql_query($sql) or die("Query Failed (killsofday)!". mysql_error());
	
	$killsTable = array();
	while($line = mysql_fetch_assoc($result))
		array_push($killsTable,$line);
	
	mysql_free_result($result);

	return $killsTable;
}

function killsbydayofweek()
{
	$sql = "SELECT DATE_FORMAT(obit_time, '%W') AS day, count(*) AS kills FROM assassins_obits GROUP BY DATE_FORMAT(obit_time, '%w')";

	$result = mysql_query($sql) or die("Query Failed (killsofdayofweek)!". mysql_error());
	
	$killsTable = array();
	while($line = mysql_fetch_assoc($result))
		array_push($killsTable,$line);
	
	mysql_free_result($result);

	return $killsTable;
}

function killsbydayofrespawn()
{	
	$sql = "SELECT ((DATEDIFF(obit_time,'2006-04-21') % 4) + 1) AS day, count(*) AS kills FROM assassins_obits GROUP BY (DATEDIFF(obit_time,'2006-04-21') % 4)";

	$result = mysql_query($sql) or die("Query Failed (killsofdayofrespawn)!". mysql_error());
	
	$killsTable = array();
	while($line = mysql_fetch_assoc($result))
		array_push($killsTable,$line);
	
	mysql_free_result($result);

	return $killsTable;
}

function totalkills()
{
	$sql = "SELECT count( * ) AS kills FROM assassins_obits ";

	$result = mysql_query($sql) or die("Query Failed (totalkills)!". mysql_error());
	
	return mysql_fetch_assoc($result);
}

function stats_bblb()
{
	$term = db_currentClass('start');
	$class = db_currentClass('class_id');

	$sql = 'SELECT user_name AS pledge, '
			. ' user_name AS active, '
			. ' count(*) AS events '
			. ' FROM user AS pledge, user AS active, tracking AS ptracking, tracking AS atracking, event, bro '
			. ' WHERE pledge.user_id = bro.little AND active.user_id = bro.big ' // joining conditions
			. ' AND ptracking.event_id = atracking.event_id AND ptracking.event_id = event.event_id '
			. ' AND ptracking.user_id = pledge.user_id AND atracking.user_id = active.user_id ' 
			. " AND pledge.class_id = '$class' AND event_date > '$term' AND eventtype_id NOT IN (5,6,9) "
			. ' GROUP BY active.user_id, pledge.user_id ORDER BY events desc LIMIT 10';

	return db_select($sql);
}

function stats_events()
{
	$term = db_currentClass('start');

	$sql = 'SELECT user_name AS name, class_nick, '
			. ' count(user.user_id) AS events '
			. ' FROM (user NATURAL JOIN class) NATURAL JOIN tracking, event WHERE event.event_id = tracking.event_id AND '
			. " event_date > '$term' "
			. ' GROUP BY user.user_id ORDER BY events desc LIMIT 10';

	return db_select($sql);
}


function stats_service()
{
	$term = db_currentClass('start');
	$service = EVENTTYPE_SERVICE;

	$sql = 'SELECT user_name AS name, class_nick, '
			. ' sum(tracking.hours) AS hours '
			. ' FROM (user NATURAL JOIN class) NATURAL JOIN tracking, event WHERE event.event_id = tracking.event_id AND '
			. " event_date > '$term' AND eventtype_id = '$service' "
			. ' GROUP BY user.user_id ORDER BY hours desc LIMIT 10';

	return db_select($sql);
}


function stats_fellowships()
{
	$term = db_currentClass('start');
	$fellowship = EVENTTYPE_FELLOWSHIP;

	$sql = 'SELECT user_name AS name, class_nick, '
			. ' count(user.user_id) AS events '
			. ' FROM (user NATURAL JOIN class) NATURAL JOIN tracking, event WHERE event.event_id = tracking.event_id AND '
			. " event_date > '$term' AND eventtype_id = '$fellowship' "
			. ' GROUP BY user.user_id ORDER BY events desc LIMIT 10';

	return db_select($sql);
}

function stats_caw()
{
	$term = db_currentClass('start');
	$caw = EVENTTYPE_CAW;

	$sql = 'SELECT user_name AS name, class_nick, '
			. ' sum(tracking.hours) AS hours '
			. ' FROM (user NATURAL JOIN class) NATURAL JOIN tracking, event WHERE event.event_id = tracking.event_id AND '
			. " event_date > '$term' AND eventtype_id = '$caw' "
			. ' GROUP BY user.user_id ORDER BY hours desc LIMIT 10';

	return db_select($sql);
}

function stats_chaired()
{
	$term = db_currentClass('start');

	$sql = 'SELECT user_name AS name, class_nick, '
			. ' sum(tracking.chairs) AS events '
			. ' FROM (user NATURAL JOIN class) NATURAL JOIN tracking, event WHERE event.event_id = tracking.event_id AND '
			. " event_date > '$term' "
			. ' GROUP BY user.user_id ORDER BY events desc LIMIT 10';

	return db_select($sql);
}

function stats_ic()
{
	$term = db_currentClass('start');

	$sql = 'SELECT user_name AS name, class_nick, '
			. ' count(user.user_id) AS events '
			. ' FROM (user NATURAL JOIN class) NATURAL JOIN tracking, event WHERE event.event_id = tracking.event_id AND '
			. " event_date > '$term' AND event_ic > '0' "
			. ' GROUP BY user.user_id ORDER BY events desc LIMIT 10';

	return db_select($sql);
}

function stats_forum()
{
	$term = db_currentClass('start');

	$sql = 'SELECT user_name AS name, class_nick, '
			. ' count(user.user_id) AS posts '
			. ' FROM (user NATURAL JOIN class) NATURAL JOIN phorum_messages '
			. ' GROUP BY user.user_id ORDER BY posts desc LIMIT 10';

	return db_select($sql);
}

function stats_family_events()
{
	$term = db_currentClass('start');

	$sql = 'SELECT family_name AS name, '
			. ' count(*) AS events '
			. ' FROM user, tracking, family, event '
			. ' WHERE user.user_id = tracking.user_id AND user.family_id = family.family_id AND event.event_id = tracking.event_id '
			. " AND event_date > '$term' "
			. ' GROUP BY family.family_id ORDER BY family.family_id asc ';

	return db_select($sql);
}

function stats_family_service()
{
	$term = db_currentClass('start');
	$service = EVENTTYPE_SERVICE;

	$sql = 'SELECT family_name AS name, '
			. ' sum(tracking.hours) AS hours '
			. ' FROM user, tracking, family, event '
			. ' WHERE user.user_id = tracking.user_id AND user.family_id = family.family_id AND event.event_id = tracking.event_id '
			. " AND event_date > '$term' AND eventtype_id = $service "
			. ' GROUP BY family.family_id ORDER BY family.family_id asc ';

	return db_select($sql);
}

function stats_family_fellowship()
{
	$term = db_currentClass('start');
	$fellowship = EVENTTYPE_FELLOWSHIP;

	$sql = 'SELECT family_name AS name, '
			. ' count(*) AS events '
			. ' FROM user, tracking, family, event '
			. ' WHERE user.user_id = tracking.user_id AND user.family_id = family.family_id AND event.event_id = tracking.event_id '
			. " AND event_date > '$term' AND eventtype_id = $fellowship "
			. ' GROUP BY family.family_id ORDER BY family.family_id asc ';

	return db_select($sql);
}

function stats_family_chaired()
{
	$term = db_currentClass('start');

	$sql = 'SELECT family_name AS name, '
			. ' sum(tracking.chairs) AS events '
			. ' FROM user, tracking, family, event '
			. ' WHERE user.user_id = tracking.user_id AND user.family_id = family.family_id AND event.event_id = tracking.event_id '
			. " AND event_date > '$term' "
			. ' GROUP BY family.family_id ORDER BY family.family_id asc ';

	return db_select($sql);
}

function stats_family_caw()
{
	$term = db_currentClass('start');
	$caw = EVENTTYPE_CAW;

	$sql = 'SELECT family_name AS name, '
			. ' sum(tracking.hours) AS hours '
			. ' FROM user, tracking, family, event '
			. ' WHERE user.user_id = tracking.user_id AND user.family_id = family.family_id AND event.event_id = tracking.event_id '
			. " AND event_date > '$term' AND eventtype_id = $caw "
			. ' GROUP BY family.family_id ORDER BY family.family_id asc ';

	return db_select($sql);
}

function stats_family_ic()
{
	$term = db_currentClass('start');

	$sql = 'SELECT family_name AS name, '
			. ' count(*) AS events '
			. ' FROM user, tracking, family, event '
			. ' WHERE user.user_id = tracking.user_id AND user.family_id = family.family_id AND event.event_id = tracking.event_id '
			. " AND event_date > '$term' AND event_ic > 0 "
			. ' GROUP BY family.family_id ORDER BY family.family_id asc ';

	return db_select($sql);
}

function stats_family_forum()
{

	$sql = 'SELECT family_name AS name, '
			. ' count(*) AS posts '
			. ' FROM user, family, phorum_messages '
			. ' WHERE user.user_id = phorum_messages.user_id AND user.family_id = family.family_id '
			. ' GROUP BY family.family_id ORDER BY family.family_id asc ';

	return db_select($sql);
}


function stats_class_events()
{
	$term = db_currentClass('start');

	$sql = 'SELECT class_name AS name, '
			. ' count(*) AS events '
			. ' FROM ((user NATURAL JOIN tracking) NATURAL JOIN event) NATURAL JOIN class '
			. ' WHERE user.user_id = tracking.user_id AND user.class_id = class.class_id AND tracking.event_id = event.event_id '
			. " AND event_date > '$term' "
			. ' GROUP BY class.class_id ORDER BY events desc ';

	return db_select($sql);
}

?>
