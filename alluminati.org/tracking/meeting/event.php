<?php 
include_once dirname(dirname(dirname(__FILE__))) . '/include/template.inc.php';
include_once dirname(dirname(dirname(__FILE__))) . '/include/forms.inc.php';
include_once dirname(dirname(dirname(__FILE__))) . '/include/show.inc.php';
include_once dirname(dirname(dirname(__FILE__))) . '/include/event.inc.php';
include_once dirname(dirname(dirname(__FILE__))) . '/include/user.inc.php';
include($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

include_once '../sql.php';

if(isset($_GET['event']))
	$event = $_GET['event'];

if(isset($_SESSION['id']))
	$id = $_SESSION['id'];

if(isset($_SESSION['class']))
	$class = $_SESSION['class'];

$temp=user_get($id, 'f');
$temp=$temp['name'];

if ( !( ($temp == 'recsecs' || $temp == 'admin') && $class=='admin') )
	show_note('You must be logged in as recsecs to access this page.');

if(!isset($event))
{
	// get meetings
	$list = getEvents(6, false);

get_header();
	?>
	<form name="selecttracking" method="GET" action="/tracking/meeting/event.php">
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

	$name = event_get($event);
	$users = getTrackedEventAll($event);

    $script = "var pledges = Array();\n";
    foreach($users as $user)
    {
    	if($user['status_id'] == STATUS_PLEDGE)
        	$script .= "pledges.push({$user['user_id']});\n";
    }
    $script .= '
    function checkPledges()
    {
    	for(var i=0; i<pledges.length; i++)
        	document.getElementsByName("user[" + pledges[i] + "]")[0].checked = true;
    }';

    show_header("<script type=\"text/javascript\">$script</script>");
	show_filter();
	?><form name="settracking" method="POST" action="/tracking/input.php">
	<?php forms_hiddenInput("settracking","/tracking/meeting/event.php?event=$event");
	forms_hidden('event', $event);
	show_usersTrack($users, date('m/d/y', $name['date']) . ' ' . $name['name']);
	echo '</form>';

}

function show_usersTrack($users, $name)
{
	?>
	<table  class="table table-condensed table-bordered">
	<tr><td class="heading" colspan="4"><?php echo $name ?></td></tr>
	<tr>
		<th>Name</th>
		<th>Credit </th>
		<th>Pin/Letters </th>
	</tr>

	<?php foreach($users as $user){
		$class = isset($user['p']) ? 'small' : 'small waitlist';
		$checked = isset($user['p']) ? 'checked' : '';
		$half  =   ($user['h'] == '0.5') ? 'checked' : '';
		$nothalf = ($user['h'] != '0.5') ? 'checked' : '';

	?>
		<tr id="r<?php echo $user['user_id'] ?>">
			<td class="<?php echo $class ?>">
				<?php 
                echo "<input name=\"user[{$user['user_id']}]\" type=\"checkbox\" $checked value=\"{$user['user_id']}\" />";
                echo "<span title=\"{$user['class_nick']} Class\">{$user['name']}</span>";
                ?>
			</td>
			<td class="<?php echo $class ?>">
				<?php echo "<input name=\"h[{$user['user_id']}]\" type=\"radio\" $nothalf value=\"1\" />Full" ?>
				<?php echo "<input name=\"h[{$user['user_id']}]\" type=\"radio\" $half value=\"0.5\" />Half" ?>
			</td>
			<td class="<?php echo $class ?>">
				<?php forms_checkbox("p[{$user['user_id']}]", 1, $user['p']>0); ?>
			</td>
		</tr>
	<?php
	}
	echo '</table><br/>';

    echo '<table cellspacing="1"><tr><th>';
	echo '<input type="button" onclick="checkPledges()" value="Check All Pledges">';
	echo '</th><td class="small" colspan="3">Checks all the pledges\' boxes. This will not submit the tracking, so you can continue to edit after pressing this button.</td></tr><tr><th>';
	forms_submit('Set Tracking');
	echo '</th><td class="small" colspan="3">Sets the tracking to match the current changes.</td></table><br/>';
}

show_footer();
?>
