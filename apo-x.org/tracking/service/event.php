<?php 
include_once dirname(dirname(dirname(__FILE__))) . '/include/template.inc.php';
include_once dirname(dirname(dirname(__FILE__))) . '/include/forms.inc.php';
include_once dirname(dirname(dirname(__FILE__))) . '/include/show.inc.php';
include_once dirname(dirname(dirname(__FILE__))) . '/include/event.inc.php';
include_once dirname(dirname(dirname(__FILE__))) . '/include/user.inc.php';
include_once '../sql.php';



include($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');


if(isset($_GET['event']))
	$event = $_GET['event'];
	
if(isset($_SESSION['id']))
	$id = $_SESSION['id'];
	
if(isset($_SESSION['class']))
	$class = $_SESSION['class'];

get_header();

$temp=user_get($id, 'f');
$temp=$temp['name'];

if ( !( ($temp == 'service' || $temp == 'admin') && $class=='admin') )
	show_note('You must be logged in as service to access this page.');

function show_usersTrack($users, $name)
{
	?>
	<table id="usertable" class="table table-condensed table-bordered">
	<tr><td class="heading" colspan="6"><?php echo $name ?></td></tr>
	<tr>
		<th width="120">Name</th>
		<th width="50">Hours </th>
		<th width="100">Positive Hours</th>
		<th width="40">Project</th>
		<th width="40">Chair </th>
		 <!--<th width="120">Driving<br>People / Miles</th> //temporary solution to the tracking problem// --> 
		<th width="40">Chair Comments </th>
	</tr>

	<?php foreach($users as $user){ 
		if(isset($user['h']))
		{
			$class = 'small';
			$checked = 'checked';
		}
		else
		{
			$class = 'small waitlist';
			$checked = '';
		}
			
		?><tr id="r<?php echo $user['user_id'] ?>"><?php
		echo "<td class=\"$class\">";
       echo "<input name=\"user[]\" type=\"checkbox\" $checked value=\"{$user['user_id']}\" "
           . "onclick='javascript:document.getElementById(\"h{$user['user_id']}\").disabled = !this.checked'/>";
        echo "<span title=\"{$user['class_nick']} Class\">{$user['name']}</span></td>";
		
        echo "<td class=\"$class\">";
        
        $disabled = $checked ? "" : "disabled";
        
        echo "<input id=h{$user['user_id']} name='h[{$user['user_id']}]' "
           . "type='text' id='decimal' size='3' maxlength='6' value='{$user['h']}' $disabled />";

		echo " hrs </td><td class=\"$class\">";

		echo "<input id=ph{$user['user_id']} name='ph[{$user['user_id']}]' "
           . "type='text' id='decimal' size='3' maxlength='6' value='{$user['ph']}' />";

		
		echo " hrs </td><td class=\"$class\">";
		forms_checkbox("p[{$user['user_id']}]", 1, $user['p']);
		
		echo "</td><td class=\"$class\">";
		forms_checkbox("c[{$user['user_id']}]", 1, $user['c']);
		
		echo "</td><td class=\"$class\" align=\"center\">";
		forms_text(40,"details[{$user['user_id']}]", $user['details']);
		
	   //  forms_decimal("mi[{$user['user_id']}]", $user['mi']);
	   // 	echo " mi </td><td class=\"$class\">";
	   
		echo '</td>';
		echo '</tr>';
	} ?>
	</table>
	<?php 
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
	show_filters();

	$name = event_get($event);  //$event is an id
	
	$users = getTrackedEvent($event); //the behavior of this function has changed, see sql.php
	?><form name="settracking" method="POST" action="/tracking/input.php">
	<?php forms_hiddenInput("settracking","/tracking/service/event.php?event=$event");
	forms_hidden('event', $event);
	show_usersTrack($users, date('m/d/y', $name['date']) . ' ' . $name['name']);
	forms_submit('Set Tracking');
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

foreach($list as $user){
	echo $user['name'];
}
show_footer();
?>
