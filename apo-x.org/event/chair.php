<?php
include_once dirname(dirname(__FILE__)) . '/include/template.inc.php';
include_once dirname(dirname(__FILE__)) . '/include/forms.inc.php';

show_header();

// permissions and prereqs
if($_SESSION['class'] != 'admin')
	show_note('You must be excomm to modify event chairs.');

if(!isset($_GET['event']))
	show_note('You must select an event to which to add chairs.');

$event = $_GET['event'];

// SQL
$sql = 'SELECT user.user_id, user_name AS name '
			. ' FROM user, chair WHERE user.user_id = chair.user_id '
			. " AND chair.event_id = '$event' ";
$chairs = db_select($sql);

$sql = "SELECT event_name FROM event WHERE event_id = '$event' ";
$event_name = db_select1($sql);
$event_name = "<a href=\"/event/show.php?id=$event\">{$event_name['event_name']}</a>";

// html
echo '<table cellspacing="1" style="width: 50%">';
echo "<tr><td colspan=\"2\" class=\"heading\">Chairs for $event_name"; 
echo '</td></tr><tr><th>Name</th><th>Options</th></tr>';

if($chairs == $false)
{
	echo '<tr><td class="note" colspan="2">(none)</td></tr>';
}
else
{
	foreach($chairs as $chair)
	{
		echo "<tr><td>{$chair['name']}</td><td>";
		echo '<form action="/event/input.php" method="POST">';
		forms_hiddenInput('removechair', "/event/chair.php?event=$event");
		forms_hidden('user', $chair['user_id']);
		forms_hidden('event', $event);
		forms_submit('Remove', 'Remove');
		echo '</form></td></tr>';
	}
}

echo '</table><br/>';

// code for adding a chair
	include_once dirname(dirname(__FILE__)) . '/include/user.inc.php';
	include_once dirname(dirname(__FILE__)) . '/include/show.inc.php';
	$userlist = user_getAll(); ?>
	<form action="/event/input.php" method="POST">
	<table cellspacing="0"><tr><td class="heading">
	Add Chair
	</td></tr>
	<tr><td class="nested">
	<?php
		show_users($userlist);
		forms_hidden('event', $event);
		forms_hiddenInput('addchair',"/event/chair.php?event=$event");
	?>
	</td></tr>
	<tr><td class="nested"><input type="submit" name="submit" value="Add Chair" /></td></tr>
	</table>
	</form>
	<?php


show_footer();

?>
