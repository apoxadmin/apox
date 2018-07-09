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

if($class!="admin")
	show_note('You must be an administrator to access this page.');

function show_usersTrack($users, $name)
{
	$adder = '';	// used to add list of attending people
	?>
	<table class="table table-condensed table-bordered">
	<tr><td class="heading" colspan="4"><?php echo $name ?></td></tr>
	<tr>
		<th>Name</th>
		<th width="60">Hours </th>
		<th width="60">Chair </th>
		<th width="60">Chair Comments </th>
	</tr>
	
	<?php foreach($users as $user){ 
		$class = isset($user['h']) ? 'small' : 'small waitlist';
		$checked = isset($user['h']) ? 'checked' : '';
		if(isset($user['details']))
			$script .= "document.getElementsByName('user[{$user['user_id']}]')[0].checked = true; ";
		if(isset($user['chair']))
			$script .= "document.getElementsByName('c[{$user['user_id']}]')[0].checked = true; ";
		
	?>
		<tr id="r<?php echo $user['user_id'] ?>">
			<td class="<?php echo $class ?>">
				<?php 
                echo "<input name=\"user[{$user['user_id']}]\" type=\"checkbox\" $checked value=\"{$user['user_id']}\" />";
                echo "<span title=\"{$user['class_nick']} Class\">{$user['name']}</span>";
                ?>
			</td>
			<td class="<?php echo $class ?>">
				<?php forms_decimal("h[{$user['user_id']}]", $user['h']); ?>
			</td>
			<td class="<?php echo $class ?>">
				<?php forms_checkbox("c[{$user['user_id']}]", 1, $user['c']>0); ?>
			</td>
			<td class="<?php echo $class ?>">
				<?php forms_text(40,"details[{$user['user_id']}]", $user['details']); ?>
				<?php 
					if(isset($user['details']))
					{
						echo '(attended)';
						$ruser = 'r'.$user['user_id'];
						$adder .= "users['$ruser'].attended = true;";
					} 
					echo (isset($user['chair']))?'(chair)':''; 
				?>
			</td>
		</tr>
	<?php 
	}
	echo '</table><br/>';
	
	echo '<table cellspacing="1"><tr><th>';
	echo "<input type=\"button\" onclick=\"$script\" value=\"Apply Chair's Tracking\">";
	echo '</th><td class="small" colspan="3">Checks all the boxes of the people that the chair marked as present. Also checks the "chair" boxes of the people who are signed up as chair. This button cannot assign the hours.</td></tr><tr><th>';
	forms_submit('Set Tracking');
	echo '</th><td class="small" colspan="3">Sets the tracking to match the current changes.</td></table><br/>';
	?>
<script language="JavaScript" type="text/javascript">
	function adder()
	{
		<?=$adder?>
	}
</script><?php
  
}

if(!isset($event))
{
	// get service events
	$list = getEvents(1, true);
	?>
	<form name="selecttracking" method="GET" action="/tracking/service/event.php">
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
	show_header('','adder();');
	show_filter();
	$name = event_get($event);
	$users = getTrackedEventAll($event); //the behavior of this function has changed, see sql.php
	?><form name="settracking" method="POST" action="/tracking/input.php">
	<?php forms_hiddenInput("settracking","/tracking/service/event.php?event=$event");
	forms_hidden('event', $event);
	show_usersTrack($users, date('m/d/y', $name['date']) . ' ' . $name['name']);
	?></form>
	<?php
	$submits = getTrackingTime($event);
	echo '<table cellspacing="1"><tr><th>Chair Modification History</th></tr>';
	foreach($submits as $submit)
	{
		$date = date('F jS, Y \a\t g:ia', $submit['date']);
		echo "<tr><td>Modified on <strong>$date</strong> by <strong>{$submit['name']}</strong>.</td></tr>";
	}
	echo '</table>';
}
	
show_footer();
?>
