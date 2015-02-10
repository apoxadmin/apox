<?php 
include_once 'template.inc.php';
include_once 'forms.inc.php';
include_once 'show.inc.php';
include_once 'event.inc.php';
include_once 'user.inc.php';
include_once 'sql.php';
include($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

if(isset($_GET['event']))
	$event = $_GET['event'];
	
if(isset($_SESSION['id']))
	$id = $_SESSION['id'];
	
if(isset($_SESSION['class']))
	$class = $_SESSION['class'];

get_header();

if(!isset($event))
{
	$list = getGoodEvents($id); 
	?>
	<table>
        <tr><td class="heading" colspan="3">My Chaired Events</td></tr>
        <tr><th>Date</th><th>Event</th><th>Submitted</th></tr>
		<?php foreach($list as $line): 
			$date = date("m/d/y", $line['date']);
            $name = $line['event_name'];
            $event_id = $line['event_id'];
            $time = $line['submitted'] ? $line['submitted'] : 'Not Submitted';
			?>
            <tr>
                <td><?= $date ?></td>
                <td>
			    <a href="/tracking/useredit.php?event=<?= $event_id ?>">
                    <?= $name ?>
                </a>
                </td>
                <td style="text-align: center"><?= $time ?></td>
            </tr>
        <?php endforeach; ?>
	</table>
<?php
}
	$events = tracking_blame();
?>
	<table cellspacing="1" style="width: 75%">
	<tr><td class="heading" colspan="4">Tracking of Tracking</td></tr>
	<tr>
		<th style="width: 40px">Date</th>
		<th>Type</th>
		<th style="width: 200px">Event</th>
		<th>Waiting on: </th>
	</tr>
	
	<?php foreach($events as $event){
		$class  = 'small';
		$class  .= ' et' . $event['eventtype_id'];
		$date = date('m/d/y', $event['date']);
		
		if($event['chairs'])
			$status = 'excomm';
		elseif($event['eventtype_id'] == 1) // service chairs are not in 'chair' table
		{
			$status = "chair (";// ({$event['names']})";
			
			$sql = 'SELECT DISTINCT user.user_id, user_name AS name '
					. ' FROM user, signup, shift, event WHERE shift.event_id = event.event_id AND signup.shift_id = shift.shift_id AND user.user_id = signup.user_id '
					. " AND event.event_id = '{$event['event_id']}' AND signup.signup_chair > '0' ";
			foreach(db_select($sql) as $user)
			{
				if(isset($first))
					$status .= ", ";
				$status .= "<a href=\"/people/profile.php?user={$user['user_id']}\">{$user['name']}</a>";
				$first = 1;
			}
			if(!isset($first))
				$status = "(no chair";
			unset($first);
				
			$status .= ")";
		}
		else
		{
			$status = "chair (";// ({$event['names']})";
			
			$sql = 'SELECT user.user_id, user_name AS name '
					. "FROM chair NATURAL JOIN user WHERE event_id = '{$event['event_id']}' ";
			foreach(db_select($sql) as $user)
			{
				if(isset($first))
					$status .= ", ";
				$status .= "<a href=\"/people/profile.php?user={$user['user_id']}\">{$user['name']}</a>";
				$first = 1;
			}
			unset($first);
				
			$status .= ")";
			
		}
	?>
		<tr>
			<td><?= $date ?></td>
			<td><?= $event['type'] ?></td>
			<td>
				<?= "<a href=\"/event/show.php?id={$event['event_id']}\">{$event['event_name']}</a>" ?>
			</td>		
			<td><?= $status ?></td>
		</tr>
	<?php } ?>
	</table>
	<?
	echo '<br/>';
	
show_footer();

function getGoodEvents($user)
{
    // now, w/ some slack so techy people can track at events
	$date = strtotime("+2 hours", NOW);
	
	$sql = '(SELECT DISTINCT event.event_id, event_name, '
        . ' UNIX_TIMESTAMP(event_date) AS date, t.time AS submitted '
		. ' FROM ((event NATURAL JOIN shift) NATURAL JOIN signup) '
            . " LEFT JOIN (SELECT event_id, user_id, MAX(time) AS time "
            . " FROM trackingtime WHERE user_id = '$user' GROUP BY event_id) t"
                . ' ON t.event_id = event.event_id '
        . " WHERE event.eventtype_id = '1' AND signup.signup_chair = '1' "
            . " AND signup.user_id = '$user' "
            . " AND event_date > " . db_currentClass('start')
            . " AND event_date < FROM_UNIXTIME($date)) "
        . ' UNION (SELECT DISTINCT event.event_id, event_name,' 
        . ' UNIX_TIMESTAMP(event_date) AS date, t.time as submitted '
		. ' FROM (event NATURAL JOIN chair) '
            . " LEFT JOIN (SELECT event_id, user_id, MAX(time) AS time "
            . " FROM trackingtime WHERE user_id = '$user' GROUP BY event_id) t"
                . ' ON t.event_id = event.event_id '
        . " WHERE chair.user_id = '$user' "
            . " AND event_date > " . db_currentClass('start')
            . " AND event_date < FROM_UNIXTIME($date) ) "
        . ' ORDER BY date';

	$table = db_select($sql, "getGoodEvents()");
	
	return $table;
}

function tracking_blame()
{
	$now = NOW;
	$term = db_currentClass('start');

	$sql = 'SELECT UNIX_TIMESTAMP(event_date) AS date, event_name, event.event_id, '
			. ' eventtype_name AS type, eventtype.eventtype_id, '
			. ' count( DISTINCT tracking.event_id ) AS officer, '
			. ' count( DISTINCT trackingbyuser.event_id ) AS chairs, '
			. ' count( DISTINCT chair.user_id) signed_chairs '
			. ' FROM ( ( ( event NATURAL JOIN eventtype ) '
			. ' LEFT JOIN tracking ON event.event_id = tracking.event_id ) '
			. ' LEFT JOIN trackingbyuser ON event.event_id = trackingbyuser.event_id ) '
			. ' LEFT JOIN chair ON chair.event_id = event.event_id '
			. ' WHERE event.eventtype_id IN ( 1, 2, 6, 7 ,9 ) AND event_name NOT LIKE \'%CANCELLED%\' '
			. " AND event_date > '$term' AND event_date < FROM_UNIXTIME('$now') "
			. ' GROUP BY event.event_id'
			. ' HAVING officer <> 1 AND (signed_chairs <> 0 OR eventtype_id = 1) '
			. ' ORDER BY event_date';
			
	return db_select($sql);
}
?>
