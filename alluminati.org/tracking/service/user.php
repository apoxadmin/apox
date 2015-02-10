<?php 
include_once 'template.inc.php';
include_once 'forms.inc.php';
include_once 'show.inc.php';
include_once 'user.inc.php';
include_once 'event.inc.php';

include_once '../sql.php';
include($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

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
	<table class="table table-condensed table-bordered">
	<tr><td class="heading" colspan="9"><?= $name ?></td></tr>
	<tr>
		<th width="50%">Event</th>
		<th width="10%">Hours </th>
		<th width="10%">Projects</th>
		<th width="10%">Chair </th>
		<th width="20%">Driving<br>People/Miles</th>
		<th width="10%" colspan="4">C </th>
	</tr>
	
	<?php foreach($events as $event){
		$total['h'] += $event['h'];
		$total['p'] += $event['p'];
		$total['c'] += $event['c'];
		$checked = isset($event['h']) ? 'checked' : '';
		if ($event['ppl'] > 0)	//if they drove somebody
			$total['d'] += 1;
		$class  = 'small'; // . $event['fourc_c'];
		$class2 = 'small fourc' . $event['fourc_c'];
		$class  .= isset($event['h']) ? '' : ' waitlist';
		$class2 .= isset($event['h']) ? '' : 'dark';
		$text = date('m/d/y', $event['date']) . ' ' . $event['event_name'];
	?>
		<tr>
			<td class="<?php echo $class ?>">
				<?php echo "<input name=\"event[]\" type=\"checkbox\" $checked value=\"{$event['event_id']}\" />$text" ?>
			</td>
			<td class="<?php echo $class ?>">
				<?php forms_decimal("h[{$event['event_id']}]", $event['h']); ?>
			</td>
			<td class="<?php echo $class ?>">
				<?php forms_checkbox("p[{$event['event_id']}]", 1, $event['p']); ?>
			</td>
			<td class="<?php echo $class ?>">
				<?php forms_checkbox("c[{$event['event_id']}]", 1, $event['c']); ?>
			</td>
			<td class=<?php echo "\"$class\" align=\"center\">";
				forms_decimal("ppl[{$event['event_id']}]", $event['ppl'], 2); echo " ppl ";
				forms_decimal("mi[{$event['event_id']}]", $event['mi']);
			?> mi </td>
			<td colspan="4" class="<?php echo $class2 ?>"><?php echo fourc_get($event['event_id']) ?></td>
		</tr>
	<?php } ?>
	<tr>
		<?php 
			$fourc_totals = getCTotal($user);
			echo '<td>Total</td>';
			echo "<td>{$total['h']}</td>";
			echo "<td>{$total['p']}</td>";
			echo "<td>{$total['c']}</td>";
			echo "<td>{$total['d']}</td>";
			
			$c[0] = $c[1] = $c[2] = $c[3] = 0;
			foreach($fourc_totals as $fourc_total)
			{
				$c[$fourc_total['fourc_c']] = $fourc_total['C'];
			}
			
			echo "<td class=\"small fourc0\">{$c[0]}</td>";
			echo "<td class=\"small fourc1\">{$c[1]}</td>";
			echo "<td class=\"small fourc2\">{$c[2]}</td>";
			echo "<td class=\"small fourc3\">{$c[3]}</td>";
		?>
	</tr>
	</table>
	<?php 
}

if(!isset($user))
{
	$list = getUsers();
	?>
	<form method="GET" action="/tracking/user.php">
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
	$events = getTrackedUser($user, 1);
	
	$all = '0';
	foreach($events as $event)
		$all .= ', ' . $event['event_id'];
	
	?><form name="settrackinguser" method="POST" action="/tracking/input.php">
	<?php forms_hiddenInput("settrackinguser","/tracking/service/user.php?user=$user");
	forms_hidden('user', $user);
	forms_hidden('all', $all);
	show_eventsTrack($events, $name['name'], $user);
	forms_submit('Set Tracking');
	?></form>
	<?php
}

show_footer();
?>
