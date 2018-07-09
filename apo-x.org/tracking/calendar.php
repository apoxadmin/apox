<?php 
include_once dirname(dirname(__FILE__)) . '/include/template.inc.php'; 
get_header();
if(isset($_SESSION['id']))
	$id = $_SESSION['id'];
if(isset($_SESSION['class']))
	$class = $_SESSION['class'];
	
if(isset($_GET['month'],$_GET['year'])):
	$month = $_SESSION['month'] = $_GET['month'];
	$year = $_SESSION['year'] = $_GET['year'];
elseif(isset($_SESSION['month'],$_SESSION['year'])):
	$month = $_SESSION['month'];
	$year = $_SESSION['year'];
else:
	$month = date("F",strtotime('now'));
	$year = date("Y",strtotime('now'));
endif;

function event_getMyMonth($year, $month)
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
	$now = NOW;

	// debugging
	// echo "startStamp: " . $startStamp . "<br>";
	// echo "endStamp: " . $now . "<br>";

	$sql = 'SELECT UNIX_TIMESTAMP(event_date) AS date, event_name AS name, event.event_id AS id, '
			. ' SUBSTRING_INDEX(eventtype_name, \' \', 1) AS typename, event_ic as ic, '
			. ' count( DISTINCT tracking.event_id ) AS officer, '
			. ' count( DISTINCT trackingbyuser.event_id ) AS chairs '
			. ' FROM ( ( ( event NATURAL JOIN eventtype ) '
			. ' LEFT JOIN tracking ON event.event_id = tracking.event_id ) '
			. ' LEFT JOIN trackingbyuser ON event.event_id = trackingbyuser.event_id ) '
			. ' LEFT JOIN chair ON chair.event_id = event.event_id '
			. ' WHERE event.eventtype_id IN ( 1, 2, 6, 7, 8, 9 ) '
			. ' AND event_date > FROM_UNIXTIME('.$startStamp.') '
			. ' AND event_date < FROM_UNIXTIME('.$endStamp.') '
			. ' GROUP BY event.event_id'
			. ' ORDER BY event_date';
	
	return db_select($sql);
}

show_header();
	
// begin calendar output code

$eventTable = event_getMyMonth($year, $month, $id);

// debugging
// echo "$year:" . $year . "<br>";
// echo "$month" . $month . "<br>";
// echo "$id" . $id . "<br>";
// print_r ($eventTable);

// initialize date pointers
$stamp = strtotime('1 ' . $month . ' ' . $year);
$lowStamp = strtotime('-'.date('w',$stamp).' days',$stamp);
$highStamp = strtotime('+1 day',$lowStamp);

// debugging
// echo "lowStamp"; 
// echo $lowStamp;

// echo "highStamp";
// echo $highStamp;

$s1 = strtotime('-1 month',$stamp);
$m1 = date('F',$s1); // last months month
$y1 = date('Y',$s1); // last months year

$s2 = strtotime('+1 month',$stamp);
$m2 = date('F',$s2); // next months month
$y2 = date('Y',$s2); // next months year

$my = date("F, Y",$stamp); // current month and year

?>


<table id="calendar" cellspacing="1">
<tr>
<td class="heading">
	<a href="/tracking/calendar.php?month=<?php echo $m1 ?>&year=<?php echo $y1 ?>">
		&lt;&lt; <?php echo $m1 ?>
	</a>
</td>
<td colspan="5" class="heading">
	<?php echo $my ?>
</td>
<td class="heading">
	<a href="/tracking/calendar.php?month=<?php echo $m2 ?>&year=<?php echo $y2 ?>">
		<?php echo $m2 ?> &gt;&gt;
	</a>
</td>
</tr>
<tr>
	<td class="heading">S</td>
	<td class="heading">M</td>
	<td class="heading">T</td>
	<td class="heading">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;W&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td class="heading">R</td>
	<td class="heading">F</td>
	<td class="heading">S</td>
</tr>
<?php 



for($i=0,$k=0;$i<5;$i++)
{
	echo '<tr>';
	for($j=0;$j<7;$j++)
	{
		$class = "cal";
		if(date("F",$lowStamp)!=$month)
			$class .= "Out";

		echo "<td class=\"$class\" width=\"14%\">";
		echo '<span class="number">';
		echo date("j",$lowStamp);
		echo "</span>\n<br />";
		
		$kinit=$k; 
		// debugging
		// echo "k";
		// echo $k;

		while($eventTable[$k]['date']>=$lowStamp and $eventTable[$k]['date']<$highStamp)
		{
			// debugging
			// echo "$eventTable[$k]['date']";
			// echo $eventTable[$k]['date'];

			// look at the type of the event
			$type = strtolower($eventTable[$k]['typename']);
			
			// get the event id
			$event_id = $eventTable[$k]['id'];
			
			// see if a chair tracked it
			$chair = $eventTable[$k]['chairs'];
			
			// choose the color
			$class = '';
			if($eventTable[$k]['ic']==1)
				$class .= 'ic ';
				
			$class .= "et";
			if($eventTable[$k]['officer'])
				$class .= '8';
			elseif($chair)
				$class .= '3';
			else
				$class .= '1';

			echo "<p class=\"$class\">";
			echo "<a href=\"/tracking/$type/event.php?event=$event_id\">";
			echo $eventTable[$k++]['name'];
			echo '</a></p>';
		}
			
		$extralines = 3-($k-$kinit);
		while($extralines-- > 0) // prevent rows from collapsing when there aren't events
			echo '<br /><br />';
		
		$lowStamp = $highStamp; // lower bound to the next day
		$highStamp = strtotime('+1 day',$lowStamp); // upper bound to the next day
		echo '</td>';
	} // end for
	echo '</tr>';
} // end for
echo '</table>';

// end calendar output code
 
show_footer(); ?>


