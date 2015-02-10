<?php 
include_once dirname(dirname(dirname(__FILE__))) . ' /include/template.inc.php';
include_once dirname(dirname(dirname(__FILE__))) . ' /include/forms.inc.php';
include_once dirname(dirname(dirname(__FILE__))) . ' /include/show.inc.php';
include_once dirname(dirname(dirname(__FILE__))) . ' /include/user.inc.php';
include_once dirname(dirname(dirname(__FILE__))) . ' /include/event.inc.php';
include($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

include_once '../sql.php';

/* 
GET:
		user=<id of the user to do tracking for>
*/
if(isset($_GET['user']))
	$user = $_GET['user'];
	
if(isset($_SESSION['id']))
	$id = $_SESSION['id'];
	
if(isset($_SESSION['class']))
	$class = $_SESSION['class'];

if($class != 'admin')
	die('You\'re not logged in as excomm!');

get_header();


function getUsers()
{
	$sql = 'SELECT user_id, user_name '
		. ' as name from user where user_hidden=0 '
		. ' order by user_name asc';

	$table = db_select($sql, 'getTracking()');
	
	return $table;
}

function show_eventsTrack($events, $name, $user)
{
	$total = array();
	?>
	<table  class="table table-condensed table-bordered">
	<tr><td class="heading" colspan="3"><?php echo $name ?></td></tr>
	<tr>
		<th style="width: 200px">Event</th>
		<th>Credit </th>
		<th>Pin/Letters </th>
	</tr>
	
	<?php foreach($events as $event){
		$total['events'] += $event['h'];
		$total['p'] += $event['p'];
		$checked = isset($event['p']) ? 'checked' : '';
		$class  = 'small'; // . $event['fourc_c'];
		$class2 = 'small fourc' . $event['fourc_c'];
		$class  .= isset($event['p']) ? '' : ' waitlist';
		$class2 .= isset($event['p']) ? '' : 'dark';
		$text = date('m/d/y', $event['date']) . ' ' . $event['event_name'];
		$half  =   ($event['h'] == '0.5') ? 'checked' : '';
		$nothalf = ($event['h'] != '0.5') ? 'checked' : '';
	?>
		<tr>
			<td class="<?php echo $class ?>">
				<?php echo "<input name=\"event[]\" type=\"checkbox\" $checked value=\"{$event['event_id']}\" />$text" ?>
			</td>
			<td>
				<?php echo "<input name=\"h[{$event['event_id']}]\" type=\"radio\" $nothalf value=\"1\" />Full" ?>
				<?php echo "<input name=\"h[{$event['event_id']}]\" type=\"radio\" $half value=\"0.5\" />Half" ?>
			</td>
			<td class="<?php echo $class ?>">
				<?php forms_checkbox("p[{$event['event_id']}]", 1, $event['p']>0) ; ?>
			</td>
		</tr>
	<?php } ?>
	<tr>
		<?php 
			echo '<td>Total</td>';
			echo "<td>{$total['events']}</td>";
			echo "<td>{$total['p']}</td>";
		?>
	</tr>
	</table>
	<?php 
}

if(!isset($user))
{
	$list = getUsers(); 
	?>
	<form method="GET" action="/tracking/meeting/user.php">
	<select name="user" size="1">
			<?php foreach($list as $line):
				echo "<option ";
				echo "value=\"{$line['user_id']}\">{$line['name']}</option>";
			endforeach; ?>
	</select>
	<?php forms_submit('Track') ?>
	</form>
	<?php
}
else
{
	$name = user_get($user, 'fl');
	$events = getTrackedUser($user, 6);
	
	$all = '0';
	foreach($events as $event)
		$all .= ', ' . $event['event_id'];
	
	?><form name="settrackinguser" method="POST" action="/tracking/input.php">
	<?php forms_hiddenInput("settrackinguser","/tracking/meeting/user.php?user=$user");
	forms_hidden('user', $user);
	forms_hidden('all', $all);
	show_eventsTrack($events, $name['name'], $user);
	forms_submit('Set Tracking');
	?></form>
	<?php
}

show_footer();
?>
