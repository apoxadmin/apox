<?php 
include_once dirname(dirname(dirname(__FILE__))) . '/include/template.inc.php';
include_once dirname(dirname(dirname(__FILE__))) . '/include/forms.inc.php';
include_once dirname(dirname(dirname(__FILE__))) . '/include/show.inc.php';
include_once dirname(dirname(dirname(__FILE__))) . '/include/user.inc.php';
include_once dirname(dirname(dirname(__FILE__))) . '/include/event.inc.php';

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

show_header();


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
	<table class="table table-condensed table-bordered">
	<tr><td class="heading" colspan="4"><?php echo $name ?></td></tr>
	<tr>
		<th style="width: 200px">Event</th>
		<th>Events </th>
		<th>Hours </th>
		<th>Chair </th>
	</tr>
	
	<?php foreach($events as $event){
		$total['events'] += 1;
		$total['h'] += $event['h'];
		$total['c'] += $event['c'];
		$checked = isset($event['c']) ? 'checked' : '';
		$class  = 'small'; // . $event['fourc_c'];
		$class2 = 'small fourc' . $event['fourc_c'];
		$class  .= isset($event['c']) ? '' : ' waitlist';
		$class2 .= isset($event['c']) ? '' : 'dark';
		$text = date('m/d/y', $event['date']) . ' ' . $event['event_name'];
	?>
		<tr>
			<td class="<?php echo $class ?>">
				<?php echo "<input name=\"event[]\" type=\"checkbox\" $checked value=\"{$event['event_id']}\" />$text" ?>
			</td>
			<td>1</td>
			<td class="<?php echo $class ?>">
				<?php forms_decimal("h[{$event['event_id']}]", $event['h']); ?>
			</td>
			<td class="<?php echo $class ?>">
				<?php forms_checkbox("c[{$event['event_id']}]", 1, $event['c']>0) ; ?>
			</td>
		</tr>
	<?php } ?>
	<tr>
		<?php 
			echo '<td>Total</td>';
			echo "<td>{$total['events']}</td>";
			echo "<td>{$total['h']}</td>";
			echo "<td>{$total['c']}</td>";
		?>
	</tr>
	</table>
	<?php 
}

if(!isset($user))
{
	$list = getUsers(); 
	?>
	<form method="GET" action="/tracking/caw/user.php">
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
	$events = getTrackedUser($user, 9);
	
	$all = '0';
	foreach($events as $event)
		$all .= ', ' . $event['event_id'];
	
	?><form name="settrackinguser" method="POST" action="/tracking/input.php">
	<?php forms_hiddenInput("settrackinguser","/tracking/caw/user.php?user=$user");
	forms_hidden('user', $user);
	forms_hidden('all', $all);
	show_eventsTrack($events, $name['name'], $user);
	forms_submit('Set Tracking');
	?></form>
	<?php
}

show_footer();
?>
