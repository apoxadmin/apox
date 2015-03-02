<html>
<?php

// <a href="http://localhost/tracking/service/tunnel.php?time=%t&sn=%n" target="_self">tracking?</a>

include_once 'database.inc.php';
include_once 'user.inc.php';
include_once 'event.inc.php';
include_once 'constants.inc.php';

if(!isset($_GET['sn']))
	die('What is your screen name?');
	
if(isset($_SERVER['HTTP_USER_AGENT']))
	die('You must use AIM to access your tracking.');

db_open();

function getTracked($user)
{
	$date = NOW; // now
	$sql = 'SELECT event.event_id, event_name, UNIX_TIMESTAMP(event_date) AS date, '
	. ' fourc_c, hours AS h, chairs AS c '
	. ' FROM event NATURAL JOIN tracking, fourc '
	. " WHERE event_date < FROM_UNIXTIME($date) AND eventtype_id = 1 AND user_id = '$user' "
	. " AND event_date > " . db_currentClass('start')
	. ' AND fourc.event_id = event.event_id '
	. ' ORDER BY event_date';

	$events = db_select($sql, 'getTracked()');
	
	return $events;
}

function getCTotal($user)
{
	$sql = 'SELECT fourc_c, count(fourc_c) as C FROM tracking, event, fourc '
		. ' WHERE tracking.event_id = event.event_id AND fourc.event_id = event.event_id '
		. " AND user_id = '$user' "
		. ' GROUP BY fourc_c ORDER BY fourc_c';

	$table = db_select($sql);

	return $table;
}

// from tacomage@devilishly-deviant.net
function str_padX($input, $len, $pad, $flag=STR_PAD_RIGHT)
{
  $trans=array('$'=>$input,' '=>$pad);
  $output=str_pad('$',$len-strlen($input)+1,' ',$flag);
  $output=strtr($output,$trans);
  return $output;
}

function show_eventsTrack($events, $name, $user)
{
	$total = array();
	echo '<font size="-2" face="courier new">';
	echo "<br>Tracking for $name:<br><br>";
	echo str_padX('Hours',6,'&nbsp;');
	echo str_padX('Date',9,'&nbsp;');
	echo "Title<br>";
	
	foreach($events as $event)
	{
		$hours += $event['h'];
		$date = date('m/d/y', $event['date']);
		$event_name = $event['event_name'];
		$fourc_name = fourc_get($event['event_id']);
		$chair = $event['c'];
		$id = $event['event_id'];
		
		switch($event['fourc_c'])
		{
			case 0: $color = '#5F4040'; break;
			case 1: $color = '#405F40'; break;
			case 2: $color = '#5F5F40'; break;
			case 3: $color = '#40405F'; break;
		}
		$text = "<a href=\"http://www.apo-x.org/event/show.php?id=$id\">$event_name</a>";
		$text .= " (<font color=\"$color\">$fourc_name</font><font size=\"-2\" face=\"courier new\">)";
		
		//$text = wordwrap($text, 30, str_padX("<br>",19,'&nbsp;'));
		if($chair) $text .= '*';

		echo str_padX($event['h'],6,'&nbsp;');
		echo str_padX($date,9,'&nbsp;');
		echo $text, "<br>";
	}

	//$fourc_totals = getCTotal($user);
	echo '<b>';
	echo str_padX($hours,6,'&nbsp;');
	echo str_padX('--/--/--',9,'&nbsp;');
	echo "Total<br></b>";
	echo "* = Chaired<br><br></font>";
	
	/*$c[0] = $c[1] = $c[2] = $c[3] = 0;
	foreach($fourc_totals as $fourc_total)
		$c[$fourc_total['fourc_c']] = $fourc_total['C'];*/
}

$sn = $_GET['sn'];
$sn = strtolower($sn);

$sql = "SELECT user_id as id FROM user WHERE user_aim = '$sn' ";
$id = db_select1($sql) or die('the screen name you\'re using isn\'t in the roster');

$name = user_get($id['id'], 'fl');
$events = getTracked($id['id']);

show_eventsTrack($events, "{$name['name']}", $id['id']);

db_close();

?>
</html>
