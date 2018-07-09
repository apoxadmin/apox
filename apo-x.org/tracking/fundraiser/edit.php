<?php 
include_once 'template.inc.php';
include_once 'forms.inc.php';
include_once 'show.inc.php';
include_once 'event.inc.php';
include($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');
include_once '../sql.php';

if(isset($_GET['event']))
	$event = $_GET['event'];
	
if(isset($_SESSION['id']))
	$id = $_SESSION['id'];
	
if(isset($_SESSION['class']))
	$class = $_SESSION['class'];

get_header();

function getGoodEvents($user)
{
	$date = NOW; // now
	
	$sql = 'SELECT DISTINCT event.event_id, event_name, '
        . ' UNIX_TIMESTAMP(event_date) AS date'
		. ' FROM event, chair '
        . ' WHERE event.eventtype_id = 9 AND event_ic = 0 '
        . " AND chair.user_id = '$user' "
        . " AND event_date > " . db_currentClass('start')
        . " AND event_date < FROM_UNIXTIME($date) "
        . ' AND event.event_id = chair.event_id '
        . ' ORDER BY event.event_date';

	$table = db_select($sql, "getGoodEvents()");
	
	return $table;
}

function show_usersTrack($users, $name)
{
	?>
	<table class="table table-condensed table-bordered">
	<tr><td class="heading" colspan="5"><?php echo $name ?></td></tr>
	<tr>
		<th>Name</th>
		<th width="60">sign in/out time, comments, etc. </th>
	</tr>
	
	<?php foreach($users as $user){ 
		$class = isset($user['details']) ? 'small' : 'small waitlist';
		$checked = isset($user['details']) ? 'checked' : '';
	?>
		<tr id="r<?php echo $user['user_id'] ?>">
			<td class="<?php echo $class ?>">
				<?php echo "<input name=\"user[]\" type=\"checkbox\" $checked value=\"{$user['user_id']}\" />";
                echo "<span title=\"{$user['class_nick']} Class\">{$user['name']}</span>"; ?>
			</td>
			<td class="<?php echo $class ?>">
				<?php forms_text(60,"details[{$user['user_id']}]", $user['details']); ?>
			</td>
		</tr>
	<?php } ?>
	</table>
	<?php 
}

if(!isset($event))
{
	$list = getGoodEvents($id); 
	?>
	<form name="selecttracking" method="GET" action="/tracking/fundraiser/edit.php">
	<select name="event" size="1">
			<?php foreach($list as $line): 
				$text = date("m/d/y", $line['date']) . ' ' . $line['event_name'];
				echo "<option ";
				echo "value=\"{$line['event_id']}\">$text</option>";
			endforeach; ?>
	</select>
	<?php forms_submit('Track') ?>
	</form>
	<?php
}
else
{
	show_filter();
	$name = event_get($event);
	$users = getTrackedEvent($event);
	?><form name="settrackingdetails" method="POST" action="/tracking/input.php">
	<?php forms_hiddenInput('setdetails',"/tracking/fundraiser/edit.php?event=$event");
	forms_hidden('event', $event);
	show_usersTrack($users, date('m/d/y', $name['date']) . ' ' . $name['name']);
	forms_submit('Submit Tracking');
	?></form>
	<?php
}

show_footer();
?>
