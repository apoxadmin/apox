<?php
include_once dirname(dirname(__FILE__)) . '/include/template.inc.php';
include_once dirname(dirname(__FILE__)) . '/include/forms.inc.php';

show_header();

// permissions and prereqs
if($_SESSION['class'] != 'admin')
	show_note('You must be excomm to modify event interest.');

if(!isset($_GET['event']))
	show_note('You must select an event to which to add interested people.');

$event = $_GET['event'];

// SQL
$sql = 'SELECT user.user_id, user_name AS name '
			. ' FROM user NATURAL JOIN interest '
			. " WHERE interest.event_id = '$event' ";
$interest = db_select($sql);

$sql = "SELECT event_name FROM event WHERE event_id = '$event' ";
$event_name = db_select1($sql);
$event_name = "<a href=\"/event/show.php?id=$event\">{$event_name['event_name']}</a>";

// html
echo '<table cellspacing="1" style="width: 50%">';
echo "<tr><td colspan=\"2\" class=\"heading\">People interested in $event_name";
echo '</td></tr><tr><th>Name</th><th>Options</th></tr>';

if($interest == $false)
{
	echo '<tr><td class="note" colspan="2">(none)</td></tr>';
}
else
{
	foreach($interest as $person)
	{
		echo "<tr><td>{$person['name']}</td><td>";
		echo '<form action="/event/input.php" method="POST">';
		forms_hiddenInput('removeinterest', "/event/interest.php?event=$event");
		forms_hidden('user', $person['user_id']);
		forms_hidden('event', $event);
		forms_submit('Remove', 'Remove');
		echo '</form></td></tr>';
	}
}

echo '</table><br/>';

// code for adding interest
	include_once dirname(dirname(__FILE__)) . '/include/user.inc.php';
	include_once dirname(dirname(__FILE__)) . '/include/show.inc.php';
	$userlist = user_getAll(); ?>
	<form action="/event/input.php" method="POST">
	<table cellspacing="0"><tr><td class="heading">
	Add Interest
	</td></tr>
	<tr><td class="nested">
	<?php
		show_users($userlist);
		forms_hidden('event', $event);
		forms_hiddenInput('addinterest',"/event/interest.php?event=$event");
	?>
	</td></tr>
	<tr><td class="nested"><input type="submit" name="submit" value="Add Interest" /></td></tr>
	</table>
	</form>

		<form action="/input.php" method="POST">
		<table cellspacing="1">
		<?php forms_hiddenInput("signup","/event/show.php?id=$event_id"); ?>
			<tr>
				<td class="heading" colspan="5">Sign up</td>
			</tr>
			<?php if($warn): ?>
                <tr><td class="note" colspan="5">(it is less than <?=$signup_days?> days to the event, so you will need a replacement if you cancel)</td></tr>
			<?php endif; ?>
			<tr>
				<th>Shifts</th>
			    <th>Chair</th>
			    <th>Driving</th>
			    <th>Camera</th>
				<th>Ride</th>
			</tr>
			<tr>
				<td>
				<?php foreach($shiftlist as $shift): ?>
					<input name="shift[]" type="checkbox" 
                        value="<?php echo $shift['shift']?>" />
					<?php 
                    echo date('g:i a',strtotime($shift['start'])),
                        ' - ',
                        date('g:i a',strtotime($shift['end']));
                    if($shift['name'] != '')
                        echo " ({$shift['name']})";
                    ?>
					<br />
				<?php endforeach; ?>
				</td>
				<td><input name="chair" type="checkbox" value="1" /></td>
				<td><input name="driving" type="checkbox" value="1" /></td>
				<td><input name="camera" type="checkbox" value="1" /></td>
				<td><input name="ride" type="checkbox" value="1" /></td>
				<td><input type="submit" name="signmeup" value="Sign up" /></td>
			</tr>
		</table>
		</form>
show_footer();

?>
