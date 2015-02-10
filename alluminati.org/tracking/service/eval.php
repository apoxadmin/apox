<?php 
include_once 'template.inc.php';
include_once 'forms.inc.php';
include_once 'event.inc.php';
include($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');
if(isset($_GET['event']))
	$event = $_GET['event'];
	
if(isset($_SESSION['id']))
	$id = $_SESSION['id'];
	
if(isset($_SESSION['class']))
	$class = $_SESSION['class'];

get_header();

if($_GET['done'])
{
	?><div style="border: thin solid rgb(0,0,0); font-size: small; background: #ccc; color: rgb(255,0,0)">
		<br />Thank you for submitting your service tracking!<br />
	</div><?php
}
else
{
$start = event_get($event);
?>

<form name="eval" action="/tracking/input.php" method="POST" onsubmit="return valid(this)">
<table cellspacing="1">
<tr><td class="heading" colspan="2">Evaluation Form</td></tr>
<tr>
	<th>Chair Name(s):</th>
	<td><?php forms_text(60, 'chairs'); ?></td>
</tr>
<tr>
	<th>Project Title:</th>
	<td><?php forms_text(60, 'title', $start['name']); ?></td>
</tr>
<tr>
	<th>Date: </th>
	<td><?php forms_date('date', date('m/d/Y', $start['date']), 'eval'); ?></td>
</tr>
<tr>
	<th>Organization We Worked With:</th>
	<td><?php forms_text(60, 'who'); ?></td>
</tr>
<tr>
	<th>Supervisor Name (who was in charge of the volunteers at the project?):</th>
	<td><?php forms_text(30, 'who2'); ?></td>
</tr>
<tr>
	<th>Shifts:</th>
	<td><?php forms_text(60, 'shifts'); ?></td>
</tr>
<tr>
	<th>Description of Projects:</th>
	<td><?php forms_textarea('description', $start['description']); ?></td>
</tr>
<tr>
	<th>Number of Volunteers:</th>
	<td><?php forms_capacity('number'); ?></td>
</tr>
<tr>
	<th>Were there enough, not enough, or too many volunteers?</th>
	<td><?php forms_textarea('a'); ?></td>
</tr>
<tr>
	<th>Positive Points of the Project:</th>
	<td><?php forms_textarea('b'); ?></td>
</tr>
<tr>
	<th>Negative Points of the Project:</th>
	<td><?php forms_textarea('c'); ?></td>
</tr>
<tr>
	<th>How did the volunteers feel doing the project? Would they do it again?</th>
	<td><?php forms_textarea('d'); ?></td>
</tr>
<tr>
	<th>What would make this project more enjoyable?</th>
	<td><?php forms_textarea('e'); ?></td>
</tr>
<tr>
	<th>General Comments or Concerns (if you as the chair encountered any problems at the project, please also discuss them with the Service VP in person or over the phone):</th>
	<td><?php forms_textarea('f'); ?></td>
</tr>
</table>
<?php forms_submit('Submit Evaluation');
forms_hiddenInput('maileval','/tracking/eval.php?done=1'); ?>
</form>
<?php
}
show_footer();
?>