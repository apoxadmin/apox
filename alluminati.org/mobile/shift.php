<?php 
include_once dirname(dirname(__FILE__)) . '/include/mobiletemplate.inc.php'; // start session and open database
include_once dirname(dirname(__FILE__)) . '/include/forms.inc.php';

$page = $_GET['page'];
$event = $_GET['event'];
$shift = $_GET['shift'];

$id = $_SESSION['id'];
$class = $_SESSION['class'];

show_header(); 

if($class != 'admin')
	show_note('You must be an administrator to access this page.');

//create or update?
if($page == 'update')
{
	include_once dirname(dirname(__FILE__)) . '/include/signup.inc.php';
	$maybe = shift_get($shift);
	$maybe['start'] = date('g:ia',strtotime($maybe['start']));
	$maybe['end'] = date('g:ia',strtotime($maybe['end']));
	$new = false;
}
else
{
	include_once dirname(dirname(__FILE__)) . '/include/event.inc.php';
	$maybe['event'] = $event;
	$event = event_get($event);
	$maybe['start'] = date('g:ia',$event['date']);
	$maybe['end'] = date('g:ia',$event['enddate']);
	$new = true;
}

?>
<form method="POST" onsubmit="return ValidateShiftModifyForm()" 
    action="/inputAdmin.php">
<?php
forms_hiddenInput( ($new?"shiftCreate":"shiftUpdate"), 
                   "/mobile/show.php?id={$maybe['event']}");
forms_hidden('event',$maybe['event']);
forms_hidden('shift',$maybe['shift']);
?>

<table cellspacing="1">
<tr><td class="heading" colspan="3">Edit Shift</td></tr>
<tr>
    <th>Mini-Description</th>
    <td><input type="text" name="name" size="64" maxlength="64"
            value="<?= $maybe['name'] ?>" /></td>
    <td>(Optional)</td>
</tr>
<tr>
	<th>Start Time:<br></th>
	<td><input type="text" name="start" 
            value="<?php echo $maybe['start'] ?>"></td>
	<td>HH:MM (am|pm)<br>eg 12:34pm</td>
</tr>
<tr>
	<th>End Time:<br></th>
	<td><input type="text" name="end" 
            value="<?php echo $maybe['end'] ?>"></td>
	<td>HH:MM (am|pm)</td>
</tr>
<tr>
	<th>Capacity:<br></th>
	<td><input type="text" name="capacity" 
            value="<?php echo $maybe['capacity'] ?>"></td>
	<td>0 means unlimited</td>
</tr>

<tr><td class="out">
	<?php forms_submit($new ? 'Create':'Update', ''); ?>
</td></tr>
</table>
</form>
	
<?php 
show_footer();
?>
