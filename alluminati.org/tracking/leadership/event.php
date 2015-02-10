<?php 
include_once dirname(dirname(dirname(__FILE__))) . '/include/template.inc.php';
include_once dirname(dirname(dirname(__FILE__))) . '/include/forms.inc.php';
include_once dirname(dirname(dirname(__FILE__))) . '/include/show.inc.php';
include_once dirname(dirname(dirname(__FILE__))) . '/include/user.inc.php';
include_once dirname(dirname(dirname(__FILE__))) . '/include/event.inc.php';
include($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');
get_header();

include_once '../sql.php';

if(isset($_GET['event']))
	$event = $_GET['event'];
	
if(isset($_SESSION['id']))
	$id = $_SESSION['id'];
	
if(isset($_SESSION['class']))
	$class = $_SESSION['class'];

$temp=user_get($id, 'f');
$temp=$temp['name'];

if ( !( ($temp == 'membership' || $temp == 'admin') && $class=='admin') )
	show_note('You must be logged in as membership to access this page.');

function show_usersTrack($users, $name)
{
	?>
	<table class="table table-condensed table-bordered">
	<tr><td class="heading" colspan="5"><?php echo $name ?></td></tr>
	<tr>
		<th>Name</th>
		<th width="60">Credit </th>
		<th width="60">Chair </th>
		<!-- <th width="80">Driving<br>People / Miles</th> -->
		<th width="60">Chair Comments </th>
	</tr>
	
	<?php foreach($users as $user){ 
		$class = isset($user['p']) ? 'small' : 'small waitlist';
		$checked = isset($user['p']) ? 'checked' : '';
		
	?>
		<tr id="r<?php echo $user['user_id'] ?>">
			<td class="<?php echo $class ?>">
				<?php 
                echo "<input name=\"user[{$user['user_id']}]\" type=\"checkbox\" $checked value=\"{$user['user_id']}\" />";
                echo "<span title=\"{$user['class_nick']} Class\">{$user['name']}</span>";
                ?>
			</td>
			<td class="<?php echo $class ?>">
				<?php forms_decimal("p[{$user['user_id']}]", $user['p']); ?>
			</td>
			<td class="<?php echo $class ?>">
				<?php forms_checkbox("c[{$user['user_id']}]", 1, $user['c']>0); ?>
			</td>
			<!-- <td class=<?php echo "\"$class\" align=\"center\">";
				forms_decimal("ppl[{$user['user_id']}]", $user['ppl'], 2); echo " ppl ";
				forms_decimal("mi[{$user['user_id']}]", $user['mi']);
			?> mi </td> -->
			<td class="<?php echo $class ?>">
				<?php forms_text(40,"details[{$user['user_id']}]", $user['details']); ?>
				<?php echo (isset($user['details']))?'(attended)':''; echo (isset($user['chair']))?'(chair)':''; ?>
			</td>
		</tr>
	<?php 
	}
	echo '</table><br/>';
	
	echo '<table cellspacing="1"><tr><th>';
	forms_submit('Set Tracking');
	echo '</th><td class="small" colspan="3">Sets the tracking to match the current changes.</td></table><br/>';
}

if(!isset($event))
{
	// get leadership events
	$list = getEvents(7, true); 
	?>
	<form name="selecttracking" method="GET" action="/tracking/leadership/event.php">
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
	?><form name="settracking" method="POST" action="/tracking/input.php">
	<?php forms_hiddenInput("settracking","/tracking/leadership/event.php?event=$event");
	forms_hidden('event', $event);
	show_usersTrack($users, date('m/d/y', $name['date']) . ' ' . $name['name']);
	?></form>
	<?php
}

show_footer();
?>
