<?php 

include($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

include_once dirname(dirname(__FILE__)) . '/include/template.inc.php';
include_once dirname(dirname(__FILE__)) . '/include/forms.inc.php';
include_once dirname(dirname(__FILE__)) . '/include/show.inc.php';
include_once dirname(dirname(__FILE__)) . '/include/event.inc.php';
include_once dirname(dirname(__FILE__)) . '/include/user.inc.php';
include_once dirname(dirname(__FILE__)) . '/statistics/sql.php';

if(isset($_GET['event']))
	$event = $_GET['event'];
	 
if(isset($_SESSION['id']))
	$id = $_SESSION['id'];
	
if(isset($_SESSION['class']))
	$class = $_SESSION['class'];
$session_class = $class; //added since class is redefiend at the bottom

get_header();
$temp=user_get($id, 'f');
$temp=$temp['name'];

if(!isset($event))
{
	$list = getGoodEvents($id); 
	?>
	<?php if ( !( ($temp == 'admin') && $class=='admin') ){ ?>
	<table class="table table-condensed table-bordered">
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
        <?php endforeach; }?>
	</table>
	<?php if ( ( ($temp == 'admin') && $class=='admin') ){ ?>
	<div class="page-header">
	  <h1>Chapter Tracking<small> An overview of all tracking</small></h1>
	</div>
  	<p><h1><small> What type of events are you tracking?</small></h1></p>
	<div class="btn-group">
  		<a href="/tracking/leadership/event.php"><button class="btn">Leadership</button></a>
  		<a href="/tracking/fellowship/event.php"><button class="btn">Fellowship</button></a>
  		<a href="/tracking/service/event.php"><button class="btn">Service</button></a>
  		<a href="/tracking/meeting/event.php"><button class="btn">Meetings</button></a>
  		<a href="/tracking/caw/event.php"><button class="btn">CAW Hours</button></a>
  		<a href="/tracking/ic/event.php"><button class="btn">IC</button></a>
  		<a href="/tracking/comms.php"><button class="btn">Committee Tracking</button></a>
  	<!--<a href="/tracking/pictures.php"><button class="btn">Picture Tracking</button></a>-->
	</div>
<?php }
}
	$events = tracking_blame();

?>
	<table class="table table-condensed table-bordered">
	<tr><td class="heading" colspan="4">Events to be tracked</td></tr>
	<tr>
		<th style="width: 40px">Date</th>
		<th>Type</th>
		<th style="width: 200px">Event</th>
		<th>Waiting on: </th>
	</tr>
	
	<?php $events_to_be_tracked = 0;
		foreach($events as $event){
		$class  = 'small';
		$class  .= ' et' . $event['eventtype_id'];
		$date = date('m/d/y', $event['date']);
		
		$sql = 'SELECT DISTINCT user.user_id, user_name AS name '
				. ' FROM user, signup, shift, event WHERE shift.event_id = event.event_id AND signup.shift_id = shift.shift_id AND user.user_id = signup.user_id '
				. " AND event.event_id = '{$event['event_id']}' AND signup.signup_chair > '0' ";
			foreach(db_select($sql) as $user)
			{
				$first = 1;
			}
			if(isset($first)){

				//if($event['chairs'])
				//	$status = 'excomm';
				if($event['eventtype_id'] == 1||$event['eventtype_id'] == 2||$event['eventtype_id'] == 7) // service chairs are not in 'chair' table
				{
					$status = "chair (";// ({$event['names']})";
					
					$sql = 'SELECT DISTINCT user.user_id, user_name AS name '
							. ' FROM user, signup, shift, event WHERE shift.event_id = event.event_id AND signup.shift_id = shift.shift_id AND user.user_id = signup.user_id '
							. " AND event.event_id = '{$event['event_id']}' AND signup.signup_chair > '0' ";
					unset($first);
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
			}
			else{
				continue;
			}
			$tracking_type = strtolower($event['type']);
	?>
		<tr>
			<td><?= $date ?></td>
			<td><?= $event['type'] ?></td>
			<td>
				<?php 
					if($session_class == 'admin'){
						echo "<a href=\"/tracking/$tracking_type/event.php?event={$event['event_id']}&submit=Track\">{$event['event_name']}</a>";
					}
					else{
						echo "<a href=\"/event/show.php?id={$event['event_id']}\">{$event['event_name']}</a>";
					} 
				?>
			</td>		
			<td><?= $status ?></td>
		</tr>
	<?php 
		$events_to_be_tracked++;} 
		if($events_to_be_tracked == 0){
			echo "Congrats there are no events to track!";
		}
	?>
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
			. ' count(chair.user_id) signed_chairs'
			. ' FROM ( ( ( event NATURAL JOIN eventtype ) '
			. ' LEFT JOIN tracking ON event.event_id = tracking.event_id ) '
			. ' LEFT JOIN trackingbyuser ON event.event_id = trackingbyuser.event_id ) '
			. ' LEFT JOIN chair ON chair.event_id = event.event_id '
			. ' WHERE event.eventtype_id IN ( 1, 2, 6, 7 ,9 ) AND event_name NOT LIKE \'%CANCELLED%\' '
			. " AND event_date > '$term' AND event_date < FROM_UNIXTIME('$now') "
			. ' GROUP BY event.event_id'
			. ' HAVING officer <> 1 AND (signed_chairs > 0 OR eventtype_id IN (1,2,7)) '
			. ' ORDER BY event_date';
			
	return db_select($sql);
}
?>
